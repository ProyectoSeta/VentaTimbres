<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UcdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ucds')->insert([
            'valor' => '40.96',
            'moneda' => 'EUR',
            'fecha' => '2024-09-24',
        ]);
    }
}
