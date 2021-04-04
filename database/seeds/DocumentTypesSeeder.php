<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (config('document_types') as $data) {
            DB::table('document_types')->insertOrIgnore([
                'name' => $data['name'],
                'can_request' => $data['can_request'],
                'has_deadline' => $data['has_deadline']
            ]);
        }
    }
}
