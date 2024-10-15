<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('formas')->insert([
            'forma' => 'Forma01',
            'identificador' => 1,
        ]);
        DB::table('formas')->insert([
            'forma' => 'Forma14',
            'identificador' => 2,
        ]);
        DB::table('formas')->insert([
            'forma' => 'Estampillas',
            'identificador' => 3,
        ]);
    }
}
