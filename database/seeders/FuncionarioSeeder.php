<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class FuncionarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('funcionarios')->insert([
            'nombre' => 'ADMIN',
            'ci_condicion' => 'V',
            'ci_nro' => '0000000',
            'cargo' => 'administrador',
            'estado' => 16
        ]);




        /////TAQ1
        DB::table('funcionarios')->insert([
            'nombre' => 'Sauli Parra',
            'ci_condicion' => 'V',
            'ci_nro' => '25538245',
            'cargo' => 'Taquillero',
            'key' => '1124',
            'estado' => 16
        ]);

        
        /////TAQ2
        DB::table('funcionarios')->insert([
            'nombre' => 'Ardo Tovar',
            'ci_condicion' => 'V',
            'ci_nro' => '18488163',
            'cargo' => 'Taquillero',
            'key' => '1125',
            'estado' => 16
        ]);


        /////TAQ3
        DB::table('funcionarios')->insert([
            'nombre' => 'Dubraska Lugo',
            'ci_condicion' => 'V',
            'ci_nro' => '27400716',
            'cargo' => 'Taquillero',
            'key' => '1126',
            'estado' => 16
        ]);


        /////TAQ4
        DB::table('funcionarios')->insert([
            'nombre' => 'Royer Mendoza',
            'ci_condicion' => 'V',
            'ci_nro' => '18083925',
            'cargo' => 'Taquillero',
            'key' => '2127',
            'estado' => 16
        ]);



        /////TAQ5
        DB::table('funcionarios')->insert([
            'nombre' => 'William Ruiz',
            'ci_condicion' => 'V',
            'ci_nro' => '10891445',
            'cargo' => 'Taquillero',
            'key' => '3128',
            'estado' => 16
        ]);



        /////TAQ6
        DB::table('funcionarios')->insert([
            'nombre' => 'Carlos Ruiz',
            'ci_condicion' => 'V',
            'ci_nro' => '6320989',
            'cargo' => 'Taquillero',
            'key' => '4129',
            'estado' => 16
        ]);


        /////TAQ7
        DB::table('funcionarios')->insert([
            'nombre' => 'Marly Guimarais',
            'ci_condicion' => 'V',
            'ci_nro' => '16761575',
            'cargo' => 'Taquillero',
            'key' => '5130',
            'estado' => 16
        ]);


       

        
    }
}
