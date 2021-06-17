<?php

namespace App\Providers;

use App\Utils\Language;
use App\Utils\Text;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::share('language', Language::class);
        View::share('text', Text::class);

        Relation::morphMap([
            'office' => 'App\Models\Office',
            'user' => 'App\Models\User',
            'citizen' => 'App\Models\Citizen',
            'organization' => 'App\Models\Organization'
        ]);
    }
}
