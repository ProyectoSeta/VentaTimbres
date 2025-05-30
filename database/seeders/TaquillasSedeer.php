<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TaquillasSedeer extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pass_taq = 'Taq11237.';

        /////TAQ1
        DB::table('taquillas')->insert([
            'key_sede' => 1,
            'key_funcionario' => 2,
            'clave' => Hash::make($pass_taq),
            'estado' => 16
        ]);

        /////TAQ2
        DB::table('taquillas')->insert([
            'key_sede' => 1,
            'key_funcionario' => 3,
            'clave' => Hash::make($pass_taq),
            'estado' => 16
        ]);

        /////TAQ3
        DB::table('taquillas')->insert([
            'key_sede' => 1,
            'key_funcionario' => 4,
            'clave' => Hash::make($pass_taq),
            'estado' => 16
        ]);

        /////TAQ4
        DB::table('taquillas')->insert([
            'key_sede' => 5,
            'key_funcionario' => 5,
            'clave' => Hash::make($pass_taq),
            'estado' => 16
        ]);


        /////TAQ5
        DB::table('taquillas')->insert([
            'key_sede' => 3,
            'key_funcionario' => 6,
            'clave' => Hash::make($pass_taq),
            'estado' => 16
        ]);


        /////TAQ6
        DB::table('taquillas')->insert([
            'key_sede' =>4,
            'key_funcionario' => 7,
            'clave' => Hash::make($pass_taq),
            'estado' => 16
        ]);

        /////TAQ7
        DB::table('taquillas')->insert([
            'key_sede' => 2,
            'key_funcionario' => 8,
            'clave' => Hash::make($pass_taq),
            'estado' => 16
        ]);
        
    }
}
