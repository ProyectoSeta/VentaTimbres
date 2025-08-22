@extends('layouts.app')

@section('content')
<div id="body_sesion" class="">
    <div class="px-4 py-4 pb-2 px-md-5 text-center text-lg-start" id="div_body_session">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-6">
                    <div class="d-flex flex-column">
                        <div class=" d-flex align-items-end">
                            <img src="{{asset('assets/gobierno.png')}}" class="mx-1" alt="" width="140px">
                            <img src="{{asset('assets/aragua.png')}}" class="mx-1" alt="" width="78px">
                            <img src="{{asset('assets/logo_seta.png')}}" class="mx-1" alt="" class="mt-3 ms-2" width="120px">
                        </div>

                        <div class="my-5">
                            <h1 class=" display-3 fw-bold ls-tight">
                            ¡Tributar para<br />
                            <span class="text-primary">Servir!</span>
                            </h1>
                            <h4 class="fs-2 text-muted fw-bold ls-tight">
                                <span id="container-efect">
                                        Venta de Timbres Fiscales.  
                                        <span>&#160;</span>
                                </span>
                            </h4>
                        </div>

                        <!-- <div class="d-flex justify-content-cente">
                            <img src="{{asset('assets/timbre.svg')}}" alt="" class="mt-3 ms-2" width="220px">
                        </div> -->
                    </div>
                    
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body py-5 px-md-5 pt-4 pb-4">
                            <div class="d-flex justify-content-center">
                                <img src="{{asset('assets/logo_seta.png')}}" class="img-fluid pb-3 my-3" alt="" width="190px">
                            </div>
                           

                            <!-- Pills content -->
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
                                    <form  method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <!-- Email input -->
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="email">Correo electrónico</label><span class="text-danger">*</span>
                                            <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <!-- Password input -->
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="password">Contraseña</label><span class="text-danger">*</span>
                                            <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                           
                                        </div>

                                        <div class="d-flex justify-content-center">
                                            <!-- Submit button -->
                                            <button type="submit" class="btn btn-primary btn-block mt-3 mb-3">{{ __('Ingresar') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div> <!--cierra class.row -->
        </div> <!--cierra class.container -->
    
        <!-- <div class=" mt-5">
            <div class="row mx-3 px-2 border-top" style="font-size:14px">
                <div class="col-sm-6 mb-0 pb-0 d-flex align-items-end">
                    <div class="bottom-0 start-0 ps-3 pb-3">
                        <img src="{{asset('assets/gobierno.png')}}" alt="" width="150px">
                        <img src="{{asset('assets/aragua.png')}}" alt="" width="75px">
                        <img src="{{asset('assets/logo_seta.png')}}" alt="" class="mt-3 ms-2" width="130px">
                    </div>
                </div>
                
                <div class="col-sm-6 my-3 text-end">
                    <p class="mb-0 text-navy fw-bold">Servicio Tributario del Estado Aragua (SETA)</p>
                    <p class="mb-2">R.I.F.: G-20008920-2</p>

                    <p class="mb-0"><span class="text-navy">Dirección:</span> Av.10 de Diciembre ,entre calle Junin y Sucre, Edif, Invivar Municipio Girardot Maracay Estado Aragua.</p>
                    <p class="mb-0"><span class="text-navy">Contacto:</span> +58 0243 2336565</p>
                    <p class="mb-0"><span class="text-navy">Correo:</span> atencionalcddno.seta@gmail.com</p>
                </div>
            </div>
        </div> -->
            
    </div> <!--cierra id.div_body_session -->
    
</div> <!--cierra id.body_sesion_register -->



@endsection

