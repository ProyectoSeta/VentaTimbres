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
        $user = auth()->id();
        $query = DB::table('users')->select('key_sujeto')->where('id','=',$user)->first();
        $q2 = DB::table('taquillas')->select('id_taquilla')->where('key_funcionario','=',$query->key_sujeto)->first();

        $id_taquilla = $q2->id_taquilla;
        $hoy = date('Y-m-d');
        $apertura_admin = false;
        $apertura_taquillero = false;
        $hora_apertura_admin = '';
        $hora_apertura_taquillero = '';

        $q3 = DB::table('apertura_taquillas')->select('apertura_admin','apertura_taquillero')
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
                $hora_apertura_admin = $q3->apertura_admin;
                $hora_apertura_taquillero = $q3->apertura_taquillero;
            }
            
        }else{
            /////no hay registro, admin no ha aperturado taquilla
            $apertura_admin = false;
        }

        return view('home', compact('apertura_admin','apertura_taquillero','hora_apertura_admin','hora_apertura_taquillero'));


    }

    
    public function apertura_taquilla(Request $request){
        $pass = $request->post('clave');
        $hoy = date('Y-m-d');

        $user = auth()->id();
        $query = DB::table('users')->select('key_sujeto')->where('id','=',$user)->first();
        $q2 = DB::table('taquillas')->select('id_taquilla','clave')->where('key_funcionario','=',$query->key_sujeto)->first();
        if ($q2) {
            /// usuario taquillero
            $id_taquilla = $q2->id_taquilla;

            if (Hash::check($q2->clave, $pass)) {
                $hora = date('H:i:s');
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
