<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pass = 'Admin852.';
        DB::table('users')->insert([
            'email' => 'administrador@gmail.com',
            'password' => Hash::make($pass),
            'type' => 2,
            'key_sujeto' => 1,
        ]);

        DB::table('contribuyentes')->insert([
            'identidad_condicion' => 'V',
            'identidad_nro' =>'123456',
            'nombre_razon' => 'Prueba Uno'
        ]);

        $pass = 'Hola45.';
        DB::table('users')->insert([
            'email' => 'prueba@gmail.com',
            'password' => Hash::make($pass),
            'type' => 1,
            'key_sujeto' => 2,
        ]);

       
    }
}
