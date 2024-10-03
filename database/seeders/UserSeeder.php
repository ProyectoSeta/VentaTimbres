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
            'key_sujeto' => 1, /////funcionario id 1 admin
        ]);




        ////////////SUJETO PRUEBA CONTRIBUYENTE
        DB::table('contribuyentes')->insert([
            'identidad_condicion' => 'V',
            'identidad_nro' =>'123456',
            'nombre_razon' => 'Prueba Uno'
        ]);

        $pass = 'Hola45.';
        DB::table('users')->insert([
            'email' => 'prueba_uno@gmail.com',
            'password' => Hash::make($pass),
            'type' => 1,
            'key_sujeto' => 1,
        ]);


        /////////SUJETOS TAQUILLEROS PRUEBA 
        $pass = '123456';
        DB::table('users')->insert([
            'email' => 'taquillero1@gmail.com',
            'password' => Hash::make($pass),
            'type' => 2,
            'key_sujeto' => 2, //////funcionario id 2
        ]);

        $pass = '123456';
        DB::table('users')->insert([
            'email' => 'taquillero2@gmail.com',
            'password' => Hash::make($pass),
            'type' => 2,
            'key_sujeto' => 3,/////funcionario id 3
        ]);
       
    }
}
