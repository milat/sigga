<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequestStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (config('request_statuses') as $status) {
            DB::table('request_statuses')->insertOrIgnore([
                'name' => $status['name'],
                'class' => $status['class'],
                'rgba' => $status['rgba']
            ]);
        }
    }
}
