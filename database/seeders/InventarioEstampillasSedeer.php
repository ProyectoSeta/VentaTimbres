<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class InventarioEstampillasSedeer extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('inventario_estampillas')->insert([
            'key_denominacion' => 1,
            'cantidad'  => 0,
        ]);
        DB::table('inventario_estampillas')->insert([
            'key_denominacion' => 2,
            'cantidad'  => 0,
        ]);
        DB::table('inventario_estampillas')->insert([
            'key_denominacion' => 3,
            'cantidad'  => 0,
        ]);
        DB::table('inventario_estampillas')->insert([
            'key_denominacion' => 4,
            'cantidad'  => 0,
        ]);
        DB::table('inventario_estampillas')->insert([
            'key_denominacion' => 5,
            'cantidad'  => 0,
        ]);
        DB::table('inventario_estampillas')->insert([
            'key_denominacion' => 6,
            'cantidad'  => 0,
        ]);
    }
}
