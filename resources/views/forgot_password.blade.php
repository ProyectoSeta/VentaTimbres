@extends('layouts.app')

@section('content')
<!-- <div id="body_sesion" class="position-relative" style="background:#ffff;">
    <div class="px-4 py-4 pb-2 px-md-5 text-center text-lg-start position-absolute top-50 start-50 translate-middle" id="div_body_session">
            <div class="container">
                <div class="card mb-3" style="width:800px">
                    <div class="row g-0">
                        <div class="col-md-4 bg-primary bg-gradient position-relative">
                            <div class="custom-shape-divider-top-1724784650">
                                <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                                    <path d="M0,0V6c0,21.6,291,111.46,741,110.26,445.39,3.6,459-88.3,459-110.26V0Z" class="shape-fill"></path>
                                </svg>
                            </div>
                            <div class="position-absolute position-absolute top-0 start-50 translate-middle-x">
                                <h1 class="titulo text-white text-center mt-3">Guías de Circulación</h1>
                                <h6 class="titulo text-center">Minerales no metalicos</h6>
                            </div>
    
                        </div>
                        <div class="col-md-8 bg-white">
                        <div class="card-body py-5 px-4">
                            <h2 class="card-title">¿Olvidaste tu contraseña?</h2>
                            <p class="card-text">Ingresa tu correo electrónico y te enviaremos un enlace de restablecimiento.</p>
                            
                            <div class="row justify-content-center">
                                <div class="col-sm-8 col-md">
                                    <form class="mb-3"><input class="form-control" type="email" placeholder="Dirección de correo electrónico" _mstplaceholder="203853" _msthash="6">
                                        <div class="mb-3"></div><button class="btn btn-primary d-block w-100 mt-3" type="submit" name="submit" _msttexthash="884091" _msthash="7">Enviar enlace de restablecimiento</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div> 
    </div> 
</div>  -->


<main class="login-form">
        <div class="cotainer">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Recuperar Contraseña</div>
                        <div class="card-body">

                            @if (Session::has('message'))
                                <div class="alert alert-success" role="alert">
                                    {{ Session::get('message') }}
                                </div>
                            @endif

                            <form action="{{ route('send-email') }}" method="GET">
                                @csrf
                                <div class="form-group row">
                                    <label for="email_address" class="col-md-4 col-form-label text-md-right">Tu Email</label>
                                    <div class="col-md-6">
                                        <input type="text" id="email_address" class="form-control" name="email"
                                            required autofocus>
                                        @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Enviar Email de recuperación
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>



@endsection

