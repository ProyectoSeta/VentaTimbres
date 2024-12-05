@extends('adminlte::page')

@section('title', 'Principal')


@section('content')
    


    <main>
        <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-white container-fluid">
            <div class="p-lg-5 mx-auto my-5">
                <h1 class="display-5 text-navy fw-bold">FORMA 14 | Estampillas</h1>
                <h3 class="fw-normal text-muted mb-3 titulo">Venta de Timbres Fiscales</h3>
                <div class="d-flex gap-3 justify-content-center fw-normal titulo" style="font-size:12.7px">
                    @if ($apertura_admin == false)
                        <p class="text-muted titulo fs-5">Disculpe, el usuario administrador no ha aperturado esta Taquilla todavia. Ante cualquier duda, 
                            comuniquese con su Supervisor.</p>
                    @elseif ($apertura_admin == true && $apertura_taquillero == false)
                        <button type="button" class="btn btn-s btn-primary py-1" data-bs-toggle="modal" data-bs-target="#modal_apertura_taquilla">Aperturar Taquilla</button>
                    @elseif ($apertura_taquillero == true)
                        <button type="button" class="btn btn-s btn-primary py-1">Bóveda</button>
                        <a href="{{ route('venta') }}" class="btn btn-s btn-success py-1">Vender</a>
                        <button type="button" class="btn btn-s btn-secondary  py-1">Cierre</button>
                    @endif               
                </div>
            </div>

            @if ($apertura_admin == true && $apertura_taquillero == false)
                <div class="text-end fw-bold">
                    <span>Apertura Administrador: <span class="text-muted">{{$hora_apertura_admin}}</span> </span>
                </div>       
            @elseif ($apertura_taquillero == true)
                <div class="text-end fw-bold">
                    <span>Apertura Administrador: <span class="text-muted">{{$hora_apertura_admin}}</span> </span><br>
                    <span>Apertura Taquillero: <span class="text-muted">{{$hora_apertura_taquillero}}</span> </span>
                </div>
            @endif 

            
        </div>


        <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-white">
            <div class="p-lg-5 mx-auto my-5">
                <h1 class="display-5 fw-bold text-navy">FORMA 01 | Venta Online</h1>
                <h3 class="fw-normal text-muted mb-3">Venta de Timbres Fiscales</h3>
                <div class="d-flex gap-3 justify-content-center fw-normal titulo" style="font-size:12.7px">
                    <button type="button btn-sm" class="btn btn-primary  py-1">Ver</button>
                </div>
            </div>
        </div>


<!--         
        <div class="row g-0">
            <div class="col-md-6">
                <div class="bg-body-tertiary me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden">
                    <div class="my-3 py-3">
                        <h2 class="display-5">FORMA 14</h2>
                        <p class="lead">Timbre Fiscal Electrónico.</p>
                    </div>
                    <img src="{{asset('assets/timbre.svg')}}" class="shadow-sm mx-auto img-fluid" alt="" style="width: 80%; height: 300px;">
                    
                </div>
            </div>
            <div class="col-md-6">
                <div class="bg-body-tertiary me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden" role="button">
                    <div class="my-3 p-3">
                        <h2 class="display-5">Estampilla</h2>
                        <p class="lead">Timbre Movil.</p>
                    </div>
                    <div class="bg-dark shadow-sm mx-auto" style="width: 80%; height: 300px; border-radius: 21px 21px 0 0;"></div>
                </div>
            </div>
        </div> -->

    </main>
    
<!-- *********************************  MODALES ******************************* -->
    <!-- ************ APERTURA DE TAQUILLA ************** -->
    <div class="modal fade" id="modal_apertura_taquilla" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_apertura_taquillas">
                <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-lock-open-alt fs-2 text-muted me-2"></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">Apertura Taquilla</h1>
                    </div>
                </div> 
                <div class="modal-body px-5 py-3" style="font-size:13px">
                    <form id="form_aperturar_taquilla" method="post" onsubmit="event.preventDefault(); aperturaTaquilla()">
                        
                        <label for="clave" class="form-label"><span class="text-danger">* </span>Ingrese la clave de seguridad de la Taquilla:</label>
                        <input type="password" id="clave" class="form-control form-control-sm" name="clave">

                        <p class="text-muted text-end"><span style="color:red">*</span> Campos requeridos.</p>

                        <div class="d-flex justify-content-center mt-3 mb-3">
                            <button type="button" class="btn btn-secondary btn-sm me-2" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success btn-sm">Aperturar</button>
                        </div>
                    </form>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>
<!-- ************************************************************************** -->


@stop

@section('footer')


    

  
        
@stop



@section('css')
    
    <link rel="stylesheet" href="{{asset('assets/style.css')}}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
@stop

@section('js')
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
    <script src="{{ asset('jss/toastr.js') }}" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" ></script>


    <script type="text/javascript">
        $(document).ready(function () {
          
        });

        function aperturaTaquilla(){
            var formData = new FormData(document.getElementById("form_aperturar_taquilla"));
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url:'{{route("home.apertura_taquilla") }}',
                    type:'POST',
                    contentType:false,
                    cache:false,
                    processData:false,
                    async: true,
                    data: formData,
                    success: function(response){
                        console.log(response);
                        if (response.success) {
                            alert('TAQUILLA APERTURADA.');
                            window.location.href = "{{ route('home')}}";
                        }else{
                            if (response.nota != '') {
                                alert(response.nota);
                            }else{
                                alert('Disculpe, ha ocurrido un error.');
                            }
                            
                        }  

                    },
                    error: function(error){
                        
                    }
                });
        }
    </script>
  
@stop