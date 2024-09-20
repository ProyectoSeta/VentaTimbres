<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\SujetoPasivo;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class SettingsContribuyenteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->id();
        $sp = DB::table('sujeto_pasivos')->join('users', 'sujeto_pasivos.id_user', '=', 'users.id')
                                        ->select('sujeto_pasivos.*','users.email','users.password')
                                        ->where('id_user','=',$user)->first();
        $id_sp = $sp->id_sujeto;
        $canteras = DB::table('canteras')->selectRaw("count(*) as total")
                                            ->where('id_sujeto','=',$id_sp)
                                            ->where('status','=','Verificada')->first();

        return view('actualizar_datos', compact('sp', 'canteras'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function editar(Request $request)
    {
        $idSujeto = $request->post('id_sujeto'); 
        $user = auth()->id(); 

        $correo = $request->post('correo');
        if ($correo != '') {
            $update_correo = DB::table('users')->where('id', '=', $user)->update(['email' => $correo]);
        }


        
        $razon_social = $request->post('razon_social');
        $direccion = $request->post('direccion');
        $tlf_movil_sp = $request->post('tlf_movil_sp');
        $tlf_fijo_sp = $request->post('tlf_fijo_sp');

        $ci_condicion_repr = $request->post('ci_condicion_repr');
        $ci_nro_repr = $request->post('ci_nro_repr');
        $rif_condicion_repr = $request->post('rif_condicion_repr');
        $rif_nro_repr = $request->post('rif_nro_repr');
        $nombre_repr = $request->post('nombre_repr');
        $tlf_movil_repr = $request->post('tlf_movil_repr');

        $update = DB::table('sujeto_pasivos')->where('id_sujeto', '=', $idSujeto)
                                            ->update(['razon_social' => $razon_social, 
                                                    'direccion' => $direccion, 
                                                    'tlf_movil' => $tlf_movil_sp, 
                                                    'tlf_fijo' => $tlf_fijo_sp,
                                                    'ci_condicion_repr' => $ci_condicion_repr,
                                                    'ci_nro_repr' => $ci_nro_repr,
                                                    'rif_condicion_repr' => $rif_condicion_repr,
                                                    'rif_nro_repr' => $rif_nro_repr,
                                                    'name_repr' => $nombre_repr,
                                                    'tlf_repr' => $tlf_movil_repr]);


        if ($update || $update_correo) {
            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
        }
    }




    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
