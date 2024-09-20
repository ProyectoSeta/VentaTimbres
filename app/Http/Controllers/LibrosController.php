<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class LibrosController extends Controller
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
        $userTipo = '';
        $consulta = DB::table('users')->select('type')->where('id','=',$user)->first();
        if ($consulta->type == 3) {
            $sp = DB::table('sujeto_pasivos')->select('id_sujeto')->where('id_user','=',$user)->first();
            $id_sp = $sp->id_sujeto;

            $x = DB::table('libros')->where('id_sujeto','=',$id_sp)->get();
            $userTipo = 'sp';
        }else{
            $x = [];
            $consulta = DB::table('sujeto_pasivos')->get();
            foreach ($consulta as $c) {
                $sd = DB::table('libros')
                                    ->selectRaw("count(*) as total")
                                    ->where('id_sujeto','=',$c->id_sujeto)
                                    ->where('estado','=',2)->first();
                if ($sd) {
                    $array = array(
                        'id_sujeto' => $c->id_sujeto,
                        'razon_social' => $c->razon_social,
                        'rif_condicion' => $c->rif_condicion,
                        'rif_nro' => $c->rif_nro,
                        'sin_declarar' => $sd->total
                        );
    
                    $a = (object) $array;
                    array_push($x, $a);
                }
            }
            $userTipo = 'seta';
        }
        
        

        return view('libros', compact('x','userTipo'));
    }

   

    /**
     * Show the form for creating a new resource.
     */
    public function detalles(Request $request)
    {
        $user = auth()->id();
        $sp = DB::table('sujeto_pasivos')->select('id_sujeto')->where('id_user','=',$user)->first();
        $id_sp = $sp->id_sujeto;

        $libro = $request->post('libro');
        $html = '';
        $tables = '';

        $declaraciones = DB::table('declaracions')
                                    ->join('tipos', 'declaracions.tipo', '=', 'tipos.id_tipo')
                                    ->select('declaracions.*', 'tipos.nombre_tipo')
                                    ->where('declaracions.id_libro','=',$libro)
                                    ->where('declaracions.id_sujeto','=',$id_sp)->get();
        if ($declaraciones) {
            foreach ($declaraciones as $dclr) {
                /////////////////////ESTADO DE LA DECLARAIÓN
                $estado = '';
                $consula_estado = DB::table('clasificacions')->select('nombre')->where('id_clasificacion','=',$dclr->estado)->first();
                if ($consula_estado) {
                    switch ($consula_estado->nombre) {
                        case 'Verificando':
                            $estado = '<span class="d-flex align-items-center justify-content-center badge bg-secondary-subtle border text-muted rounded-pill px-0 py-2">Verificado</span>';
                            break;
                        case 'Verificado':
                            $estado = '<span class="d-flex align-items-center justify-content-center badge bg-success-subtle border text-success rounded-pill px-0 py-2">Verificado</span>';
                            break;
                        case 'Negado':
                            $estado = '<span class="d-flex align-items-center justify-content-center badge bg-danger-subtle border text-danger rounded-pill px-0 py-2">Negado</span>';
                            break;   
                    }
                }

                ////////////////////REFERENCIA: 
                if ($dclr->nro_guias_declaradas == 0) {
                    $referencia = '<span class="fw-bold text-danger">SIN ACTIVIDAD ECONÓMICA</span>';
                }else{
                    $referencia = '<a target="_blank" class="ver_pago" href="'.asset($dclr->referencia) .'">Ver</a>';
                }

                ////////////////////OBSERVACIONES: SI ESTA NEGADA
                $observaciones = '';
                if ($dclr->observaciones == null) {
                    $observaciones = '';
                }else{
                    $observaciones = '<tr>
                                        <th>Observaciones</th>
                                        <td>
                                            '.$dclr->observaciones.'
                                        </td>
                                    </tr>';
                }

                $tables .= '<p class="fw-bold bg-primary-subtle rounded-pill px-3 py-2 text-navy fs-6 d-flex align-items-center justify-content-center">
                                <span>'.$dclr->nombre_tipo.'</span>
                            </p>
                            <div class="mx-3 mb-4">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th>Nro. Guías Declaradas</th>
                                            <td class="fw-bold">'.$dclr->nro_guias_declaradas.' Guía(s)</td>
                                        </tr>
                                        <tr>
                                            <th>Total UCD</th>
                                            <td>'.$dclr->total_ucd.' UCD</td>
                                        </tr>
                                        <tr>
                                            <th>Monto Total</th>
                                            <td>'.$dclr->monto_total.' Bs.</td>
                                        </tr>
                                        <tr>
                                            <th>Fecha</th>
                                            <td class="text-secondary">'.$dclr->fecha.'</td>
                                        </tr>
                                        <tr>
                                            <th>Referencia</th>
                                            <td>
                                                '.$referencia.'
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Estado</th>
                                            <td>
                                                '.$estado.'
                                            </td>
                                        </tr>
                                        '.$observaciones.'
                                    </table>
                                </div>
                            </div>';

            }
            
            $periodo = DB::table('libros')->select('mes','year')->where('id_libro','=',$libro)->first();
            if ($periodo) {
                $meses = ['','ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO','JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];
                            $mes_bd = $periodo->mes;
                            $mes_libro = $meses[$mes_bd];

                $html =    '<div class="modal-header d-flex flex-column justify-content-center">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">
                                    Declaración(es) del Libro
                                </h1>
                                <span class="fw-bold text-navy fs-5">'.$mes_libro.' '.$periodo->year.'</span>
                            </div>
                            <div class="modal-body px-4" style="font-size:14px;" >
                                '.$tables.'
                            </div>';
            }
            return response($html);
        }else{
            return response()->json(['success' => false]);
        }


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
