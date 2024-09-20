@extends('layouts.app')

@section('content')

<div id="body_sesion_resgister" class="position-relative">
    <div class="px-4 py-5 pb-2 px-md-5 text-center text-lg-start" id="div_body_session">
            <div class="container">
            <div class="row gx-lg-5 align-self-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                <h1 class="my-5 display-3 fw-bold ls-tight">
                    Registrate para comprar tus<br />
                    <span class="text-primary">Timbres en Línea</span>
                </h1>
                <p style="color: hsl(0, 0%, 20.8%)">
                    
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
                                <a class="nav-link" id="tab-login" data-mdb-toggle="pill" href="{{route('login')}}" role="tab"
                                aria-controls="pills-login" aria-selected="true">Login</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="tab-register" data-mdb-toggle="pill" href="{{route('register')}}" role="tab"
                                aria-controls="pills-register" aria-selected="false">Registrarse</a>
                            </li>
                        </ul>

                        <!-- Pills content -->
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
                                <form  method="POST" action="{{route('user.store') }}">
                                @csrf
                                {{-- DATOS : SUJETO PASIVO --}}
                                <div class="text-muted fw-semibold text-center title_resgister_form">
                                    <span>Datos del Contribuyente</span>
                                </div>
                                <!-- R.I.F input -->
                                <label class="form-label" for="rif">R.I.F./C.I.</label><span class="text-danger"> *</span>
                                <div class="row mb-2">
                                    <div class="col-3">
                                        <select class="form-select form-select-sm" id="rif_condicion" aria-label="Default select example" name="rif_condicion" required>
                                            <option value="J" id="rif_juridico">J</option>    
                                            <option value="G" id="rif_gubernamental">G</option>
                                        </select>
                                    </div>
                                    <div class="col-1">-</div>
                                    <div class="col-8">
                                        <input type="number" id="rif" class="form-control form-control-sm" name="rif_nro" placeholder="Ejemplo: 30563223" autofocus value="{{ old('rif_nro') }}" required/>
                                        <p class="text-end text-muted mb-0" style="font-size:12px;">Ejemplo: 30563223</p>
                                    </div>
                                </div>

                                <!-- razon social input -->
                                <div class="form-outline mb-2">
                                    <label class="form-label" for="razon_social">Razon Social</label><span class="text-danger"> *</span>
                                    <input type="text" id="razon_social" class="form-control form-control-sm" name="razon_social" value="{{ old('razon_social') }}" required/>
                                </div>

                                

                                {{-- DATOS : USUARIO --}}
                                <div class="text-muted fw-semibold text-center title_resgister_form mt-3 mb-2">
                                    <span>Datos del Usuario</span>
                                </div>

                                <!-- correo input -->
                                <div class="form-outline mb-2">
                                    <label class="form-label" for="name">Nombre</label><span class="text-danger"> *</span>
                                    <input type="text" id="name" class="form-control form-control-sm @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" >
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- correo input -->
                                <div class="form-outline mb-2">
                                    <label class="form-label" for="email">Correo electrónico</label><span class="text-danger"> *</span>
                                    <input type="email" id="email" class="form-control form-control-sm @error('email') is-invalid @enderror" placeholder="example@gmail.com" name="email" value="{{ old('email') }}" required autocomplete="email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                 <!-- pass input -->
                                 <div class="form-outline mb-2">
                                    <label class="form-label" for="password">Contraseña</label><span class="text-danger"> *</span>
                                    <input type="password" id="password" class="form-control form-control-sm @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- pass input -->
                                <div class="form-outline mb-2">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirmar contraseña') }}</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                                <p class="text-muted text-end"><span style="color:red">*</span> Campos requeridos.</p>
                                
                                <div class="text-muted mt-4" style="font-size:14px">
                                    <span>La Contraseña debe contener:</span>
                                    <ol>
                                        <li>Mínimo 8 caracteres.</li>
                                        <li>Caracteres alfanuméricos.</li>
                                        <li>Caracteres especiales (Ejemplo: ., @, $, *, %, !, &, entre otros.).</li>
                                    </ol>
                                </div>
                                

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="d-flex justify-content-center">
                                    <!-- Submit button -->
                                    <button type="submit" class="btn btn-primary btn-block mt-3 mb-3">{{ __('Registrarse') }}</button>
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



@section('js')
<script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
<script type="text/javascript">
    $(document).ready(function () {
        console.log('hol5ss');
        ///////HABILITAR EL CAMPO DE ARTESANAL
        $(document).on('change','#rif_condicion', function(e) { 
            e.preventDefault(e); 
            var value = $("#rif_condicion").val();

           if (value == 'J') {
                $("#artesanal_no").attr('disabled', false);
                $("#artesanal_si").attr('disabled', false); 
           }else{
                $("#artesanal_no").attr('disabled', true);
                $("#artesanal_si").attr('disabled', true); 
           }
        });           

    });
</script>


@stop