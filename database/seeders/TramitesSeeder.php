<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TramitesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ////////////////REGISTRO
        DB::table('tramites')->insert([
            'tramite' => 'Legalización',
            'key_ente' => 1,
            'alicuota' => 7,
            'natural' => '3',
            'juridico' => '3',
            'small' => null,
            'medium' => null,
            'large' => null,
            
        ]);
        DB::table('tramites')->insert([
            'tramite' => 'Partida de Nacimiento',
            'key_ente' => 1,
            'alicuota' => 7,
            'natural' => '3',
            'juridico' => '3',
            'small' => null,
            'medium' => null,
            'large' => null,
        ]);
        DB::table('tramites')->insert([
            'tramite' => 'Registro de Título Universitario',
            'key_ente' => 1,
            'alicuota' => 7,
            'natural' => '2',
            'juridico' => '2',
            'small' => null,
            'medium' => null,
            'large' => null,
        ]);
        DB::table('tramites')->insert([
            'tramite' => 'Sellado de Libro',
            'key_ente' => 1,
            'alicuota' => 7,
            'natural' => '3',
            'juridico' => '10',
            'small' => null,
            'medium' => null,
            'large' => null,
        ]);

        ///////////// ALCALDÍA
        DB::table('tramites')->insert([
            'tramite' => 'Licencia de Actividad Económica',
            'key_ente' => 2,
            'alicuota' => 7,
            'natural' => '3',
            'juridico' => '10',
            'small' => null,
            'medium' => null,
            'large' => null,
            
        ]);
        DB::table('tramites')->insert([
            'tramite' => 'Uso conforme',
            'key_ente' => 2,
            'alicuota' => 7,
            'natural' => '10',
            'juridico' => '10',
            'small' => null,
            'medium' => null,
            'large' => null,
        ]);

        ////////////NOTARÍA
        DB::table('tramites')->insert([
            'tramite' => 'Poder Natural',
            'key_ente' => 3,
            'alicuota' => 7,
            'natural' => '5',
            'juridico' => '5',
            'small' => null,
            'medium' => null,
            'large' => null,
        ]);
        DB::table('tramites')->insert([
            'tramite' => 'Poder Especial',
            'key_ente' => 3,
            'alicuota' => 7,
            'natural' => '10',
            'juridico' => '10',
            'small' => null,
            'medium' => null,
            'large' => null,
        ]);


        ///////////BOMBEROS
        DB::table('tramites')->insert([
            'tramite' => 'Permiso de Bomberos',
            'key_ente' => 4,
            'alicuota' => 7,
            'natural' => '0',
            'juridico' => '0',
            'small' => '100',
            'medium' => '250',
            'large' => '500',
        ]);
    }
}
