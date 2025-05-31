<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PHPMailerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth\login');
});

Auth::routes();


// Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('user');
// Route::post('/user', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');



/////////////////////  HOME
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/home/apertura_taquilla', [App\Http\Controllers\HomeController::class, 'apertura_taquilla'])->name('home.apertura_taquilla');
Route::post('/home/fondo_caja', [App\Http\Controllers\HomeController::class, 'fondo_caja'])->name('home.fondo_caja');
Route::post('/home/alert_boveda', [App\Http\Controllers\HomeController::class, 'alert_boveda'])->name('home.alert_boveda');
Route::post('/home/modal_boveda', [App\Http\Controllers\HomeController::class, 'modal_boveda'])->name('home.modal_boveda');
Route::post('/home/ingreso_boveda', [App\Http\Controllers\HomeController::class, 'ingreso_boveda'])->name('home.ingreso_boveda');
Route::post('/home/historial_boveda', [App\Http\Controllers\HomeController::class, 'historial_boveda'])->name('home.historial_boveda');
Route::post('/home/cierre_taquilla', [App\Http\Controllers\HomeController::class, 'cierre_taquilla'])->name('home.cierre_taquilla');

/////PRUEBA IMPRESION DE TIMBRE
Route::post('/home/timbre', [App\Http\Controllers\HomeController::class, 'timbre'])->name('home.timbre');

//// PAPEL DAÑADO
Route::post('/home/modal_clave', [App\Http\Controllers\HomeController::class, 'modal_clave'])->name('home.modal_clave');
Route::post('/home/clave', [App\Http\Controllers\HomeController::class, 'clave'])->name('home.clave');
Route::post('/home/modal_imprimir', [App\Http\Controllers\HomeController::class, 'modal_imprimir'])->name('home.modal_imprimir');
Route::post('/home/imprimir', [App\Http\Controllers\HomeController::class, 'imprimir'])->name('home.imprimir');





///////////////////// CONSULTA
Route::get('/consulta', [App\Http\Controllers\ConsultaTimbresController::class, 'index'])->middleware('can:consulta')->name('consulta');
Route::post('/consulta/search_tfe', [App\Http\Controllers\ConsultaTimbresController::class, 'search_tfe'])->name('consulta.search_tfe');
Route::post('/consulta/search_est', [App\Http\Controllers\ConsultaTimbresController::class, 'search_est'])->name('consulta.search_est');




///////////////////// CIERRE
Route::get('/cierre', [App\Http\Controllers\CierreController::class, 'index'])->middleware('can:cierre')->name('cierre');
Route::post('/cierre/comprobar', [App\Http\Controllers\CierreController::class, 'comprobar'])->name('cierre.comprobar');
Route::post('/cierre/registro_cierre', [App\Http\Controllers\CierreController::class, 'registro_cierre'])->name('cierre.registro_cierre');
Route::get('/cierre/arqueo/{id?}/', [App\Http\Controllers\CierreController::class, 'arqueo'])->middleware('can:cierre.arqueo')->name('cierre.arqueo');

/////// CIERRE DIARIO
Route::get('/cierre_diario/{fecha?}/', [App\Http\Controllers\CierreDiarioController::class, 'index'])->middleware('can:cierre_diario')->name('cierre_diario');
Route::get('/pdf_cierre_diario/{id?}/', [App\Http\Controllers\CierreDiarioController::class, 'pdf_cierre_diario'])->middleware('can:pdf_cierre_diario')->name('pdf_cierre_diario');

/////////////////// HISTORIAL CIERRES
Route::get('/historial_cierre', [App\Http\Controllers\HistorialCierresController::class, 'index'])->middleware('can:historial_cierre')->name('historial_cierre');
Route::post('/historial_cierre/search', [App\Http\Controllers\HistorialCierresController::class, 'search'])->name('historial_cierre.search');

///////////////////// REPORTE ANUAL
Route::get('/reporte_anual', [App\Http\Controllers\ReporteAnualController::class, 'index'])->middleware('can:reporte_anual')->name('reporte_anual');
Route::get('/reporte_anual/pdf_reporte/{year?}/', [App\Http\Controllers\ReporteAnualController::class, 'pdf_reporte'])->middleware('can:reporte_anual.pdf_reporte')->name('reporte_anual.pdf_reporte');


//////////////////// REPORTE TRIMESTRAL
// Route::get('/trimestres/{year?}/', [App\Http\Controllers\ReporteTrimestralController::class, 'index'])->name('trimestres');
// Route::get('/reportes_trimestral/{tri?}/{year?}/', [App\Http\Controllers\ReporteTrimestralController::class, 'reportes_trimestral'])->name('reportes_trimestral');




///////////////////// PAPEL DE SEGURIDAD
Route::get('/emision_papel', [App\Http\Controllers\PapelSeguridadController::class, 'index'])->middleware('can:emision_papel')->name('emision_papel');
Route::post('/papel/modal_f14', [App\Http\Controllers\PapelSeguridadController::class, 'modal_f14'])->name('papel.modal_f14');
Route::post('/papel/modal_estampillas', [App\Http\Controllers\PapelSeguridadController::class, 'modal_estampillas'])->name('papel.modal_estampillas');
Route::post('/papel/emitir_f14', [App\Http\Controllers\PapelSeguridadController::class, 'emitir_f14'])->name('papel.emitir_f14');
Route::post('/papel/emitir_estampillas', [App\Http\Controllers\PapelSeguridadController::class, 'emitir_estampillas'])->name('papel.emitir_estampillas');
Route::post('/papel/delete_f14', [App\Http\Controllers\PapelSeguridadController::class, 'delete_f14'])->name('papel.delete_f14');
Route::post('/papel/delete_estampillas', [App\Http\Controllers\PapelSeguridadController::class, 'delete_estampillas'])->name('papel.delete_estampillas');
Route::post('/papel/enviar_inv_f14', [App\Http\Controllers\PapelSeguridadController::class, 'enviar_inv_f14'])->name('papel.enviar_inv_f14');
Route::post('/papel/enviar_inv_estampillas', [App\Http\Controllers\PapelSeguridadController::class, 'enviar_inv_estampillas'])->name('papel.enviar_inv_estampillas');
Route::post('/papel/detalle_f14', [App\Http\Controllers\PapelSeguridadController::class, 'detalle_f14'])->name('papel.detalle_f14');
Route::post('/papel/detalle_estampillas', [App\Http\Controllers\PapelSeguridadController::class, 'detalle_estampillas'])->name('papel.detalle_estampillas');

/////////PDF: PAPEL DE SEGURIDAD EMITIDOS
Route::get('/papel/pdf_tfes', [App\Http\Controllers\PapelSeguridadController::class, 'pdf_tfes'])->middleware('can:papel.pdf_tfes')->name('papel.pdf_tfes');
Route::get('/papel/pdf_estampillas', [App\Http\Controllers\PapelSeguridadController::class, 'pdf_estampillas'])->middleware('can:papel.pdf_estampillas')->name('papel.pdf_estampillas');






///////////////////// INVENTARIO PAPEL DE SEGURIDAD
Route::get('/inventario_papel', [App\Http\Controllers\InventarioPapelController::class, 'index'])->middleware('can:inventario_papel')->name('inventario_papel');

///////////////////// INVENTARIO ESTAMPILLAS UT
Route::get('/inventario_ut', [App\Http\Controllers\InventarioUTController::class, 'index'])->middleware('can:inventario_ut')->name('inventario_ut');





///////////////////// EMISION DE DENOMINACIONES UCD - ESTAMPILLAS
Route::get('/emision_ucd', [App\Http\Controllers\EmisionUcdController::class, 'index'])->middleware('can:emision_ucd')->name('emision_ucd');
Route::post('/emision_ucd/denominacions', [App\Http\Controllers\EmisionUcdController::class, 'denominacions'])->name('emision_ucd.denominacions');
Route::post('/emision_ucd/modal_emitir', [App\Http\Controllers\EmisionUcdController::class, 'modal_emitir'])->name('emision_ucd.modal_emitir');
Route::post('/emision_ucd/emitir_denominacion', [App\Http\Controllers\EmisionUcdController::class, 'emitir_denominacion'])->name('emision_ucd.emitir_denominacion');
Route::post('/emision_ucd/detalle', [App\Http\Controllers\EmisionUcdController::class, 'detalle'])->name('emision_ucd.detalle');
Route::post('/emision_ucd/delete', [App\Http\Controllers\EmisionUcdController::class, 'delete'])->name('emision_ucd.delete');

/////////PDF:  EMISION DE DENOMINACIONES UCD - ESTAMPILLAS
Route::get('/emision_ucd/pdf_emision', [App\Http\Controllers\EmisionUcdController::class, 'pdf_emision'])->middleware('can:emision_ucd.pdf_emision')->name('emision_ucd.pdf_emision');







///////////////////// ASIGNACIÓN DE TIMBRES
Route::get('/asignar', [App\Http\Controllers\AsignarController::class, 'index'])->middleware('can:asignar')->name('asignar');
Route::post('/asignar/taquillas', [App\Http\Controllers\AsignarController::class, 'taquillas'])->name('asignar.taquillas');
Route::post('/asignar/funcionario', [App\Http\Controllers\AsignarController::class, 'funcionario'])->name('asignar.funcionario');
Route::post('/asignar/asignar_forma_14', [App\Http\Controllers\AsignarController::class, 'asignar_forma_14'])->name('asignar.asignar_forma_14');
Route::post('/asignar/content_estampillas', [App\Http\Controllers\AsignarController::class, 'content_estampillas'])->name('asignar.content_estampillas');
Route::post('/asignar/denominacions', [App\Http\Controllers\AsignarController::class, 'denominacions'])->name('asignar.denominacions');
Route::post('/asignar/asignar_estampillas', [App\Http\Controllers\AsignarController::class, 'asignar_estampillas'])->name('asignar.asignar_estampillas');
Route::post('/asignar/info_taquilla', [App\Http\Controllers\AsignarController::class, 'info_taquilla'])->name('asignar.info_taquilla');
Route::post('/asignar/detalle_estampillas', [App\Http\Controllers\AsignarController::class, 'detalle_estampillas'])->name('asignar.detalle_estampillas');
Route::post('/asignar/detalle_rollos', [App\Http\Controllers\AsignarController::class, 'detalle_rollos'])->name('asignar.detalle_rollos');
/////////PDF: CONSTANCIA DE ASIGNACIÓN
Route::get('/asignar/pdf_forma14', [App\Http\Controllers\AsignarController::class, 'pdf_forma14'])->middleware('can:asignar.pdf_forma14')->name('asignar.pdf_forma14');
Route::get('/asignar/pdf_estampillas', [App\Http\Controllers\AsignarController::class, 'pdf_estampillas'])->middleware('can:asignar.pdf_estampillas')->name('asignar.pdf_estampillas');



///////////////////// ASIGNACIONES DE TAQUILLAS
Route::get('/timbres_asignados', [App\Http\Controllers\AsignadoTaquillasController::class, 'index'])->middleware('can:timbres_asignados')->name('timbres_asignados');
Route::post('/timbres_asignados/modal_forma14', [App\Http\Controllers\AsignadoTaquillasController::class, 'modal_forma14'])->name('timbres_asignados.modal_forma14');
Route::post('/timbres_asignados/recibido_forma14', [App\Http\Controllers\AsignadoTaquillasController::class, 'recibido_forma14'])->name('timbres_asignados.recibido_forma14');
Route::post('/timbres_asignados/modal_estampillas', [App\Http\Controllers\AsignadoTaquillasController::class, 'modal_estampillas'])->name('timbres_asignados.modal_estampillas');
Route::post('/timbres_asignados/recibido_estampillas', [App\Http\Controllers\AsignadoTaquillasController::class, 'recibido_estampillas'])->name('timbres_asignados.recibido_estampillas');


///////////////////// HISTORIAL ASIGNACIONES
Route::get('/historial_asignaciones', [App\Http\Controllers\HistorialAsignacionesController::class, 'index'])->middleware('can:historial_asignaciones')->name('historial_asignaciones');



///////////////////// APERTURA TAQUILLAS
Route::get('/apertura', [App\Http\Controllers\AperturaTaquillasController::class, 'index'])->middleware('can:apertura')->name('apertura');
Route::post('/apertura/modal_apertura', [App\Http\Controllers\AperturaTaquillasController::class, 'modal_apertura'])->name('apertura.modal_apertura');
Route::post('/apertura/apertura_taquillas', [App\Http\Controllers\AperturaTaquillasController::class, 'apertura_taquillas'])->name('apertura.apertura_taquillas');
Route::post('/apertura/search_fecha', [App\Http\Controllers\AperturaTaquillasController::class, 'search_fecha'])->name('apertura.search_fecha');



///////////////////// TAQUILLAS - INVENTARIO
Route::get('/inventario_taquillas', [App\Http\Controllers\InventarioTaquillasController::class, 'index'])->middleware('can:inventario_taquillas')->name('inventario_taquillas');
Route::post('/inventario_taquillas/detalle', [App\Http\Controllers\InventarioTaquillasController::class, 'detalle'])->name('inventario_taquillas.detalle');




///////////////////// SEDES TAQUILLAS
Route::get('/sede_taquilla', [App\Http\Controllers\SedeTaquillaController::class, 'index'])->middleware('can:sede_taquilla')->name('sede_taquilla');
Route::post('/sede_taquilla/new_sede', [App\Http\Controllers\SedeTaquillaController::class, 'new_sede'])->name('sede_taquilla.new_sede');
Route::post('/sede_taquilla/new_taquillero', [App\Http\Controllers\SedeTaquillaController::class, 'new_taquillero'])->name('sede_taquilla.new_taquillero');
Route::post('/sede_taquilla/modal_new_taquilla', [App\Http\Controllers\SedeTaquillaController::class, 'modal_new_taquilla'])->name('sede_taquilla.modal_new_taquilla');
Route::post('/sede_taquilla/new_taquilla', [App\Http\Controllers\SedeTaquillaController::class, 'new_taquilla'])->name('sede_taquilla.new_taquilla');

Route::post('/sede_taquilla/update_clave', [App\Http\Controllers\SedeTaquillaController::class, 'update_clave'])->name('sede_taquilla.update_clave');
Route::post('/sede_taquilla/habilitar_taquilla', [App\Http\Controllers\SedeTaquillaController::class, 'habilitar_taquilla'])->name('sede_taquilla.habilitar_taquilla');
Route::post('/sede_taquilla/habilitar_taquillero', [App\Http\Controllers\SedeTaquillaController::class, 'habilitar_taquillero'])->name('sede_taquilla.habilitar_taquillero');




///////////////////// AJUSTES
Route::get('/ajustes', [App\Http\Controllers\AjustesController::class, 'index'])->middleware('can:ajustes')->name('ajustes');
Route::post('/ajustes/modal_editar', [App\Http\Controllers\AjustesController::class, 'modal_editar'])->name('ajustes.modal_editar');
Route::post('/ajustes/update', [App\Http\Controllers\AjustesController::class, 'update'])->name('ajustes.update');



///////////USUARIOS
Route::get('/usuarios', [App\Http\Controllers\UsuariosController::class, 'index'])->middleware('can:usuarios')->name('usuarios');
Route::post('/usuarios/store', [App\Http\Controllers\UsuariosController::class, 'store'])->name('usuarios.store');
Route::post('/usuarios/modal_edit', [App\Http\Controllers\UsuariosController::class, 'modal_edit'])->name('usuarios.modal_edit');
Route::post('/usuarios/editar', [App\Http\Controllers\UsuariosController::class, 'editar'])->name('usuarios.editar');



///////////BITACORA
Route::get('/bitacora', [App\Http\Controllers\BitacoraController::class, 'index'])->middleware('can:bitacora')->name('bitacora');


// ROLES
Route::get('/roles', [App\Http\Controllers\RolesController::class, 'index'])->middleware('can:roles')->name('roles');
Route::post('/roles/modal_new', [App\Http\Controllers\RolesController::class, 'modal_new'])->name('roles.modal_new');
Route::post('/roles/store', [App\Http\Controllers\RolesController::class, 'store'])->name('roles.store');
Route::post('/roles/ver', [App\Http\Controllers\RolesController::class, 'ver'])->name('roles.ver');
Route::post('/roles/modal_editar', [App\Http\Controllers\RolesController::class, 'modal_editar'])->name('roles.modal_editar');
Route::post('/roles/update', [App\Http\Controllers\RolesController::class, 'update'])->name('roles.update');

// ROLES DE USUARIOS
Route::get('/rol_usuario', [App\Http\Controllers\UserRolesController::class, 'index'])->middleware('can:rol_usuario')->name('rol_usuario');
Route::post('/rol_usuario/modal_edit', [App\Http\Controllers\UserRolesController::class, 'modal_edit'])->name('rol_usuario.modal_edit');
Route::post('/rol_usuario/roles', [App\Http\Controllers\UserRolesController::class, 'roles'])->name('rol_usuario.roles');
Route::post('/rol_usuario/update', [App\Http\Controllers\UserRolesController::class, 'update'])->name('rol_usuario.update');




//////////////////NUEVA CONTRASEÑA
Route::get('/new_pass', [App\Http\Controllers\NewPassController::class, 'index'])->middleware('can:new_pass')->name('new_pass');
Route::post('/new_pass/update', [App\Http\Controllers\NewPassController::class, 'update'])->name('new_pass.update');







//////////////////////  VENTA FORMA 14 - ESTAMPILLAS
Route::get('/venta', [App\Http\Controllers\VentaController::class, 'index'])->middleware('can:venta')->name('venta');
Route::post('/venta/search', [App\Http\Controllers\VentaController::class, 'search'])->name('venta.search');
Route::post('/venta/ucd_tramite', [App\Http\Controllers\VentaController::class, 'ucd_tramite'])->name('venta.ucd_tramite');
Route::post('/venta/tramites', [App\Http\Controllers\VentaController::class, 'tramites'])->name('venta.tramites');
Route::post('/venta/metros', [App\Http\Controllers\VentaController::class, 'metros'])->name('venta.metros');
Route::post('/venta/alicuota', [App\Http\Controllers\VentaController::class, 'alicuota'])->name('venta.alicuota');
Route::post('/venta/disponibilidad', [App\Http\Controllers\VentaController::class, 'disponibilidad'])->name('venta.disponibilidad');
Route::post('/venta/folios', [App\Http\Controllers\VentaController::class, 'folios'])->name('venta.folios');

Route::post('/venta/total', [App\Http\Controllers\VentaController::class, 'total'])->name('venta.total');
Route::post('/venta/debitado', [App\Http\Controllers\VentaController::class, 'debitado'])->name('venta.debitado');
Route::post('/venta/add_contribuyente', [App\Http\Controllers\VentaController::class, 'add_contribuyente'])->name('venta.add_contribuyente');

Route::post('/venta/estampillas', [App\Http\Controllers\VentaController::class, 'estampillas'])->name('venta.estampillas');
Route::post('/venta/est_detalle', [App\Http\Controllers\VentaController::class, 'est_detalle'])->name('venta.est_detalle');
Route::post('/venta/update_inv_taquilla', [App\Http\Controllers\VentaController::class, 'update_inv_taquilla'])->name('venta.update_inv_taquilla');
Route::post('/venta/delete_tramite', [App\Http\Controllers\VentaController::class, 'delete_tramite'])->name('venta.delete_tramite');
Route::post('/venta/add_estampilla', [App\Http\Controllers\VentaController::class, 'add_estampilla'])->name('venta.add_estampilla');


Route::post('/venta/agregar', [App\Http\Controllers\VentaController::class, 'agregar'])->name('venta.agregar');
Route::post('/venta/quitar', [App\Http\Controllers\VentaController::class, 'quitar'])->name('venta.quitar');

Route::post('/venta/venta', [App\Http\Controllers\VentaController::class, 'venta'])->name('venta.venta');




///////////////////// ARQUEO
Route::get('/arqueo', [App\Http\Controllers\ArqueoTaquillaController::class, 'index'])->middleware('can:arqueo')->name('arqueo');
Route::post('/arqueo/contribuyente', [App\Http\Controllers\ArqueoTaquillaController::class, 'contribuyente'])->name('arqueo.contribuyente');
Route::post('/arqueo/timbres', [App\Http\Controllers\ArqueoTaquillaController::class, 'timbres'])->name('arqueo.timbres');
Route::post('/arqueo/detalle_venta', [App\Http\Controllers\ArqueoTaquillaController::class, 'detalle_venta'])->name('arqueo.detalle_venta');
Route::post('/arqueo/detalle_forma', [App\Http\Controllers\ArqueoTaquillaController::class, 'detalle_forma'])->name('arqueo.detalle_forma');
Route::post('/arqueo/cierre_punto', [App\Http\Controllers\ArqueoTaquillaController::class, 'cierre_punto'])->name('arqueo.cierre_punto');
Route::post('/arqueo/cierre_cuenta', [App\Http\Controllers\ArqueoTaquillaController::class, 'cierre_cuenta'])->name('arqueo.cierre_cuenta');
Route::get('/pdf_cierre_taquilla/{id?}/', [App\Http\Controllers\ArqueoTaquillaController::class, 'pdf_cierre_taquilla'])->middleware('can:pdf_cierre_taquilla')->name('pdf_cierre_taquilla');




   

/////IMPRIMIR TIMBRE
Route::get('/timbre/{t?}/', [App\Http\Controllers\TimbresController::class, 'index'])->middleware('can:timbre')->name('timbre');

/////PROVEEDORES
Route::get('/proveedores', [App\Http\Controllers\ProveedoresController::class, 'index'])->middleware('can:proveedores')->name('proveedores');
Route::post('/proveedores/store', [App\Http\Controllers\ProveedoresController::class, 'store'])->name('proveedores.store');



/////VISTA QR AFUERA
Route::get('/qr/{id?}/', [App\Http\Controllers\QrController::class, 'index'])->name('qr');


////ANULACION DE TIMBRE
Route::get('/anular', [App\Http\Controllers\AnulacionController::class, 'index'])->middleware('can:anular')->name('anular');
Route::post('/anular/search_tfe', [App\Http\Controllers\AnulacionController::class, 'search_tfe'])->name('anular.search_tfe');
Route::post('/anular/anular', [App\Http\Controllers\AnulacionController::class, 'anular'])->name('anular.anular');


///////////////////// EMISIÓN ROLLOS FORMA 14
// Route::get('/emision_rollos', [App\Http\Controllers\RollosController::class, 'index'])->name('emision_rollos');
// Route::post('/rollos/modal_emitir', [App\Http\Controllers\RollosController::class, 'modal_emitir'])->name('rollos.modal_emitir');
// Route::post('/rollos/emitir', [App\Http\Controllers\RollosController::class, 'emitir'])->name('rollos.emitir');
// Route::post('/rollos/modal_enviar', [App\Http\Controllers\RollosController::class, 'modal_enviar'])->name('rollos.modal_enviar');
// Route::post('/rollos/detalles', [App\Http\Controllers\RollosController::class, 'detalles'])->name('rollos.detalles');
// Route::post('/rollos/enviar_inventario', [App\Http\Controllers\RollosController::class, 'enviar_inventario'])->name('rollos.enviar_inventario');
// Route::post('/rollos/delete', [App\Http\Controllers\RollosController::class, 'delete'])->name('rollos.delete');
// /////////PDF: ROLLOS A EMITIR
// Route::get('/rollos/pdf', [App\Http\Controllers\RollosController::class, 'pdf'])->name('rollos.pdf');



// //////////////////EMISIÓN ESTAMPILLAS
// Route::get('/emision_estampillas', [App\Http\Controllers\EstampillasController::class, 'index'])->name('emision_estampillas');
// Route::post('/emision_estampillas/denominacions', [App\Http\Controllers\EstampillasController::class, 'denominacions'])->name('emision_estampillas.denominacions');
// Route::post('/emision_estampillas/modal_emitir', [App\Http\Controllers\EstampillasController::class, 'modal_emitir'])->name('emision_estampillas.modal_emitir');
// Route::post('/emision_estampillas/emitir_estampillas', [App\Http\Controllers\EstampillasController::class, 'emitir_estampillas'])->name('emision_estampillas.emitir_estampillas');
// Route::post('/emision_estampillas/detalles', [App\Http\Controllers\EstampillasController::class, 'detalles'])->name('emision_estampillas.detalles');
// Route::post('/emision_estampillas/modal_enviar', [App\Http\Controllers\EstampillasController::class, 'modal_enviar'])->name('emision_estampillas.modal_enviar');
// Route::post('/emision_estampillas/enviar_inventario', [App\Http\Controllers\EstampillasController::class, 'enviar_inventario'])->name('emision_estampillas.enviar_inventario');
// Route::post('/emision_estampillas/delete', [App\Http\Controllers\EstampillasController::class, 'delete'])->name('emision_estampillas.delete');
// /////////PDF: TIRAS A EMITIR 
// Route::get('/emision_estampillas/pdf', [App\Http\Controllers\EstampillasController::class, 'pdf'])->name('emision_estampillas.pdf');





















