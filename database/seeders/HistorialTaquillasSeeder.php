<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HistorialTaquillasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('historial_taquillas')->insert([
            'key_taquilla' => 1,
            'key_funcionario' => 2,
            'desde' => '2024-10-20'
        ]);
        DB::table('historial_taquillas')->insert([
            'key_taquilla' => 2,
            'key_funcionario' => 3,
            'desde' => '2024-10-20'
        ]);
        DB::table('historial_taquillas')->insert([
            'key_taquilla' => 3,
            'key_funcionario' => 4,
            'desde' => '2024-10-20'
        ]);
    }
}
