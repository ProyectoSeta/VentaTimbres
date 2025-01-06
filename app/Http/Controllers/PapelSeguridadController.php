<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class PapelSeguridadController extends Controller
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
        return view('emision_papel');
    }



    public function modal_f14()
    {
        $desde = '';
        $hasta = '';

        $consulta = DB::table('emision_papel_tfes')->selectRaw("count(*) as total")->first();
        if ($consulta->total != 0) {
            //////ya se han emitido 
            $query =  DB::table('emision_papel_tfes')->select('hasta')->orderBy('id_lote_papel', 'desc')->first();
            $desde = $query->hasta + 1;
        }else{
            /////primer lote a emitir
            $desde = 1;
        }

        $c1 =  DB::table('variables')->select('valor')->where('variable','=','cant_por_emision_tfes')->first();
        $cant_timbres_lote = $c1->valor;
        $hasta = ($desde + $cant_timbres_lote) - 1;
        
        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-plus-circle fs-2 text-muted me-2"></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">Emisión</h1>
                        <span>Papel de Seguridad | TFE-14</span>
                    </div>
                </div> 
                <div class="modal-body px-5 py-3" style="font-size:13px">
                    <p class="text-muted">*NOTA: Si el total de timbres fiscales a emitir 
                        es diferente al esperado o se ha cambiado el numero de timbres a producirse por emisión, 
                        dirigirse al modulo configuraciones (Papel de Seguridad) para cambiar el numero total de timbres fiscales.
                    </p>
                    
                    <div class="fw-bold text-center">
                        <p class="text-navy m-0">Total de Timbres a Emitir</p>
                        <p class="fs-5 titulo fw-semibold text-muted">1000 Timbres TFE-14 | Papel de Seguridad</p>
                    </div>
                    

                    <div class="d-flex justify-content-center my-4">
                        <table class="table table-borderess w-50">
                            <tr>
                                <th>Desde:</th>
                                <td>'.$desde.'</td>
                            </tr>
                            <tr>
                                <th>Hasta:</th>
                                <td>'.$hasta.'</td>
                            </tr>
                        </table>
                    </div>

                    <form id="form_emitir_papel_f14" method="post" onsubmit="event.preventDefault(); emitirPapelF14()">
                        <div class="d-flex justify-content-center mt-3 mb-3">
                            <button type="button" class="btn btn-secondary btn-sm me-2" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success btn-sm">Emitir</button>
                        </div>
                    </form>
                    
                </div>';

        return response($html);


    }


    public function emitir_f14(Request $request)
    {
        $query = DB::table('emision_papel_tfes')->select('id_lote_papel')->where('estado', '=', 18)->first();
        if ($query) {
            ///// hay un lote en proceso
            return response()->json(['success' => false, 'nota' => 'Disculpe el Lote No.'.$query->id_lote_papel.' esta "En Proceso", para emitir otro lote de papel de seguridad debe culminar el proceso pendiente. ']);
        }else{
            ///no hay lote en proceso
            $user = auth()->id();

            $desde = '';
            $hasta = '';

            $consulta = DB::table('emision_papel_tfes')->selectRaw("count(*) as total")->first();
            if ($consulta->total != 0) {
                //////ya se han emitido 
                $query =  DB::table('emision_papel_tfes')->select('hasta')->orderBy('id_lote_papel', 'desc')->first();
                $desde = $query->hasta + 1;
            }else{
                /////primer lote a emitir
                $desde = 1;
            }

            $c1 =  DB::table('variables')->select('valor')->where('variable','=','cant_por_emision_tfes')->first();
            $cant_timbres_lote = $c1->valor;
            $hasta = ($desde + $cant_timbres_lote) - 1;
            
            $insert_emision = DB::table('emision_papel_tfes')->insert([
                                            'key_user' => $user,
                                            'cantidad_timbres' => $cant_timbres_lote,
                                            'desde' => $desde,
                                            'hasta' => $hasta,
                                            'estado' => 18,
                                            'asignados' => 0]);  
            if ($insert_emision) {
                $id_emision = DB::table('emision_papel_tfes')->max('id_lote_papel');
                $c2 =  DB::table('variables')->select('valor')->where('variable','=','letra_correlativo_papel_tfes')->first();
                $letra_papel = $c2->valor;

                    
                $length = 6;
                $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
                $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);

                $tr = '<tr>
                            <td>#</td>
                            <td>'.$letra_papel.'-'.$formato_desde.'</td>
                            <td>'.$letra_papel.'-'.$formato_hasta.'</td>
                        </tr>';
                
                
                

                $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                            <div class="text-center">
                                <i class="bx bx-collection fs-2 text-muted me-2"></i>
                                <h1 class="modal-title fs-5 fw-bold text-navy">Correlativo | <span class="text-muted">Emisión Papel de Seguridad</span></h1>
                                <h1 class="fs-6 fw-bold text-muted">TFE 14</h1>
                            </div>
                        </div>
                        <div class="modal-body px-5 py-3" style="font-size:13px">
                            <p class="text-secondary">*NOTA: El lote en emisión tiene un total de '.$cant_timbres_lote.' Trimbres Fiscales TFE-14.</p>
                        
                            <div class="">
                                <table class="table text-center">
                                    <tr>
                                        <th>#</th>
                                        <th>Desde</th>
                                        <th>Hasta</th>
                                    </tr>
                                    '.$tr.'
                                </table>
                            </div>

                            <div class="d-flex justify-content-center mb-3">
                                <a href="'.route("emision_papel").'" class="btn btn-secondary btn-sm me-2">Cancelar</a>
                                <a href="'.route("rollos.pdf", ["emision" => $id_emision]).'" class="btn btn-dark btn-sm"  style="font-size:12.7px">Imprimir</a>
                            </div>
                        </div>';
                return response()->json(['success' => true, 'html' => $html]);
            }else{
                return response()->json(['success' => false]);
            }
        }
    }



    public function modal_estampillas()
    {
        $desde = '';
        $hasta = '';

        $consulta = DB::table('emision_papel_estampillas')->selectRaw("count(*) as total")->first();
        if ($consulta->total != 0) {
            //////ya se han emitido 
            $query =  DB::table('emision_papel_estampillas')->select('hasta')->orderBy('id_lote_papel', 'desc')->first();
            $desde = $query->hasta + 1;
        }else{
            /////primer lote a emitir
            $desde = 1;
        }

        $c1 =  DB::table('variables')->select('valor')->where('variable','=','cant_por_emision_tfes')->first();
        $cant_timbres_lote = $c1->valor;
        $hasta = ($desde + $cant_timbres_lote) - 1;
        
        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-plus-circle fs-2 text-muted me-2"></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">Emisión</h1>
                        <span>Papel de Seguridad | Estampillas</span>
                    </div>
                </div> 
                <div class="modal-body px-5 py-3" style="font-size:13px">
                    <p class="text-muted">*NOTA: Si el total de timbres fiscales a emitir 
                        es diferente al esperado o se ha cambiado el numero de timbres a producirse por emisión, 
                        dirigirse al modulo configuraciones (Papel de Seguridad) para cambiar el numero total de timbres fiscales.
                    </p>
                    
                    <div class="fw-bold text-center">
                        <p class="text-navy m-0">Total de Timbres a Emitir</p>
                        <p class="fs-5 titulo fw-semibold text-muted">1000 Timbres Estampillas | Papel de Seguridad</p>
                    </div>
                    

                    <div class="d-flex justify-content-center my-4">
                        <table class="table table-borderess w-50">
                            <tr>
                                <th>Desde:</th>
                                <td>'.$desde.'</td>
                            </tr>
                            <tr>
                                <th>Hasta:</th>
                                <td>'.$hasta.'</td>
                            </tr>
                        </table>
                    </div>

                    <form id="form_emitir_papel_estampillas" method="post" onsubmit="event.preventDefault(); emitirPapelEstampillas()">
                        <div class="d-flex justify-content-center mt-3 mb-3">
                            <button type="button" class="btn btn-secondary btn-sm me-2" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success btn-sm">Emitir</button>
                        </div>
                    </form>
                    
                </div>';

        return response($html);
    }


    public function emitir_estampillas(Request $request)
    {
        //
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
