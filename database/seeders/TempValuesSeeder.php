<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TempValuesSeeder extends Seeder
{
    public function run()
    {
        DB::table('tenants')->upsert([
            ['id' => 'clinic1', 'data' => json_encode(['name' => 'Clinic One']), 'created_at' => '2025-12-21 18:10:03', 'updated_at' => '2025-12-21 18:10:03'],
            ['id' => 'clinic2', 'data' => json_encode(['name' => 'Clinic two']), 'created_at' => '2025-12-21 18:10:03', 'updated_at' => '2025-12-21 18:10:03'],
            ['id' => 'clinic3', 'data' => json_encode(['name' => 'Clinic three']), 'created_at' => '2025-12-21 18:10:03', 'updated_at' => '2025-12-21 18:10:03'],
        ], ['id'], ['data', 'updated_at']);

        DB::table('domains')->upsert([
            ['domain' => 'clinic-website.soomnow.com', 'tenant_id' => 'clinic1', 'created_at' => '2025-12-21 18:10:03', 'updated_at' => '2025-12-21 18:10:03'],
            ['domain' => '127.0.0.1', 'tenant_id' => 'clinic2', 'created_at' => '2025-12-21 19:22:03', 'updated_at' => '2025-12-21 19:22:03'],
            ['domain' => '172.18.0.155', 'tenant_id' => 'clinic3', 'created_at' => '2025-12-21 19:22:03', 'updated_at' => '2025-12-21 19:22:03'],
        ], ['domain'], ['tenant_id', 'updated_at']);
    }
}
