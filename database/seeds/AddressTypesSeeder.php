<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (config('address_types') as $data) {
            DB::table('address_types')->insertOrIgnore([
                'name' => $data
            ]);
        }
    }
}
