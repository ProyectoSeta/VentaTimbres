<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class InventarioTaquillasSedeer extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('inventario_taquillas')->insert([
            'key_taquilla' => 1,
            'cantidad_tfe' => 0,
            'cantidad_estampillas' => 0
        ]);

        DB::table('inventario_taquillas')->insert([
            'key_taquilla' => 2,
            'cantidad_tfe' => 0,
            'cantidad_estampillas' => 0
        ]);

        DB::table('inventario_taquillas')->insert([
            'key_taquilla' => 3,
            'cantidad_tfe' => 0,
            'cantidad_estampillas' => 0
        ]);

        // DB::table('inventario_taquillas')->insert([
        //     'key_taquilla' => 4,
        //     'cantidad_tfe' => 0,
        //     'cantidad_estampillas' => 0
        // ]);

        // DB::table('inventario_taquillas')->insert([
        //     'key_taquilla' => 5,
        //     'cantidad_tfe' => 0,
        //     'cantidad_estampillas' => 0
        // ]);

        // DB::table('inventario_taquillas')->insert([
        //     'key_taquilla' => 6,
        //     'cantidad_tfe' => 0,
        //     'cantidad_estampillas' => 0
        // ]);
    }
}
