@extends('adminlte::page')

@section('title', 'Registro de Guías')

@section('content_header')
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{asset('vendor/sweetalert.js') }}"></script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>

    <!-- <img src="{{asset('assets/bf-4.svg')}}" class="w-100" alt="..."> -->
@stop

@section('content')
    <div class="container rounded-4 p-3 pt-0" style="background-color:#ffff;">
        <div class="d-flex justify-content-between align-items-center mb-0">
            <h3 class="mb-3 text-navy titulo fw-bold">Libro de Control <span class="text-success fs-4">| {{$fecha}}</span></h3>
            <!-- <h4 class="text-muted titulo">Libro de <span class="text-success">{{$fecha}}</span></h4>  -->
            
            <div class="row w-25 d-flex justify-content-end">
                <div class="col-sm-12">
                    <div class="card shadow-none border-light-subtle">
                        <div class="card-body px-3 py-2">
                            <h3 class="d-flex align-items-center justify-content-between mb-0 pb-1">
                                <div class="p-2 border border-primary-subtle grd-primary-light rounded-5 d-flex">
                                    <i class='bx bxs-collection fs-3 text-primary'></i>
                                </div>
                                <div class="d-flex flex-column text-center">
                                    <span class=" pb-1" style="font-size:14px">Guías Registradas</span>
                                    <span class="text-primary">{{$count}}</span> 
                                    <span class="text-muted" style="font-size:14px">del Mes</span>
                                </div>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <button type="button" class="btn bg-navy rounded-pill px-3 btn-sm fw-bold d-flex align-items-center" id="registrar_new_guia" data-bs-toggle="modal" data-bs-target="#modal_registro_guia"> 
                    <i class='bx bx-plus fw-bold fs-6 pe-2'></i>
                    <span>Registrar guía</span>
                </button>
            </div>
        </div>
        <div class="table-responsive" style="font-size:14px">
            <table id="example" class="table table-hover border-light-subtle mt-3 text-center" style="font-size:13px;">
            <thead class=" border-light-subtle">
                <tr>
                    <th scope="col">Nro. Guía</th>
                    <th scope="col">Cantera</th>
                    <th scope="col">Tipo de Mineral</th>
                    <th scope="col">Cantidad Transportada</th>
                    <th scope="col">Destinatario</th>
                    <th scope="col">Destino</th>
                    <th scope="col">Nro. Factura</th>
                    <th scope="col">¿Anulada?</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
                <tbody>
                    @foreach ($registros as $index => $registro)
                        <tr role="button">
                            <td class="info_guia" nro_guia="{{$registro->nro_guia}}">{{$registro->nro_guia}}</td>
                            <td class="fw-bold info_guia" nro_guia="{{$registro->nro_guia}}">{{$registro->nombre}}</td>
                            <td class="info_guia" nro_guia="{{$registro->nro_guia}}">{{$registro->mineral}}</td>
                            <td class="info_guia" nro_guia="{{$registro->nro_guia}}">{{$registro->cantidad_despachada}} {{$registro->unidad_medida}}</td>
                            <td class="fw-bold info_guia" nro_guia="{{$registro->nro_guia}}">{{$registro->razon_destinatario}}</td>
                            <td class="info_guia" nro_guia="{{$registro->nro_guia}}">{{$registro->destino}}</td>
                            @php
                                if($registro->nro_factura == ''){
                            @endphp       
                                <td class="fst-italic text-secondary info_guia" nro_guia="{{$registro->nro_guia}}">No Aplica</td>
                            @php
                                }else{
                            @endphp       
                                <td class="info_guia" nro_guia="{{$registro->nro_guia}}">{{$registro->nro_factura}}</td>
                            @php
                                }
                            @endphp
                            
                            <td class="info_guia" nro_guia="{{$registro->nro_guia}}">{{$registro->anulada}}</td>
                            <td>
                                <div class="d-flex">
                                    @php
                                        if($index == count($registros)-1){
                                    @endphp
                                        <span class="badge me-1 delete_guia" style="background-color: #ed0000;" role="button" evento="ultimoRegistro();" nro_guia="{{$registro->nro_guia}}">
                                            <i class='bx bx-trash-alt fs-6'></i>
                                        </span>
                                    @php
                                        }else{
                                    @endphp
                                        <span class="badge me-1" style="background-color: #777777ba;" disabled>
                                            <i class='bx bx-trash-alt fs-6'></i>
                                        </span>
                                    @php
                                        }
                                    @endphp
                                    <span class="badge editar_guia" style="background-color: #169131;" role="button" data-bs-toggle="modal" data-bs-target="#modal_editar_guia" nro_guia="{{$registro->nro_guia}}">
                                        <i class='bx bx-pencil fs-6'></i>
                                    </span>
                                </div> 
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>

    </div>

    

    


      

    
    
<!--****************** MODALES **************************-->
    <!-- ********* NUEVA GUIA ******** -->
    <div class="modal" id="modal_registro_guia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 d-flex align-items-center text-navy" id="exampleModalLabel">
                        <i class='bx bx-barcode fs-1 me-2'></i>
                        Registro de Guía
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4" style="font-size:14px;" id="content_registro_guia">
                    <div class="my-5 py-5 d-flex flex-column text-center">
                        <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                        <span class="text-muted">Cargando, por favor espere un momento...</span>
                    </div>
                </div>  <!-- cierra modal-body -->
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    

    <!-- ********* EDITAR GUIA ******** -->
    <div class="modal" id="modal_editar_guia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 d-flex align-items-center text-navy" id="exampleModalLabel">
                        <i class='bx bx-barcode fs-1 me-2'></i>
                        Editar Guía
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="font-size:14px;" id="content_editar_guia">
                    <div class="my-5 py-5 d-flex flex-column text-center">
                        <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                        <span class="text-muted">Cargando, por favor espere un momento...</span>
                    </div>
                



                </div>  <!-- cierra modal-body -->
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>


    <!-- ********* VER EL REGISTRO DE LA GUÍA ******** -->
    <div class="modal" id="modal_content_guia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                
                    <div class="row mx-3 mt-3 mb-1 d-flex align-items-center">
                        <div class="col-3 d-flex justify-content-center">
                            <img src="{{asset('assets/aragua.png')}}" alt="" width="100px">
                        </div>
                        <div class="col-6 d-flex flex-column text-center pt-4">
                            <span class="fs-6 fw-bold">GUÍA DE CIRCULACIÓN DE MINERALES NO METÁLICOS</span>
                            <span>GOBIERNO BOLIVARIANO DEL ESTADO ARAGUA SERVICIO TRIBUTARIO DE ARAGUA (SETA)</span>
                        </div>
                        <div class="col-3 d-flex justify-content-center">
                            <img src="{{asset('assets/logo_seta.png')}}" alt="" class="mt-3 ms-2" width="130px">
                        </div>
                    </div>
                <div class="modal-body mx-4" style="font-size:14px" id="content_info_guia">
                    
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>


<!--************************************************-->



    




@stop





@section('css')
    <link rel="stylesheet" href="{{asset('assets/style.css')}}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
@stop

@section('js')
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
        const myModal = document.getElementById('myModal');
        const myInput = document.getElementById('myInput');

        myModal.addEventListener('shown.bs.modal', () => {
            myInput.focus();
        });
    </script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
    <script src="{{ asset('jss/datatable.min.js') }}" defer ></script>
    <script src="{{ asset('jss/datatable.bootstrap.js') }}" ></script>
    <script src="{{ asset('jss/toastr.js') }}" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" ></script>
   
    <script type="text/javascript">
        $(document).ready(function () {
            $('#example').DataTable(
                {
                    "language": {
                        "lengthMenu": " Mostrar  _MENU_  Registros por página",
                        "zeroRecords": "No se encontraron registros",
                        "info": "Mostrando página _PAGE_ de _PAGES_",
                        "infoEmpty": "No se encuentran Registros",
                        "infoFiltered": "(filtered from _MAX_ total records)",
                        'search':"Buscar",
                        'paginate':{
                            'next':'Siguiente',
                            'previous':'Anterior'
                        }
                    }
                }
            );

        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {

            ///////MODAL - HTML: REGISTRAR GUIA 
            $(document).on('click','#registrar_new_guia', function(e) { 
                e.preventDefault(e); 
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("registro_guia.modal_registro") }}',
                    success: function(response) {
                        // alert(response);
                        // console.log(response);               
                        $('#content_registro_guia').html(response);
                    },
                    error: function() {
                    }
                });
            });

            /////MODAL: SELECCION DE CANTERA
            $(document).on('change','#select_cantera', function(e) { 
                e.preventDefault(e); 
                var cantera = $(this).val();
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("registro_guia.cantera") }}',
                    data: {cantera:cantera},
                    success: function(response) {
                        console.log(response);    
                        if (response.success){
                            $('#nro_guia_view').html(response.formato_nro_guia);
                            $('#select_minerales').html(response.minerales);

                            $('#id_talonario').val(response.talonario);
                            $('#nro_guia').val(response.nro_guia);
                            

                            $("#fecha").attr('disabled', false);
                            $("#venta").attr('disabled', false);
                            $("#donacion").attr('disabled', false);
                            $("#razon").attr('disabled', false);
                            $("#tlf_dest").attr('disabled', false);
                            $("#ci").attr('disabled', false);
                            $("#municipio").attr('disabled', false);
                            $("#parroquia").attr('disabled', false);
                            $("#destino").attr('disabled', false);
                            $("#select_minerales").attr('disabled', false);
                            $("#unidad_medida").attr('disabled', false);
                            $("#cantidad").attr('disabled', false);
                            $("#fecha_facturacion").attr('disabled', false);
                            $("#saldo_anterior").attr('disabled', false);
                            $("#cantidad_despachada").attr('disabled', false);
                            $("#saldo_restante").attr('disabled', false);
                            $("#modelo").attr('disabled', false);
                            $("#nombre_conductor").attr('disabled', false);
                            $("#tlf_conductor").attr('disabled', false);
                            $("#placa").attr('disabled', false);
                            $("#ci_conductor").attr('disabled', false);
                            $("#capacidad_vehiculo").attr('disabled', false);
                            $("#hora_salida").attr('disabled', false);
                            $("#factura").attr('disabled', false);
                            $("#anulado_si").attr('disabled', false);
                            $("#anulado_no").attr('disabled', false);
                            $("#motivo_anulada").attr('disabled', false);
                            $("#btn_guardar_guia").attr('disabled', false);


                        } else{
                            // alert("SE HA PRODUCIDO UN ERROR AL ELIMINAR LA GUÍA");
                            $('#nro_guia_view').html('');
                           
                            $('#select_minerales').html('');

                            $('#id_talonario').val('');
                            $('#nro_guia').val('');
                            

                            $("#fecha").attr('disabled', true);
                            $("#venta").attr('disabled', true);
                            $("#donacion").attr('disabled', true);
                            $("#razon").attr('disabled', true);
                            $("#tlf_dest").attr('disabled', true);
                            $("#ci").attr('disabled', true);
                            $("#municipio").attr('disabled', true);
                            $("#parroquia").attr('disabled', true);
                            $("#destino").attr('disabled', true);
                            $("#select_minerales").attr('disabled', true);
                            $("#unidad_medida").attr('disabled', true);
                            $("#cantidad").attr('disabled', true);
                            $("#fecha_facturacion").attr('disabled', true);
                            $("#saldo_anterior").attr('disabled', true);
                            $("#cantidad_despachada").attr('disabled', true);
                            $("#saldo_restante").attr('disabled', true);
                            $("#modelo").attr('disabled', true);
                            $("#nombre_conductor").attr('disabled', true);
                            $("#tlf_conductor").attr('disabled', true);
                            $("#placa").attr('disabled', true);
                            $("#ci_conductor").attr('disabled', true);
                            $("#capacidad_vehiculo").attr('disabled', true);
                            $("#hora_salida").attr('disabled', true);
                            $("#factura").attr('disabled', true);
                            $("#anulado_si").attr('disabled', true);
                            $("#anulado_no").attr('disabled', true);
                            $("#motivo_anulada").attr('disabled', true);
                            $("#btn_guardar_guia").attr('disabled', true);
                        }   
                       
                    },
                    error: function() {
                    }
                });
            });

            //////SELECION DE ANULADA: SI 
            $(document).on('change','#anulado_si', function(e) { 
                e.preventDefault(e); 
                $("#motivo_anulada").attr('disabled', false);
                
            });
             ////SELECION DE ANULADA: NO
            $(document).on('change','#anulado_no', function(e) { 
                e.preventDefault(e); 
                $("#motivo_anulada").attr('disabled', true);
                $("#motivo_anulada").val("");
                
            });

            //////ELIMINAR 
            $(document).on('click','.delete_guia', function(e) { 
                e.preventDefault(e); 
                var guia = $(this).attr('nro_guia');
                // alert(guia);
                if (confirm("¿ESTA SEGURO QUE DESEA ELIMINAR LA GUÍA NRO.: " + guia + "?")) {
                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        type: 'POST',
                        url: '{{route("registro_guia.destroy") }}',
                        data: {guia:guia},
                        success: function(response) {
                            // alert(response);
                            if (response.success){
                                alert("GUÍA ELIMINADA EXITOSAMENTE");
                                window.location.href = "{{ route('registro_guia')}}";
                            } else{
                                alert("SE HA PRODUCIDO UN ERROR AL ELIMINAR LA GUÍA");
                            }      
                        },
                        error: function() {
                        }
                    });
                }else{
                } 
            });

            ///////MODAL - HTML: EDITAR GUIA 
            $(document).on('click','.editar_guia', function(e) { 
                e.preventDefault(e); 
                var guia = $(this).attr('nro_guia');
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("registro_guia.editar") }}',
                    data: {guia:guia},
                    success: function(response) {
                        // alert(response);
                        // console.log(response);               
                        $('#content_editar_guia').html(response);
                    },
                    error: function() {
                    }
                });
            });

            /////////SELECT MUNICIPIO Y PARROQUIA
            $(document).on('change','#municipio', function(e) {
                var municipio = $(this).val();

                switch (municipio) {
                    case 'Bolívar':
                        $('#parroquia').html('<option value="Bolívar (San Mateo)">Bolívar (San Mateo)</option>');
                        break;
                    case 'Camatagua':
                        $('#parroquia').html('<option value="Camatagua">Camatagua</option>'+
                                            '<option value="Carmen de Cura">Carmen de Cura</option>');
                        break;
                    case 'Francisco Linares Alcántara':
                        $('#parroquia').html('<option value="Santa Rita">Santa Rita</option>'+
                                            '<option value="Francisco de Miranda">Francisco de Miranda</option>'+
                                            '<option value="Moseñor Feliciano González">Moseñor Feliciano González</option>');
                        break;
                    case 'Girardot':
                        $('#parroquia').html('<option value="Pedro José Ovalles">Pedro José Ovalles</option>'+
                                            '<option value="Joaquín Crespo">Joaquín Crespo</option>'+
                                            '<option value="José Casanova Godoy">José Casanova Godoy</option>'+
                                            '<option value="Madre María de San José">Madre María de San José</option>'+
                                            '<option value="Andrés Eloy Blanco">Andrés Eloy Blanco</option>'+
                                            '<option value="Los Tacarigua">Los Tacarigua</option>'+
                                            '<option value="Las Delicias">Las Delicias</option>'+
                                            '<option value="Choroní">Choroní</option>');

                    break;
                    case 'José Ángel Lamas':
                        $('#parroquia').html('<option value="Santa Cruz">Santa Cruz</option>');
                        break;
                    case 'José Félix Ribas':
                        $('#parroquia').html('<option value="José Félix Ribas">José Félix Ribas</option>'+
                                            '<option value="Castor Nieves Ríos">Castor Nieves Ríos</option>'+
                                            '<option value="Las Guacamayas">Las Guacamayas</option>'+
                                            '<option value="Pao de Zárate">Pao de Zárate</option>'+
                                            '<option value="Zuata">Zuata</option>');
                    break;
                    case 'José Rafael Revenga':
                        $('#parroquia').html('<option value="José Rafael Revenga">José Rafael Revenga</option>');
                        break;
                    case 'Libertador':
                        $('#parroquia').html('<option value="Palo Negro">Palo Negro</option>'+
                                            '<option value="San Martín de Porres">San Martín de Porres</option>');
                        break;
                    case 'Mario Briceño Iragorry':
                        $('#parroquia').html('<option value="El Limón">El Limón</option>'+
                                            '<option value="Caña de Azúcar">Caña de Azúcar</option>');
                    break;
                    case 'Ocumare de la Costa de Oro':
                        $('#parroquia').html('<option value="Ocumare de la Costa">Ocumare de la Costa</option>');
                        break;
                    case 'San Casimiro':
                        $('#parroquia').html('<option value="San Casimiro">San Casimiro</option>'+
                                            '<option value="Güiripa">Güiripa</option>'+
                                            '<option value="Ollas de Caramacate">Ollas de Caramacate</option>'+
                                            '<option value="Valle Morín">Valle Morín</option>');
                        break;
                    case 'San Sebastián':
                        $('#parroquia').html('<option value="San Sebastián">San Sebastián</option>');
                        break;
                    case 'Santiago Mariño':
                        $('#parroquia').html('<option value="Turmero">Turmero</option>'+
                                            '<option value="Arévalo Aponte">Arévalo Aponte</option>'+
                                            '<option value="Chuao">Chuao</option>'+
                                            '<option value="Samán de Güere">Samán de Güere</option>'+
                                            '<option value="Alfredo Pacheco Miranda">Alfredo Pacheco Miranda</option>');
                        break;
                    case 'Santos Michelena':
                        $('#parroquia').html('<option value="Santos Michelena">Santos Michelena</option>'+
                                            '<option value="Tiara">Tiara</option>');
                        break;
                    case 'Sucre':
                        $('#parroquia').html('<option value="Cagua">Cagua</option>'+
                                            '<option value="Bella Vista">Bella Vista</option>');
                    break;
                    case 'Tovar':
                        $('#parroquia').html('<option value="Tovar">Tovar</option>');
                        break;
                    case 'Urdaneta':
                        $('#parroquia').html('<option value="Urdaneta">Urdaneta</option>'+
                                            '<option value="Las Peñitas">Las Peñitas</option>'+
                                            '<option value="San Francisco de Cara">San Francisco de Cara</option>'+
                                            '<option value="Taguay">Taguay</option>');
                        break;
                    case 'Zamora':
                        $('#parroquia').html('<option value="Zamora">Zamora</option>'+
                                            '<option value="Magdaleno">Magdaleno</option>'+
                                            '<option value="San Francisco de Asís">San Francisco de Asís</option>'+
                                            '<option value="Valles de Tucutunemo">Valles de Tucutunemo</option>'+
                                            '<option value="Augusto Mijares">Augusto Mijares</option>');
                        break;
                    default:
                        break;
                }

            }); 

            ////////////////////MODAL: INFO GUIA
            $(document).on('click','.info_guia', function(e) { 
                e.preventDefault(e); 
                var guia = $(this).attr('nro_guia');
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("correlativo.guia") }}',
                    data: {guia:guia},
                    success: function(response) {           
                        $('#modal_content_guia').modal('show');

                        $('#content_info_guia').html(response);

                    },
                    error: function() {
                    }
                });
            });

        });


        function registrarGuia(){
            var formData = new FormData(document.getElementById("form_registrar_guia"));
            console.log("alo");
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url:'{{route("registro_guia.store") }}',
                type:'POST',
                contentType:false,
                cache:false,
                processData:false,
                async: true,
                data: formData,
                success: function(response){
                    console.log(response);
                    if (response.success) {
                        alert('REGISTRO DE GUÍA EXITOSO');
                        $('#modal_registro_guia').modal('hide');
                        $('#form_registrar_guia')[0].reset();
                        window.location.href = "{{ route('registro_guia')}}";
                    } else {
                        alert('Ha ocurrido un error al registrar la guía.');
                    } 
                },
                error: function(error){
                }
            });
        }

        function editarGuia(){
            var formData = new FormData(document.getElementById("form_editar_guia"));
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url:'{{route("registro_guia.editar_guia") }}',
                type:'POST',
                contentType:false,
                cache:false,
                processData:false,
                async: true,
                data: formData,
                success: function(response){
                    console.log(response);
                    if (response.success) {
                        alert('LA GUÍA SE HA EDITADO EXITOSAMENTE');
                        $('#modal_editar_guia').modal('hide');
                        window.location.href = "{{ route('registro_guia')}}";
                    } else {
                        alert('Ha ocurrido un error al editar la guía.');
                    } 
                },
                error: function(error){
                }
            });
        }

        
       
    </script>
    
@stop