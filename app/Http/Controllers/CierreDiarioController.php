<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CierreDiarioController extends Controller
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

        $fecha = $request->fecha;
        $hoy = '';

        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"); 


        if (isset($fecha)) {
            //// viene la variable: consulta
            $hoy = $fecha;

            $hoy_view = $dias[date('w',strtotime($fecha))].", ".date('d',strtotime($fecha))." de ".$meses[date('n',strtotime($fecha))-1]. " ".date('Y');
        }else{
            /// no viene la variable: vista
            $hoy = date('Y-m-d');

            $hoy_view = $dias[date('w')].", ".date('d')." de ".$meses[date('n')-1]. " ".date('Y');
        }

        // VENTAS DEL DÍA
        $ventas = [];
        $con_ventas = DB::table('ventas')->join('contribuyentes', 'ventas.key_contribuyente', '=','contribuyentes.id_contribuyente')
                                ->select('ventas.*','contribuyentes.identidad_condicion','contribuyentes.identidad_nro')
                                ->whereDate('ventas.fecha', $hoy)
                                ->get();
        foreach ($con_ventas as $key) {
            $con = DB::table('taquillas')->join('sedes', 'taquillas.key_sede', '=','sedes.id_sede')
                                        ->join('funcionarios', 'taquillas.key_funcionario', '=','funcionarios.id_funcionario')
                                        ->select('sedes.sede','funcionarios.nombre')
                                        ->where('taquillas.id_taquilla','=',$key->key_taquilla)
                                        ->first();


            $array = array(
                        'id_venta' => $key->id_venta,
                        'key_taquilla' => $key->key_taquilla,
                        'key_contribuyente' => $key->key_contribuyente,
                        'total_ucd' => $key->total_ucd,
                        'total_bolivares' => $key->total_bolivares,
                        'fecha' => $key->fecha,
                        'hora' => $key->hora,
                        'key_ucd' => $key->key_ucd,
                        'identidad_condicion' => $key->identidad_condicion,
                        'identidad_nro' => $key->identidad_nro,
                        'sede' => $con->sede,
                        'taquillero' => $con->nombre,
                    );
            $a = (object) $array;
            array_push($ventas,$a);
        }


        
        // DETALLE ARQUEO
        $arqueo = DB::table('cierre_diarios')->whereDate('fecha', $hoy)->first();

    

        return view('cierre_diario',compact('hoy_view','ventas','arqueo'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function pdf_cierre_diario(Request $request)
    {
        $id_cierre = $request->id;
       
        $c1 = DB::table('cierre_diarios')->where('id', '=', $id_cierre)->first();


        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"); 
        $fecha = $dias[date('w',strtotime($c1->fecha))].", ".date('d',strtotime($c1->fecha))." de ".$meses[date('n',strtotime($c1->fecha))-1]. " ".date('Y');

        $pdf = PDF::loadView('pdf/cierre_diario', compact('c1','fecha'));

        return $pdf->download('CierreDiario('.$c1->fecha.').pdf');

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
