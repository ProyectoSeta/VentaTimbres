<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EntesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('entes')->insert([
            'ente' => 'Registro',
        ]);

        DB::table('entes')->insert([
            'ente' => 'Municipal o Alcaldías',
        ]);

        DB::table('entes')->insert([
            'ente' => 'Notaría',
        ]);

        DB::table('entes')->insert([
            'ente' => 'Bomberos',
        ]);

        DB::table('entes')->insert([
            'ente' => 'Prefecturas',
        ]);

        DB::table('entes')->insert([
            'ente' => 'Habitabilidad Sanitaria',
        ]);

        DB::table('entes')->insert([
            'ente' => 'SENIAT',
        ]);

    }
}
