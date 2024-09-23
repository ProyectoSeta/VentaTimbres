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
            'ente' => 'Alcaldía',
        ]);

        DB::table('entes')->insert([
            'ente' => 'Notaría',
        ]);
    }
}
