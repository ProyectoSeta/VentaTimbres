<?php

namespace App\Http\Controllers;
use App\Models\Users;
use App\Models\User;
use App\Models\SujetoPasivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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
    public function store(Request $request){
        // print_r($request->post('rif_nro'));
       
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'confirmed', Password::min(8)
            ->letters() // Requerir al menos una letra...
            ->mixedCase() // Requerir al menos una letra mayúscula y una minúscula...
            ->numbers() // Requerir al menos un número...
            ->symbols() // Requerir al menos un símbolo...
            ->uncompromised()],
            'email' => 'required|unique:users|email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }else{
            $usuario = User::create([
                'name'=>$request->post('name'),
                'email'=>$request->post('email'),
                'password'=>bcrypt($request->post('password')),
                'type'=>3
            ]);
            if($usuario->save()){ // insercion en la tabla User creando el usuario
                $artesanal = '';
                if ($request->post('artesanal') == '') {
                   $artesanal = 'No';
                }
                else if($request->post('artesanal') == 'No'){
                    $artesanal = 'No';
                }
                else if($request->post('artesanal') == 'Si'){
                    $artesanal = 'Si';
                }
                $identificador = $usuario->id; // Aca se Obtiene el ID del usuario creado
                $sujeto = new SujetoPasivo(); // SE llama al modelo sujetopasivo
                $sujeto = SujetoPasivo::create([
                        'id_user'=>$identificador,
                        'rif_condicion' => $request->post('rif_condicion'),
                        'rif_nro' => $request->post('rif_nro'),
                        'artesanal' => $artesanal,
                        'razon_social' => $request->post('razon_social'),
                        'direccion' => $request->post('direccion'),
                        'tlf_movil' => $request->post('tlf_movil'),
                        'tlf_fijo' => $request->post('tlf_fijo'),
                        'ci_condicion_repr' => $request->post('ci_condicion_repr'),
                        'ci_nro_repr' => $request->post('ci_nro_repr'),
                        'rif_condicion_repr' => $request->post('rif_condicion_repr'),
                        'rif_nro_repr' => $request->post('rif_nro_repr'),
                        'name_repr' => $request->post('name_repr'),
                        'tlf_repr' => $request->post('tlf_repr')
                ]);
                if ($sujeto->save()) { //insercion en la tabla sujeto pasivo
                    return redirect()->route("home"); // Redirecciona a el controlador que se necesite
                }
            }
                    
            return $id;
        }  ////cierra else (if ($validator->fails()))

        
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
