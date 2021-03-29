<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (config('permissions') as $permission) {
            DB::table('permissions')->insertOrIgnore([
                'label' => $permission['label'],
                'code' => $permission['code'],
                'parent' => $permission['parent']
            ]);
        }
    }
}
