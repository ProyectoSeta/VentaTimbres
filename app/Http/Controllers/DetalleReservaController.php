<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class DetalleReservaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $asignaciones = [];
        $id_talonario = $request->talonario;
        $detalles = DB::table('detalle_talonario_reservas')->where('id_talonario','=',$id_talonario)->get();
        $rif_nro = '';
        $rif_condicion = '';
        $razon_social = '';

            foreach($detalles as $d) {
                $id_asignacion = $d->id_asignacion_reserva;

                $asignacion = DB::table('asignacion_reservas')
                                ->join('clasificacions', 'asignacion_reservas.estado', '=', 'clasificacions.id_clasificacion')
                                ->select('asignacion_reservas.*','clasificacions.nombre_clf')
                                ->where('asignacion_reservas.id_asignacion','=',$id_asignacion)
                                ->first();
                $contribuyente = $asignacion->contribuyente;
    
                if ($contribuyente == 27) { ///registrado
                    $sujeto = DB::table('sujeto_pasivos')->select('razon_social','rif_nro','rif_condicion')->where('id_sujeto','=',$asignacion->id_sujeto)->first();
                    $rif_nro = $sujeto->rif_nro;
                    $rif_condicion = $sujeto->rif_condicion;
                    $razon_social = $sujeto->razon_social;
                }else{  //////no registrado
                    $sujeto = DB::table('sujeto_notusers')->select('razon_social','rif_nro','rif_condicion')->where('id_sujeto_notuser','=',$asignacion->id_sujeto_notuser)->first();
                    $rif_nro = $sujeto->rif_nro;
                    $rif_condicion = $sujeto->rif_condicion;
                    $razon_social = $sujeto->razon_social;
                }
    
                $array = array(
                    'id_asignacion' => $id_asignacion,
                    'contribuyente' => $contribuyente,
                    'id_sujeto' => $asignacion->id_sujeto,
                    'rif_nro' =>  $rif_nro,
                    'razon_social' => $razon_social,
                    'rif_condicion' => $rif_condicion,
                    'cantidad_guias' => $asignacion->cantidad_guias,
                    'fecha_emision' => $asignacion->fecha_emision,
                    'soporte' => $asignacion->soporte,
                    'id_estado' => $asignacion->estado,
                    'estado' => $asignacion->nombre_clf,
                    'desde' => $d->desde,
                    'hasta' => $d->hasta
                );
    
                $a = (object) $array;
                array_push($asignaciones, $a);
            }
    
            $asignado = DB::table('talonarios')->select('asignado')->where('id_talonario','=',$id_talonario)->first();

        return view('detalle_reserva', compact('asignaciones','id_talonario','asignado'));
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
