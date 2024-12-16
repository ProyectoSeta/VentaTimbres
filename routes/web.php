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


Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('user');
Route::post('/user', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');


/////////////////////  HOME
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/home/apertura_taquilla', [App\Http\Controllers\HomeController::class, 'apertura_taquilla'])->name('home.apertura_taquilla');
Route::post('/home/fondo_caja', [App\Http\Controllers\HomeController::class, 'fondo_caja'])->name('home.fondo_caja');
Route::post('/home/alert_boveda', [App\Http\Controllers\HomeController::class, 'alert_boveda'])->name('home.alert_boveda');
Route::post('/home/modal_boveda', [App\Http\Controllers\HomeController::class, 'modal_boveda'])->name('home.modal_boveda');
Route::post('/home/ingreso_boveda', [App\Http\Controllers\HomeController::class, 'ingreso_boveda'])->name('home.ingreso_boveda');
Route::post('/home/historial_boveda', [App\Http\Controllers\HomeController::class, 'historial_boveda'])->name('home.historial_boveda');



///////////////////// EMISIÓN ROLLOS FORMA 14
Route::get('/emision_rollos', [App\Http\Controllers\RollosController::class, 'index'])->name('emision_rollos');
Route::post('/rollos/modal_emitir', [App\Http\Controllers\RollosController::class, 'modal_emitir'])->name('rollos.modal_emitir');
Route::post('/rollos/emitir', [App\Http\Controllers\RollosController::class, 'emitir'])->name('rollos.emitir');
Route::post('/rollos/modal_enviar', [App\Http\Controllers\RollosController::class, 'modal_enviar'])->name('rollos.modal_enviar');
Route::post('/rollos/detalles', [App\Http\Controllers\RollosController::class, 'detalles'])->name('rollos.detalles');
Route::post('/rollos/enviar_inventario', [App\Http\Controllers\RollosController::class, 'enviar_inventario'])->name('rollos.enviar_inventario');
Route::post('/rollos/delete', [App\Http\Controllers\RollosController::class, 'delete'])->name('rollos.delete');
/////////PDF: ROLLOS A EMITIR
Route::get('/rollos/pdf', [App\Http\Controllers\RollosController::class, 'pdf'])->name('rollos.pdf');



//////////////////EMISIÓN ESTAMPILLAS
Route::get('/emision_estampillas', [App\Http\Controllers\EstampillasController::class, 'index'])->name('emision_estampillas');
Route::post('/emision_estampillas/denominacions', [App\Http\Controllers\EstampillasController::class, 'denominacions'])->name('emision_estampillas.denominacions');
Route::post('/emision_estampillas/modal_emitir', [App\Http\Controllers\EstampillasController::class, 'modal_emitir'])->name('emision_estampillas.modal_emitir');
Route::post('/emision_estampillas/emitir_estampillas', [App\Http\Controllers\EstampillasController::class, 'emitir_estampillas'])->name('emision_estampillas.emitir_estampillas');
Route::post('/emision_estampillas/detalles', [App\Http\Controllers\EstampillasController::class, 'detalles'])->name('emision_estampillas.detalles');
Route::post('/emision_estampillas/modal_enviar', [App\Http\Controllers\EstampillasController::class, 'modal_enviar'])->name('emision_estampillas.modal_enviar');
Route::post('/emision_estampillas/enviar_inventario', [App\Http\Controllers\EstampillasController::class, 'enviar_inventario'])->name('emision_estampillas.enviar_inventario');
Route::post('/emision_estampillas/delete', [App\Http\Controllers\EstampillasController::class, 'delete'])->name('emision_estampillas.delete');
/////////PDF: TIRAS A EMITIR 
Route::get('/emision_estampillas/pdf', [App\Http\Controllers\EstampillasController::class, 'pdf'])->name('emision_estampillas.pdf');



///////////////////// ASIGNACIÓN ROLLOS FORMA 14
Route::get('/asignar', [App\Http\Controllers\AsignarController::class, 'index'])->name('asignar');
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
Route::get('/asignar/pdf_forma14', [App\Http\Controllers\AsignarController::class, 'pdf_forma14'])->name('asignar.pdf_forma14');
Route::get('/asignar/pdf_estampillas', [App\Http\Controllers\AsignarController::class, 'pdf_estampillas'])->name('asignar.pdf_estampillas');



///////////////////// ASIGNACIONES DE TAQUILLAS
Route::get('/timbres_asignados', [App\Http\Controllers\AsignadoTaquillasController::class, 'index'])->name('timbres_asignados');
Route::post('/timbres_asignados/modal_forma14', [App\Http\Controllers\AsignadoTaquillasController::class, 'modal_forma14'])->name('timbres_asignados.modal_forma14');
Route::post('/timbres_asignados/recibido_forma14', [App\Http\Controllers\AsignadoTaquillasController::class, 'recibido_forma14'])->name('timbres_asignados.recibido_forma14');
Route::post('/timbres_asignados/modal_estampillas', [App\Http\Controllers\AsignadoTaquillasController::class, 'modal_estampillas'])->name('timbres_asignados.modal_estampillas');
Route::post('/timbres_asignados/recibido_estampillas', [App\Http\Controllers\AsignadoTaquillasController::class, 'recibido_estampillas'])->name('timbres_asignados.recibido_estampillas');



///////////////////// TAQUILLAS - INVENTARIO
Route::get('/inventario_taquillas', [App\Http\Controllers\InventarioTaquillasController::class, 'index'])->name('inventario_taquillas');
Route::post('/inventario_taquillas/detalle', [App\Http\Controllers\InventarioTaquillasController::class, 'detalle'])->name('inventario_taquillas.detalle');



//////////////////////  VENTA FORMA 14 - ESTAMPILLAS
Route::get('/venta', [App\Http\Controllers\VentaController::class, 'index'])->name('venta');
Route::post('/venta/search', [App\Http\Controllers\VentaController::class, 'search'])->name('venta.search');
Route::post('/venta/ucd_tramite', [App\Http\Controllers\VentaController::class, 'ucd_tramite'])->name('venta.ucd_tramite');
Route::post('/venta/tramites', [App\Http\Controllers\VentaController::class, 'tramites'])->name('venta.tramites');
Route::post('/venta/metros', [App\Http\Controllers\VentaController::class, 'metros'])->name('venta.metros');
Route::post('/venta/disponibilidad', [App\Http\Controllers\VentaController::class, 'disponibilidad'])->name('venta.disponibilidad');

Route::post('/venta/total', [App\Http\Controllers\VentaController::class, 'total'])->name('venta.total');
Route::post('/venta/debitado', [App\Http\Controllers\VentaController::class, 'debitado'])->name('venta.debitado');
Route::post('/venta/add_contribuyente', [App\Http\Controllers\VentaController::class, 'add_contribuyente'])->name('venta.add_contribuyente');

Route::post('/venta/venta', [App\Http\Controllers\VentaController::class, 'venta'])->name('venta.venta');


///////////////////// APERTURA TAQUILLAS
Route::get('/apertura', [App\Http\Controllers\AperturaTaquillasController::class, 'index'])->name('apertura');
Route::post('/apertura/modal_apertura', [App\Http\Controllers\AperturaTaquillasController::class, 'modal_apertura'])->name('apertura.modal_apertura');
Route::post('/apertura/apertura_taquillas', [App\Http\Controllers\AperturaTaquillasController::class, 'apertura_taquillas'])->name('apertura.apertura_taquillas');
Route::post('/apertura/search_fecha', [App\Http\Controllers\AperturaTaquillasController::class, 'search_fecha'])->name('apertura.search_fecha');



///////////////////// SEDES TAQUILLAS
Route::get('/sede_taquilla', [App\Http\Controllers\SedeTaquillaController::class, 'index'])->name('sede_taquilla');
Route::post('/sede_taquilla/new_sede', [App\Http\Controllers\SedeTaquillaController::class, 'new_sede'])->name('sede_taquilla.new_sede');
Route::post('/sede_taquilla/new_taquillero', [App\Http\Controllers\SedeTaquillaController::class, 'new_taquillero'])->name('sede_taquilla.new_taquillero');
Route::post('/sede_taquilla/modal_new_taquilla', [App\Http\Controllers\SedeTaquillaController::class, 'modal_new_taquilla'])->name('sede_taquilla.modal_new_taquilla');
Route::post('/sede_taquilla/new_taquilla', [App\Http\Controllers\SedeTaquillaController::class, 'new_taquilla'])->name('sede_taquilla.new_taquilla');

Route::post('/sede_taquilla/update_clave', [App\Http\Controllers\SedeTaquillaController::class, 'update_clave'])->name('sede_taquilla.update_clave');
Route::post('/sede_taquilla/habilitar_taquilla', [App\Http\Controllers\SedeTaquillaController::class, 'habilitar_taquilla'])->name('sede_taquilla.habilitar_taquilla');





// Route::post('/sede_taquilla/taquilleros', [App\Http\Controllers\SedeTaquillaController::class, 'taquilleros'])->name('sede_taquilla.taquilleros');

