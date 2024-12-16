@extends('adminlte::page')

@section('title', 'Asignación Timbres')

@section('content_header')
    
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <!-- <script src="{{asset('vendor/sweetalert.js') }}"></script> -->
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>

    <!-- <img src="{{asset('assets/bf-1.svg')}}" class="w-100" alt="..."> -->
@stop

@section('content')
    
    <div class="container rounded-4 p-3 px-0" style="background-color:#ffff;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-3 text-navy titulo fw-bold">Asignación de Timbres <span class="text-secondary fs-4">| Taquillas</span></h3>
            <div class="mb-3">
                <button type="button" class="btn bg-navy rounded-pill px-3 btn-sm fw-bold d-flex align-items-center" id="" data-bs-toggle="modal" data-bs-target="#modal_asignar_timbres">
                    <i class='bx bx-plus fw-bold fs-6 pe-2'></i>
                    <span>Asignar</span>
                </button>
            </div>
        </div>
         
        <div class="text-navy fs-3 mb-3 titulo fw-bold">
            Forma 14 <span class="text-muted">TFE-14</span>
        </div>
        <div class="table-responsive mb-5 pb-3" style="font-size:12.7px">
            <table id="asignados_forma14" class="table text-center border-light-subtle" style="font-size:12.7px">
                <thead>
                    <th>#</th>
                    <th>Asignado a</th>
                    <th>Fecha</th>
                    <th>Cantidad</th>
                    <th>Detalle</th>
                    <th>Constancia</th>
                    <!-- <th>¿Recibido?</th>  -->
                </thead>
                <tbody id="" class="border-light-subtle"> 
                    @foreach ($asignado_tfe as $tfe)
                        <tr>
                            <td>{{$tfe->id_asignacion}}</td>
                            <td>
                                <a href="#" class="taquilla" taquilla="{{$tfe->key_taquilla}}" data-bs-toggle="modal" data-bs-target="#modal_info_taquilla">Taquilla ID {{$tfe->key_taquilla}} </a>
                                <span class="text-muted ms-2">({{$tfe->sede}})</span>
                            </td>
                            <td class="text-muted">{{$tfe->fecha}}</td>
                            <td>{{$tfe->cantidad}} Rollos</td>
                            <td>
                                <a href="#" class="detalle_asignacion_rollos" vista="asignacion" asignacion="{{$tfe->id_asignacion}}" data-bs-toggle="modal" data-bs-target="#modal_asignado_forma14">Ver</a>
                            </td>
                            <td>
                                <a href="{{route('asignar.pdf_forma14', ['asignacion' => $tfe->id_asignacion])}}">Imprimir</a>
                            </td>
                            <!-- <td>
                                <span class="text-secondary fst-italic">Sin recibir</span>
                            </td> -->
                        </tr>
                    @endforeach
                </tbody> 
            </table>
        </div>

        <div class="text-navy fs-3 mb-3 titulo fw-bold">
            Estampillas <span class="text-muted">Timbre Móvil</span>
        </div>
        <div class="table-responsive" style="font-size:12.7px">
            <table id="asignados_estampillas" class="table text-center border-light-subtle" style="font-size:12.7px">
                <thead>
                    <th>#</th>
                    <th>Asignado a</th>
                    <th>Fecha</th>
                    <th>Detalle</th>
                    <th>Constancia</th>
                    <!-- <th>¿Recibido?</th>  -->
                </thead>
                <tbody id="" class="border-light-subtle"> 
                    @foreach ($asignado_estampillas as $estampillas)
                        <tr>
                            <td>{{$estampillas->id_asignacion}}</td>
                            <td>
                                <a href="#" class="taquilla" taquilla="{{$estampillas->key_taquilla}}" data-bs-toggle="modal" data-bs-target="#modal_info_taquilla">Taquilla ID {{$estampillas->key_taquilla}}</a>
                                <span class="text-muted ms-2"> ({{$estampillas->sede}})</span>
                            </td>
                            <td class="text-muted">{{$estampillas->fecha}}</td>
                            <td>
                                <a href="" class="detalle_asignacion_estampillas" vista="asignacion" asignacion="{{$estampillas->id_asignacion}}" data-bs-toggle="modal" data-bs-target="#modal_asignado_estampillas">Ver</a>
                            </td>
                            <td>
                                <a href="{{route('asignar.pdf_estampillas', ['asignacion' => $estampillas->id_asignacion])}}">Imprimir</a>
                            </td>
                            <!-- <td>
                                <span class="text-secondary fst-italic">Sin recibir</span>
                            </td> -->
                        </tr>
                    @endforeach
                </tbody> 
            </table>
        </div>

        

       

        

       
    </div>
    
    

      

    
    
<!--****************** MODALES **************************-->
    <div class="modal fade" id="modal_asignar_timbres" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content" id="content_asignar_timbres">
                <div class="modal-header p-2">
                    <h1 class="modal-title fs-5 fw-bold text-navy ms-3">
                        <!-- <i class='bx bx-collection fs-2 text-muted me-2'></i>  -->
                        Asignar Timbres 
                        <span class="text-secondary">| Taquillas</span>
                    </h1>
                </div>
                <div class="modal-body px-5 py-3" style="font-size:13px">
                    <div class="d-flex justify-content-center">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-14-tab" data-bs-toggle="pill" data-bs-target="#pills-14" type="button" role="tab" aria-controls="pills-14" aria-selected="true">Forma 14</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-estampilla-tab" data-bs-toggle="pill" data-bs-target="#pills-estampilla" type="button" role="tab" aria-controls="pills-estampilla" aria-selected="false">Estampillas</button>
                            </li>
                        </ul>
                    </div>


                    <!-- CONTENIDO -->
                    <div class="tab-content" id="pills-tabContent">
                        <!-- forma14 -->
                        <div class="tab-pane fade show active" id="pills-14" role="tabpanel" aria-labelledby="pills-14-tab" tabindex="0">
                            <form id="form_asignar_forma14" method="post" onsubmit="event.preventDefault(); asignarForma14()">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="sede" class="form-label">Sede: <span style="color:red">*</span></label>
                                        <select class="form-select form-select-sm sede" forma="forma14" id="select_sede_tfe" name="sede" required>
                                            <option>Seleccionar</option>
                                            @foreach ($sedes as $sede)
                                                <option value="{{$sede->id_sede}}">{{$sede->sede}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="taquilla" class="form-label">Taquilla: <span style="color:red">*</span></label>
                                        <select class="form-select form-select-sm taquilla" forma="14" id="select_taquilla_tfe" name="taquilla" required>
                                            <option>Seleccionar</option>
                                        </select>
                                    </div>
                                </div>

                                <p class="text-muted my-2 text-end">Taquillero designado: <span class="text-navy fw-bold" id="funcionario_forma14"> </span></p>

                                <label for="cantidad" class="form-label">Cantidad de Timbres Fiscales TFE-14: <span style="color:red">*</span></label>
                                <input class="form-control form-control-sm" type="number" name="cantidad" required>

                               
                                <div class="d-flex justify-content-center mt-3 mb-3">
                                    <button type="button" class="btn btn-secondary btn-sm me-2" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-success btn-sm">Asignar</button>
                                </div>
                            </form>
                        </div>  
                        <!-- estampillas -->
                        <div class="tab-pane fade" id="pills-estampilla" role="tabpanel" aria-labelledby="pills-estampilla-tab" tabindex="0">
                            <div class="my-5 py-5 d-flex flex-column text-center">
                                <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                                <span class="text-muted">Cargando, por favor espere un momento...</span>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>


    <!-- ************  CORRELATIVO ROLLOS ASIGNADOS ************** -->
    <div class="modal fade" id="modal_asignado_forma14" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_asignado_forma14">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ************  CORRELATIVO ESTAMPILLAS ASIGNADAS ************** -->
    <div class="modal fade" id="modal_asignado_estampillas" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_asignado_estampillas">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ********* INFO SUJETO ******** -->
    <div class="modal" id="modal_info_taquilla" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" id="html_info_taquilla">
                
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
    </script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
    <script src="{{ asset('jss/datatable.min.js') }}" defer ></script>
    <script src="{{ asset('jss/datatable.bootstrap.js') }}" ></script>
    <script src="{{ asset('jss/toastr.js') }}" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" ></script>
   
    <script type="text/javascript">
        $(document).ready(function () {
            $('#asignados_forma14').DataTable(
                {
                    // "order": [[ 0, "desc" ]],
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

            $('#asignados_estampillas').DataTable(
                {
                    // "order": [[ 0, "desc" ]],
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
        ///////////////////////////////////////AGREGAR CAMPOS A OTRO(S) PAGO
        var maxFieldTramite = 9; //Input fields increment limitation
            var c = 1; //Initial field counter is 1

            $(document).on('click', '.add_button', function(e){ //Once add button is clicked
                if(c < maxFieldTramite){ //Check maximum number of input fields
                    c++; //Increment field counter

                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        type: 'POST',
                        url: '{{route("asignar.denominacions") }}',
                        success: function(response) {
                            // console.log(response);
                            $('#conten_detalle_asignar_estampillas').append('<div class="row">'+
                                            '<div class="col-5">'+
                                                '<label for="denominacion_'+c+'" class="form-label">Denominación: <span class="text-danger">*</span></label>'+
                                                '<select class="form-select form-select-sm denominacion" id="denominacion_'+c+'" i="'+c+'" name="emitir['+c+'][denominacion]">'+
                                                    response+
                                                '</select>'+
                                            '</div>'+
                                            '<div class="col-5">'+
                                                '<label for="cantidad_'+c+'" class="form-label">Cant. Estampillas:</label>'+
                                                '<input type="number" class="form-control form-control-sm" i="'+c+'" id="cantidad_'+c+'" name="emitir['+c+'][cantidad]">'+
                                            '</div>'+
                                            '<div class="col-2 pt-4">'+
                                                '<a  href="javascript:void(0);" class="btn remove_button" >'+
                                                    '<i class="bx bx-x fs-4"></i>'+
                                                '</a>'+
                                            '</div>'+
                                        '</div>'); // Add field html
                        },
                        error: function() {
                        }
                    });

                    
                }
            });

            $(document).on('click', '.remove_button', function(e){ //Once remove button is clicked
                e.preventDefault();
                $(this).parent('div').parent('div').remove(); //Remove field html
                c--; //Decrement field counter
            });
        ///////////////////////////////////////////////////////////////////
        
        /////////////////// CONTENT MODAL ASIGNAR ESTAMPILLAS
        $(document).on('click','#pills-estampilla-tab', function(e) {
            e.preventDefault();

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("asignar.content_estampillas") }}',
                success: function(response) {
                    // console.log(response);
                    $('#pills-estampilla').html(response);
                },
                error: function() {
                }
            });
        });

        ///////////////////////COLOCAR SELECCIONE SI EL VALOR (DENOMINACION) YA HA SIDO ESCOGIDO
        $(document).on('change','.denominacion', function(e) {
            var value = $(this).val();
            var i = $(this).attr('i');
            var x = false;

            $('.denominacion').each(function(e){
                var d = $(this).val();
                var d_i = $(this).attr('i');
                
                if (d == value && d_i != i) {
                    x = true;
                }
                
            });

            if (x == true) {
                alert("Disculpe, no puede seleccionar dos (2) denominaciones del mismo valor para la misma emisión.");
                $('#denominacion_'+i)[0].selectedIndex = 0;
            }
        });

        
        ////////////////////////////  TAQUILLAS SEGUN LA SEDA - ASIGNACION FORMA 14
        $(document).on('change','.sede', function(e) {
            e.preventDefault(); 
            var value = $(this).val();
            var forma = $(this).attr('forma');

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("asignar.taquillas") }}',
                data: {value:value},
                success: function(response) {
                    if (forma == 'forma14') {
                        $('#select_taquilla_tfe').html(response);
                    }else{
                        $('#select_taquilla_estampilla').html(response);
                    }
                    
                },
                error: function() {
                }
            });
        });


        ////////////////////////////  TAQUILLERO ASIGNADO
        $(document).on('change','.taquilla', function(e) {
            e.preventDefault(); 
            var value = $(this).val();
            var forma = $(this).attr('forma');
            
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("asignar.funcionario") }}',
                data: {value:value},
                success: function(response) {
                    if (forma == '14') {
                        $('#funcionario_forma14').html(response);
                    }else{
                        $('#funcionario_estampillas').html(response);
                    }
                    
                },
                error: function() {
                }
            });
        });


        ///////////////////////////  INFO TAQUILLA
        $(document).on('click','.taquilla', function(e) {
            e.preventDefault(); 
            var taquilla = $(this).attr('taquilla');

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("asignar.info_taquilla") }}',
                data: {taquilla:taquilla},
                success: function(response) {
                    $('#html_info_taquilla').html(response);                 
                },
                error: function() {
                }
            });
        });


        ///////////////////////////  DETALLES ASIGNACION ESTAMPILLAS
        $(document).on('click','.detalle_asignacion_estampillas', function(e) {
            e.preventDefault(); 
            var asignacion = $(this).attr('asignacion');
            var vista = $(this).attr('vista');

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("asignar.detalle_estampillas") }}',
                data: {asignacion:asignacion,vista:vista},
                success: function(response) {
                    // console.log(response);
                    $('#content_asignado_estampillas').html(response);                 
                },
                error: function() {
                }
            });
        });


        ///////////////////////////  DETALLES ASIGNACION ROLLOS
        $(document).on('click','.detalle_asignacion_rollos', function(e) {
            e.preventDefault(); 
            var asignacion = $(this).attr('asignacion');
            var vista = $(this).attr('vista');

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("asignar.detalle_rollos") }}',
                data: {asignacion:asignacion,vista:vista},
                success: function(response) {
                    console.log(response);
                    $('#content_asignado_forma14').html(response);                 
                },
                error: function() {
                }
            });
        });

          
    });


    function asignarForma14(){
        var formData = new FormData(document.getElementById("form_asignar_forma14"));
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url:'{{route("asignar.asignar_forma_14") }}',
            type:'POST',
            contentType:false,
            cache:false,
            processData:false,
            async: true,
            data: formData,
            success: function(response){
                console.log(response);
                if (response.success) {
                    $('#modal_asignar_timbres').modal('hide');
                    $('#modal_asignado_forma14').modal('show');
                    $('#content_asignado_forma14').html(response.html);
                    
                }else{
                    if (response.nota) {
                        alert(response.nota);
                    }else{
                        alert('Disculpe, ha ocurrido un error en la asignación.');
                    }
                    
                }  

            },
            error: function(error){
                
            }
        });
    }


    function asignarEstampillas(){
        var formData = new FormData(document.getElementById("form_asignar_estampillas"));
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url:'{{route("asignar.asignar_estampillas") }}',
            type:'POST',
            contentType:false,
            cache:false,
            processData:false,
            async: true,
            data: formData,
            success: function(response){
                console.log(response);
                if (response.success) {
                    $('#modal_asignar_timbres').modal('hide');
                    $('#modal_asignado_estampillas').modal('show');
                    $('#content_asignado_estampillas').html(response.html);
                    
                }else{
                    if (response.nota) {
                        alert(response.nota);
                    }else{
                        alert('Disculpe, ha ocurrido un error en la asignación.');
                    }
                    
                }  

            },
            error: function(error){
                
            }
        });
    }
    

    </script>


  
@stop