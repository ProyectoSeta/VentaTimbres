@extends('layouts.app')

@section('content')
<div id="body_sesion" class="">
    <div class="px-4 py-4 pb-2 px-md-5 text-center text-lg-start" id="div_body_session">
            <div class="container">
            <div class="row gx-lg-5 align-self-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                <h1 class="my-5 display-3 fw-bold ls-tight">
                    Solicita tu<br />
                    <span class="text-primary">Guía de Circulación</span>
                </h1>
                <p style="color: hsl(0, 0%, 20.8%)">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Eveniet, itaque accusantium odio, soluta, corrupti aliquam
                    quibusdam tempora at cupiditate quis eum maiores libero
                    veritatis? Dicta facilis sint aliquid ipsum atque?
                </p>
                </div>

                <div class="col-lg-6 mb-5 mb-lg-0">
                <div class="card">
                    <div class="card-body py-5 px-md-5 pt-4 pb-4">
                        <div class="d-flex justify-content-center">
                            <img src="{{asset('assets/logo_seta.png')}}" class="img-fluid pb-3 my-3" alt="" width="190px">
                        </div>
                        <ul class="nav nav-pills nav-justified me-5 ms-5 mb-3" id="ex1" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="tab-login" data-mdb-toggle="pill" href="{{route('login')}}" role="tab"
                                aria-controls="pills-login" aria-selected="true">Login</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="tab-register" data-mdb-toggle="pill" href="{{route('register')}}" role="tab"
                                aria-controls="pills-register" aria-selected="false">Registrarse</a>
                            </li>
                        </ul>

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
                                        <div class="text-end">
                                            <!-- <a href="{{route('password.request')}}" class="link">¿Ha olvidado su contraseña?</a> -->
                                            <a href="{{route('forgot_password')}}" class="link">¿Ha olvidado su contraseña?</a>
                                        </div>
                                        
                                    </div>

                                    <div class="d-flex justify-content-center">
                                        <!-- Submit button -->
                                        <button type="submit" class="btn btn-primary btn-block mt-3 mb-3">{{ __('Ingresar') }}</button>
                                    </div>
                                

                                    <!-- Register buttons -->
                                    <div class="text-center">
                                        <p>¿No estas registrado? <a href="{{route('register')}}">Registrate</a></p>
                                    </div>

                                </form>
                            </div>
                        </div>

                    </div>
                </div>
                </div>
            </div> <!--cierra class.row -->
            </div> <!--cierra class.container -->
    
        <div class=" mt-5">
            <div class="row mx-3 px-2 border-top" style="font-size:14px">
                <div class="col-sm-6 mb-0 pb-0 d-flex align-items-end">
                    <div class="bottom-0 start-0 ps-3 pb-3">
                        <img src="{{asset('assets/gobierno.png')}}" alt="" width="150px">
                        <img src="{{asset('assets/aragua.png')}}" alt="" width="75px">
                        <img src="{{asset('assets/logo_seta.png')}}" alt="" class="mt-3 ms-2" width="130px">
                    </div>
                </div>
                
                <div class="col-sm-6 my-3 text-end">
                    <!-- <div class="d-flex justify-content-end mb-2 mt-0 pt-0">
                        <img src="{{asset('assets/logo_seta_grey.png')}}" class="" alt="" width="180px">
                    </div> -->
                    <p class="mb-0 text-navy fw-bold">Servicio Tributario del Estado Aragua (SETA)</p>
                    <p class="mb-2">R.I.F.: G-20008920-2</p>

                    <p class="mb-0"><span class="text-navy">Dirección:</span> Av.10 de Diciembre ,entre calle Junin y Sucre, Edif, Invivar Municipio Girardot Maracay Estado Aragua.</p>
                    <p class="mb-0"><span class="text-navy">Contacto:</span> +58 0243 2336565</p>
                    <p class="mb-0"><span class="text-navy">Correo:</span> atencionalcddno.seta@gmail.com</p>
                </div>
            </div>
        </div>
            
    </div> <!--cierra id.div_body_session -->
    
</div> <!--cierra id.body_sesion_register -->



@endsection

