<?php

namespace App\Repositories;

use App\Models\RequestCategory;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;

class RequestCategoryRepository extends Repository
{
    /**
     *  Finds category by id
     *
     *  @param int $id
     *
     *  @return RequestCategory|bool
     */
    public static function find(int $id)
    {
        return self::findIn(RequestCategory::class, $id);
    }

    /**
     *  Searches for category by query
     *
     *  @param string $query
     *
     *  @return RequestCategory
     */
    public static function search(string $query)
    {
        return RequestCategory::search($query);
    }

    /**
     *  Persiste categoria
     *
     *  @param HttpRequest $httpRequest
     *
     *  @return void
     */
    public static function insert(HttpRequest $httpRequest)
    {
        $category = new RequestCategory;
        $category->office_id = Auth::user()->office_id;
        self::set($category, $httpRequest);

        return $category->save();
    }

    /**
     *  Updates request category
     *
     *  @param RequestCategory $category
     *  @param Request $request
     *
     *  @return mixed
     */
    public static function update(RequestCategory $category, HttpRequest $httpRequest)
    {
        self::set($category, $httpRequest);
        return $category->save();
    }

    /**
     *  Returns office's active categories
     *
     *  @return array
     */
    public static function getActives()
    {
        return RequestCategory::getActives();
    }

    /**
     *  Returns data for dashboard
     *
     *  @return array
     */
    public static function getDashboardData()
    {
        $data = array();

        foreach (self::getActives() as $category) {
            $data['categories']['month'][] = [
                'label' => $category->name,
                'total' => $category->monthRequests->count()
            ];
            $data['categories']['year'][] = [
                'label' => $category->name,
                'total' => $category->yearRequests->count()
            ];
        }

        return $data;
    }

    /**
     *  Sets request category model with HttpRequest
     *
     *  @param RequestCategory $category
     *  @param HttpRequest $httpRequest
     *
     *  @return void
     */
    private static function set(RequestCategory &$category, HttpRequest $httpRequest)
    {
        $category->name = $httpRequest->category_name;
        $category->is_active = $httpRequest->category_is_active;
        $category->colour = $httpRequest->category_colour ?? '#f8f9fa';
    }
}
