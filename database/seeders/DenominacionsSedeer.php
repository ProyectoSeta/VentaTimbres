<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DenominacionsSedeer extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ucd_denominacions')->insert([
            'denominacion' => '1',
        ]);
        DB::table('ucd_denominacions')->insert([
            'denominacion' => '2',
        ]);
        DB::table('ucd_denominacions')->insert([
            'denominacion' => '3',
        ]);
        DB::table('ucd_denominacions')->insert([
            'denominacion' => '5',
        ]);
        DB::table('ucd_denominacions')->insert([
            'denominacion' => '10',
        ]);
        DB::table('ucd_denominacions')->insert([
            'denominacion' => '15',
        ]);
        DB::table('ucd_denominacions')->insert([
            'denominacion' => '100',
        ]);
        DB::table('ucd_denominacions')->insert([
            'denominacion' => '250',
        ]);
        DB::table('ucd_denominacions')->insert([
            'denominacion' => '500',
        ]);

    }
}
