<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventarioUTSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('inventario_ut_estampillas')->insert([
            'key_denominacion' => 15,
            'cantidad_timbres' => 500,
            'desde' => '3106',
            'hasta' => '3605',
            'asignado' => '0',
            'estado' => 1
        ]);

        DB::table('inventario_ut_estampillas')->insert([
            'key_denominacion' => 16,
            'cantidad_timbres' => 500,
            'desde' => '3606',
            'hasta' => '4105',
            'asignado' => '0',
            'estado' => 1
        ]);
    }
}
