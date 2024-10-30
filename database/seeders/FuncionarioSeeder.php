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
        ]);


        DB::table('funcionarios')->insert([
            'nombre' => 'Sujeto Uno',
            'ci_condicion' => 'V',
            'ci_nro' => '0000001',
            'cargo' => 'Taquillero',
        ]);

        DB::table('funcionarios')->insert([
            'nombre' => 'Sujeto Dos',
            'ci_condicion' => 'V',
            'ci_nro' => '0000002',
            'cargo' => 'Taquillero',
        ]);

        DB::table('funcionarios')->insert([
            'nombre' => 'Sujeto Tres',
            'ci_condicion' => 'V',
            'ci_nro' => '0000003',
            'cargo' => 'Taquillero',
        ]);

        DB::table('funcionarios')->insert([
            'nombre' => 'Sujeto Cuatro',
            'ci_condicion' => 'V',
            'ci_nro' => '0000004',
            'cargo' => 'Taquillero',
        ]);

        DB::table('funcionarios')->insert([
            'nombre' => 'Sujeto Cinco',
            'ci_condicion' => 'V',
            'ci_nro' => '0000005',
            'cargo' => 'Taquillero',
        ]);

        DB::table('funcionarios')->insert([
            'nombre' => 'Sujeto Seis',
            'ci_condicion' => 'V',
            'ci_nro' => '0000006',
            'cargo' => 'Taquillero',
        ]);

        DB::table('funcionarios')->insert([
            'nombre' => 'Sujeto Siete',
            'ci_condicion' => 'V',
            'ci_nro' => '0000007',
            'cargo' => 'Taquillero',
        ]);
    }
}
