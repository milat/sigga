<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DocumentTypesSeeder::class);
        $this->call(AddressTypesSeeder::class);
        $this->call(PhoneTypesSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(RequestStatusesSeeder::class);
        $this->call(SuperusersSeeder::class);
    }
}
