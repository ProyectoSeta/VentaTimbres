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


//////////////////////  VENTA FORMA 14 - ESTAMPILLAS
Route::get('/venta', [App\Http\Controllers\VentaController::class, 'index'])->name('venta');
Route::post('/search', [App\Http\Controllers\VentaController::class, 'search'])->name('venta.search');
Route::post('/ucd_tramite', [App\Http\Controllers\VentaController::class, 'ucd_tramite'])->name('venta.ucd_tramite');
Route::post('/tramites', [App\Http\Controllers\VentaController::class, 'tramites'])->name('venta.tramites');
Route::post('/total', [App\Http\Controllers\VentaController::class, 'total'])->name('venta.total');
Route::post('/debitado', [App\Http\Controllers\VentaController::class, 'debitado'])->name('venta.debitado');
Route::post('/add_contribuyente', [App\Http\Controllers\VentaController::class, 'add_contribuyente'])->name('venta.add_contribuyente');
Route::post('/venta_f14', [App\Http\Controllers\VentaController::class, 'venta_f14'])->name('venta.venta_f14');


///////////////////// EMISIÓN ROLLOS FORMA 14
Route::get('/emision_rollos', [App\Http\Controllers\RollosController::class, 'index'])->name('emision_rollos');
Route::post('/emitir', [App\Http\Controllers\RollosController::class, 'emitir'])->name('rollos.emitir');
Route::post('/modal_enviar', [App\Http\Controllers\RollosController::class, 'modal_enviar'])->name('rollos.modal_enviar');
Route::post('/enviar_inventario', [App\Http\Controllers\RollosController::class, 'enviar_inventario'])->name('rollos.enviar_inventario');
/////////PDF: ROLLOS A EMITIR
Route::get('/pdf', [App\Http\Controllers\RollosController::class, 'pdf'])->name('rollos.pdf');


//////////////////EMISIÓN ESTAMPILLAS
Route::get('/emision_estampillas', [App\Http\Controllers\EstampillasController::class, 'index'])->name('emision_estampillas');
Route::post('/denominacions', [App\Http\Controllers\EstampillasController::class, 'denominacions'])->name('emision_estampillas.denominacions');
Route::post('/modal_emitir', [App\Http\Controllers\EstampillasController::class, 'modal_emitir'])->name('emision_estampillas.modal_emitir');
Route::post('/emitir', [App\Http\Controllers\EstampillasController::class, 'emitir'])->name('emision_estampillas.emitir');


///////////////////// ASIGNACIÓN ROLLOS FORMA 14
Route::get('/asignar', [App\Http\Controllers\AsignarController::class, 'index'])->name('asignar');
Route::post('/taquillas', [App\Http\Controllers\AsignarController::class, 'taquillas'])->name('asignar.taquillas');
Route::post('/funcionario', [App\Http\Controllers\AsignarController::class, 'funcionario'])->name('asignar.funcionario');
Route::post('/asignar_forma_14', [App\Http\Controllers\AsignarController::class, 'asignar_forma_14'])->name('asignar.asignar_forma_14');
/////////PDF: ROLLOS A EMITIR
Route::get('/pdf_forma14', [App\Http\Controllers\AsignarController::class, 'pdf_forma14'])->name('asignar.pdf_forma14');

///////////////////// ASIGNACIONES DE TAQUILLAS
Route::get('/timbres_asignados', [App\Http\Controllers\AsignadoTaquillasController::class, 'index'])->name('timbres_asignados');