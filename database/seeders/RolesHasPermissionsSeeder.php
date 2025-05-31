<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesHasPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // SUPERINTENDENTE
        $roleSuperInt = Role::create(['name' => 'Superintendente']);
        $roleSuperInt->syncPermissions('home',
                                        'consulta',
                                        'cierre_diario','pdf_cierre_diario',
                                        'historial_cierre',
                                        'cierre.arqueo',
                                        'arqueo','arqueo.timbres','arqueo.detalle_venta','arqueo.detalle_forma','arqueo.cierre_punto','pdf_cierre_taquilla',
                                        'reporte_anual',
                                        'emision_papel','papel.emitir_f14','papel.emitir_estampillas','papel.delete_f14','papel.delete_estampillas','papel.enviar_inv_f14','papel.enviar_inv_estampillas','papel.pdf_tfes','papel.pdf_estampillas',
                                        'inventario_papel',
                                        'inventario_ut',
                                        'emision_ucd','emision_ucd.emitir_denominacion','emision_ucd.delete','emision_ucd.pdf_emision',
                                        'historial_asignaciones',
                                        'inventario_taquillas',
                                        'sede_taquilla','sede_taquilla.new_sede','sede_taquilla.new_taquillero','sede_taquilla.new_taquilla','sede_taquilla.habilitar_taquilla','sede_taquilla.habilitar_taquillero',
                                        'usuarios','usuarios.store','usuarios.editar',
                                        'new_pass','new_pass.update');

        // RECAUDACIÓN
        $roleRecaud = Role::create(['name' => 'Recaudación']);
        $roleRecaud->syncPermissions('home',
                                        'consulta',
                                        'cierre','cierre.registro_cierre','cierre.arqueo', ///completo
                                        'arqueo','arqueo.timbres','arqueo.detalle_venta','arqueo.detalle_forma','arqueo.cierre_punto','pdf_cierre_taquilla',
                                        'cierre_diario','pdf_cierre_diario',
                                        'historial_cierre',
                                        'reporte_anual',
                                        'emision_papel','papel.emitir_f14','papel.emitir_estampillas','papel.delete_f14','papel.delete_estampillas','papel.enviar_inv_f14','papel.enviar_inv_estampillas','papel.pdf_tfes','papel.pdf_estampillas', ////completo
                                        'inventario_papel',/// completo
                                        'inventario_ut',/// completo
                                        'emision_ucd','emision_ucd.emitir_denominacion','emision_ucd.delete','emision_ucd.pdf_emision',
                                        'asignar','asignar.asignar_forma_14','asignar.asignar_estampillas','asignar.pdf_forma14','asignar.pdf_estampillas',
                                        'historial_asignaciones', ///completo
                                        'apertura','apertura.apertura_taquillas','apertura.search_fecha', /// completo
                                        'inventario_taquillas',
                                        'sede_taquilla','sede_taquilla.new_sede','sede_taquilla.new_taquillero','sede_taquilla.new_taquilla','sede_taquilla.update_clave','sede_taquilla.habilitar_taquilla','sede_taquilla.habilitar_taquillero', /// completo
                                        'new_pass','new_pass.update',
                                        'proveedores','proveedores.store');



        // COORDINADOR DE TAQUILLAS
        $roleCoordinador = Role::create(['name' => 'Coordinador']);
        $roleCoordinador->syncPermissions('home',
                                        'consulta',
                                        'cierre','cierre.registro_cierre','cierre.arqueo', ///completo
                                        'arqueo','arqueo.timbres','arqueo.detalle_venta','arqueo.detalle_forma','arqueo.cierre_punto','pdf_cierre_taquilla',
                                        'cierre_diario','pdf_cierre_diario',
                                        'historial_cierre',
                                        'reporte_anual',
                                        'emision_papel','papel.emitir_f14','papel.emitir_estampillas','papel.delete_f14','papel.delete_estampillas','papel.enviar_inv_f14','papel.enviar_inv_estampillas','papel.pdf_tfes','papel.pdf_estampillas', ////completo
                                        'inventario_papel',/// completo
                                        'inventario_ut',/// completo
                                        'emision_ucd','emision_ucd.emitir_denominacion','emision_ucd.delete','emision_ucd.pdf_emision', ///completo
                                        'asignar','asignar.asignar_forma_14','asignar.asignar_estampillas','asignar.pdf_forma14','asignar.pdf_estampillas',
                                        'historial_asignaciones', ///completo
                                        'apertura','apertura.apertura_taquillas','apertura.search_fecha', /// completo
                                        'inventario_taquillas',
                                        'sede_taquilla','sede_taquilla.new_sede','sede_taquilla.new_taquillero','sede_taquilla.new_taquilla','sede_taquilla.update_clave','sede_taquilla.habilitar_taquilla','sede_taquilla.habilitar_taquillero', /// completo
                                        'new_pass','new_pass.update',
                                        'anular');
    

        

        

        // TECNOLOGÍA
        $roleTecno = Role::create(['name' => 'Tecnología']);
        $roleTecno->syncPermissions('home',
                                    'consulta',
                                    'sede_taquilla','sede_taquilla.new_sede','sede_taquilla.new_taquillero','sede_taquilla.new_taquilla','sede_taquilla.update_clave','sede_taquilla.habilitar_taquilla','sede_taquilla.habilitar_taquillero', /// completo
                                    'ajustes','ajustes.update',
                                    'usuarios','usuarios.store','usuarios.editar',
                                    'bitacora',
                                    'roles','roles.store','roles.ver','roles.update',
                                    'rol_usuario','rol_usuario.update',
                                    'new_pass','new_pass.update');
        

        // AUDITORIA
        $roleAut = Role::create(['name' => 'Auditoría']);
        $roleAut->syncPermissions('home',
                                    'inventario_papel',
                                    'inventario_ut',
                                    'historial_asignaciones', ///completo
                                    'cierre.arqueo', 
                                    'arqueo',
                                    'cierre_diario','pdf_cierre_diario',
                                    'historial_cierre',
                                    'new_pass','new_pass.update');
        

        // TAQUILLERO
        $roleTaq = Role::create(['name' => 'Taquillero']);
        $roleTaq->syncPermissions('home','home.apertura_taquilla','home.cierre_taquilla','home.modal_clave',
                                    'venta',
                                    'arqueo','arqueo.timbres','arqueo.detalle_venta','arqueo.detalle_forma','arqueo.cierre_punto','pdf_cierre_taquilla',
                                    'timbres_asignados','timbres_asignados.recibido_forma14','timbres_asignados.recibido_estampillas',
                                    'new_pass','new_pass.update',
                                    'timbre'
                                    );
          
    }
}
