<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TaquillasSedeer extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pass = '123456789';

        DB::table('taquillas')->insert([
            'key_sede' => 1,
            'key_funcionario' => 2,
            'clave' => Hash::make($pass),
            'estado' => 16
        ]);
        DB::table('taquillas')->insert([
            'key_sede' => 1,
            'key_funcionario' => 3,
            'clave' => Hash::make($pass),
            'estado' => 16
        ]);
        DB::table('taquillas')->insert([
            'key_sede' => 2,
            'key_funcionario' => 4,
            'clave' => Hash::make($pass),
            'estado' => 16
        ]);

        // DB::table('taquillas')->insert([
        //     'key_sede' => 3,
        //     'key_funcionario' => 5,
        //     'clave' => Hash::make($pass)
        // ]);
        // DB::table('taquillas')->insert([
        //     'key_sede' => 4,
        //     'key_funcionario' => 6,
        //     'clave' => Hash::make($pass)
        // ]);
        // DB::table('taquillas')->insert([
        //     'key_sede' => 5,
        //     'key_funcionario' => 7,
        //     'clave' => Hash::make($pass)
        // ]);


        ////////////// TABLA INVENTARIO TEMP TAQUILLAS ESTAMPILLAS Y TFE 14
        // ESTAMPILLAS
        DB::table('inv_est_taq_temps')->insert([
            'key_taquilla' => 1,
            '1_ucd' => 0,
            '2_ucd' => 0,
            '3_ucd' => 0,
            '5_ucd' => 0,
            'fecha' => '2025-03-10'
        ]);

        DB::table('inv_est_taq_temps')->insert([
            'key_taquilla' => 2,
            '1_ucd' => 0,
            '2_ucd' => 0,
            '3_ucd' => 0,
            '5_ucd' => 0,
            'fecha' => '2025-03-10'
        ]);
        DB::table('inv_est_taq_temps')->insert([
            'key_taquilla' => 3,
            '1_ucd' => 0,
            '2_ucd' => 0,
            '3_ucd' => 0,
            '5_ucd' => 0,
            'fecha' => '2025-03-10'
        ]);

        // TFE14
        DB::table('inv_tfe_taq_temps')->insert([
            'key_taquilla' => 1,
            'cantidad' => 0,
            'fecha' => '2025-03-10'
        ]);
        DB::table('inv_tfe_taq_temps')->insert([
            'key_taquilla' => 2,
            'cantidad' => 0,
            'fecha' => '2025-03-10'
        ]);
        DB::table('inv_tfe_taq_temps')->insert([
            'key_taquilla' => 3,
            'cantidad' => 0,
            'fecha' => '2025-03-10'
        ]);
        
    }
}
