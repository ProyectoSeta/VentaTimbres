<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClasificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Inventario',
        ]);
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Asignado',
        ]);

        ////////MODULO
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Rollos',
        ]);
    }
}
