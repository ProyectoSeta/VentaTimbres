@extends('adminlte::page')

@section('title', 'Asignar Taquillero')

@section('content_header')
    
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
@stop

@section('content')
    
    <div class="container rounded-4 p-3 px-0" style="background-color:#ffff;">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-3 text-navy titulo fw-bold">Asignar Taquilleros <span class="text-secondary fs-4">| Exenciones</span></h3>
        </div>


        <div class="table-response" style="font-size:12.7px">
            <table id="asignar_taq_exencion" class="table align-middle border-light-subtle text-center " style="font-size:12.7px">
                <thead class="bg-primary border-light-subtle">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Fecha emisión</th>
                            <th scope="col">Contribuyente</th>
                            <th scope="col">Total UCD</th>
                            <th scope="col">Exención (%)</th>
                            <th scope="col">Detalles</th>
                            <th scope="col">Taquillero</th>
                            <th scope="col">Asignar</th>
                        </tr>
                </thead>
                <tbody>
                    @foreach ($proceso as $process)
                        <tr>
                            <td>{{$process->id_exencion}}</td>
                            <td><span class="text-muted fst-italic">{{$process->fecha}}</span></td>
                            <td>
                                <a class="info_sujeto_exencion d-flex flex-column" role="button" exencion="{{$process->id_exencion}}" sujeto="{{$process->key_contribuyente}}" data-bs-toggle="modal" data-bs-target="#modal_info_sujeto_exencion">
                                    <span>{{$process->nombre_razon}}</span>
                                    <span>{{$process->identidad_condicion}}-{{$process->identidad_nro}}</span>
                                </a>
                            </td>
                            <td>
                                <span class="text-navy fw-bold">{{$process->total_ucd}} UCD</span>                                    
                            </td>
                            <td>
                                <span class="badge bg-primary-subtle border border-primary-subtle text-primary-emphasis rounded-pill" style="font-size:12.7px">{{$process->porcentaje_exencion}}%</span>
                            </td>
                            <td>
                                <a class="detalle_solicitud" exencion="{{$process->id_exencion}}" data-bs-toggle="modal" data-bs-target="#modal_detalles_exencion">Ver</a>
                            </td>
                            <td>
                                <span class="text-secondary fst-italic" title="En espera de la asignación de Taquillero">
                                    @if ($process->key_taquilla == NULL)
                                        Sin Asignar
                                    @else
                                        
                                    @endif
                                </span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-secondary btn-sm pb-0 btn_asignar_taquillero" exencion="{{$process->id_exencion}}" data-bs-toggle="modal" data-bs-target="#modal_asignar_taquillero"><i class='bx bx-card'></i></button>                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>







        <!-- ASIGNADOS -->

        <div class="d-flex justify-content-between align-items-center mb-4 mt-5">
            <h3 class="mb-3 text-muted titulo fw-bold">Asignados <span class="text-secondary fs-4">| Historial</span></h3>
        </div>

        <div class="table-response" style="font-size:12.7px">
            <table id="historial_asignados" class="table align-middle border-light-subtle text-center " style="font-size:12.7px">
                <thead class="bg-primary border-light-subtle">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Fecha emisión</th>
                            <th scope="col">Contribuyente</th>
                            <th scope="col">Total UCD</th>
                            <th scope="col">Exención (%)</th>
                            <th scope="col">Detalles</th>
                            <th scope="col">Asignado (fecha)</th>
                            <th scope="col">Taquillero</th>
                            <th scope="col">¿Emitido?</th>
                        </tr>
                </thead>
                <tbody>
                    @foreach ($asignados as $asignado)
                        <tr>
                            <td>{{$asignado->id_exencion}}</td>
                            <td><span class="text-muted fst-italic">{{$asignado->fecha}}</span></td>
                            <td>
                                <a class="info_sujeto_exencion d-flex flex-column" role="button" exencion="{{$asignado->id_exencion}}" sujeto="{{$asignado->key_contribuyente}}" data-bs-toggle="modal" data-bs-target="#modal_info_sujeto_exencion">
                                    <span>{{$asignado->nombre_razon}}</span>
                                    <span>{{$asignado->identidad_condicion}}-{{$asignado->identidad_nro}}</span>
                                </a>
                            </td>
                            <td>
                                <span class="text-navy fw-bold">{{$process->total_ucd}} UCD</span>                                    
                            </td>
                            <td>
                                <span class="badge bg-primary-subtle border border-primary-subtle text-primary-emphasis rounded-pill" style="font-size:12.7px">{{$asignado->porcentaje_exencion}}%</span>
                            </td>
                            <td>
                                <a class="detalle_solicitud" exencion="{{$asignado->id_exencion}}" data-bs-toggle="modal" data-bs-target="#modal_detalles_exencion">Ver</a>
                            </td>
                            <td>
                                @php
                                    echo date("Y-m-d h:i A",strtotime($asignado->fecha_asig_taquilla));
                                @endphp
                            </td>
                            <td>
                                <a class="info_taquillero" taquillero="{{$asignado->key_funcionario}}" taquilla="{{$asignado->key_taquilla}}" data-bs-toggle="modal" data-bs-target="#modal_info_taquillero">{{$asignado->nombre_taquillero}}</a>
                            </td>
                            <td>
                                @if ($asignado->fecha_impreso == null)
                                <span class="badge bg-secondary-subtle border border-secondary-subtle text-secondary-emphasis rounded-pill d-flex align-items-center justify-content-center" style="font-size:12.7px">
                                    <i class='bx bx-time-five me-2'></i> 
                                    <span>En espera</span>
                                </span>
                                @else
                                <span class="badge bg-success-subtle border border-success-subtle text-success-emphasis rounded-pill d-flex align-items-center justify-content-center" style="font-size:12.7px">
                                <i class='bx bx-check me-2'></i>
                                    <span>Emitido</span>
                                </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>



        










         
    

        
        

       

        

       
    </div>
    
    

      

    
    
<!--****************** MODALES **************************-->
    <!-- ************ ASIGNAR TAQUILLERO ************* -->
    <div class="modal fade" id="modal_asignar_taquillero" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_asignar_taquillero">
            <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-plus-circle fs-2 text-muted me-2"></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">Asignar Taquillero | <span class="text-muted">Exención</span></h1>
                    </div>
                </div> 
                <div class="modal-body px-5 py-3" style="font-size:13px">
                    <form id="form_asignar_taquillero_ex" method="post" onsubmit="event.preventDefault(); asignarTaquilleroEx()">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="sede" class="form-label">Sede: <span style="color:red">*</span></label>
                                <select class="form-select form-select-sm sede" forma="forma14" id="select_sede" name="sede" required>
                                    <option>Seleccionar</option>
                                    @foreach ($sedes as $sede)
                                        <option value="{{$sede->id_sede}}">{{$sede->sede}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="taquilla" class="form-label">Taquilla: <span style="color:red">*</span></label>
                                <select class="form-select form-select-sm taquilla" forma="14" id="select_taquilla" name="taquilla" required>
                                    <option>Seleccionar</option>
                                </select>
                            </div>
                        </div>

                        <input type="hidden" name="exencion" id="input_exencion">

                        <p class="text-muted my-2 text-end">Taquillero designado: <span class="text-navy fw-bold" id="taquillero_ex"> </span></p>
                        


                        <div class="d-flex justify-content-center mt-4 mb-3">
                            <button type="button" class="btn btn-secondary btn-sm me-2" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success btn-sm" id="btn_submit_exencion">Aceptar</button>
                        </div>
                    </form>
                    
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ************ INFO TAQUILLERO ************* -->
    <div class="modal fade" id="modal_info_taquillero" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_info_taquillero">
                
                 
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
            $('#asignar_taq_exencion').DataTable(
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

            $('#historial_asignados').DataTable(
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
                    $('#select_taquilla').html(response);
                    
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
                    
                    $('#taquillero_ex').html(response);
                    
                    
                },
                error: function() {
                }
            });
        });

        /////////////////// INPUT ID EXENCION
        $(document).on('click','.btn_asignar_taquillero', function(e) {
            e.preventDefault();
            var exencion = $(this).attr('exencion');

            $('#input_exencion').val(exencion);
    
        });

        ///////////////////////////  INFO TAQUILLERO
        $(document).on('click','.info_taquillero', function(e) {
            e.preventDefault(); 
            var taquillero = $(this).attr('taquillero');
            var taquilla = $(this).attr('taquilla');

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("asignar_taquillero.info_taquillero") }}',
                data: {taquillero:taquillero,taquilla:taquilla},
                success: function(response) {
                    $('#content_info_taquillero').html(response);                 
                },
                error: function() {
                }
            });
        });

          
    });


    function asignarTaquilleroEx(){
        var formData = new FormData(document.getElementById("form_asignar_taquillero_ex"));
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url:'{{route("asignar_taquillero.asignar") }}',
            type:'POST',
            contentType:false,
            cache:false,
            processData:false,
            async: true,
            data: formData,
            success: function(response){
                console.log(response);
                if (response.success) {
                    alert('ASIGNACIÓN EXITOSA.');
                    window.location.href = "{{ route('asignar_taquillero')}}";
                }else{
                    if (response.nota) {
                        alert(response.nota);
                    }else{
                        alert('Disculpe, ha ocurrido un error. Vuelva a intentarlo.');
                    }
                    
                }  

            },
            error: function(error){
                
            }
        });
    }


    


   


    


    


    


    
    

    </script>


  
@stop