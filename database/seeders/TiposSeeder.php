<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ///////////TIPOS DE USUARIOS
        DB::table('tipos')->insert([
            'nombre_tipo' => 'Contribuyente',
        ]);
        DB::table('tipos')->insert([
            'nombre_tipo' => 'Funcionario',
        ]);

        /////////////TIPO DE VENTA TIMBRES
        DB::table('tipos')->insert([
            'nombre_tipo' => 'Forma14',
        ]); 
        DB::table('tipos')->insert([
            'nombre_tipo' => 'Estampilla',
        ]);

        //////////METODOS DE PAGO
        DB::table('tipos')->insert([
            'nombre_tipo' => 'Punto',
        ]); 
        DB::table('tipos')->insert([
            'nombre_tipo' => 'Efectivo',
        ]);

        //////////ALICUOTAS
        DB::table('tipos')->insert([
            'nombre_tipo' => 'UCD',
        ]); 
        DB::table('tipos')->insert([
            'nombre_tipo' => 'Porcentaje',
        ]);
    }
}
