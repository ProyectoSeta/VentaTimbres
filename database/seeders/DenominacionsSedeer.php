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
            'identificador' => 'A',
            'alicuota' => 7,
        ]);
        DB::table('ucd_denominacions')->insert([
            'denominacion' => '2',
            'forma01' => 'true',
            'forma14' => 'true',
            'estampillas' => 'true',
            'identificador' => 'B',
            'alicuota' => 7,
        ]);
        DB::table('ucd_denominacions')->insert([
            'denominacion' => '3',
            'forma01' => 'true',
            'forma14' => 'true',
            'estampillas' => 'true',
            'identificador' => 'C',
            'alicuota' => 7,
        ]);
        DB::table('ucd_denominacions')->insert([
            'denominacion' => '5',
            'forma01' => 'true',
            'forma14' => 'true',
            'estampillas' => 'true',
            'identificador' => 'D',
            'alicuota' => 7,
        ]);
        DB::table('ucd_denominacions')->insert([
            'denominacion' => '10',
            'forma01' => 'true',
            'forma14' => 'true',
            'estampillas' => 'false',
            'identificador' => 'E',
            'alicuota' => 7,
        ]);
        DB::table('ucd_denominacions')->insert([
            'denominacion' => '15',
            'forma01' => 'false',
            'forma14' => 'true',
            'estampillas' => 'false',
            'identificador' => 'F',
            'alicuota' => 7,
        ]);
        DB::table('ucd_denominacions')->insert([
            'denominacion' => '100',
            'forma01' => 'false',
            'forma14' => 'true',
            'estampillas' => 'false',
            'identificador' => 'G',
            'alicuota' => 7,
        ]);
        DB::table('ucd_denominacions')->insert([
            'denominacion' => '250',
            'forma01' => 'false',
            'forma14' => 'true',
            'estampillas' => 'false',
            'identificador' => 'H',
            'alicuota' => 7,
        ]);
        DB::table('ucd_denominacions')->insert([
            'denominacion' => '500',
            'forma01' => 'false',
            'forma14' => 'true',
            'estampillas' => 'false',
            'identificador' => 'I',
            'alicuota' => 7,
        ]);


        DB::table('ucd_denominacions')->insert([
            'denominacion' => '2.5',
            'forma01' => 'false',
            'forma14' => 'true',
            'estampillas' => 'false',
            'identificador' => 'J',
            'alicuota' => 8,
        ]);
        DB::table('ucd_denominacions')->insert([
            'denominacion' => '3',
            'forma01' => 'false',
            'forma14' => 'true',
            'estampillas' => 'false',
            'identificador' => 'K',
            'alicuota' => 8,
        ]);

        DB::table('ucd_denominacions')->insert([
            'denominacion' => '4',
            'forma01' => 'false',
            'forma14' => 'true',
            'estampillas' => 'false',
            'identificador' => 'L',
            'alicuota' => 7,
        ]);
        DB::table('ucd_denominacions')->insert([
            'denominacion' => '8',
            'forma01' => 'false',
            'forma14' => 'true',
            'estampillas' => 'false',
            'identificador' => 'M',
            'alicuota' => 7,
        ]);
        DB::table('ucd_denominacions')->insert([
            'denominacion' => '0',
            'forma01' => 'false',
            'forma14' => 'true',
            'estampillas' => 'false',
            'identificador' => 'N',
            'alicuota' => 7,
        ]);

    }
}
