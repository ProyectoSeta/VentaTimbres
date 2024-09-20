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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/home/libro', [App\Http\Controllers\HomeController::class, 'libro'])->name('home.libro');


Route::get('/venta', [App\Http\Controllers\VentaController::class, 'index'])->name('venta');



Route::get('/forgot_password', [App\Http\Controllers\ForgotController::class, 'index'])->name('forgot_password');
Route::post('/forgot_password/email', [App\Http\Controllers\ForgotController::class, 'email'])->name('forgot_password.email');
Route::get('/forgot_password/recover/{token}', [App\Http\Controllers\ForgotController::class, 'recover'])->name('forgot_password.recover');
Route::post('/forgot_password/update', [App\Http\Controllers\ForgotController::class, 'update'])->name('forgot_password.update');


// ///////PHP MAILER
Route::get("email", [App\Http\Controllers\PHPMailerController::class, "email"])->name("email");
Route::get("send-email", [App\Http\Controllers\PHPMailerController::class, "composeEmail"])->name("send-email");
// Route::get('send-email/{email}', [App\Http\Controllers\PHPMailerController::class, 'composeEmail'])->name('send-email');



Route::get('/solicitud', [App\Http\Controllers\SolicitudController::class, 'index'])->name('solicitud');

/*Usuario sujeto pasivo*/


Route::get('/user/{slug?}/roles', [App\Http\Controllers\UserController::class, 'roles'])->name('user.roles');
Route::get('/user/{slug?}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
Route::put('/user/{slug?}/updat', [App\Http\Controllers\UserController::class, 'updat'])->name('user.updat');
Route::put('/user/{slug?}', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');

// /////// CANTERAS
Route::get('/cantera', [App\Http\Controllers\CanteraController::class, 'index'])->name('cantera');
Route::post('/cantera/modal_new', [App\Http\Controllers\CanteraController::class, 'modal_new'])->name('cantera.modal_new');
Route::post('/cantera/store', [App\Http\Controllers\CanteraController::class, 'store'])->name('cantera.store');
Route::post('/cantera/editar', [App\Http\Controllers\CanteraController::class, 'editar'])->name('cantera.editar');
Route::post('/cantera/modal_edit', [App\Http\Controllers\CanteraController::class, 'modal_edit'])->name('cantera.modal_edit');
Route::post('/cantera/minerales', [App\Http\Controllers\CanteraController::class, 'minerales'])->name('cantera.minerales');
Route::post('/cantera/info_denegada', [App\Http\Controllers\CanteraController::class, 'info_denegada'])->name('cantera.info_denegada');
Route::post('/cantera/info_limite', [App\Http\Controllers\CanteraController::class, 'info_limite'])->name('cantera.info_limite');
Route::post('/cantera', [App\Http\Controllers\CanteraController::class, 'destroy'])->name('cantera.destroy');

// ///////SUJETO PASIVO
Route::get('/sujeto', [App\Http\Controllers\SujetoController::class, 'index'])->name('sujeto');
Route::post('/sujeto/representante', [App\Http\Controllers\SujetoController::class, 'representante'])->name('sujeto.representante');
Route::post('/sujeto/edit_estado', [App\Http\Controllers\SujetoController::class, 'edit_estado'])->name('sujeto.edit_estado');
Route::post('/sujeto/update_estado', [App\Http\Controllers\SujetoController::class, 'update_estado'])->name('sujeto.update_estado');

// ////////SOLICITUD
Route::get('/solicitud', [App\Http\Controllers\SolicitudController::class, 'index'])->name('solicitud');
Route::post('/solicitud/new_solicitud', [App\Http\Controllers\SolicitudController::class, 'new_solicitud'])->name('solicitud.new_solicitud');
Route::post('/solicitud/calcular', [App\Http\Controllers\SolicitudController::class, 'calcular'])->name('solicitud.calcular');
Route::post('/solicitud/store', [App\Http\Controllers\SolicitudController::class, 'store'])->name('solicitud.store');
Route::post('/solicitud/talonarios', [App\Http\Controllers\SolicitudController::class, 'talonarios'])->name('solicitud.talonarios');
// Route::post('/solicitud/pago', [App\Http\Controllers\SolicitudController::class, 'pago'])->name('solicitud.pago');
Route::post('/solicitud', [App\Http\Controllers\SolicitudController::class, 'destroy'])->name('solicitud.destroy');


// ///////////APROBACIÓN DE SOLICITUDES
Route::get('/aprobacion_solicitud', [App\Http\Controllers\AprobacionController::class, 'index'])->name('aprobacion');
Route::post('/aprobacion_solicitud/sujeto', [App\Http\Controllers\AprobacionController::class, 'sujeto'])->name('aprobacion.sujeto');
Route::post('/aprobacion_solicitud/aprobar', [App\Http\Controllers\AprobacionController::class, 'aprobar'])->name('aprobacion.aprobar');
Route::post('/aprobacion_solicitud/correlativo', [App\Http\Controllers\AprobacionController::class, 'correlativo'])->name('aprobacion.correlativo');
Route::post('/aprobacion_solicitud/info', [App\Http\Controllers\AprobacionController::class, 'info'])->name('aprobacion.info');
Route::post('/aprobacion_solicitud/denegarInfo', [App\Http\Controllers\AprobacionController::class, 'denegarInfo'])->name('aprobacion.denegarInfo');
Route::post('/aprobacion_solicitud/denegar', [App\Http\Controllers\AprobacionController::class, 'denegar'])->name('aprobacion.denegar');
Route::get('/aprobacion_solicitud/qr', [App\Http\Controllers\AprobacionController::class, 'qr'])->name('aprobacion.qr');
Route::post('/aprobacion_solicitud/min_talonarios', [App\Http\Controllers\AprobacionController::class, 'min_talonarios'])->name('aprobacion.min_talonarios');


// ///////////HISTORIAL DE SOLICITUDES
Route::get('/hsolicitudes', [App\Http\Controllers\HSolicitudesController::class, 'index'])->name('hsolicitudes');


// //////////CONTROL DE CANTERAS
Route::get('/control_canteras', [App\Http\Controllers\ControlCanterasController::class, 'index'])->name('control_canteras');
Route::post('/control_canteras/update_limite', [App\Http\Controllers\ControlCanterasController::class, 'update_limite'])->name('control_canteras.update_limite');
Route::post('/control_canteras/update', [App\Http\Controllers\ControlCanterasController::class, 'update'])->name('control_canteras.update');


// ///////////ESTADO DE TALONARIOS
Route::get('/estado', [App\Http\Controllers\EstadoController::class, 'index'])->name('estado');
Route::post('/estado/modal_enviados', [App\Http\Controllers\EstadoController::class, 'modal_enviados'])->name('estado.modal_enviados');
Route::post('/estado/enviados', [App\Http\Controllers\EstadoController::class, 'enviados'])->name('estado.enviados');
Route::post('/estado/modal_recibidos', [App\Http\Controllers\EstadoController::class, 'modal_recibidos'])->name('estado.modal_recibidos');
Route::post('/estado/recibidos', [App\Http\Controllers\EstadoController::class, 'recibidos'])->name('estado.recibidos');
Route::post('/estado/modal_entregados', [App\Http\Controllers\EstadoController::class, 'modal_entregados'])->name('estado.modal_entregados');
Route::post('/estado/entregados', [App\Http\Controllers\EstadoController::class, 'entregados'])->name('estado.entregados');

// ///////////INFO SOLICITUDES
Route::post('/estado/solicitud', [App\Http\Controllers\EstadoController::class, 'solicitud'])->name('estado.solicitud');
Route::post('/estado/info_denegada', [App\Http\Controllers\EstadoController::class, 'info_denegada'])->name('estado.info_denegada');
// Route::post('/estado/update', [App\Http\Controllers\EstadoController::class, 'update'])->name('estado.update');


// ///////////ESTADO DE SOLICITUDES
Route::get('/estado_solicitud', [App\Http\Controllers\EstadoSolicitudController::class, 'index'])->name('estado_solicitud');
Route::post('/estado_solicitud/detalles', [App\Http\Controllers\EstadoSolicitudController::class, 'detalles'])->name('estado_solicitud.detalles');


Route::get('/correlativo/print_tira/{grupo?}/{talonario?}/', [App\Http\Controllers\CorrelativoController::class, 'print_tira'])->name('correlativo.print_tira');
Route::get('/correlativo/printqr_A/{talonario?}/', [App\Http\Controllers\CorrelativoController::class, 'printqr_A'])->name('correlativo.printqr_A');
Route::get('/correlativo/printqr_B/{guia?}/', [App\Http\Controllers\CorrelativoController::class, 'printqr_B'])->name('correlativo.printqr_B');

// //////////////CORRELATIVO
Route::get('/correlativo', [App\Http\Controllers\CorrelativoController::class, 'index'])->name('correlativo');

Route::post('/correlativo/talonario', [App\Http\Controllers\CorrelativoController::class, 'talonario'])->name('correlativo.talonario');
Route::post('/correlativo/guia', [App\Http\Controllers\CorrelativoController::class, 'guia'])->name('correlativo.guia');
Route::post('/correlativo/qr', [App\Http\Controllers\CorrelativoController::class, 'qr'])->name('correlativo.qr');
Route::post('/correlativo/accion', [App\Http\Controllers\CorrelativoController::class, 'accion'])->name('correlativo.accion');


// ////////////////VERIFICAR NUEVO USUARIO
Route::get('/verificar_user', [App\Http\Controllers\VerificarUserController::class, 'index'])->name('verificar_user');
Route::post('/verificar_user/info', [App\Http\Controllers\VerificarUserController::class, 'info'])->name('verificar_user.info');
Route::post('/verificar_user/aprobar', [App\Http\Controllers\VerificarUserController::class, 'aprobar'])->name('verificar_user.aprobar');
Route::post('/verificar_user/info_denegar', [App\Http\Controllers\VerificarUserController::class, 'info_denegar'])->name('verificar_user.info_denegar');
Route::post('/verificar_user/denegar', [App\Http\Controllers\VerificarUserController::class, 'denegar'])->name('verificar_user.denegar');


// ////////////////VERIFICAR CANTERA
Route::get('/verificar_cantera', [App\Http\Controllers\VerificarCanteraController::class, 'index'])->name('verificar_cantera');
Route::post('/verificar_cantera/info', [App\Http\Controllers\VerificarCanteraController::class, 'info'])->name('verificar_cantera.info');
Route::post('/verificar_cantera/verificar', [App\Http\Controllers\VerificarCanteraController::class, 'verificar'])->name('verificar_cantera.verificar');
Route::post('/verificar_cantera/info_denegar', [App\Http\Controllers\VerificarCanteraController::class, 'info_denegar'])->name('verificar_cantera.info_denegar');
Route::post('/verificar_cantera/denegar', [App\Http\Controllers\VerificarCanteraController::class, 'denegar'])->name('verificar_cantera.denegar');

// ////////////////VERIFICAR DECLARACIONES
Route::get('/verificar_declaracion', [App\Http\Controllers\VerificarDeclaracionController::class, 'index'])->name('verificar_declaracion');
Route::post('/verificar_declaracion/info', [App\Http\Controllers\VerificarDeclaracionController::class, 'info'])->name('verificar_declaracion.info');
Route::post('/verificar_declaracion/verificar', [App\Http\Controllers\VerificarDeclaracionController::class, 'verificar'])->name('verificar_declaracion.verificar');
Route::post('/verificar_declaracion/denegar', [App\Http\Controllers\VerificarDeclaracionController::class, 'denegar'])->name('verificar_declaracion.denegar');

// ////////////////LIBRO DE CONTRO: REGISTRO DE GUÍAS
Route::get('/registro_guia', [App\Http\Controllers\RegistroGuiaController::class, 'index'])->name('registro_guia');
Route::post('/registro_guia/modal_registro', [App\Http\Controllers\RegistroGuiaController::class, 'modal_registro'])->name('registro_guia.modal_registro');
Route::post('/registro_guia/cantera', [App\Http\Controllers\RegistroGuiaController::class, 'cantera'])->name('registro_guia.cantera');
Route::post('/registro_guia/store', [App\Http\Controllers\RegistroGuiaController::class, 'store'])->name('registro_guia.store');
Route::post('/registro_guia/editar', [App\Http\Controllers\RegistroGuiaController::class, 'editar'])->name('registro_guia.editar');
Route::post('/registro_guia/editar_guia', [App\Http\Controllers\RegistroGuiaController::class, 'editar_guia'])->name('registro_guia.editar_guia');
Route::post('/registro_guia', [App\Http\Controllers\RegistroGuiaController::class, 'destroy'])->name('registro_guia.destroy');


// //////////////////CONFIGURACION DE USUARIO:CONTRIBUYENTES
Route::get('/actualizar_datos', [App\Http\Controllers\SettingsContribuyenteController::class, 'index'])->name('actualizar_datos');
Route::post('/actualizar_datos/editar', [App\Http\Controllers\SettingsContribuyenteController::class, 'editar'])->name('actualizar_datos.editar');
// Route::post('/settings_contribuyente/representante', [App\Http\Controllers\SettingsContribuyenteController::class, 'representante'])->name('settings_contribuyente.representante');

// //////////////////NUEVA CONTRASEÑA
Route::get('/new_pass', [App\Http\Controllers\NewPassController::class, 'index'])->name('new_pass');
Route::post('/new_pass/update', [App\Http\Controllers\NewPassController::class, 'update'])->name('new_pass.update');

// ////////////////DECLARAR GUIAS (VISTA: CONTRIBUYENTE)
Route::get('/declarar', [App\Http\Controllers\DeclararController::class, 'index'])->name('declarar');
Route::post('/declarar/info_declarar', [App\Http\Controllers\DeclararController::class, 'info_declarar'])->name('declarar.info_declarar');
Route::post('/declarar/declarar_libros', [App\Http\Controllers\DeclararController::class, 'declarar_libros'])->name('declarar.declarar_libros');
Route::post('/declarar/info_declarar_extemporaneas', [App\Http\Controllers\DeclararController::class, 'info_declarar_extemporaneas'])->name('declarar.info_declarar_extemporaneas');
Route::post('/declarar/declarar_guias', [App\Http\Controllers\DeclararController::class, 'declarar_guias'])->name('declarar.declarar_guias');

// ///////////LIBROS
Route::get('/libros', [App\Http\Controllers\LibrosController::class, 'index'])->name('libros');
Route::post('/libros/detalles', [App\Http\Controllers\LibrosController::class, 'detalles'])->name('libros.detalles');

// ///////////LIBROS CONTRIBUYENTES
Route::get('/libro_contribuyente/{id_sujeto?}/', [App\Http\Controllers\LibroContribuyenteController::class, 'index'])->name('libro_contribuyente.index');

// ///////////DETALLE DE LIBRO
Route::get('/detalle_libro/{mes?}/{year?}/{sujeto?}/', [App\Http\Controllers\DetalleLibroController::class, 'index'])->name('detalle_libro.index');
Route::post('/detalle_libro/modal_registro', [App\Http\Controllers\DetalleLibroController::class, 'modal_registro'])->name('detalle_libro.modal_registro');
Route::post('/detalle_libro/store', [App\Http\Controllers\DetalleLibroController::class, 'store'])->name('detalle_libro.store');
Route::post('/detalle_libro/editar', [App\Http\Controllers\DetalleLibroController::class, 'editar'])->name('detalle_libro.editar');
Route::post('/detalle_libro/editar_guia', [App\Http\Controllers\DetalleLibroController::class, 'editar_guia'])->name('detalle_libro.editar_guia');


// ////////////////HISTORIAL DECLARACIONES
Route::get('/historial_declaraciones', [App\Http\Controllers\DeclararHistorialController::class, 'index'])->name('historial_declaraciones');
Route::post('/historial_declaraciones/nota', [App\Http\Controllers\DeclararHistorialController::class, 'nota'])->name('historial_declaraciones.nota');

// ///////////HISTORIAL DECLARACIONES : VISTA SETA
Route::get('/declaraciones_contribuyente/{id_sujeto?}/', [App\Http\Controllers\DeclaracionesContribuyenteController::class, 'index'])->name('declaraciones_contribuyente.index');


// ///////////USUARIOS
Route::get('/usuarios', [App\Http\Controllers\UsuariosController::class, 'index'])->name('usuarios');
Route::post('/usuarios/store', [App\Http\Controllers\UsuariosController::class, 'store'])->name('usuarios.store');
Route::post('/usuarios/modal_edit', [App\Http\Controllers\UsuariosController::class, 'modal_edit'])->name('usuarios.modal_edit');
Route::post('/usuarios/editar', [App\Http\Controllers\UsuariosController::class, 'editar'])->name('usuarios.editar');
Route::post('/usuarios', [App\Http\Controllers\UsuariosController::class, 'destroy'])->name('usuarios.destroy');

// ///////////BITACORA
Route::get('/bitacora', [App\Http\Controllers\BitacoraController::class, 'index'])->name('bitacora');

// ///////////UCD
Route::get('/ucd', [App\Http\Controllers\UcdController::class, 'index'])->name('ucd');
Route::post('/ucd/update', [App\Http\Controllers\UcdController::class, 'update'])->name('ucd.update');

// ///////////CONFIGURACIÓN DE DATOS
Route::get('/config', [App\Http\Controllers\ConfigController::class, 'index'])->name('config');
Route::post('/config/modal', [App\Http\Controllers\ConfigController::class, 'modal'])->name('config.modal');
Route::post('/config/update', [App\Http\Controllers\ConfigController::class, 'update'])->name('config.update');







// ///////////RECAUDACIÓN
Route::get('/recaudacion', [App\Http\Controllers\RecaudacionController::class, 'index'])->name('recaudacion');


// ///////////RESERVAS
Route::get('/reserva', [App\Http\Controllers\ReservaController::class, 'index'])->name('reserva');
Route::post('/reserva/emitir', [App\Http\Controllers\ReservaController::class, 'emitir'])->name('reserva.emitir');
Route::post('/reserva/info_correlativo', [App\Http\Controllers\ReservaController::class, 'info_correlativo'])->name('reserva.info_correlativo');


// ///////////DETALLE RESERVA  
Route::get('/detalle_reserva/{talonario?}/', [App\Http\Controllers\DetalleReservaController::class, 'index'])->name('detalle_reserva.index');

// ///////////ASIGNACIÓN DE GUÍAS (RESERVA - EN BLANCO)
Route::get('/asignar', [App\Http\Controllers\AsignarController::class, 'index'])->name('asignar');
Route::post('/asignar/search', [App\Http\Controllers\AsignarController::class, 'search'])->name('asignar.search');
Route::post('/asignar/modal', [App\Http\Controllers\AsignarController::class, 'modal'])->name('asignar.modal');
Route::post('/asignar/sujeto', [App\Http\Controllers\AsignarController::class, 'sujeto'])->name('asignar.sujeto');
Route::post('/asignar/asignar_notuser', [App\Http\Controllers\AsignarController::class, 'asignar_notuser'])->name('asignar.asignar_notuser');
Route::post('/asignar/asignar_user', [App\Http\Controllers\AsignarController::class, 'asignar_user'])->name('asignar.asignar_user');
Route::post('/asignar/guias', [App\Http\Controllers\AsignarController::class, 'guias'])->name('asignar.guias');
Route::post('/asignar/add_cantera', [App\Http\Controllers\AsignarController::class, 'add_cantera'])->name('asignar.add_cantera');
Route::post('/asignar/registro_guias', [App\Http\Controllers\AsignarController::class, 'registro_guias'])->name('asignar.registro_guias');
Route::post('/asignar/cerrar', [App\Http\Controllers\AsignarController::class, 'cerrar'])->name('asignar.cerrar');
Route::post('/asignar/detalle', [App\Http\Controllers\AsignarController::class, 'detalle'])->name('asignar.detalle');
Route::post('/asignar/delete', [App\Http\Controllers\AsignarController::class, 'delete'])->name('asignar.delete');

Route::post('/asignar/canteras', [App\Http\Controllers\AsignarController::class, 'canteras'])->name('asignar.canteras');
Route::post('/asignar/calcular', [App\Http\Controllers\AsignarController::class, 'calcular'])->name('asignar.calcular');
Route::post('/asignar/asignar', [App\Http\Controllers\AsignarController::class, 'asignar'])->name('asignar.asignar');
Route::post('/asignar/correlativo', [App\Http\Controllers\AsignarController::class, 'correlativo'])->name('asignar.correlativo');





// Route::get('/asignar_qr/guias_asignadas/{asignacion?}/', [App\Http\Controllers\AsignarQrController::class, 'guias_asignadas'])->name('asignar_qr.guias_asignadas');

// ///////////ASIGNAR QR (RESERVA - EN BLANCO)
Route::get('/asignar_qr', [App\Http\Controllers\AsignarQrController::class, 'index'])->name('asignar_qr');
Route::post('/asignar_qr/qr_listo', [App\Http\Controllers\AsignarQrController::class, 'qr_listo'])->name('asignar_qr.qr_listo');
Route::post('/asignar_qr/guia', [App\Http\Controllers\AsignarQrController::class, 'guia'])->name('asignar_qr.guia');
Route::get('/asignar_qr/print_qr/{guia?}/', [App\Http\Controllers\AsignarQrController::class, 'print_qr'])->name('asignar_qr.print_qr');
Route::get('/asignar_qr/print_tira/{asignacion?}/', [App\Http\Controllers\AsignarQrController::class, 'print_tira'])->name('asignar_qr.print_tira');
Route::post('/asignar_qr/modal_qrlisto', [App\Http\Controllers\AsignarQrController::class, 'modal_qrlisto'])->name('asignar_qr.modal_qrlisto');
Route::post('/asignar_qr/qrlisto', [App\Http\Controllers\AsignarQrController::class, 'qrlisto'])->name('asignar_qr.qrlisto');
Route::post('/asignar_qr/modal_guias', [App\Http\Controllers\AsignarQrController::class, 'modal_guias'])->name('asignar_qr.modal_guias');



// ///////SOLICITUD RESERVAS
Route::get('/solicitud_reserva', [App\Http\Controllers\SolicitudReservaController::class, 'index'])->name('solicitud_reserva');
Route::post('/solicitud_reserva/new_solicitud', [App\Http\Controllers\SolicitudReservaController::class, 'new_solicitud'])->name('solicitud_reserva.new_solicitud');
Route::post('/solicitud_reserva/calcular', [App\Http\Controllers\SolicitudReservaController::class, 'calcular'])->name('solicitud_reserva.calcular');
Route::post('/solicitud_reserva/store', [App\Http\Controllers\SolicitudReservaController::class, 'store'])->name('solicitud_reserva.store');
Route::post('/solicitud_reserva', [App\Http\Controllers\SolicitudReservaController::class, 'destroy'])->name('solicitud_reserva.destroy');

// ///////////SOLICITUD RESERVAS
Route::get('/aprobacion_provicional', [App\Http\Controllers\AprobacionProvicionalController::class, 'index'])->name('aprobacion_provicional');
Route::post('/aprobacion_provicional/aprobar', [App\Http\Controllers\AprobacionProvicionalController::class, 'aprobar'])->name('aprobacion_provicional.aprobar');
Route::post('/aprobacion_provicional/correlativo', [App\Http\Controllers\AprobacionProvicionalController::class, 'correlativo'])->name('aprobacion_provicional.correlativo');
Route::post('/aprobacion_provicional/info', [App\Http\Controllers\AprobacionProvicionalController::class, 'info'])->name('aprobacion_provicional.info');

//////////////QR
Route::get('/qr/qr', [App\Http\Controllers\QrController::class, 'qr'])->name('qr.qr');
Route::get('/qr/qrReserva', [App\Http\Controllers\QrController::class, 'qrReserva'])->name('qr.qrReserva');




