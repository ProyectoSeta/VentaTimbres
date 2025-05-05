<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class InventarioTaquillasController extends Controller
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
        $query_1 = DB::table('sedes')->get();
        $t1 = DB::table('sedes')->selectRaw("count(*) as total")->first();

        $taquillas = [];
        $s = 0;

        foreach ($query_1 as $q1) {
            $s++;
            $t2 = DB::table('taquillas')->selectRaw("count(*) as total")->where('key_sede','=', $q1->id_sede)->first();
            if ($s == $t1->total) {
                

                ////ultima sede
                $array = array(
                    'salto' => true,
                    'fin' => false,
                    'sede' => $q1->sede,
                    'id_taquilla' => '',
                    'cantidad_tfe' => '',
                    'cantidad_estampillas' => '',
                    'taquillero' => '',
                    'cant_taquillas' => $t2->total
                );
                $a = (object) $array;
                array_push($taquillas,$a);
    
                $query = DB::table('taquillas')->join('funcionarios', 'taquillas.key_funcionario', '=','funcionarios.id_funcionario')
                                                ->select('funcionarios.nombre','taquillas.id_taquilla')
                                                ->where('taquillas.key_sede','=', $q1->id_sede)->get();
                

                $t = 0;
                foreach ($query as $key) {
                    $t++;

                    if ($t == $t2->total) {
                        ///ultima taquilla, de la ultima sede
                        $c1 = DB::table('inventario_taquillas')->where('key_taquilla','=', $key->id_taquilla)->first();
                        $array = array(
                                   'salto' => false,
                                   'fin' => false,
                                   'sede' => '',
                                   'id_taquilla' => $key->id_taquilla,
                                   'cantidad_tfe' => $c1->cantidad_tfe,
                                   'cantidad_estampillas' => $c1->cantidad_estampillas,
                                   'taquillero' => $key->nombre,
                                   'cant_taquillas' => $t2->total
                               );
                        $a = (object) $array;
                        array_push($taquillas,$a);

                        //////
                        $array = array(
                                    'salto' => false,
                                    'fin' => true,
                                    'sede' => '',
                                    'id_taquilla' => '',
                                    'cantidad_tfe' => '',
                                    'cantidad_estampillas' => '',
                                    'taquillero' => '',
                                    'cant_taquillas' => $t2->total
                                );
                        $a = (object) $array;
                        array_push($taquillas,$a);

                    }else{
                        $c1 = DB::table('inventario_taquillas')->where('key_taquilla','=', $key->id_taquilla)->first();
                        $array = array(
                                    'salto' => false,
                                    'fin' => false,
                                    'sede' => '',
                                    'id_taquilla' => $key->id_taquilla,
                                    'cantidad_tfe' => $c1->cantidad_tfe,
                                    'cantidad_estampillas' => $c1->cantidad_estampillas,
                                    'taquillero' => $key->nombre,
                                    'cant_taquillas' => $t2->total
                                );
                        $a = (object) $array;
                        array_push($taquillas,$a);
                    }
                    
                }

            }else{
                $array = array(
                        'salto' => true,
                        'fin' => false,
                        'sede' => $q1->sede,
                        'id_taquilla' => '',
                        'cantidad_tfe' => '',
                        'cantidad_estampillas' => '',
                        'taquillero' => '',
                        'cant_taquillas' => $t2->total
                );
                $a = (object) $array;
                array_push($taquillas,$a);
    
                $query = DB::table('taquillas')->join('funcionarios', 'taquillas.key_funcionario', '=','funcionarios.id_funcionario')
                                                ->select('funcionarios.nombre','taquillas.id_taquilla')
                                                ->where('taquillas.key_sede','=', $q1->id_sede)->get();
    
                foreach ($query as $key) {
                    $c1 = DB::table('inventario_taquillas')->where('key_taquilla','=', $key->id_taquilla)->first();
                    $array = array(
                                'salto' => false,
                                'fin' => false,
                                'sede' => '',
                                'id_taquilla' => $key->id_taquilla,
                                'cantidad_tfe' => $c1->cantidad_tfe,
                                'cantidad_estampillas' => $c1->cantidad_estampillas,
                                'taquillero' => $key->nombre,
                                'cant_taquillas' => $t2->total
                            );
                    $a = (object) $array;
                    array_push($taquillas,$a);
                }

            }



            

        }

        return view('inventario_taquillas',compact('taquillas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function detalle(Request $request)
    {
        $taquilla = $request->post('taquilla');
        $tr = '';

        $c1 = DB::table('ucd_denominacions')->join('tipos', 'ucd_denominacions.alicuota', '=','tipos.id_tipo')
                        ->select('ucd_denominacions.id','ucd_denominacions.denominacion','tipos.nombre_tipo')
                        ->where('ucd_denominacions.estampillas','=','true')->get();
        foreach ($c1 as $key) {
            $total = 0;
            $consulta = DB::table('detalle_asignacion_estampillas')->select('cantidad_timbres','vendido')
                                                        ->where('key_denominacion','=',$key->id)
                                                        ->where('key_taquilla','=',$taquilla)
                                                        ->where('condicion','!=',8)
                                                        ->where('condicion','!=',7)
                                                        ->get();
            foreach ($consulta as $detalle) {
                $disponible = $detalle->cantidad_timbres - $detalle->vendido;
                $total = $total + $disponible;
                
            }

            if ($total < 25) {
               $ucd = '<span class="text-navy fw-bold titulo d-flex align-items-center justify-content-center">
                            '.$key->denominacion.' '.$key->nombre_tipo.' 
                            <i class="bx bx-error-circle ms-2 text-danger"></i>
                        </span>';
            }elseif ($total >= 26  && $total <= 50) {
                $ucd = '<span class="text-navy fw-bold titulo d-flex align-items-center justify-content-center">
                            '.$key->denominacion.' '.$key->nombre_tipo.' 
                            <i class="bx bx-minus-circle ms-2" style="color:#f59d11"></i>
                        </span>';
            }else{
                $ucd = '<span class="text-navy fw-bold titulo d-flex align-items-center justify-content-center">
                            '.$key->denominacion.' '.$key->nombre_tipo.' 
                            <i class="bx bx-check-circle ms-2 text-success"></i>
                        </span>';
            }

            $tr .= '<tr>
                        <td>
                            '.$ucd.'
                        </td>
                        <td>'.$total.' und.</td>
                    </tr>';
        }

        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-collection fs-2 text-muted me-2"></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">Detalle Inventario <span class="text-muted">| Estampillas</span></h1>
                    </div>
                </div>
                <div class="modal-body px-3 py-3" style="font-size:13px;">
                    <!-- <p class="">NOTA: </p> -->
                    <div class="d-flex justify-content-center">
                        <table class="table w-75 text-center">
                            <tr>
                                <th class="w-50">Estampillas</th>
                                <th class="w-50">Cantidad</th>
                            </tr>
                            '.$tr.'
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3 mb-3">
                        <button type="button" class="btn btn-secondary btn-sm me-2" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>';

        return response($html);
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
