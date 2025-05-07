<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClasificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Inventario',
        ]);
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Asignado',
        ]);


        DB::table('clasificacions')->insert([
            'nombre_clf' => 'En Uso',
        ]);
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Reserva',
        ]);
        
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Emisión',
        ]);

        ////////MODULO
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Rollos',
        ]);


        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Vendido',
        ]);
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Sin recibir',
        ]);


        //////ESTADOS RITEA
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Vigente',
        ]);
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Vencido',
        ]);
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Verificando',
        ]);


        /////ESTADOS DATAS 
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'En Revisión',
        ]);
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Corrección',
        ]);
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Por Aprobación',
        ]);
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Verificado',
        ]);

        //////ESTADOS: TAQUILLAS - FUNCIONARIOS - SEDES
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Habilitado',
        ]);
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Deshabilitado',
        ]);

        //////////ESTADO EMISION TFE(PARTE 2)
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'En Proceso',
        ]);


        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Recibido',
        ]);


        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Emitido',
        ]);
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Entregado',
        ]);
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Solvente',
        ]);


        // CLASIFICACIÓN CONFIGURACIONES
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'emision_tfe14',
        ]);
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'venta',
        ]);

        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Bs',
        ]);
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Und',
        ]);

        DB::table('clasificacions')->insert([
            'nombre_clf' => 'emision_est',
        ]);
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'ucd',
        ]);


        // CONDICION DETALLE VENTA TFE14
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Anulado',
        ]);
        DB::table('clasificacions')->insert([
            'nombre_clf' => 'Vuelto a imprimir',
        ]);

    }
}
