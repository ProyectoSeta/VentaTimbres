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
                        'description' => 'Ver Arqueo del día | Taquillas ',
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
                        'description' => 'Enviar Lote de Papel a Inventario (TFE-14)',
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
        Permission::create(['name' => 'asignar',
                        'description' => 'Ver Asignación de Timbres | Taquillas',
                        'module' => 5,
                        'priority'=> 1]);
        Permission::create(['name' => 'asignar.taquillas',
                        'description' => 'Taquillas',
                        'module' => 5,
                        'priority'=> 2]);
        Permission::create(['name' => 'asignar.funcionario',
                        'description' => 'Funcionario',
                        'module' => 5,
                        'priority'=> 2]);                
        Permission::create(['name' => 'asignar.asignar_forma_14',
                        'description' => 'Asignar Timbres Fiscales a Taquillas (TFE-14)',
                        'module' => 5,
                        'priority'=> 1]);
        Permission::create(['name' => 'asignar.content_estampillas',
                        'description' => 'Modal Estampillas',
                        'module' => 5,
                        'priority'=> 2]);
        Permission::create(['name' => 'asignar.denominacions',
                        'description' => 'Denominaciones',
                        'module' => 5,
                        'priority'=> 2]);
        Permission::create(['name' => 'asignar.asignar_estampillas',
                        'description' => 'Asignar Timbres Fiscales a Taquillas (Estampillas)',
                        'module' => 5,
                        'priority'=> 1]);
        Permission::create(['name' => 'asignar.info_taquilla',
                        'description' => 'Info Taquilla',
                        'module' => 5,
                        'priority'=> 2]);
        Permission::create(['name' => 'asignar.detalle_estampillas',
                        'description' => 'Detalle Asignación',
                        'module' => 5,
                        'priority'=> 2]);
        Permission::create(['name' => 'asignar.detalle_rollos',
                        'description' => 'Detalle Asignación Rollos',
                        'module' => 5,
                        'priority'=> 2]);
        Permission::create(['name' => 'asignar.pdf_forma14',
                        'description' => 'Descargar PDF | Asignación Forma 14',
                        'module' => 5,
                        'priority'=> 1]);
        Permission::create(['name' => 'asignar.pdf_estampillas',
                        'description' => 'Descargar PDF | Estampillas',
                        'module' => 5,
                        'priority'=> 1]);


        ////ASIGNACIONES A TAQUILLA
        Permission::create(['name' => 'timbres_asignados',
                        'description' => 'Ver Timbres Asignados (Taquilla)',
                        'module' => 5,
                        'priority'=> 1]);
        Permission::create(['name' => 'timbres_asignados.modal_forma14',
                        'description' => 'Modal Timbres Asignados (TFE-14)',
                        'module' => 5,
                        'priority'=> 2]);
        Permission::create(['name' => 'timbres_asignados.recibido_forma14',
                        'description' => 'Aceptar Timbres Asignados (TFE-14)',
                        'module' => 5,
                        'priority'=> 1]);
        Permission::create(['name' => 'timbres_asignados.modal_estampillas',
                        'description' => 'Modal Timbres Asignados (Estampillas)',
                        'module' => 5,
                        'priority'=> 2]);
        Permission::create(['name' => 'timbres_asignados.recibido_estampillas',
                        'description' => 'Aceptar Timbres Asignados (Estampillas)',
                        'module' => 5,
                        'priority'=> 1]);


        ///// HISTORIAL ASIGNACIONES
        Permission::create(['name' => 'historial_asignaciones',
                        'description' => 'Ver Historial de Asignaciones',
                        'module' => 5,
                        'priority'=> 1]);


        //// APERTURAR TAQUILLAS
        Permission::create(['name' => 'apertura',
                        'description' => 'Ver Apertura de Taquillas',
                        'module' => 6,
                        'priority'=> 1]);
        Permission::create(['name' => 'apertura.modal_apertura',
                        'description' => 'Modal Apertura',
                        'module' => 6,
                        'priority'=> 2]);
        Permission::create(['name' => 'apertura.apertura_taquillas',
                        'description' => 'Aperturar Taquillas',
                        'module' => 6,
                        'priority'=> 1]);
        Permission::create(['name' => 'apertura.search_fecha',
                        'description' => 'Buscar Aperturas de Taquillas',
                        'module' => 6,
                        'priority'=> 1]);

        /////INVENTARIO DE TAQUILLAS
        Permission::create(['name' => 'inventario_taquillas',
                        'description' => 'Ver Inventario de Taquillas',
                        'module' => 6,
                        'priority'=> 1]);
        Permission::create(['name' => 'inventario_taquillas.detalle',
                        'description' => 'Detalles',
                        'module' => 6,
                        'priority'=> 2]);


        ////// SEDES / TAQUILLAS
        Permission::create(['name' => 'sede_taquilla',
                        'description' => 'Ver Sedes y Taquillas',
                        'module' => 7,
                        'priority'=> 1]);
        Permission::create(['name' => 'sede_taquilla.new_sede',
                        'description' => 'Crear Sede',
                        'module' => 7,
                        'priority'=> 1]);
        Permission::create(['name' => 'sede_taquilla.new_taquillero',
                        'description' => 'Crear Taquillero',
                        'module' => 7,
                        'priority'=> 1]);
        Permission::create(['name' => 'sede_taquilla.modal_new_taquilla',
                        'description' => 'Modal nueva Taquilla',
                        'module' => 7,
                        'priority'=> 2]);
        Permission::create(['name' => 'sede_taquilla.new_taquilla',
                        'description' => 'Crear Taquilla',
                        'module' => 7,
                        'priority'=> 1]);
        Permission::create(['name' => 'sede_taquilla.update_clave',
                        'description' => 'Actualizar Clave de Taquilla',
                        'module' => 7,
                        'priority'=> 1]);
        Permission::create(['name' => 'sede_taquilla.habilitar_taquilla',
                        'description' => 'Habilitar/Deshabilitar Taquillas',
                        'module' => 7,
                        'priority'=> 1]);
        Permission::create(['name' => 'sede_taquilla.habilitar_taquillero',
                        'description' => 'Habilitar/Deshabilitar Taquilleras',
                        'module' => 7,
                        'priority'=> 1]);


        ///////AJUSTES
        Permission::create(['name' => 'ajustes',
                        'description' => 'Ver Ajustes',
                        'module' => 8,
                        'priority'=> 1]);
        Permission::create(['name' => 'ajustes.modal_editar',
                        'description' => 'Modal editar',
                        'module' => 8,
                        'priority'=> 2]);
        Permission::create(['name' => 'ajustes.update',
                        'description' => 'Actualizar datos',
                        'module' => 8,
                        'priority'=> 1]);

        ///// USUARIOS
        Permission::create(['name' => 'usuarios',
                        'description' => 'Ver Usuarios',
                        'module' => 8,
                        'priority'=> 1]);
        Permission::create(['name' => 'usuarios.store',
                        'description' => 'Registrar Usuarios',
                        'module' => 8,
                        'priority'=> 1]);
        Permission::create(['name' => 'usuarios.modal_edit',
                        'description' => 'Modal editar',
                        'module' => 8,
                        'priority'=> 2]);
        Permission::create(['name' => 'usuarios.editar',
                        'description' => 'Editar Usuario',
                        'module' => 8,
                        'priority'=> 1]);


        //// BITACORA
        Permission::create(['name' => 'bitacora',
                        'description' => 'Ver Bitácoras',
                        'module' => 8,
                        'priority'=> 1]);


        ////NUEVA CONTRASEÑA
        Permission::create(['name' => 'new_pass',
                        'description' => 'Ver Mi Cuenta',
                        'module' => 9,
                        'priority'=> 1]);
        Permission::create(['name' => 'new_pass.update',
                        'description' => 'Actualizar Contraseña',
                        'module' => 9,
                        'priority'=> 1]);


        //// VENTA 
        Permission::create(['name' => 'venta',
                        'description' => 'Realizar Venta de Timbres',
                        'module' => 10,
                        'priority'=> 1]);
       

        //// ARQUEO
        Permission::create(['name' => 'arqueo',
                        'description' => 'Ver Arqueo de Taquilla',
                        'module' => 10,
                        'priority'=> 1]);
        Permission::create(['name' => 'arqueo.contribuyente',
                        'description' => 'Datos Contribuyentes',
                        'module' => 10,
                        'priority'=> 2]);
        Permission::create(['name' => 'arqueo.timbres',
                        'description' => 'Ver Timbres emitidos en la Venta',
                        'module' => 10,
                        'priority'=> 1]);
        Permission::create(['name' => 'arqueo.detalle_venta',
                        'description' => 'Ver Detalle de la Venta',
                        'module' => 10,
                        'priority'=> 1]);
        Permission::create(['name' => 'arqueo.detalle_forma',
                        'description' => 'Ver Detalle de la Forma (Timbre Fiscal)',
                        'module' => 10,
                        'priority'=> 1]);
        Permission::create(['name' => 'arqueo.cierre_punto',
                        'description' => 'Ver Cierre de Punto',
                        'module' => 10,
                        'priority'=> 1]);
        Permission::create(['name' => 'pdf_cierre_taquilla',
                        'description' => 'Descargar PDF | Arqueo de Taquilla',
                        'module' => 10,
                        'priority'=> 1]);

      
       // ROLES
        Permission::create(['name' => 'roles',
                                'description' => 'Ver Roles',
                                'module' => 8,
                                'priority'=> 1]);
        Permission::create(['name' => 'roles.modal_new',
                                'description' => 'Modal Nuevo Rol',
                                'module' => 8,
                                'priority'=> 2]);
        Permission::create(['name' => 'roles.store',
                                'description' => 'Crear Rol',
                                'module' => 8,
                                'priority'=> 1]);
        Permission::create(['name' => 'roles.ver',
                                'description' => 'Ver Permisos del Rol',
                                'module' => 8,
                                'priority'=> 1]);
        Permission::create(['name' => 'roles.modal_editar',
                                'description' => 'Modal Editar Rol',
                                'module' => 8,
                                'priority'=> 2]);
        Permission::create(['name' => 'roles.update',
                                'description' => 'Editar Rol',
                                'module' => 8,
                                'priority'=> 1]);
        
        // ROLES DE USUARIOS
        Permission::create(['name' => 'rol_usuario',
                                'description' => 'Ver Roles de Usuario',
                                'module' => 8,
                                'priority'=> 1]);
        Permission::create(['name' => 'rol_usuario.modal_edit',
                                'description' => 'Editar Rol de Usuario',
                                'module' => 8,
                                'priority'=> 2]);
        Permission::create(['name' => 'rol_usuario.roles',
                                'description' => 'Consulta Roles',
                                'module' => 8,
                                'priority'=> 2]);
        Permission::create(['name' => 'rol_usuario.update',
                                'description' => 'Editar Rol de Usuario',
                                'module' => 8,
                                'priority'=> 1]); 


        /////VENTA
        Permission::create(['name' => 'timbre',
                                'description' => 'Imprimir Timbre Fiscal',
                                'module' => 10,
                                'priority'=> 1]); 

        /////PAPEL SEGURIDAD: PROVEEDORES
        Permission::create(['name' => 'proveedores',
                                'description' => 'Ver Proveedores',
                                'module' => 3,
                                'priority'=> 1]); 
        Permission::create(['name' => 'proveedores.store',
                                'description' => 'Registrar nuevos Proveedores',
                                'module' => 3,
                                'priority'=> 1]); 
        /// CONSULTA PT.2
        Permission::create(['name' => 'anular',
                        'description' => 'Anular Timbres',
                        'module' => 1,
                        'priority'=> 1]);

    }
}
