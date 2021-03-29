<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperusersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('superusers')->insert([
            'name' => 'root',
            'email' => config('system.root_superuser'),
            'email_verified_at' => now(),
            'password' => Hash::make(config('system.root_init_password')),
            'is_root' => true,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
