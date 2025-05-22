<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ////// PRINCIPAL 
        Permission::create(['name' => 'home',
                        'description' => 'Principal',
                        'module' => 10,
                        'priority'=> 2]);
        Permission::create(['name' => 'home.apertura_taquilla',
                        'description' => 'Aperturar Taquilla',
                        'module' => 10,
                        'priority'=> 1]);
        Permission::create(['name' => 'home.fondo_caja',
                        'description' => 'Fondo de caja',
                        'module' => 10,
                        'priority'=> 2]);
        Permission::create(['name' => 'home.alert_boveda',
                        'description' => 'Alerta Boveda',
                        'module' => 10,
                        'priority'=> 2]);
        Permission::create(['name' => 'home.modal_boveda',
                        'description' => 'Modal Ingreso Boveda',
                        'module' => 10,
                        'priority'=> 2]);
        Permission::create(['name' => 'home.ingreso_boveda',
                        'description' => 'Ingreso Boveda',
                        'module' => 10,
                        'priority'=> 2]);
        Permission::create(['name' => 'home.historial_boveda',
                        'description' => 'Historial de Boveda',
                        'module' => 10,
                        'priority'=> 2]);
        Permission::create(['name' => 'home.cierre_taquilla',
                        'description' => 'Cierre de Taquilla',
                        'module' => 10,
                        'priority'=> 1]);

        //// HOME: PAPEL DAÑADO
        Permission::create(['name' => 'home.modal_clave',
                        'description' => 'Imprimir | Falla de Impresión',
                        'module' => 10,
                        'priority'=> 1]);
        Permission::create(['name' => 'home.clave',
                        'description' => 'Clave',
                        'module' => 10,
                        'priority'=> 2]);
        Permission::create(['name' => 'home.modal_imprimir',
                        'description' => 'Modal Imprimir',
                        'module' => 10,
                        'priority'=> 2]);
        Permission::create(['name' => 'home.imprimir',
                        'description' => 'Imprimir',
                        'module' => 10,
                        'priority'=> 2]);


        /// CONSULTA 
        Permission::create(['name' => 'consulta',
                        'description' => 'Consultar Timbre Fiscal',
                        'module' => 1,
                        'priority'=> 1]);
        Permission::create(['name' => 'consulta.search_tfe',
                        'description' => 'Buscar TFE-14',
                        'module' => 1,
                        'priority'=> 2]);
        Permission::create(['name' => 'consulta.search_est',
                        'description' => 'Buscar Estampilla',
                        'module' => 1,
                        'priority'=> 2]);


        //// CIERRE
        Permission::create(['name' => 'cierre',
                        'description' => 'Ver Cierres del día (General y Taquillas)',
                        'module' => 2,
                        'priority'=> 1]);
        Permission::create(['name' => 'cierre.comprobar',
                        'description' => 'Comprobar cierres taquillas',
                        'module' => 2,
                        'priority'=> 1]);
        Permission::create(['name' => 'cierre.registro_cierre',
                        'description' => 'Realizar Cierre General del día',
                        'module' => 2,
                        'priority'=> 1]);
        Permission::create(['name' => 'cierre.arqueo',
                        'description' => 'Ver Cierre de Taquillas del día',
                        'module' => 2,
                        'priority'=> 1]);


        ///// CIERRE DIARIO 
        Permission::create(['name' => 'cierre_diario',
                        'description' => 'Ver Cierre del Día',
                        'module' => 2,
                        'priority'=> 1]);
        Permission::create(['name' => 'pdf_cierre_diario',
                        'description' => 'Descargar PDF | Cierre del día',
                        'module' => 2,
                        'priority'=> 1]);


        //// HISTORIAL CIERRES
        Permission::create(['name' => 'historial_cierre',
                        'description' => 'Ver Historial de Cierres',
                        'module' => 2,
                        'priority'=> 1]);
        Permission::create(['name' => 'historial_cierre.search',
                        'description' => 'Buscar cierre',
                        'module' => 2,
                        'priority'=> 2]);

        //// REPORTE ANUAL 
        Permission::create(['name' => 'reporte_anual',
                        'description' => 'Ver Reportes Anuales',
                        'module' => 2,
                        'priority'=> 1]);
        Permission::create(['name' => 'reporte_anual.pdf_reporte',
                        'description' => 'Descargar reportes anuales',
                        'module' => 2,
                        'priority'=> 1]);




        Permission::create(['name' => '',
                        'description' => 'Principal',
                        'module' => 1,
                        'priority'=> 1]);
        Permission::create(['name' => '',
                        'description' => 'Principal',
                        'module' => 1,
                        'priority'=> 1]);
        Permission::create(['name' => '',
                        'description' => 'Principal',
                        'module' => 1,
                        'priority'=> 1]);
        Permission::create(['name' => '',
                        'description' => 'Principal',
                        'module' => 1,
                        'priority'=> 1]);
        Permission::create(['name' => '',
                        'description' => 'Principal',
                        'module' => 1,
                        'priority'=> 1]);
        Permission::create(['name' => '',
                        'description' => 'Principal',
                        'module' => 1,
                        'priority'=> 1]);
        Permission::create(['name' => '',
                        'description' => 'Principal',
                        'module' => 1,
                        'priority'=> 1]);
        Permission::create(['name' => '',
                        'description' => 'Principal',
                        'module' => 1,
                        'priority'=> 1]);
        Permission::create(['name' => '',
                        'description' => 'Principal',
                        'module' => 1,
                        'priority'=> 1]);
        Permission::create(['name' => '',
                        'description' => 'Principal',
                        'module' => 1,
                        'priority'=> 1]);
        Permission::create(['name' => '',
                        'description' => 'Principal',
                        'module' => 1,
                        'priority'=> 1]);
        Permission::create(['name' => '',
                        'description' => 'Principal',
                        'module' => 1,
                        'priority'=> 1]);
        Permission::create(['name' => '',
                        'description' => 'Principal',
                        'module' => 1,
                        'priority'=> 1]);
        Permission::create(['name' => '',
                        'description' => 'Principal',
                        'module' => 1,
                        'priority'=> 1]);
        Permission::create(['name' => '',
                        'description' => 'Principal',
                        'module' => 1,
                        'priority'=> 1]);
        Permission::create(['name' => '',
                        'description' => 'Principal',
                        'module' => 1,
                        'priority'=> 1]);
        Permission::create(['name' => '',
                        'description' => 'Principal',
                        'module' => 1,
                        'priority'=> 1]);
        Permission::create(['name' => '',
                        'description' => 'Principal',
                        'module' => 1,
                        'priority'=> 1]);
        Permission::create(['name' => '',
                        'description' => 'Principal',
                        'module' => 1,
                        'priority'=> 1]);
        Permission::create(['name' => '',
                        'description' => 'Principal',
                        'module' => 1,
                        'priority'=> 1]);

      



    }
}
