<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

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
        return view('home');
    }

    
    public function libro()
    {
        $user = auth()->id();
        $query = DB::table('users')->select('type')->where('id','=',$user)->first();
        $type = $query->type;
        if ($type == 3) {
            ////contribuyente
            $sp = DB::table('sujeto_pasivos')->select('id_sujeto')->where('id_user','=',$user)->first();
            $id_sp = $sp->id_sujeto;

            // $query_2 = DB::table('sujeto_pasivos')->selectRaw('DATE(created_at) as fecha')->where('id_sujeto','=',$id_sp)->first();
            // $fecha = $query_2->fecha;
            
            // $fechaComoEntero = strtotime($fecha);
            // $mes_ingreso = date("m", $fechaComoEntero);
            $c = DB::table('libros')->selectRaw("count(*) as total")->where('id_sujeto','=',$id_sp)->first();
            if ($c->total == 0) {
                ////////no tiene libros - 1er inicio de sesión
                $mes = date('m');
                $year = date('Y');
                $insert_libros = DB::table('libros')->insert(['id_sujeto' => $id_sp, 'mes' => $mes, 'year' => $year, 'estado' => 2]);
            }else{
                $consulta = DB::table('libros')->select('mes','year')->where('id_sujeto','=',$id_sp)->orderBy('id_libro', 'desc')->first();
                // print_r($consulta);
                $ultimo_dclr_mes = $consulta->mes;
                $ultimo_dclr_year = $consulta->year;

                $mes_now = date('m');
                $year_now = date('Y');

                $day = date('d');
                $cierre = DB::table('variables')->select('valor')->where('nombre','=','cierre_libro')->first();
                if ($cierre) {
                    $dia_cierre = $cierre->valor;
                }

                $primer_mes_sd = $ultimo_dclr_mes + 1;

                if ($ultimo_dclr_year == $year_now) {
                    ////faltan declaraciones del mismo año
                    for ($i=$primer_mes_sd; $i <= $mes_now ; $i++) { 
                        if ($i == $mes_now) {
                            if ($day > $dia_cierre) {
                                $insert_libros = DB::table('libros')->insert(['id_sujeto' => $id_sp, 'mes' => $i, 'year' => $year_now, 'estado' => 2]);
                            }
                        }else{
                            $insert_libros = DB::table('libros')->insert(['id_sujeto' => $id_sp, 'mes' => $i, 'year' => $year_now, 'estado' => 2]);
                        }
                    }
                }else{
                    ////faltan declaraciones de varios años
                    
                    for ($y=$ultimo_dclr_year; $y <= $year_now ; $y++) { 
                        if ($y == $ultimo_dclr_year) {
                            /////el ciclo va a durar hasta 12
                            for ($m=$primer_mes_sd; $m <= 12 ; $m++) { 
                                $insert_libros = DB::table('libros')->insert(['id_sujeto' => $id_sp, 'mes' => $m, 'year' => $y, 'estado' => 2]);
                            }
                        }elseif ($y == $year_now) {
                            /////el ciclo va a durar el presente mes
                            for ($m=1; $m <= $mes_now ; $m++) { 
                                if ($m == $mes_now) {
                                    if ($day > $dia_cierre) {
                                        $insert_libros = DB::table('libros')->insert(['id_sujeto' => $id_sp, 'mes' => $m, 'year' => $y, 'estado' => 2]);
                                    }
                                }else{
                                    $insert_libros = DB::table('libros')->insert(['id_sujeto' => $id_sp, 'mes' => $m, 'year' => $y, 'estado' => 2]);
                                }
                            }
                        }else{
                            /////el ciclo va a durar hasta 12
                            for ($m=1; $m <= 12 ; $m++) { 
                                $insert_libros = DB::table('libros')->insert(['id_sujeto' => $id_sp, 'mes' => $m, 'year' => $y, 'estado' => 2]);
                            }
                        }
                        
                    }
                }
            }
        

        }

    
    }
    
}
