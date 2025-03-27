<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; 

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
        




        // function calcularCombinacionMinimaConLimite($arrayNumeros, $montoTotal, $limiteElementos = 5) {
        //     $combinacion = [];
            
        //     // Ordenar los números en orden descendente
        //     usort($arrayNumeros, function($a, $b) {
        //         return $b['numero'] - $a['numero'];
        //     });
        
        //     $elementosUsados = 0;
        
        //     foreach ($arrayNumeros as $item) {
        //         $numero = $item['numero'];
        //         $cantidadDisponible = $item['cantidad'];
        
        //         // Calcular cuántas veces podemos usar este número sin exceder el monto o el límite de elementos
        //         $cantidadUsar = min(floor($montoTotal / $numero), $cantidadDisponible);
        
        //         // Ajustar la cantidad a usar si excede el límite de elementos
        //         if ($cantidadUsar + $elementosUsados > $limiteElementos) {
        //             $cantidadUsar = $limiteElementos - $elementosUsados;
        //         }
        
        //         if ($cantidadUsar > 0) {
        //             $combinacion[] = [
        //                 'numero' => $numero,
        //                 'cantidad' => $cantidadUsar,
        //             ];
        //             $montoTotal -= $cantidadUsar * $numero;
        //             $elementosUsados += $cantidadUsar;
        //         }
        
        //         // Si el monto total llega a 0 o alcanzamos el límite de elementos, terminamos
        //         if ($montoTotal == 0 || $elementosUsados >= $limiteElementos) {
        //             break;
        //         }
        //     }
        
        //     // Verificar si el monto total pudo ser alcanzado
        //     if ($montoTotal > 0) {
        //         return null; // No se pudo lograr el monto exacto con los números disponibles y el límite de elementos
        //     }
        
        //     return $combinacion;
        // }
        
        

        // $arrayNumeros = [
        //     ['numero' => 5, 'cantidad' => 3],
        //     ['numero' => 3, 'cantidad' => 5],
        //     ['numero' => 2, 'cantidad' => 10],
        //     ['numero' => 1, 'cantidad' => 0],
        // ];
        
        // $montoTotal = 6;
        
        // $resultado = calcularCombinacionMinimaConLimite($arrayNumeros, $montoTotal);
        
        // if ($resultado) {
        //     echo "Mejor combinación encontrada:\n";
        //     foreach ($resultado as $item) {
        //         echo "Número: {$item['numero']}, Cantidad: {$item['cantidad']}\n";
        //     }
        // } else {
        //     echo "No es posible alcanzar el monto total dentro del límite de elementos.\n";
        // }
        

        

        

        $user = auth()->id();
        $query = DB::table('users')->select('key_sujeto')->where('id','=',$user)->first();
        $q2 = DB::table('taquillas')->select('id_taquilla')->where('key_funcionario','=',$query->key_sujeto)->first();

        $id_taquilla = $q2->id_taquilla;
        $hoy = date('Y-m-d');
        $apertura_admin = false;
        $apertura_taquillero = false;
        $cierre_taquilla = false;
        $hora_apertura_admin = '';
        $hora_apertura_taquillero = '';
        $hora_cierre_taquilla = '';

        $q3 = DB::table('apertura_taquillas')->select('apertura_admin','apertura_taquillero','cierre_taquilla')
                                            ->where('key_taquilla','=', $id_taquilla)
                                            ->where('fecha','=', $hoy)->first();
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


        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");   

        $hoy_view = $dias[date('w')].", ".date('d')." de ".$meses[date('n')-1]. " ".date('Y');

        return view('home', compact('apertura_admin','apertura_taquillero','hora_apertura_admin','hora_apertura_taquillero','cierre_taquilla','hora_cierre_taquilla','hoy_view'));


    }

    



    public function apertura_taquilla(Request $request){
        $pass = $request->post('clave');

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
                    $hora = date('H:i:s');

                    // ACTUALIZCION DEL INVENTARIO DE TAQUILLA (ESTAMPILLAS Y TFES)
                    $q3 = DB::table('ucd_denominacions')->select('denominacions')->where('estampillas','=','true')->get();
                    foreach ($q3 as $key) {
                        $key_deno = $key->denominacions;
                        
                    }

                    







                    $update = DB::table('apertura_taquillas')->where('key_taquilla', '=', $id_taquilla)
                                                            ->where('fecha','=', $hoy)
                                                            ->update(['apertura_taquillero' => $hora]);
                    if ($update) {
                        return response()->json(['success' => true]);
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
                                                    ->where('fecha','=', $hoy)
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

            $q3 = DB::table('efectivo_taquillas_temps')->select('efectivo')->where('key_taquilla','=',$id_taquilla)->first();
           
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
                            <input type="number" id="monto" class="form-control form-control-sm me-2" name="monto" required> <span>Bs.</span>
                        </div>
                        
                        <p>Monto Total (Efectivo) en Taquilla: <span class="text-success"> '.$q3->efectivo.' Bs</span></p>

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
                                                                    ->where('fecha','=',$hoy)->get();
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
                                <td class="fw-bold">'.$key->monto.' Bs.</td>
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
        $pass = $request->post('clave');

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
                    $hora = date('H:i:s');
                    $update = DB::table('apertura_taquillas')->where('key_taquilla', '=', $id_taquilla)
                                                            ->where('fecha','=', $hoy)
                                                            ->update(['cierre_taquilla' => $hora]);
                    if ($update) {
                        return response()->json(['success' => true]);
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

    
}
