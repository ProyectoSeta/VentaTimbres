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


        //// PAPEL DE SEGURIDAD
        Permission::create(['name' => 'emision_papel',
                        'description' => 'Ver Emisión de Papel',
                        'module' => 3,
                        'priority'=> 1]);
        Permission::create(['name' => 'papel.modal_f14',
                        'description' => 'Modal emitir TFE14',
                        'module' => 3,
                        'priority'=> 2]);
        Permission::create(['name' => 'papel.modal_estampillas',
                        'description' => 'Modal emitir Estampillas',
                        'module' => 3,
                        'priority'=> 2]);
        Permission::create(['name' => 'papel.emitir_f14',
                        'description' => 'Emitir Papel para TFE-14',
                        'module' => 3,
                        'priority'=> 1]);
        Permission::create(['name' => 'papel.emitir_estampillas',
                        'description' => 'Emitir Papel para Estampillas',
                        'module' => 3,
                        'priority'=> 1]);
        Permission::create(['name' => 'papel.delete_f14',
                        'description' => 'Eliminar Emision de Papel (TFE-14)',
                        'module' => 3,
                        'priority'=> 1]);
        Permission::create(['name' => 'papel.delete_estampillas',
                        'description' => 'Eliminar Emision de Papel (Estampillas)',
                        'module' => 3,
                        'priority'=> 1]);
        Permission::create(['name' => 'papel.enviar_inv_f14',
                        'description' => 'Enviar Lote de Papel a Inventario (TFFE-14)',
                        'module' => 3,
                        'priority'=> 1]);
        Permission::create(['name' => 'papel.enviar_inv_estampillas',
                        'description' => 'Enviar Lote de Papel a Inventario (Estampillas)',
                        'module' => 3,
                        'priority'=> 1]);
        Permission::create(['name' => 'papel.detalle_f14',
                        'description' => 'Detalles Emisión TFE-14',
                        'module' => 3,
                        'priority'=> 2]);
        Permission::create(['name' => 'papel.detalle_estampillas',
                        'description' => 'Detalle Emisión Estampillas',
                        'module' => 3,
                        'priority'=> 2]);
        Permission::create(['name' => 'papel.pdf_tfes',
                        'description' => 'Imprimir Reporte de Lote emitido (TFE-14)',
                        'module' => 3,
                        'priority'=> 1]);
        Permission::create(['name' => 'papel.pdf_estampillas',
                        'description' => 'Imprimir Reporte de Lote emitido (Estampillas)',
                        'module' => 1,
                        'priority'=> 1]);


        /////INVENTARIO DE PAPEL
        Permission::create(['name' => 'inventario_papel',
                        'description' => 'Ver Inventario | Papel de Seguridad',
                        'module' => 3,
                        'priority'=> 1]);

        ///// INVENTARIO DE ESTAMPILLAS UT
        Permission::create(['name' => 'inventario_ut',
                        'description' => 'Ver Inventario | Estampillas U.T.',
                        'module' => 3,
                        'priority'=> 1]);


        ///// ASIGNACION DE UCD
        Permission::create(['name' => 'emision_ucd',
                        'description' => 'Ver Asignación de UCD | Estampillas',
                        'module' => 4,
                        'priority'=> 1]);
        Permission::create(['name' => 'emision_ucd.denominacions',
                        'description' => 'Denominaciones',
                        'module' => 4,
                        'priority'=> 2]);
        Permission::create(['name' => 'emision_ucd.modal_emitir',
                        'description' => 'Modal emitir',
                        'module' => 4,
                        'priority'=> 2]);
        Permission::create(['name' => 'emision_ucd.emitir_denominacion',
                        'description' => 'Asignar Denominaciones a Estampillas',
                        'module' => 4,
                        'priority'=> 1]);
        Permission::create(['name' => 'emision_ucd.detalle',
                        'description' => 'Detalle',
                        'module' => 4,
                        'priority'=> 2]);
        Permission::create(['name' => 'emision_ucd.delete',
                        'description' => 'Eliminar Asignaciones de Denominación a Estampillas',
                        'module' => 4,
                        'priority'=> 1]);
        Permission::create(['name' => 'emision_ucd.pdf_emision',
                        'description' => 'Descargar PDF | Asignaciones realizadas',
                        'module' => 4,
                        'priority'=> 1]);




        /////// ASIGNACIÓN DE TIMBRES
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
