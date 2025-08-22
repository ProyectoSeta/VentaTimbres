<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class RecaudacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $mes_actual = date('m');

        // TOTAL RECAUDADO EN EL MES
        $c1 = DB::table('cierre_diarios')->select(DB::raw('SUM(recaudado) as total'))
                                    ->whereMonth('fecha', $mes_actual)->first();
        $recaudacion_mensual = $c1->total;



        // RECAUDADO FORMA 14
        $c2 = DB::table('ventas')->select('id_venta')->whereMonth('fecha', $mes_actual)->get();
        foreach ($c2 as $key) {
            // buscar en forma14


            // buscar en estampillas

            
        }

        return view('recaudacion', compact('recaudacion_mensual'));
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
    public function consulta(Request $request)
    {
        $desde = $request->post('desde');
        $hasta = $request->post('hasta');

        $query = DB::table('cierre_taquillas')->whereBetween('fecha', [$desde, $hasta])->get();
        if ($query) {
            $total_recaudado = 0;
            $recaudado_f14 = 0;
            $recaudado_est = 0;
            $total_timbres = 0;
            $total_f14 = 0;
            $total_est = 0;

            foreach ($query as $key) {
                $total_recaudado += $key->recaudado;
                $recaudado_f14 += $key->recaudado_tfe;
                $recaudado_est += $key->recaudado_est;

                $total_timbres += $key->cantidad_tfe + $key->cantidad_est;
                $total_f14 += $key->cantidad_tfe;
                $total_est += $key->cantidad_est;
            }

            ////entes
            $q2 = DB::table('ventas')->select('id_venta')->whereBetween('fecha', [$desde, $hasta])->get();
            foreach ($q2 as $value) {
                $q3 = DB::table('detalle_ventas')->select('key_tramite','ucd','bs')->where('key_venta','=',$value->id_venta)->get();
                foreach ($q3 as $key) {
                    
                }
            }

            return response();
        }else{

        }

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
