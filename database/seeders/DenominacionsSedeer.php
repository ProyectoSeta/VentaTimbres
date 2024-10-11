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
            'forma01' => 'true',
            'forma14' => 'true',
            'estampillas' => 'true',
        ]);
        DB::table('ucd_denominacions')->insert([
            'denominacion' => '2',
            'forma01' => 'true',
            'forma14' => 'true',
            'estampillas' => 'true',
        ]);
        DB::table('ucd_denominacions')->insert([
            'denominacion' => '3',
            'forma01' => 'true',
            'forma14' => 'true',
            'estampillas' => 'true',
        ]);
        DB::table('ucd_denominacions')->insert([
            'denominacion' => '5',
            'forma01' => 'true',
            'forma14' => 'true',
            'estampillas' => 'true',
        ]);
        DB::table('ucd_denominacions')->insert([
            'denominacion' => '10',
            'forma01' => 'true',
            'forma14' => 'true',
            'estampillas' => 'true',
        ]);
        DB::table('ucd_denominacions')->insert([
            'denominacion' => '15',
            'forma01' => 'false',
            'forma14' => 'true',
            'estampillas' => 'true',
        ]);
        DB::table('ucd_denominacions')->insert([
            'denominacion' => '100',
            'forma01' => 'false',
            'forma14' => 'true',
            'estampillas' => 'false',
        ]);
        DB::table('ucd_denominacions')->insert([
            'denominacion' => '250',
            'forma01' => 'false',
            'forma14' => 'true',
            'estampillas' => 'false',
        ]);
        DB::table('ucd_denominacions')->insert([
            'denominacion' => '500',
            'forma01' => 'false',
            'forma14' => 'true',
            'estampillas' => 'false',
        ]);

    }
}
