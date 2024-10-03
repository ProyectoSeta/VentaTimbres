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
            'nombre' => 'Taquillero 1',
            'ci_condicion' => 'V',
            'ci_nro' => '0000001',
            'cargo' => 'Taquillero',
        ]);

        DB::table('funcionarios')->insert([
            'nombre' => 'Taquillero 2',
            'ci_condicion' => 'V',
            'ci_nro' => '0000002',
            'cargo' => 'Taquillero',
        ]);
    }
}
