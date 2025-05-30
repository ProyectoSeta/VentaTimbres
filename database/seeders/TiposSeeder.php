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

        ///////////TIPOS DE CONTRIBUYENTES
        DB::table('tipos')->insert([
            'nombre_tipo' => 'Persona Natural',
        ]);
        DB::table('tipos')->insert([
            'nombre_tipo' => 'Firma Personal',
        ]);
        DB::table('tipos')->insert([
            'nombre_tipo' => 'Empresa',
        ]);
        DB::table('tipos')->insert([
            'nombre_tipo' => 'Ente Gubernamental',
        ]);

        //////////ALICUOTAS PT.2
        DB::table('tipos')->insert([
            'nombre_tipo' => 'Metrado',
        ]);


        ////////// TIPO PAGO (EXENCIONES)
        DB::table('tipos')->insert([
            'nombre_tipo' => 'Obra',
        ]);
        DB::table('tipos')->insert([
            'nombre_tipo' => 'Bien',
        ]);
        DB::table('tipos')->insert([
            'nombre_tipo' => 'Servicio',
        ]);
        DB::table('tipos')->insert([
            'nombre_tipo' => 'Suministros',
        ]);
        DB::table('tipos')->insert([
            'nombre_tipo' => 'Deposito',
        ]);

        //////////ALICUOTAS PT.3
        DB::table('tipos')->insert([
            'nombre_tipo' => 'UT',
        ]);


       

    }
}
