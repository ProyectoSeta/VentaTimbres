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
        DB::table('configuraciones')->insert([
            'nombre' => 'Timbres por Rollo',
            'descripcion' => 'Cantidad de Timbres Fiscales TFE-14 que contiene un (1) rollo.',
            'valor' => '60',
            'module' => 23
        ]);
        DB::table('configuraciones')->insert([
            'nombre' => 'Timbres emitidos por Lote',
            'descripcion' => 'Cantidad Total de Timbres Fiscales TFE-14 emitidos en un Lote de rollos.',
            'valor' => '6000',
            'module' => 23
        ]);
        DB::table('configuraciones')->insert([
            'nombre' => 'No. Inicio | Correlativo de papel',
            'descripcion' => 'Número (Correlativo de papel) por el cual se iniciará la emisión de Timbres Fiscales TFE-14.',
            'valor' => NUll,
            'module' => 23
        ]);
    }
}
