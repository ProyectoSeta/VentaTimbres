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


        DB::table('clasificacions')->insert([
            'nombre_clf' => 'En Uso',
        ]);
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Reserva',
        ]);
        
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Emisión',
        ]);

        ////////MODULO
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Rollos',
        ]);


        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Vendido',
        ]);
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Sin recibir',
        ]);


        //////ESTADOS RITEA
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Vigente',
        ]);
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Vencido',
        ]);
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Verificando',
        ]);
    }
}
