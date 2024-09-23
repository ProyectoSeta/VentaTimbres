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
            'ucd' => '3'
        ]);
        DB::table('tramites')->insert([
            'tramite' => 'Partida de Nacimiento',
            'key_ente' => 1,
            'ucd' => '3'
        ]);
        DB::table('tramites')->insert([
            'tramite' => 'Registro de Título Universitario',
            'key_ente' => 1,
            'ucd' => '2'
        ]);
        DB::table('tramites')->insert([
            'tramite' => 'Sellado de Libro',
            'key_ente' => 1,
            'ucd' => '10'
        ]);

        ///////////// ALCALDÍA
        DB::table('tramites')->insert([
            'tramite' => 'Licencia de Actividad Económica',
            'key_ente' => 2,
            'ucd' => '10'
        ]);
        DB::table('tramites')->insert([
            'tramite' => 'Uso conforme',
            'key_ente' => 2,
            'ucd' => '10'
        ]);

        ////////////NOTARÍA
        DB::table('tramites')->insert([
            'tramite' => 'Poder Natural',
            'key_ente' => 3,
            'ucd' => '3'
        ]);
        DB::table('tramites')->insert([
            'tramite' => 'Poder Especial',
            'key_ente' => 3,
            'ucd' => '5'
        ]);
    }
}
