<?php

namespace App\Http\Controllers;
use DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; 


use Mike42\Escpos\PrintConnectors\FilePrintConnector;
// use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
// use Mike42\Escpos\Printer;

use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    public function index()
    {
        $user = auth()->id();
        $query = DB::table('users')->select('key_sujeto')->where('id','=',$user)->first();
        $con_fun = DB::table('funcionarios')->select('cargo')->where('id_funcionario','=',$query->key_sujeto)->first();


        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");   

        $hoy_view = $dias[date('w')].", ".date('d')." de ".$meses[date('n')-1]. " ".date('Y');


        if ($con_fun->cargo == 'Taquillero') {
            $vista = 'Taquillero';

            $q2 = DB::table('taquillas')->join('sedes', 'taquillas.key_sede', '=','sedes.id_sede')
                                        ->select('sedes.sede','taquillas.id_taquilla')
                                        ->where('taquillas.key_funcionario','=',$query->key_sujeto)->first();

            $id_taquilla = $q2->id_taquilla;
            $sede = $q2->sede;
            $hoy = date('Y-m-d');
            $apertura_admin = false;
            $apertura_taquillero = false;
            $cierre_taquilla = false;
            $hora_apertura_admin = '';
            $hora_apertura_taquillero = '';
            $hora_cierre_taquilla = '';

            $q3 = DB::table('apertura_taquillas')->select('apertura_admin','apertura_taquillero','cierre_taquilla')
                                                ->where('key_taquilla','=', $id_taquilla)
                                                ->whereDate('fecha', $hoy)->first();
            if ($q3) {
                //////hay registro, admin aperturo taquilla
                if ($q3->apertura_taquillero == null) {
                    ///////taquillero no ha aperturado
                    $apertura_admin = true;
                    $apertura_taquillero = false;
                    $hora = date("h:i A",strtotime($q3->apertura_admin));
                    $hora_apertura_admin = $hora;

                }else{
                    //////taquillero aperturo 
                    $apertura_admin = true;
                    $apertura_taquillero = true;
                    $hora_apertura_admin = date("h:i A",strtotime($q3->apertura_admin));
                    $hora_apertura_taquillero = date("h:i A",strtotime($q3->apertura_taquillero));
                }
                
                if ($q3->cierre_taquilla != null) {
                    $cierre_taquilla = true;
                    $hora_cierre_taquilla = date("h:i A",strtotime($q3->cierre_taquilla));
                }
            }else{
                /////no hay registro, admin no ha aperturado taquilla
                $apertura_admin = false;
            }

            return view('home', compact('vista','apertura_admin','apertura_taquillero','hora_apertura_admin','hora_apertura_taquillero','cierre_taquilla','hora_cierre_taquilla','hoy_view','sede','id_taquilla'));

        }else{
            $vista = 'Administrativo';

            return view('home', compact('vista','hoy_view'));

        }
        


    }

    

    public function timbre(){

        // try {
        // // Enter the share name for your USB printer here


        // $connector = null;
        //     $connector = new WindowsPrintConnector("EPSON_TM_U220_Receipt");
        //     /* Print a "Hello world" receipt" */
        //     $printer = new Printer($connector);
        //     $printer -> text("Hello World\n");
        //     $printer -> cut();

        //     /* Close printer */
        //     $printer -> close();
        // } catch (Exception $e) {
        //     echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
        // }


        // $impresora = 'USB001';COMPOSER
        // $nombreImpresora = "EPSON TM-U220 Receipt";
        // $connector = new WindowsPrintConnector($nombreImpresora);
        // $impresora = new Printer($connector);
        // $impresora->setJustification(Printer::JUSTIFY_CENTER);
        // $impresora->setTextSize(2, 2);
        // $impresora->text("Imprimiendo\n");
        // $impresora->text("ticket\n");
        // $impresora->text("desde\n");
        // $impresora->text("Laravel\n");
        // $impresora->setTextSize(1, 1);
        // $impresora->text("https://parzibyte.me");
        // $impresora->feed(5);
        // $impresora->close();


        if (($handle = @fopen("COM2","w")) === FALSE) {
            die('No se puede imprimir, verifique la conexion con el terminal');
        }
-
        fwrite($handle,chr(27). chr(64)); /// reinicio?
        fwrite($handle,chr(27). chr(100). chr(0));
        fwrite($handle,chr(27). chr(33). chr(8));
        fwrite($handle,"HOLA MUNDO");
        fclose($handle);
        $salida = shell_exec('lpr COM2');



    }


    public function apertura_taquilla(Request $request){
        $pass = $request->post('clave');

        if ($pass == '' || $pass == null) {
            return response()->json(['success' => false, 'nota' => 'Ingrese la clave de seguridad.']);
        }else{
            $hoy = date('Y-m-d');

            $user = auth()->id();
            $query = DB::table('users')->select('key_sujeto')->where('id','=',$user)->first();
            $q2 = DB::table('taquillas')->select('id_taquilla','clave','estado')->where('key_funcionario','=',$query->key_sujeto)->first();
            $con_taq = DB::table('funcionarios')->select('estado')->where('id_funcionario','=',$query->key_sujeto)->first();

            if ($q2 && $con_taq) {
                ///// verificar si estan deshabilitados
                if ($q2->estado == 17) {
                    return response()->json(['success' => false, 'nota'=> 'Taquilla Deshabilitada..']);
                }
                if ($con_taq->estado == 17) {
                    return response()->json(['success' => false, 'nota'=> 'Funcionario Deshabilitado.']);
                }

                /// usuario taquillero
                $id_taquilla = $q2->id_taquilla;

                if (Hash::check($pass, $q2->clave)) {
                    $hora = date('H:i:s');

                    // ACTUALIZCION DEL INVENTARIO DE TAQUILLA (ESTAMPILLAS Y TFES)
                    $upd_1 = DB::table('inv_est_taq_temps')->where('key_taquilla', '=', $id_taquilla)
                                                                        ->update(['fecha' => $hoy]);
                    $upd_2 = DB::table('inv_tfe_taq_temps')->where('key_taquilla', '=', $id_taquilla)
                                                                        ->update(['fecha' => $hoy]);
                                                                        
                    if ($upd_1 && $upd_2) {
                        // INVENTARO ESTAMPILLAS TAQUILLA
                        $q3 = DB::table('ucd_denominacions')->select('id','denominacion')->where('estampillas','=','true')->get();
                        foreach ($q3 as $key) {
                            $key_deno = $key->id;
                            $deno = $key->denominacion;

                            $cant_inv = 0;

                            $c1 = DB::table('detalle_asignacion_estampillas')->select('cantidad_timbres','vendido')
                                                                            ->where('key_taquilla','=',$id_taquilla)
                                                                            ->where('key_denominacion','=',$key_deno)
                                                                            ->where('condicion','!=',7)->get(); 
                                                                            // return response($c1);
                            if ($c1) {
                                foreach ($c1 as $value) {
                                    $cant_inv = $cant_inv + ($value->cantidad_timbres - $value->vendido);
                                }
                            }else{
                                $cant_inv = 0;
                            }
                            

                            switch ($key_deno) {
                                case 1:
                                    # 1 UCD
                                    $upd_inv = DB::table('inv_est_taq_temps')->where('key_taquilla', '=', $id_taquilla)
                                                                            ->where('fecha','=', $hoy)
                                                                            ->update(['one_ucd' => $cant_inv]);
                                    break;
                                case 2:
                                    # 2 UCD
                                    $upd_inv = DB::table('inv_est_taq_temps')->where('key_taquilla', '=', $id_taquilla)
                                                                            ->where('fecha','=', $hoy)
                                                                            ->update(['two_ucd' => $cant_inv]);
                                    break;
                                case 3:
                                    # 3 UCD
                                    $upd_inv = DB::table('inv_est_taq_temps')->where('key_taquilla', '=', $id_taquilla)
                                                                            ->where('fecha','=', $hoy)
                                                                            ->update(['three_ucd' => $cant_inv]);
                                    break;
                                case 4:
                                    # 5 UCD
                                    $upd_inv = DB::table('inv_est_taq_temps')->where('key_taquilla', '=', $id_taquilla)
                                                                            ->where('fecha','=', $hoy)
                                                                            ->update(['five_ucd' => $cant_inv]);
                                    break;
                                default:
                                    # code...
                                    break;
                            }
                        }

                        // INVENTARIO TFES TAQUILLA
                        $cant_tfe = 0;
                        $c2 = DB::table('inventario_tfes')->select('cantidad_timbres','vendido')
                                                            ->where('key_taquilla','=',$id_taquilla)
                                                            ->where('condicion','!=',7)->get();
                        if ($c2) {
                            foreach ($c2 as $value) {
                                $cant_tfe = $cant_tfe + ($value->cantidad_timbres - $value->vendido);
                            }
                        }else{
                            $cant_tfe = 0;
                        }
                        

                        $upd_inv_tfe = DB::table('inv_tfe_taq_temps')->where('key_taquilla', '=', $id_taquilla)
                                                                ->where('fecha','=', $hoy)
                                                                ->update(['cantidad' => $cant_tfe]);



                        $update = DB::table('apertura_taquillas')->where('key_taquilla', '=', $id_taquilla)
                                                                ->whereDate('fecha', $hoy)
                                                                ->update(['apertura_taquillero' => $hora]);
                        if ($update) {
                            return response()->json(['success' => true]);
                        }else{
                            return response()->json(['success' => false]);
                        }
                    }else{
                        return response()->json(['success' => false]);
                    }
                }else{
                    return response()->json(['success' => false, 'nota' => 'Disculpe, la contraseña ingresada no es válida.']);
                }
            }else{
                ////no esta asignado a ninguna taquilla
                /////BITACORA 
                return response()->json(['success' => false, 'nota' => 'Disculpe, usted no se encuentra asociado a ninguna taquilla.']);
            }
        }
        

    }





    public function fondo_caja(Request $request){
        $hoy = date('Y-m-d');
        $user = auth()->id();

        $query = DB::table('users')->select('key_sujeto')->where('id','=',$user)->first();
        $q2 = DB::table('taquillas')->select('id_taquilla','clave')->where('key_funcionario','=',$query->key_sujeto)->first();
        if ($q2) {
            $id_taquilla = $q2->id_taquilla;
            $fondo = $request->post('fondo');
            if ($fondo == 0) {
                return response()->json(['success' => true]);
            }else{
                $update = DB::table('apertura_taquillas')->where('key_taquilla', '=', $id_taquilla)
                                                    ->whereDate('fecha', $hoy)
                                                    ->update(['fondo_caja' => $fondo]);
                if ($update) {
                    return response()->json(['success' => true]);
                }else{
                    return response()->json(['success' => false]);
                }
            }
        }else{
            ////no esta asignado a ninguna taquilla
            /////BITACORA 
            return response()->json(['success' => false, 'nota' => 'Disculpe, usted no se encuentra asociado a ninguna taquilla.']);
        }

        
    }




    public function alert_boveda(){
        $user = auth()->id();
        $query = DB::table('users')->select('key_sujeto')->where('id','=',$user)->first();
        $q2 = DB::table('taquillas')->select('id_taquilla','clave')->where('key_funcionario','=',$query->key_sujeto)->first();
        if ($q2) {
            /// usuario taquillero
            $id_taquilla = $q2->id_taquilla;

            $q3 = DB::table('efectivo_taquillas_temps')->select('efectivo')->where('key_taquilla','=',$id_taquilla)->first();
            if ($q3->efectivo > 500) {
                return response()->json(['success' => true]);
            }else{
                return response()->json(['success' => false]);
            }

        }else{
            ////no esta asignado a ninguna taquilla
            /////BITACORA 
            return response()->json(['success' => false]);
        }
    }




    public function modal_boveda(){
        $user = auth()->id();
        $query = DB::table('users')->select('key_sujeto')->where('id','=',$user)->first();
        $q2 = DB::table('taquillas')->select('id_taquilla','clave')->where('key_funcionario','=',$query->key_sujeto)->first();

        if ($q2) {
            $id_taquilla = $q2->id_taquilla;
            $hoy = date('Y-m-d');

            $q3 = DB::table('efectivo_taquillas_temps')->select('efectivo')->where('key_taquilla','=',$id_taquilla)->first();
            $q4 = DB::table('apertura_taquillas')->select('fondo_caja')->whereDate('fecha', $hoy)->where('key_taquilla','=',$id_taquilla)->first();

            $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-money fs-2 text-muted me-2"></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">Ingresar Efectivo en Bóveda</h1>
                    </div>
                </div> 
                <div class="modal-body px-5 py-3" style="font-size:13px">
                    <form id="form_ingreso_boveda" method="post" onsubmit="event.preventDefault(); ingresoBoveda()">
                        
                        <label for="clave" class="form-label"><span class="text-danger">* </span>Monto ingresado en Bóveda:</label>
                        
                        <div class="d-flex align-items-center">
                            <input type="number" id="monto" step="0.01" max="'.$q3->efectivo.'" class="form-control form-control-sm me-2" name="monto" required> <span>Bs.</span>
                        </div>
                        
                        <p class="pb-0 mb-0">Monto Total (Efectivo) en Taquilla: <span class="text-success"> '.number_format($q3->efectivo, 2, ',', '.').' Bs</span></p>
                        <span>Fondo de caja: <span class="text-success"> '.number_format($q4->fondo_caja, 2, ',', '.').' Bs</span></span>

                        <p class="text-muted text-end"><span style="color:red">*</span> Campo requerido.</p>

                        <div class="d-flex justify-content-center mt-3 mb-3">
                            <button type="submit" class="btn btn-success btn-sm me-2">Aceptar</button>
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>';

            return response($html);

        }else{
            ////no esta asignado a ninguna taquilla
            /////BITACORA 
            return response()->json(['success' => false]);
        }
    }




    public function ingreso_boveda(Request $request){
        $user = auth()->id();
        $query = DB::table('users')->select('key_sujeto')->where('id','=',$user)->first();
        $q2 = DB::table('taquillas')->select('id_taquilla')->where('key_funcionario','=',$query->key_sujeto)->first();

        if ($q2) {
            $id_taquilla = $q2->id_taquilla;
            $monto = $request->post('monto');

            $c1 = DB::table('efectivo_taquillas_temps')->select('efectivo')->where('key_taquilla','=',$id_taquilla)->first();
            if ($c1->efectivo == 0 || $c1->efectivo < $monto) {
                return response()->json(['success' => false, 'nota' => 'El monto a ingresar en la Bóveda difiere del monto total en taquilla.']);
            }else{
                $insert = DB::table('boveda_ingresos')->insert(['key_taquilla' => $id_taquilla,'monto' => $monto]); 
                if ($insert) {
                    $id_ingreso = DB::table('boveda_ingresos')->max('correlativo');

                    $new_efectivo_temps = $c1->efectivo - $monto;
                    $update = DB::table('efectivo_taquillas_temps')->where('key_taquilla', '=', $id_taquilla)->update(['efectivo' => $new_efectivo_temps]);
                    if ($update) {
                        return response()->json(['success' => true]);
                    }else{
                        $delete = DB::table('boveda_ingresos')->where('correlativo', '=', $id_ingreso)->delete();
                        return response()->json(['success' => false]);
                    }
                }else{
                    return response()->json(['success' => false]);
                }
            }

            
        }else{
            ////no esta asignado a ninguna taquilla
            /////BITACORA 
            return response()->json(['success' => false]);
        }
    }




    public function historial_boveda(){
        $hoy = date('Y-m-d');
        $tr = '';

        $user = auth()->id();
        $query = DB::table('users')->select('key_sujeto')->where('id','=',$user)->first();
        $q2 = DB::table('taquillas')->select('id_taquilla')->where('key_funcionario','=',$query->key_sujeto)->first();

        if ($q2) {
            $id_taquilla = $q2->id_taquilla;
            $q3 = DB::table('boveda_ingresos')->select('hora','monto')->where('key_taquilla','=',$id_taquilla)
                                                                    ->whereDate('fecha', $hoy)->get();
            $c = 0;
            $count = count($q3);
            if ($count != 0){
                foreach ($q3 as $key) {
                    $c++;
                    $hora = date("h:i A",strtotime($key->hora)); 
                    $tr .= '<tr>
                                <td class="text-muted">'.$c.'</td>
                                <td>
                                    <span class="badge bg-primary-subtle border border-primary-subtle text-primary-emphasis rounded-pill" style="font-size:12.7px">'.$hora.'</span>
                                </td>
                                <td class="fw-bold">'.number_format($key->monto, 2, ',', '.').' Bs.</td>
                            </tr>';
                }
            }else{
                $tr = '<tr>
                            <td class="text-muted" colspan="3">No se han realizado ingresos de efectivo hoy en la Bóveda.</td>
                        </tr>';
            }
            

            $html = '<div class="offcanvas-header">
                        <i class="bx bx-detail text-muted me-3 fs-4"></i>
                        <h5 class="offcanvas-title titulo fs-5 fw-bold text-navy" id="">Bóveda | <span class="text-muted">Historial</span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body px-3" style="font-size:13px">               

                        <p class="text-muted">*Nota: El historial que se muestra a continuación corresponde al día de hoy.</p>
                        
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Hora</th>
                                    <th>Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                               '.$tr.'
                            </tbody>
                        </table>
                        
                    </div>';

            return response($html);

        }else{
            ////no esta asignado a ninguna taquilla
            /////BITACORA 
            return response()->json(['success' => false]);
        }
    }


    public function cierre_taquilla(Request $request){
        $pass = $request->post('clave_cierre');

        if ($pass == '' || $pass == null) {
            return response()->json(['success' => false, 'nota' => 'Ingrese la clave de seguridad.']);
        }else{
            $hoy = date('Y-m-d');

            $user = auth()->id();
            $query = DB::table('users')->select('key_sujeto')->where('id','=',$user)->first();
            $q2 = DB::table('taquillas')->select('id_taquilla','clave')->where('key_funcionario','=',$query->key_sujeto)->first();
            if ($q2) {
                /// usuario taquillero
                $id_taquilla = $q2->id_taquilla;

                if (Hash::check($pass, $q2->clave)) {
                    //  ARQUEO
                    $recaudado = 0;
                    $punto = 0;
                    $efectivo = 0;
                    $recaudado_tfe = 0;
                    $recaudado_est = 0;
                    $cantidad_tfe = 0;
                    $cantidad_est = 0;

                    $q1 = DB::table('ventas')->select('id_venta','total_bolivares','key_ucd')
                                            ->where('key_taquilla','=',$id_taquilla)
                                            ->whereDate('fecha', $hoy)->get();
                    if ($q1) {
                        foreach ($q1 as $key) {
                            $recaudado = $recaudado + $key->total_bolivares;

                            // CONSULTA UCD
                            $c1 = DB::table('ucds')->select('valor')->where('id','=',$key->key_ucd)->first();
                            $valor_ucd = $c1->valor;
    
                            // PUNTO Y EFECTIVO
                            $q2 = DB::table('pago_ventas')->where('key_venta','=',$key->id_venta)->get();
                            foreach ($q2 as $pago) {
                                if ($pago->metodo == 5) {
                                    //PUNTO
                                    $punto = $punto + $pago->monto;
                                }else{
                                    //EFECTIVO
                                    $efectivo = $efectivo + $pago->monto;
                                }
                            }
                            
    
                            // (RECAUDACION Y CANTIDAD) TFE Y EST
                            $q3 = DB::table('detalle_ventas')->where('key_venta','=',$key->id_venta)->get();
                            foreach ($q3 as $value) {
                                if ($value->forma == 3) {
                                    // FORMA 14
                                    $cantidad_tfe++;

                                    if ($value->capital != NULL) {
                                        // bs
                                        $recaudado_tfe = $recaudado_tfe + $value->bs;
                                    }else{
                                        // ucd
                                        $ucd_bs = $value->ucd * $valor_ucd;
                                        $recaudado_tfe = $recaudado_tfe + $ucd_bs;
                                    }
                                }else{
                                    // ESTAMPILLAS
                                    $q4 = DB::table('detalle_venta_estampillas')->selectRaw("count(*) as total")->where('key_detalle_venta','=',$value->correlativo)->first();
                                    $cantidad_est = $cantidad_est + $q4->total;

                                    $ucd_bs = $value->ucd * $valor_ucd;
                                    $recaudado_est = $recaudado_est + $ucd_bs;
                                }
                            }
                        } //cierra foreach
                    }else{
                        // sin ventas
                    }

                    $hora = date('H:i:s');
                    $insert = DB::table('cierre_taquillas')->insert(['key_taquilla' => $id_taquilla,
                                                                    'recaudado' => $recaudado,
                                                                    'punto' => $punto,
                                                                    'efectivo' => $efectivo,
                                                                    'recaudado_tfe' => $recaudado_tfe,
                                                                    'recaudado_est' => $recaudado_est,
                                                                    'cantidad_tfe' => $cantidad_tfe,
                                                                    'cantidad_est' => $cantidad_est
                                                                ]); 
                    if ($insert) {
                        $update = DB::table('apertura_taquillas')->where('key_taquilla', '=', $id_taquilla)
                                                                    ->whereDate('fecha', $hoy)
                                                                    ->update(['cierre_taquilla' => $hora]);
                        $con_temp = DB::table('efectivo_taquillas_temps')->select('efectivo')->where('key_taquilla','=',$id_taquilla)->first();
                        if ($con_temp->efectivo != 0) {
                            $update_temp = DB::table('efectivo_taquillas_temps')->where('key_taquilla','=',$id_taquilla)->update(['efectivo' => '0']);
                        }
                        if ($update) {
                            return response()->json(['success' => true]);
                        }else{
                            return response()->json(['success' => false]);
                        }
                    }else{
                        return response()->json(['success' => false]);
                    }             
                   
                }else{
                    return response()->json(['success' => false, 'nota' => 'Disculpe, la contraseña ingresada no es válida.']);
                }
            }else{
                ////no esta asignado a ninguna taquilla
                /////BITACORA 
                return response()->json(['success' => false, 'nota' => 'Disculpe, usted no se encuentra asociado a ninguna taquilla.']);
            }
        }
    }




    public function modal_clave(Request $request){
        $papel = $request->post('papel');
        $val_papel = base64_encode(serialize($papel)); 

        ////ID TAQUILLA
        $user = auth()->id();
        $query = DB::table('users')->select('key_sujeto')->where('id','=',$user)->first();
        $q2 = DB::table('taquillas')->select('id_taquilla')->where('key_funcionario','=',$query->key_sujeto)->first();
        if ($q2) {
            $id_taquilla = $q2->id_taquilla;
        }else{
            return response()->json(['success' => false]);
        }

        ////VERIFICAR APERTURA DE TAQUILLA
        $hoy = date('Y').''.date('m').''.date('d');
        $con_apertura = DB::table('apertura_taquillas')->where('key_taquilla','=',$id_taquilla)->whereDate('fecha', $hoy)->first();
        if ($con_apertura){
            $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                        <div class="text-center">
                            <i class="bx bx-lock-open-alt fs-2 text-muted me-2"></i>
                            <h1 class="modal-title fs-5 fw-bold text-navy">Clave de Taquilla</h1>
                        </div>
                    </div> 
                    <div class="modal-body px-5 py-3" style="font-size:13px">
                        <form id="form_clave_taquilla" method="post" onsubmit="event.preventDefault(); claveTaquilla()">
                            
                            <label for="clave" class="form-label"><span class="text-danger">* </span>Ingrese la clave de seguridad de la Taquilla:</label>
                            <input type="password" id="clave" class="form-control form-control-sm" name="clave" required>
                            <input type="hidden" name="papel" value="'.$val_papel.'">
                            <p class="text-muted text-end"><span style="color:red">*</span> Campos requeridos.</p>

                            <div class="d-flex justify-content-center mt-3 mb-3">
                                <button type="button" class="btn btn-secondary btn-sm me-2" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-success btn-sm">Aceptar</button>
                            </div>
                        </form>
                    </div>';

            return response()->json(['success' => true, 'html' => $html]);
        }else{
            /////no hay registro, ADMIN no ha aperturado taquilla.
            // BITACORA = INTENTO DE VENTA SIN APERTURA DE TAQUILLA
            return response()->json(['success' => false, 'nota'=> 'Acción invalida. La taquilla no ha sido aperturada.']);
        }
        
    }

    public function clave(Request $request){
        // $papel = unserialize(base64_decode($request->post('papel')));
        $papel = $request->post('papel'); 
        $pass = $request->post('clave');

        if ($pass == '' || $pass == null) {
            return response()->json(['success' => false, 'nota' => 'Ingrese la clave de seguridad.']);
        }else{
            $user = auth()->id();
            $query = DB::table('users')->select('key_sujeto')->where('id','=',$user)->first();
            $q2 = DB::table('taquillas')->select('id_taquilla','clave')->where('key_funcionario','=',$query->key_sujeto)->first();
            if ($q2) {
                /// usuario taquillero
                $id_taquilla = $q2->id_taquilla;

                if (Hash::check($pass, $q2->clave)) {
                    ///////ACCION PERMITIDA
                    
                    /// consultar ultima venta
                    $con1 =  DB::table('ventas')->join('contribuyentes', 'ventas.key_contribuyente', '=','contribuyentes.id_contribuyente')
                                ->select('ventas.id_venta','contribuyentes.nombre_razon','contribuyentes.identidad_condicion','contribuyentes.identidad_nro')
                                ->where('ventas.key_taquilla','=',$id_taquilla)
                                ->orderBy('ventas.id_venta', 'desc')->first();
                    if ($con1) {
                        $tr = '';
                        $length = 6;

                        $con2 = DB::table('detalle_ventas')->join('tramites', 'detalle_ventas.key_tramite', '=','tramites.id_tramite')
                                    ->select('detalle_ventas.correlativo','detalle_ventas.ucd','detalle_ventas.bs','tramites.tramite')
                                    ->where('detalle_ventas.key_venta','=',$con1->id_venta)->get();

                        foreach ($con2 as $key) {
                            $con3 = DB::table('detalle_venta_tfes')->select('nro_timbre')->where('key_venta','=',$con1->id_venta)->where('key_detalle_venta','=',$key->correlativo)->where('condicion','=',7)->where('sustituto','=',NULL)->first();
                            if ($con3) {
                                $formato_nro = substr(str_repeat(0, $length).$con3->nro_timbre, - $length);
                                if ($key->ucd == null) {
                                    $monto = $key->bs.' Bs.';
                                }else{
                                    $monto = $key->ucd.' U.C.D.';
                                }

                                $timbre =  base64_encode(serialize($con3->nro_timbre));
                                $tr .= '<tr>
                                            <td><span class="text-danger fs-6 fw-bold titulo">A-'.$formato_nro.'</span></td>
                                            <td><span class="text-muted">'.$key->tramite.'</span></td>
                                            <td><span class="fw-semibold">'.$monto.'</span></td>
                                            <td>
                                                <button type="button" class="btn btn-secondary btn-sm py-0 imprimir_timbre" style="font-size:12.7px" venta="" timbre="'.$timbre.'" papel="'.$papel.'">Imprimir</button>
                                            </td>
                                        </tr>';
                            }else{
                                $tr = '<tr>
                                            <td colspan="4" ><span class="text-secondary fst-italic">No hay timbres para re-imprimir.</span></td>
                                        </tr>';
                            }   
                            

                            
                        }

                        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                                    <div class="text-center">
                                        <i class="bx bx-detail fs-2 text-muted me-2"></i>
                                        <h1 class="modal-title fs-5 fw-bold text-navy">Última Venta <span class="text-muted ">| TAQ'.$id_taquilla.'</span></h1>
                                    </div>
                                </div>  
                                <div class="modal-body px-5 py-3" style="font-size:13px">
                                    <div class="d-flex justify-content-center my-2">
                                        <table class="table table-sm w-75">
                                            <tbody>
                                                <tr>
                                                    <th>ID Venta</th>
                                                    <td class="fw-bold text-navy">'.$con1->id_venta.'</td>
                                                </tr>
                                                <tr>
                                                    <th>Contribuyente</th>
                                                    <td>
                                                        <div class="d-flex flex-column">
                                                            <span class="fw-semibold">'.$con1->nombre_razon.'</span>
                                                            <span class="text-muted">'.$con1->identidad_condicion.'-'.$con1->identidad_nro.'</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="fw-semibold text-muted fs-5 text-center mb-3">Timbres TFE-14</div>
                                    <table class="table table-sm text-center">
                                        <thead>
                                            <tr>
                                                <th>No. Timbre</th>
                                                <th>Tramite</th>
                                                <th>UCD|Bs.</th>
                                                <th>Imprimir</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            '.$tr.'
                                        </tbody>
                                    </table>
                                    
                                    <div class="d-flex justify-content-center mt-3 mb-3">
                                        <button type="button" class="btn btn-secondary btn-sm " data-bs-dismiss="modal">Cancelar</button>
                                    </div>
                                </div>';

                        return response()->json(['success' => true, 'html' => $html]);




                    }else{
                        return response()->json(['success' => false]);
                    }                    
                }else{
                    return response()->json(['success' => false, 'nota' => 'Disculpe, la contraseña ingresada no es válida.']);
                }
            }else{
                return response()->json(['success' => false]);
            }
        } 
    }


    public function modal_imprimir(Request $request){
        $papel = unserialize(base64_decode($request->post('papel')));
        $timbre = unserialize(base64_decode($request->post('timbre')));

        $val_papel = $request->post('papel');
        $val_timbre = $request->post('timbre');

        $length = 6;

        ////ID TAQUILLA
        $user = auth()->id();
        $query = DB::table('users')->select('key_sujeto')->where('id','=',$user)->first();
        $q2 = DB::table('taquillas')->select('id_taquilla')->where('key_funcionario','=',$query->key_sujeto)->first();
        if ($q2) {
            $id_taquilla = $q2->id_taquilla;
        }else{
            return response()->json(['success' => false]);
        }

    
        //// DATOS GENERALES DE LA VENTA
        $con1 = DB::table('detalle_venta_tfes')->select('key_venta','nro_timbre')->where('nro_timbre','=',$timbre)->first();
        if ($con1) {
            $con2 = DB::table('detalle_ventas')->join('tramites', 'detalle_ventas.key_tramite', '=','tramites.id_tramite')
                                    ->select('detalle_ventas.ucd','detalle_ventas.bs','tramites.tramite')
                                    ->where('detalle_ventas.key_venta','=',$con1->key_venta)->first();
            $con3 =  DB::table('ventas')->join('contribuyentes', 'ventas.key_contribuyente', '=','contribuyentes.id_contribuyente')
                                    ->select('contribuyentes.nombre_razon','contribuyentes.identidad_condicion','contribuyentes.identidad_nro')
                                    ->where('ventas.id_venta','=',$con1->key_venta)->first();
            if ($con2 && $con3) {
                $formato_nro = substr(str_repeat(0, $length).$timbre, - $length);

                if ($con2->ucd == null) {
                    $monto = $con2->bs.' Bs.';
                }else{
                    $monto = $con2->ucd.' U.C.D.';
                }
            }else{
                return response()->json(['success' => false]); 
            }
        }else{
            return response()->json(['success' => false]);
        }


        ////// TIPO DE IMPRESIÓN
        if ($papel == 1) {
            //// PAPEL EN BUEN ESTADO | MISMO NRO DE TIMBRE
            $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                        <div class="text-center">
                            <i class="bx bx-receipt fs-2 text-muted me-2"></i>
                            <h1 class="modal-title fs-5 fw-bold text-navy">Impresión TFE-14 <span class="text-secondary">| Papel en Buen Estado</span> </h1>
                        </div>
                    </div> 
                    <div class="modal-body px-5 py-3" style="font-size:13px">
                        <span class="text-muted">*IMPORTANTE:</span>

                        <div class="d-flex justify-content-center">
                            <div class="row g-3 align-items-center">
                                <div class="col-auto">
                                    <span class="text-navy fs-4 fw-bold titulo">No. Timbre</span>
                                </div>
                                <div class="col-auto">
                                    <span class="text-danger fs-4 fw-bold titulo">A-'.$formato_nro.'</span>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center my-3">
                            <table class="table table-sm">
                                <tbody>
                                    <tr>
                                        <th>ID Venta</th>
                                        <td>'.$con1->key_venta.'</td>
                                    </tr>
                                    <tr>
                                        <th>Contribuyente</th>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="fw-semibold">'.$con3->nombre_razon.'</span>
                                                <span class="text-muted">'.$con3->identidad_condicion.'-'.$con3->identidad_nro.'</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tramite</th>
                                        <td>'.$con2->tramite.'</td>
                                    </tr>
                                    <tr>
                                        <th>UCD|Bs.</th>
                                        <td>'.$monto.'</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <form id="form_imprmir_timbre" method="post" onsubmit="event.preventDefault(); imprimirTimbre()">
                            <input type="hidden" name="timbre" value="'.$val_timbre.'">
                            <input type="hidden" name="papel" value="'.$val_papel.'">

                            <div class="d-flex justify-content-center mt-3 mb-3">
                                <button type="button" class="btn btn-secondary btn-sm me-2" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-success btn-sm">Imprimir</button>
                            </div>

                        </form>
                    </div>';

            return response()->json(['success' => true, 'html' => $html, 'papel' => 1]);   
            
        }else{
            //// PAPEL DAÑADO | IMPRIMIR EN OTRO NRO TIMBRE

            /// BUSCAR EL CORRELATIVO DEL PROXIMO TIMBRE
            $con4 = DB::table('detalle_venta_tfes')->select('key_inventario_tfe')->where('nro_timbre','=',$timbre)->first();
            if ($con4) {
                $detalle_last_id = $con4->key_inventario_tfe;

                $con5 = DB::table('inventario_tfes')->select('hasta')->where('correlativo','=',$detalle_last_id)->first();
                if ($detalle_last_id < $con5->hasta) {
                    $next_nro_timbre = $timbre + 1;
                }else{
                    //lego al limite del lote asignado
                    $con6 = DB::table('inventario_tfes')->select('desde')->where('key_taquilla','=',$id_taquilla)->where('condicion','=',4)->first();
                    if ($con6) {
                        $next_nro_timbre = $con6->desde;
                    }else{
                        return response()->json(['success' => false, 'nota' => 'No tiene disponible Timbre Fiscales TFE-14 en la taquilla. Por favor, comunicarse con el coordinador.']);
                    }
                }
            }else{
                return response()->json(['success' => false]);
            }

            $formato_nro_next = substr(str_repeat(0, $length).$next_nro_timbre, - $length);

            $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                        <div class="text-center">
                            <i class="bx bx-receipt fs-2 text-muted me-2"></i>
                            <h1 class="modal-title fs-5 fw-bold text-navy">Impresión TFE-14 <span class="text-secondary">| Papel Dañado</span></h1>
                        </div>
                    </div> 
                    <div class="modal-body px-5 py-3" style="font-size:13px">
                        <span class="text-muted">*IMPORTANTE:</span>

                        <div class="">
                            <div class="row align-items-center text-center">
                                <div class="col-sm-6">
                                    <div class="d-flex flex-column">
                                        <span class="text-muted fw-bold titulo" style="font-size:13px">No. Timbre</span>
                                        <span class="fw-bold text-navy fs-5">Papel Dañado</span>
                                        <span class="text-muted fs-4 fw-bold titulo">A-'.$formato_nro.'</span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="d-flex flex-column">
                                        <span class="text-muted fw-bold titulo" style="font-size:13px">No. Timbre</span>
                                        <span class="fw-bold text-navy fs-5">A Imprimir</span>
                                        <span class="text-danger fs-4 fw-bold titulo">A-'.$formato_nro_next.'</span>
                                    </div>
                                </div>
                            </div> 
                        </div>

                        <div class="d-flex justify-content-center my-3">
                            <table class="table table-sm">
                                <tbody>
                                    <tr>
                                        <th>ID Venta</th>
                                        <td>'.$con1->key_venta.'</td>
                                    </tr>
                                    <tr>
                                        <th>Contribuyente</th>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="fw-semibold">'.$con3->nombre_razon.'</span>
                                                <span class="text-muted">'.$con3->identidad_condicion.'-'.$con3->identidad_nro.'</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tramite</th>
                                        <td>'.$con2->tramite.'</td>
                                    </tr>
                                    <tr>
                                        <th>UCD|Bs.</th>
                                        <td>'.$monto.'</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>


                        <form id="form_imprmir_timbre" method="post" onsubmit="event.preventDefault(); imprimirTimbre()">
                            <input type="hidden" name="timbre" value="'.$val_timbre.'">
                            <input type="hidden" name="papel" value="'.$val_papel.'">

                            <div class="d-flex justify-content-center mt-3 mb-3">
                                <button type="button" class="btn btn-secondary btn-sm me-2" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-success btn-sm">Imprimir</button>
                            </div>

                        </form>
                    </div>';
            return response()->json(['success' => true, 'html' => $html, 'papel' => 0]); 


        }
    }



    public function imprimir(Request $request){
        $papel = unserialize(base64_decode($request->post('papel')));
        $timbre =unserialize(base64_decode($request->post('timbre'))); 

        $length = 6;

        if ($papel == 1) {
            /// PAPEL BUENO

            $upd1 = DB::table('detalle_venta_tfes')->where('nro_timbre','=',$timbre)->update(['condicion' => 30]); //vuelto a imprimir
            if ($upd1) {
                $con1 = DB::table('detalle_venta_tfes')->select('key_venta','serial')->where('nro_timbre','=',$timbre)->first();
                if ($con1) {
                    $con2 = DB::table('detalle_ventas')->join('tramites', 'detalle_ventas.key_tramite', '=','tramites.id_tramite')
                                            ->select('detalle_ventas.ucd','detalle_ventas.bs','tramites.tramite','tramites.key_ente')
                                            ->where('detalle_ventas.key_venta','=',$con1->key_venta)->first();
                    $con3 =  DB::table('ventas')->join('contribuyentes', 'ventas.key_contribuyente', '=','contribuyentes.id_contribuyente')
                                            ->select('contribuyentes.nombre_razon','contribuyentes.identidad_condicion','contribuyentes.identidad_nro')
                                            ->where('ventas.id_venta','=',$con1->key_venta)->first();
                    if ($con2 && $con3) {
                        $formato_nro = substr(str_repeat(0, $length).$timbre, - $length);
        
                        if ($con2->ucd == null) {
                            $monto = number_format($con2->bs, 2, ',', '.').' Bs.';
                        }else{
                            $monto = $con2->ucd.' U.C.D.';
                        }
                    }else{ 
                        $update = DB::table('detalle_venta_tfes')->where('nro_timbre','=',$timbre)->update(['condicion' => 7]);
                        return response()->json(['success' => false]); 
                    }
                }else{
                    $update = DB::table('detalle_venta_tfes')->where('nro_timbre','=',$timbre)->update(['condicion' => 7]);
                    return response()->json(['success' => false]);
                }

                $con_ente = DB::table('entes')->select('ente')->where('id_ente','=',$con2->key_ente)->first();

                $html = '<div class="modal-header">
                            <h1 class="modal-title fs-5 fw-bold text-navy">Timbre Re-Impreso<span class="text-muted"></span></h1>
                        </div>
                        <div class="modal-body px-4 py-3" style="font-size:12.7px">
                            <div class="row">
                                <!-- DETALLE TIMBRE(S) -->
                                <div class="col-lg-12">
                                    <div class="border mb-4 rounded-3">
                                        <div class="d-flex justify-content-between px-3 py-2 align-items-center">
                                            <!-- DATOS -->
                                            <div class="w-50">
                                                <div class="text-danger fw-bold fs-4" id="">A-'.$formato_nro.'<span class="text-muted ms-2">TFE-14</span></div> 
                                                <table class="table table-borderless table-sm lh-1 text_12">
                                                    <tr>
                                                        <th>Ente:</th>
                                                        <td>'.$con_ente->ente.'</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Tramite:</th>
                                                        <td>'.$con2->tramite.'</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Serial:</th>
                                                        <td>'.$con1->serial.'</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <!-- UCD -->
                                            <div class="">
                                                <div class="text-center titulo fw-bold fs-3">'.$monto.'</div>
                                            </div>
                                            <!-- QR -->
                                            <div class="text-center">
                                                <img src="'.asset('assets/qrForma14/qrcode_TFE'.$timbre.'.png').'" class="img-fluid" alt="" width="110px">
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>  <!--  cierra div.row   -->
                            <div class="d-flex justify-content-center mt-3 mb-3">
                                <a href="'.route("home").'" class="btn btn-secondary btn-sm me-2">Cerrar</a>
                            </div>
                        </div>';

                /////LLAMAR A LA FUNCIUON DE IMPRIMIR Y PASAR DATOS DE IMPRESION
                return response()->json(['success' => true, 'html' => $html, 'papel' => 1]);   

            }else{
                $update = DB::table('detalle_venta_tfes')->where('nro_timbre','=',$timbre)->update(['condicion' => 7]);
                return response()->json(['success' => false]);
            }

        }else{
            /// PAPEL DAÑADO

            /// BUSCAR EL CORRELATIVO DEL PROXIMO TIMBRE
            ////ID TAQUILLA
            $user = auth()->id();
            $query = DB::table('users')->select('key_sujeto')->where('id','=',$user)->first();
            $q2 = DB::table('taquillas')->select('id_taquilla')->where('key_funcionario','=',$query->key_sujeto)->first();
            if ($q2) {
                $id_taquilla = $q2->id_taquilla;
            }else{
                return response()->json(['success' => false]);
            }
            //
            $con4 = DB::table('detalle_venta_tfes')->join('ucd_denominacions', 'detalle_venta_tfes.key_denominacion', '=','ucd_denominacions.id')
                                                    ->select('detalle_venta_tfes.key_venta','detalle_venta_tfes.key_taquilla','detalle_venta_tfes.key_detalle_venta','detalle_venta_tfes.key_denominacion','detalle_venta_tfes.bolivares','ucd_denominacions.identificador')
                                                    ->where('detalle_venta_tfes.nro_timbre','=',$timbre)->first();

            $c5 = DB::table('detalle_venta_tfes')->select('key_inventario_tfe','nro_timbre')->where('key_taquilla','=',$id_taquilla)->orderBy('correlativo', 'desc')->first();
            if ($con4 && $c5) {
                $nro_hipotetico = $c5->nro_timbre +1;
    
                $c6 = DB::table('inventario_tfes')->select('hasta','key_lote_papel')->where('correlativo','=',$c5->key_inventario_tfe)->first();

                if ($nro_hipotetico > $c6->hasta) {
                    $c7 = DB::table('inventario_tfes')->select('desde','correlativo','key_lote_papel')
                                                        ->where('key_taquilla','=',$id_taquilla)
                                                        ->where('condicion','=',4)
                                                        ->first();
                    if ($c7) {
                        $next_nro_timbre = $c7->desde;
                        $key_inventario = $c7->correlativo;
                        $key_lote = $c7->key_lote_papel;
                        $update_2 = DB::table('inventario_tfes')->where('correlativo','=',$c7->correlativo)->update(['condicion' => 3]);
                    }else{
                        return response()->json(['success' => false, 'nota'=> 'No tiene disponible Timbre Fiscales TFE-14 en la taquilla. Por favor, comunicarse con el coordinador.']);
                    }
                }else{
                    $next_nro_timbre = $nro_hipotetico;
                    $key_inventario = $c5->key_inventario_tfe;
                    $key_lote = $c6->key_lote_papel;
                    if ($nro_hipotetico == $c6->hasta) {
                        $update_1 = DB::table('inventario_tfes')->where('correlativo','=',$c5->key_inventario_tfe)->update(['condicion' => 7]);
                    }
                }

            }else{
                return response()->json(['success' => false]);
            }

            /////////
            $con2 = DB::table('detalle_ventas')->join('tramites', 'detalle_ventas.key_tramite', '=','tramites.id_tramite')
                                                ->select('detalle_ventas.ucd','detalle_ventas.bs','tramites.tramite','tramites.key_ente')
                                                ->where('detalle_ventas.key_venta','=',$con4->key_venta)->first();
            $con_ente = DB::table('entes')->select('ente')->where('id_ente','=',$con2->key_ente)->first();

            if ($con_ente && $con2) {
                $upd1 = DB::table('detalle_venta_tfes')->where('nro_timbre','=',$timbre)->update(['condicion' => 29]); //anulado
                if ($upd1) {
                    //// NUEVO DETALLE VENTA TFES
                    // SERIAL
                    $length = 6;
                    $formato_nro = substr(str_repeat(0, $length).$next_nro_timbre, - $length);

                    //////// IDENTIFICACION DE FORMA
                    $c_forma = DB::table('formas')->select('identificador')->where('forma','=','Forma14')->first();
                    $identificador_forma = $c_forma->identificador;

                    $serial = $con4->identificador.''.$identificador_forma.''.$formato_nro;

                    // QR
                    $url = 'https://tfe14.tributosaragua.com.ve/?id='.$next_nro_timbre.'?lp='.$key_lote; 
                    QrCode::format('png')->size(180)->eye('circle')->generate($url, public_path('assets/qrForma14/qrcode_TFE'.$next_nro_timbre.'.png'));


                    if ($con2->ucd == null) {
                        ///bs
                        $monto = number_format($con2->bs, 2, ',', '.').' Bs.';
                        $bs = $con2->bs;
                    }else{
                        ///ucd
                        $monto = $con2->ucd.' U.C.D.';
                        $bs = null;
                    }


                    // insert detalle_venta_estampilla
                    $insert = DB::table('detalle_venta_tfes')->insert(['key_venta' => $con4->key_venta, 
                                                                    'key_taquilla' => $con4->key_taquilla,  
                                                                    'key_detalle_venta' => $con4->key_detalle_venta, 
                                                                    'key_denominacion' =>$con4->key_denominacion,
                                                                    'bolivares' => $bs,
                                                                    'nro_timbre' => $next_nro_timbre,
                                                                    'key_inventario_tfe' => $key_inventario,
                                                                    'serial' => $serial,
                                                                    'qr' => 'assets/qrForma14/qrcode_TFE'.$next_nro_timbre.'.png',
                                                                    'condicion' => 7,
                                                                    'sustituto' => null]); 
                    if ($insert) {
                        $upd2 = DB::table('detalle_venta_tfes')->where('nro_timbre','=',$timbre)->update(['sustituto' => $next_nro_timbre]); //timbre sustituto del anulado
                        if ($upd2) {
                                $html = '<div class="modal-header">
                                        <h1 class="modal-title fs-5 fw-bold text-navy">Timbre Re-Impreso<span class="text-muted"></span></h1>
                                    </div>
                                    <div class="modal-body px-4 py-3" style="font-size:12.7px">
                                        <div class="row">
                                            <!-- DETALLE TIMBRE(S) -->
                                            <div class="col-lg-12">
                                                <div class="border mb-4 rounded-3">
                                                    <div class="d-flex justify-content-between px-3 py-2 align-items-center">
                                                        <!-- DATOS -->
                                                        <div class="w-50">
                                                            <div class="text-danger fw-bold fs-4" id="">A-'.$formato_nro.' <span class="badge text-bg-secondary ms-2" style="font-size:13px">Nuevo</span> <span class="text-muted ms-2">TFE-14</span></div> 
                                                            <table class="table table-borderless table-sm lh-1 text_12">
                                                                <tr>
                                                                    <th>Ente:</th>
                                                                    <td>'.$con_ente->ente.'</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Tramite:</th>
                                                                    <td>'.$con2->tramite.'</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Serial:</th>
                                                                    <td>'.$serial.'</td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <!-- UCD -->
                                                        <div class="">
                                                            <div class="text-center titulo fw-bold fs-3">'.$monto.'</div>
                                                        </div>
                                                        <!-- QR -->
                                                        <div class="text-center">
                                                            <img src="'.asset('assets/qrForma14/qrcode_TFE'.$next_nro_timbre.'.png').'" class="img-fluid" alt="" width="110px">
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>  <!--  cierra div.row   -->
                                        <div class="d-flex justify-content-center mt-3 mb-3">
                                            <a href="'.route("home").'"  class="btn btn-secondary btn-sm me-2">Cerrar</a>
                                        </div>
                                    </div>';

                            /////LLAMAR A LA FUNCIUON DE IMPRIMIR Y PASAR DATOS DE IMPRESION
                            return response()->json(['success' => true, 'html' => $html,'papel' => 0]); 
                        }else{
                            return response()->json(['success' => false]);
                        }
                         
                    }else{
                        $update = DB::table('detalle_venta_tfes')->where('nro_timbre','=',$timbre)->update(['condicion' => 7]); 
                        return response()->json(['success' => false]);
                    }
                }else{
                    $update = DB::table('detalle_venta_tfes')->where('nro_timbre','=',$timbre)->update(['condicion' => 7]); 
                    return response()->json(['success' => false]);
                }
                
            }else{
                return response()->json(['success' => false]);
            }

        }


    }

    
}
