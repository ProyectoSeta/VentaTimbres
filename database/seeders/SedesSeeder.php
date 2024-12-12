<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SedesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sedes')->insert([
            'sede' => 'Principal Maracay',
            'estado' => 16
        ]);
        DB::table('sedes')->insert([
            'sede' => 'Victoria',
            'estado' => 16
        ]);
        DB::table('sedes')->insert([
            'sede' => 'Cagua',
            'estado' => 16
        ]);
        DB::table('sedes')->insert([
            'sede' => 'La Villa',
            'estado' => 16
        ]);
        DB::table('sedes')->insert([
            'sede' => 'Turmero',
            'estado' => 16
        ]);
    }
}
