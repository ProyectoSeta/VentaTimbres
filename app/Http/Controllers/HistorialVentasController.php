<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class HistorialVentasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $taquillas =  DB::table('taquillas')
                        ->join('funcionarios', 'taquillas.key_funcionario', '=', 'funcionarios.id_funcionario')
                        ->join('sedes', 'taquillas.key_sede', '=', 'sedes.id_sede')
                        ->select('taquillas.*','funcionarios.nombre','sedes.sede')
                        ->where('taquillas.estado','=', 16)->get();

        return view('historial_ventas', compact('taquillas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function search(Request $request)
    {
        $fecha = $request->post('fecha');
        $taquilla = $request->post('taquilla');
        $tr = '';

        $ventas = DB::table('ventas')->join('contribuyentes', 'ventas.key_contribuyente', '=','contribuyentes.id_contribuyente')
                                        ->select('ventas.*','contribuyentes.identidad_condicion','contribuyentes.identidad_nro')
                                        ->where('ventas.key_taquilla','=',$taquilla)
                                        ->whereDate('ventas.fecha', $fecha)
                                        ->get();

        foreach ($ventas as $venta) {
            $hora = date("h:i A",strtotime($venta->hora));
            if ($venta->total_ucd == 0) {
                $ucd = '<span class="fst-italic text-muted">No Aplica</span>';
            }else{
                $ucd = ' <span class="fw-bold text-muted">'.$venta->total_ucd.' U.C.D.</span>';
            }
            $bs = number_format($venta->total_bolivares, 2, ',', '.');
            $tr .= '<tr>
                        <td class="text-muted">'.$venta->id_venta.'</td>
                        <td>'.$hora.'</td>
                        <td>
                            <a class="info_sujeto" role="button" sujeto="'.$venta->key_contribuyente.'" data-bs-toggle="modal" data-bs-target="#modal_info_sujeto">
                                <span>'.$venta->identidad_condicion.' - '.$venta->identidad_nro.'</span>
                            </a>
                        </td>
                        <td>
                            '.$ucd.'
                        </td>
                        <td>
                            <span class="fw-bold text-navy">'.$bs.' Bs.</span>
                        </td>
                        <td>
                            <a role="button" class="detalle_venta" venta="'.$venta->id_venta.'" data-bs-toggle="modal" data-bs-target="#modal_detalle_venta">Ver</a>
                        </td>
                    
                        <td>
                            <a role="button" class="timbres" venta="'.$venta->id_venta.'" data-bs-toggle="modal" data-bs-target="#modal_timbres">Ver</a>
                        </td>
                        
                    </tr>';
        }

        $html = '<div class="table-responsive py-3 pt-5 px-4"  style="font-size:12.7px">
                <table class="table table-sm border-light-subtle text-center" id="table_venta_taquilla"  style="font-size:13px">
                    <thead>
                        <tr>
                            <th>ID Venta</th>
                            <th>Hora</th>
                            <th>Contribuyente</th>
                            <th>Total U.C.D.</th>
                            <th>Total Bs.</th>
                            <th>Detalle</th>
                            <th>Timbres</th>                            
                        </tr>
                    </thead>
                    <tbody>
                        '.$tr.'
                    </tbody>
                </table>
            </div>';

        return response($html);
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
