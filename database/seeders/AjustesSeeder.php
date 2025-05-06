<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AjustesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // EMISION TFE14
        DB::table('configuraciones')->insert([
            'nombre' => 'Timbres por Rollo',
            'descripcion' => 'Cantidad de Timbres Fiscales TFE-14 que contiene un (1) rollo.',
            'valor' => '60',
            'unidad' => 26,
            'module' => 23
        ]);
        DB::table('configuraciones')->insert([
            'nombre' => 'Timbres emitidos por Lote',
            'descripcion' => 'Cantidad Total de Timbres Fiscales TFE-14 emitidos en un Lote de rollos.',
            'valor' => '6000',
            'unidad' => 26,
            'module' => 23
        ]);
        DB::table('configuraciones')->insert([
            'nombre' => 'No. Inicio | Correlativo de papel',
            'descripcion' => 'Número (Correlativo de papel) por el cual se iniciará la emisión de Timbres Fiscales TFE-14.',
            'valor' => NUll,
            'unidad' => 26,
            'module' => 23
        ]);
        DB::table('configuraciones')->insert([
            'nombre' => 'Cantidad de Timbres emitidos por Lote',
            'descripcion' => 'Cantidad de Timbres Fiscales que se emitirán por Lote de Papel de TFE-14.',
            'valor' => '1000',
            'unidad' => 26, //und
            'module' => 23
        ]);

        // VENTA
        DB::table('configuraciones')->insert([
            'nombre' => 'Precio U.T.',
            'descripcion' => 'Precio de la Unidad Tributaria',
            'valor' => '9.00',
            'unidad' => 25,
            'module' => 24
        ]);


        // EMISIÓN DE ESTAMPILLAS
        DB::table('configuraciones')->insert([
            'nombre' => 'Cantidad de Timbres emitidos por Lote',
            'descripcion' => 'Cantidad de Timbres Fiscales que se emitirán por Lote de Papel de Estampillas.',
            'valor' => '1000',
            'unidad' => 26,
            'module' => 27
        ]);


        // UCD
        DB::table('configuraciones')->insert([
            'nombre' => 'Precio U.C.D',
            'descripcion' => 'Precio (Bs.) de U.C.D.',
            'valor' => '100.6',
            'unidad' => 25,
            'module' => 28
        ]);
    }
}
