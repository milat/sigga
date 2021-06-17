<?php

namespace App\Repositories;

use App\Models\RequestStatus;

class RequestStatusRepository extends Repository
{
    /**
     *  Get all request statuses
     *
     *  @return array
     */
    public static function getAll()
    {
        return RequestStatus::with('monthRequests', 'yearRequests')->get();
    }

    /**
     *  Returns data for dashboard
     *
     *  @return array
     */
    public static function getDashboardStatus()
    {
        $data = array();

        foreach (self::getAll() as $status) {
            $data['status']['month'][] = [
                'label' => $status->name,
                'total' => $status->monthRequests->count(),
                'backgroundColor' => str_replace("<opacity>", "0.5", $status->rgba),
                'borderColor' => str_replace("<opacity>", "1", $status->rgba)
            ];
            $data['status']['year'][] = [
                'label' => $status->name,
                'total' => $status->yearRequests->count(),
                'backgroundColor' => str_replace("<opacity>", "0.5", $status->rgba),
                'borderColor' => str_replace("<opacity>", "1", $status->rgba)
            ];
        }

        return $data;
    }
}
