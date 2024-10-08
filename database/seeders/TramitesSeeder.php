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
            'alicuota' => 7,
            'natural' => '3',
            'juridico' => '3',
            'key_ente' => 1,
        ]);
        DB::table('tramites')->insert([
            'tramite' => 'Partida de Nacimiento',
            'alicuota' => 7,
            'natural' => '3',
            'juridico' => '3',
            'key_ente' => 1
        ]);
        DB::table('tramites')->insert([
            'tramite' => 'Registro de Título Universitario',
            'alicuota' => 7,
            'natural' => '2',
            'juridico' => '2',
            'key_ente' => 1
        ]);
        DB::table('tramites')->insert([
            'tramite' => 'Sellado de Libro',
            'alicuota' => 7,
            'natural' => '3',
            'juridico' => '10',
            'key_ente' => 1
        ]);

        ///////////// ALCALDÍA
        DB::table('tramites')->insert([
            'tramite' => 'Licencia de Actividad Económica',
            'alicuota' => 7,
            'natural' => '3',
            'juridico' => '10',
            'key_ente' => 2
        ]);
        DB::table('tramites')->insert([
            'tramite' => 'Uso conforme',
            'alicuota' => 7,
            'natural' => '10',
            'juridico' => '10',
            'key_ente' => 2
        ]);

        ////////////NOTARÍA
        DB::table('tramites')->insert([
            'tramite' => 'Poder Natural',
            'alicuota' => 7,
            'natural' => '5',
            'juridico' => '5',
            'key_ente' => 3
        ]);
        DB::table('tramites')->insert([
            'tramite' => 'Poder Especial',
            'alicuota' => 7,
            'natural' => '10',
            'juridico' => '10',
            'key_ente' => 3
        ]);
    }
}
