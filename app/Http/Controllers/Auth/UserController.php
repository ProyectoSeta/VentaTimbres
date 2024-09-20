<?php

namespace App\Http\Controllers;
// use App\Models\Users;
use App\Models\User;
use App\Models\Contribuyente;
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
            $sujeto = new Contribuyente(); // SE llama al modelo sujetopasivo
            $sujeto = Contribuyente::create([
                    'identidad_condicion' => $request->post('identidad_condicion'),
                    'identidad_nro' => $request->post('identidad_nro'),
                    'nombre_razon' => $request->post('nombre_razon')
            ]);

            if ($sujeto->save()) {
                $identificador = $sujeto->id; // Aca se Obtiene el ID del usuario creado

                $usuario = User::create([
                            'email'=>$request->post('email'),
                            'password'=>bcrypt($request->post('password')),
                            'type'=>1,
                            'key_sujeto'=>$identificador,
                ]);

                if($usuario->save()){
                    return redirect()->route("home"); // Redirecciona a el controlador que se necesite
                }
            }


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
