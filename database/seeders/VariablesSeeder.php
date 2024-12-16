<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class VariablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('variables')->insert([
            'variable' => 'cant_por_emision_tfes',
            'valor' => '1000'
        ]);
        DB::table('variables')->insert([
            'variable' => 'cant_por_emision_estampillas',
            'valor' => '1000'
        ]);

        DB::table('variables')->insert([
            'variable' => 'letra_correlativo_papel_tfes',
            'valor' => 'A'
        ]);
        DB::table('variables')->insert([
            'variable' => 'letra_correlativo_papel_estampillas',
            'valor' => 'A'
        ]);
    }
}
