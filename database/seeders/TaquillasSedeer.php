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
        DB::table('taquillas')->insert([
            'key_sede' => 2,
            'key_funcionario' => 4
        ]);
        DB::table('taquillas')->insert([
            'key_sede' => 3,
            'key_funcionario' => 5
        ]);
        DB::table('taquillas')->insert([
            'key_sede' => 4,
            'key_funcionario' => 6
        ]);
        DB::table('taquillas')->insert([
            'key_sede' => 5,
            'key_funcionario' => 7
        ]);



        
    }
}
