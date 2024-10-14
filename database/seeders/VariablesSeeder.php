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
            'variable' => 'cant_timbres_rollo',
            'valor' => '160'
        ]);
        DB::table('variables')->insert([
            'variable' => 'cant_timbres_tira',
            'valor' => '160'
        ]);
    }
}
