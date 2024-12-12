<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EfectivoTaquillasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('efectivo_taquillas_temps')->insert([
            'key_taquilla' => 1,
            'efectivo' => '0'
        ]);
        DB::table('efectivo_taquillas_temps')->insert([
            'key_taquilla' => 2,
            'efectivo' => '0'
        ]);
        DB::table('efectivo_taquillas_temps')->insert([
            'key_taquilla' => 3,
            'efectivo' => '0'
        ]);
        // DB::table('efectivo_taquillas_temps')->insert([
        //     'key_taquilla' => 4,
        //     'efectivo' => '0'
        // ]);
        // DB::table('efectivo_taquillas_temps')->insert([
        //     'key_taquilla' => 5,
        //     'efectivo' => '0'
        // ]);
        // DB::table('efectivo_taquillas_temps')->insert([
        //     'key_taquilla' => 6,
        //     'efectivo' => '0'
        // ]);
    }
}
