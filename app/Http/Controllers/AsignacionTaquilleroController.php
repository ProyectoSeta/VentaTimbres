<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class AsignacionTaquilleroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $asignados = [];

        $proceso = DB::table('exenciones')->join('contribuyentes', 'exenciones.key_contribuyente', '=','contribuyentes.id_contribuyente')
                                            ->select('exenciones.*','contribuyentes.nombre_razon','contribuyentes.identidad_condicion','contribuyentes.identidad_nro')
                                            ->where('exenciones.estado','=',18)->where('exenciones.key_taquilla','=',null)->get();

        $q1 = DB::table('exenciones')->join('contribuyentes', 'exenciones.key_contribuyente', '=','contribuyentes.id_contribuyente')
                                            ->join('taquillas', 'exenciones.key_taquilla', '=','taquillas.id_taquilla')
                                            ->select('exenciones.*','contribuyentes.nombre_razon','contribuyentes.identidad_condicion','contribuyentes.identidad_nro','taquillas.key_funcionario')
                                            ->where('exenciones.estado','=',18)->where('exenciones.key_taquilla','!=',null)->get();

        foreach ($q1 as $key) {
            $c1 = DB::table('funcionarios')->select('nombre')->where('id_funcionario','=', $key->key_funcionario)->first();

            $array = array(
                        'id_exencion' => $key->id_exencion,
                        'key_contribuyente' => $key->key_contribuyente,
                        'fecha' => $key->fecha,
                        'key_taquilla' => $key->key_taquilla,
                        'porcentaje_exencion' => $key->porcentaje_exencion,
                        'fecha_asig_taquilla' => $key->fecha_asig_taquilla,
                        'fecha_impreso' => $key->fecha_impresion,
                        'nombre_razon' => $key->nombre_razon,
                        'identidad_condicion' => $key->identidad_condicion,
                        'identidad_nro' => $key->identidad_nro,
                        'total_ucd' => $key->total_ucd,
                        'nombre_taquillero' => $c1->nombre,
                        'key_funcionario' => $key->key_funcionario
                    );
            $a = (object) $array;
            array_push($asignados,$a);
        }




        $sedes =  DB::table('sedes')->get();

        return view('asignar_taquillero',compact('proceso','sedes','asignados'));
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
    public function asignar(Request $request)
    {
        $sede = $request->post('sede');
        $taquilla = $request->post('taquilla');
        $exencion = $request->post('exencion');
        $user = auth()->id();

        if ($sede == 'Seleccionar' || $sede == '') {
            return response()->json(['success' => false, 'nota'=> 'Debe seleccionar la Sede.']);
        }

        if ($taquilla == 'Seleccionar' || $taquilla == '') {
            return response()->json(['success' => false, 'nota'=> 'Debe seleccionar la Taquilla.']);
        }

        $dia = date('d');
        $mes = date('m');
        $year = date('Y');
        $hoy = $year.'-'.$mes.'-'.$dia.' '.date('h:i:s');



        $update = DB::table('exenciones')->where('id_exencion','=',$exencion)->update(['key_taquilla' => $taquilla,'fecha_asig_taquilla' => $hoy]);
        if ($update) {
            /////BITACORA
            // $accion = 'IMPORTANTE: INTENTO DE MODIFICAR EL NO. DE INICIO DEL CORRELATIVO DE PAPEL PARA TIMBRE FISCAL ELECTRONICO ACTUALIZADO.';
            // $bitacora = DB::table('bitacoras')->insert(['key_user' => $user, 'key_modulo' => 8, 'accion'=> $accion]);
            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
        }

    }

    /**
     * Display the specified resource.
     */
    public function info_taquillero(Request $request)
    {
        $taquillero = $request->post('taquillero');
        $taquilla = $request->post('taquilla');

        $c1 = DB::table('funcionarios')->where('id_funcionario','=', $taquillero)->first();


        $c2 = DB::table('taquillas')->join('sedes', 'taquillas.key_sede', '=','sedes.id_sede')
                                        ->select('sedes.sede')
                                        ->where('taquillas.id_taquilla','=', $taquilla)->first();


        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-user-circle fs-1 text-secondary" ></i>
                        <h1 class="modal-title fs-5 text-navy fw-bold" id="" >Información de Taquillero</h1>
                    </div>
                </div>
                <div class="modal-body" style="font-size:13px;">
                    <div class="d-flex justify-content-centerpx-3">
                        <table class="table text-cente">
                            <tr>
                                <th class="text-center">ID</th>
                                <td class="text-muted">'.$c1->id_funcionario.'</td>
                            </tr>
                            <tr>
                                <th class="text-center">Nombre</th>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="text-navy fw-bold">'.$c1->nombre.' <span class="badge bg-primary-subtle text-primary-emphasis ms-2">'.$c1->cargo.'</span></span>
                                        <span class="text-muted">'.$c1->ci_condicion.'-'.$c1->ci_nro.'</span>
                                    </div> 
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center">Sede</th>
                                <td>'.$c2->sede.'</td>
                            </tr>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center my-2">
                        <button type="button" class="btn btn-secondary btn-sm me-2" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>';

        return response($html);

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
