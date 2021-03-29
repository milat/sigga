<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OwnerTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (config('owner_types') as $name => $owner) {
            DB::table('owner_types')->insertOrIgnore([
                'id' => $owner['id'],
                'name' => $name,
                'can_request' => $owner['can_request']
            ]);
        }
    }
}
