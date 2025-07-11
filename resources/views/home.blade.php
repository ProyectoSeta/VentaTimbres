@extends('adminlte::page')

@section('title', 'Principal')


@section('content')
    


    <main>
        <div class="d-flex justify-content-between">
            <div class="text-navy fs-3 tituo fw-semibold my-3 ms-4">{{$hoy_view}}</div>

            @if ($vista == 'Taquillero')
                <div class="text-navy fs-3 titulo fw-semibold my-3 ms-4">{{$sede}} <span class="text-secondary ps-2">TAQ{{$id_taquilla}}</span></div>
            @endif
            
        </div>
        

        <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-white container-fluid bg_arqueo" style="background-image: url({{asset('assets/fondo2.png')}});">
            <div class="p-lg-5 mx-auto my-5">

                @if ($vista == 'Taquillero')
                    <h1 class="display-5 text-navy fw-bold">FORMA 14 | Estampillas</h1>
                    <h3 class="fw-normal text-muted mb-3 titulo">Venta de Timbres Fiscales</h3>
                    @if ($cierre_taquilla == null)
                        <div class="d-flex gap-3 justify-content-center fw-normal titulo" style="font-size:12.7px">
                            @if ($apertura_admin == false)
                                <p class="text-muted titulo fs-5">Disculpe, el usuario Coordinador no ha aperturado esta Taquilla todavia. Ante cualquier duda, 
                                    comuniquese con su Supervisor.</p>
                            @elseif ($apertura_admin == true && $apertura_taquillero == false)
                                @can('home.apertura_taquilla')
                                    <button type="button" class="btn btn-s btn-primary py-1" data-bs-toggle="modal" data-bs-target="#modal_apertura_taquilla">Aperturar Taquilla</button>
                                @endcan
                            @elseif ($apertura_taquillero == true)
                                <button type="button" class="btn btn-s btn-dark py-1" id="btn_historial_boveda" data-bs-toggle="offcanvas" data-bs-target="#historial_boveda" aria-controls="historial_boveda">Historial Bv.</button>
                                <button type="button" class="btn btn-s btn-dark py-1" id="btn_boveda" data-bs-toggle="modal" data-bs-target="#modal_ingresar_boveda">Bóveda</button>
                                <a href="{{ route('venta') }}" class="btn btn-s btn-success py-1">Vender (F2)</a>
                                @can('home.cierre_taquilla')
                                    <button type="button" class="btn btn-s btn-secondary  py-1" data-bs-toggle="modal" data-bs-target="#modal_cerrar_taquilla">Cierre</button>
                                @endcan
                                

                                
                            @endif               
                        </div>
                        @if ($apertura_taquillero == true)
                            @can('home.modal_clave')
                                <div class="mt-3">
                                    <div class="">
                                        <a href="#" class="" id="btn_falla_impresion">¿Falla en la Impresión?</a>
                                    </div>   

                                    <div class="">
                                        <a href="{{ route('arqueo_temporal') }}" class="">Arqueo (Temporal)</a>
                                    </div>  

                                    <div class="mt-2 d-none" id="opctions_falla_impresion">
                                        <button type="button" id="btn_papel_bueno" papel="1" class="btn btn-sm btn-outline-secondary btn_modal_papel me-3" data-bs-toggle="modal" data-bs-target="#modal_clave_taquilla">Papel Bueno</button>
                                        <button type="button" id="btn_papel_danado" papel="0" class="btn btn-sm btn-outline-secondary btn_modal_papel" data-bs-toggle="modal" data-bs-target="#modal_clave_taquilla">Papel Dañado</button>
                                    </div>
                                    
                                </div>
                            @endcan
                            
                        @endif
                                
                        

                    @else
                        <div class="d-flex flex-column">
                            <h3 class="text-danger titulo fs-3 mb-0 pb-0">Taquilla Cerrada.</h3>
                            <span class="">Hora de Cierre: {{$hora_cierre_taquilla}}</span>
                        </div>
                        
                        <a href="{{ route('arqueo') }}" class="btn btn-s btn-secondary mt-3">Arqueo</a>
                    @endif
                    
                    

                    <div class="my-4">
                        @if ($apertura_admin == true && $apertura_taquillero == false)
                            <div class="fw-bold">
                                <span>Apertura Administrador: <span class="text-muted">{{$hora_apertura_admin}}</span> </span>
                            </div>       
                        @elseif ($apertura_taquillero == true)
                            <div class="fw-bold">
                                <span>
                                    APERTURA ADMINISTRADOR: <span class="badge bg-primary-subtle border border-primary-subtle text-primary-emphasis rounded-pill" style="font-size:13px">{{$hora_apertura_admin}}</span>
                                </span>
                                <br>
                                <span>
                                    APERTURA TAQUILLERO: <span class="badge bg-primary-subtle border border-primary-subtle text-primary-emphasis rounded-pill" style="font-size:13px">{{$hora_apertura_taquillero}}</span>
                                </span>
                            </div>
                        @endif 
                    </div>
                @else
                    <h1 class="display-5 text-navy fw-bold">TRIBUTAR PARA SERVIR</h1>
                    <h3 class="fw-normal text-muted mb-3 titulo">Sistema de Venta | Timbres Fiscales</h3>



                    































                @endif

                
            </div>

            

            
        </div>


        <!-- <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-white">
            <div class="p-lg-5 mx-auto my-5">
                <h1 class="display-5 fw-bold text-navy">FORMA 01 | Venta Online</h1>
                <h3 class="fw-normal text-muted mb-3">Venta de Timbres Fiscales</h3>
                <div class="d-flex gap-3 justify-content-center fw-normal titulo" style="font-size:12.7px">
                    <button type="button btn-sm" class="btn btn-primary  py-1">Ver</button>
                </div>
            </div>
        </div> -->


                 
        <!-- <div class="row g-0">
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
    <div class="modal fade" id="modal_apertura_taquilla" tabindex="-1" aria-hidden="true"  data-bs-backdrop="static" data-bs-keyboard="false">
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
                        <input type="password" id="clave" class="form-control form-control-sm" name="clave" required>

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


    <!-- ************ MODAL FONDO DE CAJA ************** -->
    <div class="modal fade" id="modal_fondo_caja" tabindex="-1" aria-hidden="true"  data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content" id="content_fonfo_caja">
                <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class='bx bxs-coin-stack  fs-2 text-muted me-2'></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">Fondo de Caja</h1>
                    </div>
                </div> 
                <div class="modal-body px-5 py-3" style="font-size:13px">
                    <form id="form_fondo_caja" method="post" onsubmit="event.preventDefault(); fondoCaja()">
                        
                        <label for="fondo" class="form-label"><span class="text-danger">* </span>Ingrese el fondo de caja con el que apertura la Taquilla:</label>
                        
                        <div class="d-flex align-items-center">
                            <input type="number" id="fondo" class="form-control form-control-sm me-2" name="fondo" required> <span>Bs.</span>
                        </div>
                        
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" value="0" id="sin_fondo">
                            <label class="form-check-label" for="sin_fondo">
                                Sin Fondo de Caja
                            </label>
                        </div>

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


    <!-- ************ MODAL BOVEDA ************** -->
    <div class="modal fade" id="modal_ingresar_boveda" tabindex="-1" aria-hidden="true"  data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content" id="content_ingresar_boveda">
                
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ************ CERRAR TAQUILLA ************** -->
     <div class="modal fade" id="modal_cerrar_taquilla" tabindex="-1" aria-hidden="true"  data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content" id="content_cerrar_taquilla">
                <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-lock-alt fs-2 text-muted me-2"></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">Cerrar Taquilla</h1>
                    </div>
                </div> 
                <div class="modal-body px-5 py-3" style="font-size:13px">
                    <form id="form_cerrar_taquilla" method="post" onsubmit="event.preventDefault(); cerrarTaquilla()">
                        <p class="text-muted">IMPORTANTE: Si cierra la Taquilla, no podrá volver a aperturarla durante el día, sin la aprobacion del Coordinador.
                             Asegurese de haber culminado todos los procesos.</p>    

                        <label for="clave_cierre" class="form-label"><span class="text-danger">* </span>Ingrese la clave de seguridad de la Taquilla:</label>
                        <input type="password" id="clave_cierre" class="form-control form-control-sm" name="clave_cierre" required>

                        <p class="text-muted text-end"><span style="color:red">*</span> Campos requeridos.</p>

                        <div class="d-flex justify-content-center mt-3 mb-3">
                            <button type="submit" class="btn btn-dark btn-sm me-2">Cerrar Taquilla</button>
                            <button type="button" class="btn btn-secondary btn-sm " data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>


    <!-- ************ CLAVE TAQUILLA ************** -->
    <div class="modal fade" id="modal_clave_taquilla" tabindex="-1" aria-hidden="true"  data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content" id="content_clave_taquillas">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>


    <!-- ************ ULTIMA VENTA ************** -->
    <div class="modal fade" id="modal_ultima_venta" tabindex="-1" aria-hidden="true"  data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content" id="content_ultima_venta">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>






    <!-- ************ PAPEL BUENO ************** -->
    <div class="modal fade" id="modal_papel_bueno" tabindex="-1" aria-hidden="true"  data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content" id="content_papel_bueno">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>


    <!-- ************ PAPEL DAÑADO ************** -->
    <div class="modal fade" id="modal_papel_danado" tabindex="-1" aria-hidden="true"  data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content" id="content_papel_danado">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- *************  TIMBRE RE IMPRESO************** -->
    <div class="modal fade" id="modal_timbre_reimpreso" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="content_timbre_reimpreso">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>


    


<!-- ************************************************************************** -->




<!-- ***************************** CANVAS ************************************-->
    <!-- HISTORIAL INGRESO BOVEDA -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="historial_boveda" aria-labelledby="historial_boveda">
        
    </div>

<!-- ************************************************************************* -->


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
            /////ACTUALIZAR UCD
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("home.ucd") }}',
                success: function(response) {},
                error: function() {
                }
            });

            /////////////////////// SIN FONDO
            $(document).on('click', '#sin_fondo', function(e){ 
                if($("#sin_fondo").is(':checked')) {
                    $('#fondo').val('0.00');
                } else {
                    $('#fondo').val('');
                }
            });


            /////////////////// MODAL BOVEDA
            $(document).on('click', '#btn_boveda', function(e){ 
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("home.modal_boveda") }}',
                    success: function(response) {
                        $('#content_ingresar_boveda').html(response);
                        if (response == false) {
                            alert('Disculpe, ha ocurrido un error.');
                        }
                    },
                    error: function() {
                    }
                });
            });


            ///////////////// EFECTIVO
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("home.alert_boveda") }}',
                success: function(response) {
                    // if (response) {
                    //     // Swal.fire({
                    //     //     icon: "warning",
                    //     //     iconColor: "#004cbd",
                    //     //     title: "Parece que has superado el Límite de Efectivo en Taquilla.",
                    //     //     // text: 'Dirigete a la ventana principal e ingresa el monto total o parcial del efectivo actual en Bóveda.',
                    //     //     confirmButtonColor: "#004cbd",
                    //     // });
                    // }else{
                    //     alert('Disculpe, ha ocurrido un error.');                        
                    // }
                },
                error: function() {
                }
            });


            ///////////////// HISTORIAL BOVEDA
            $(document).on('click', '#btn_historial_boveda', function(e){ 
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("home.historial_boveda") }}',
                    success: function(response) {
                        $('#historial_boveda').html(response);
                        if (response == false) {
                            alert('Disculpe, ha ocurrido un error.');
                        }
                    },
                    error: function() {
                    }
                });
            });


            /////////////////// MODAL CLAVE - VOLVER A IMPRIMIR
            $(document).on('click','.btn_modal_papel', function(e){ 
                e.preventDefault(); 
                var papel = $(this).attr('papel');
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("home.modal_clave") }}',
                    data: {papel:papel},
                    success: function(response) {
                        if (response.success) {
                            $('#content_clave_taquillas').html(response.html);
                        }else{
                            if (response.nota != '') {
                                alert(response.nota);
                            }else{
                                alert('Disculpe, ha ocurrido un error.');
                            }
                            window.location.href = "{{ route('home')}}";
                        }  
                        
                    },
                    error: function() {
                    }
                });
            });

            /////////////////// IMPRIMIR TIMBRE - MODAL
            $(document).on('click','.imprimir_timbre', function(e){ 
                e.preventDefault(); 
                var papel = $(this).attr('papel'); 
                var timbre = $(this).attr('timbre'); console.log(timbre);
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("home.modal_imprimir") }}',
                    data: {papel:papel,timbre:timbre},
                    success: function(response) {
                        if (response.success) {
                            console.log(response);
                            if (response.papel == 1) {
                                ///BUEN ESTADO
                                $('#modal_ultima_venta').modal('hide');
                                $('#modal_papel_bueno').modal('show');
                                $('#content_papel_bueno').html(response.html);
                            }else{
                                ///DAÑADO
                                $('#modal_ultima_venta').modal('hide');
                                $('#modal_papel_danado').modal('show');
                                $('#content_papel_danado').html(response.html);
                            }
                        }else{
                            if (response.nota != '') {
                                alert(response.nota);
                            }else{
                                alert('Disculpe, ha ocurrido un error.');
                            }
                            // window.location.href = "{{ route('home')}}";
                        }  
                    },
                    error: function() {
                    }
                });
            });

            /////////////////// BOTONES OPCIONES FALLA IMPRESION
            $(document).on('click','#btn_falla_impresion', function(e){ 
                $('#opctions_falla_impresion').removeClass('d-none'); 
            });




            //////DESHABILITAR EL BTN DE IMPRIMIR AL DARLE CLICK
            $(document).on('click','.btn_imprimir_tfe', function(e){ 
                $('.btn_imprimir_tfe').addClass('disabled');
            });



            /////// REDIRIGIR CON F2 A VENTA
            $(document).keydown(function(e) {
                if (e.keyCode == 113) { // 112 es el código para la tecla F1
                    // $("#mi_boton").click();
                    window.location.href = "{{ route('venta')}}";
                }
            });
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

                            $('#modal_apertura_taquilla').modal('hide');
                            $('#modal_fondo_caja').modal('show');

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


        function fondoCaja(){
            var formData = new FormData(document.getElementById("form_fondo_caja"));
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url:'{{route("home.fondo_caja") }}',
                    type:'POST',
                    contentType:false,
                    cache:false,
                    processData:false,
                    async: true,
                    data: formData,
                    success: function(response){
                        console.log(response);
                        if (response.success) {
                            alert('GUARDADO EXITOSAMENTE.');
                            window.location.href = "{{ route('home')}}";
                        }else{
                            if (response.nota != '') {
                                alert(response.nota);
                            }else{
                                alert('Disculpe, ha ocurrido un error. La taquilla aperturará con un Fondo de caja 0 Bs.');
                            }
                            window.location.href = "{{ route('home')}}";
                        }  

                    },
                    error: function(error){
                        
                    }
                });
        }


        function ingresoBoveda(){
            var formData = new FormData(document.getElementById("form_ingreso_boveda"));
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url:'{{route("home.ingreso_boveda") }}',
                    type:'POST',
                    contentType:false,
                    cache:false,
                    processData:false,
                    async: true,
                    data: formData,
                    success: function(response){
                        console.log(response);
                        if (response.success) {
                            alert('INGRESO EXITOSO.');
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

        function cerrarTaquilla(){
            var formData = new FormData(document.getElementById("form_cerrar_taquilla"));
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url:'{{route("home.cierre_taquilla") }}',
                    type:'POST',
                    contentType:false,
                    cache:false,
                    processData:false,
                    async: true,
                    data: formData,
                    success: function(response){
                        console.log(response);
                        if (response.success) {
                            alert('CIERRE DE TAQUILLA EXITOSO.');
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

        function claveTaquilla(){
            var formData = new FormData(document.getElementById("form_clave_taquilla"));
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url:'{{route("home.clave") }}',
                    type:'POST',
                    contentType:false,
                    cache:false,
                    processData:false,
                    async: true,
                    data: formData,
                    success: function(response){
                        console.log(response);
                        if (response.success) {

                            $('#modal_clave_taquilla').modal('hide');
                            $('#modal_ultima_venta').modal('show');
                            $('#content_ultima_venta').html(response.html);

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



        function imprimirTimbre(){
            var formData = new FormData(document.getElementById("form_imprmir_timbre"));
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url:'{{route("home.imprimir") }}',
                    type:'POST',
                    contentType:false,
                    cache:false,
                    processData:false,
                    async: true,
                    data: formData,
                    success: function(response){
                        console.log(response);
                        
                        if (response.success) {
                           
                            $('#modal_papel_bueno').modal('hide');
                            $('#modal_papel_danado').modal('hide');
                            
                            $('#modal_timbre_reimpreso').modal('show');
                            $('#content_timbre_reimpreso').html(response.html);

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