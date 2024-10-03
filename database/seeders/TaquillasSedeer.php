<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaquillasSedeer extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('taquillas')->insert([
            'key_sede' => 1,
            'key_funcionario' => 2
        ]);
        DB::table('taquillas')->insert([
            'key_sede' => 1,
            'key_funcionario' => 3
        ]);
    }
}
