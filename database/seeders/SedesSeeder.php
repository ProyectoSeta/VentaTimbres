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
        ]);
        DB::table('sedes')->insert([
            'sede' => 'Victoria',
        ]);
        DB::table('sedes')->insert([
            'sede' => 'Cagua',
        ]);
        DB::table('sedes')->insert([
            'sede' => 'La Villa',
        ]);
        DB::table('sedes')->insert([
            'sede' => 'Turmero',
        ]);
    }
}
