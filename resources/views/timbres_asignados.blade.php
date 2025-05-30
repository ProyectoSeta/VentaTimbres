@extends('adminlte::page')

@section('title', 'Asignación Timbres')

@section('content_header')
    
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>

@stop

@section('content')
    
    <div class="container rounded-4 p-3 px-0" style="background-color:#ffff;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-3 text-navy titulo fw-bold">Asignado a Taquilla <span class="text-secondary fs-4">| Timbres Fiscales</span></h3>
            <h2 class="text-navy fs-2 titulo fw-bold">Taquilla <sapn class="text-primary fw-bold">ID 00{{$id_taquilla}}</sapn></h2>
        </div>

        <div class="row">
            <!-- forma 14 -->
            <div class="col-md-6 pe-5">
                <h3 class="text-navy fw-bold mb-4 text-center">Forma 14 <span class="text-muted">| TFE 14</span></h3>
                <div class="table-responsive" style="font-size:12.7px">
                    <table id="forma_14" class="table text-center border-light-subtle" style="font-size:12.7px">
                        <thead>
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Detalle</th>
                            @can('timbres_asignados.recibido_forma14')
                                <th>¿Recibido?</th> 
                            @endcan
                            
                        </thead>
                        <tbody id="" class="border-light-subtle"> 
                            @php
                                $c = 1;
                            @endphp
                            @foreach ($rollos as $rollo)
                                <tr>
                                    <td>{{$rollo->id_asignacion}}</td>
                                    <td>
                                        <span class="text-muted">{{$rollo->fecha}}</span>
                                    </td>
                                    <td>
                                        <a href="" class="detalle_asignacion_rollos" vista="taquillero" asignacion="{{$rollo->id_asignacion}}" data-bs-toggle="modal" data-bs-target="#modal_asignado_forma14">Ver</a>
                                    </td>
                                    @can('timbres_asignados.recibido_forma14')
                                        <td>
                                            @if ($c == 1)
                                                <button class="btn btn-sm btn-success d-inline-flex align-items-center recibido_forma14" asignacion="{{$rollo->id_asignacion}}" type="button" data-bs-toggle="modal" data-bs-target="#modal_recibido_forma14">
                                                    <i class="bx bx-check"></i>
                                                </button>
                                            @else
                                                <button class="btn btn-sm btn-success d-inline-flex align-items-center recibido_forma14" asignacion="{{$rollo->id_asignacion}}" type="button" disabled>
                                                    <i class="bx bx-check"></i>
                                                </button>
                                            @endif
                                        </td>
                                    @endcan
                                    @php
                                     $c++;   
                                    @endphp
                                    
                                </tr>
                            @endforeach
                        </tbody> 
                    </table>
                </div>
            </div>
            <!-- estampillas -->
            <div class="col-md-6 ps-5">
                <h3 class="text-navy fw-bold mb-4 text-center">Estampillas <span class="text-muted">| Timbre móvil</span></h3>
                <div class="table-responsive" style="font-size:12.7px">
                    <table id="estampillas" class="table text-center border-light-subtle" style="font-size:12.7px">
                        <thead>
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Detalle</th>
                            @can('timbres_asignados.recibido_estampillas')
                                <th>¿Recibido?</th> 
                            @endcan 
                        </thead>
                        <tbody id="" class="border-light-subtle"> 
                             @php
                                $o = 1;
                            @endphp
                            @foreach ($estampillas as $estampilla)
                                <tr>
                                    <td>{{$estampilla->id_asignacion}}</td>
                                    <td>
                                        <span class="text-muted">{{$estampilla->fecha}}</span>
                                    </td>
                                    <td>
                                        <a href="" class="detalle_asignacion_estampillas" vista="taquillero" asignacion="{{$estampilla->id_asignacion}}" data-bs-toggle="modal" data-bs-target="#modal_asignado_estampillas">Ver</a>
                                    </td>
                                    @can('timbres_asignados.recibido_estampillas')
                                        <td>
                                            @if ($o == 1)
                                                <button class="btn btn-sm btn-success d-inline-flex align-items-center recibido_estampillas" asignacion="{{$estampilla->id_asignacion}}" type="button" data-bs-toggle="modal" data-bs-target="#modal_recibido_estampillas">
                                                    <i class="bx bx-check"></i>
                                                </button>
                                            @else
                                                <button class="btn btn-sm btn-success d-inline-flex align-items-center recibido_estampillas" asignacion="{{$estampilla->id_asignacion}}" type="button" disabled>
                                                    <i class="bx bx-check"></i>
                                                </button>
                                            @endif
                                            
                                        </td>
                                    @endcan 
                                    @php
                                      $o++;  
                                    @endphp
                                </tr>
                            @endforeach
                        </tbody> 
                    </table>
                </div>
            </div>
        </div>

        

        

       
        

       
    </div>
    
    

      

    
    
<!--****************** MODALES **************************-->
    <!-- ************  CORRELATIVO ROLLOS ASIGNADOS ************** -->
    <div class="modal fade" id="modal_asignado_forma14" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
    <div class="modal fade" id="modal_asignado_estampillas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_asignado_estampillas">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ************  TIMBRES RECIBIDOS - FORMA 14 ************** -->
    <div class="modal fade" id="modal_recibido_forma14" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_recibido_forma14">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ************  TIMBRES RECIBIDOS - ESTAMPILLAS ************** -->
    <div class="modal fade" id="modal_recibido_estampillas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_recibido_estampillas">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
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
            $('#forma_14').DataTable(
                {
                    // "order": [[ 0, "desc" ]],
                    "language": {
                        "lengthMenu": " Mostrar  _MENU_  Registros por página",
                        "zeroRecords": "No hay Timbres Forma 14 asignados a esta Taquilla.",
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

            $('#estampillas').DataTable(
                {
                    // "order": [[ 0, "desc" ]],
                    "language": {
                        "lengthMenu": " Mostrar  _MENU_  Registros por página",
                        "zeroRecords": "No hay Estampillas asignadas a esta Taquilla.",
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

        ///////////////////////////  RECIBIDO FORMA 14
        $(document).on('click','.recibido_forma14', function(e) {
            e.preventDefault(); 
            var asignacion = $(this).attr('asignacion');

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("timbres_asignados.modal_forma14") }}',
                data: {asignacion:asignacion},
                success: function(response) {
                    console.log(response);
                    $('#content_recibido_forma14').html(response);                 
                },
                error: function() {
                }
            });
        });

        ///////////////////////////  RECIBIDO ESTAMPILLAS
        $(document).on('click','.recibido_estampillas', function(e) {
            e.preventDefault(); 
            var asignacion = $(this).attr('asignacion');

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("timbres_asignados.modal_estampillas") }}',
                data: {asignacion:asignacion},
                success: function(response) {
                    // console.log(response);
                    $('#content_recibido_estampillas').html(response);                 
                },
                error: function() {
                }
            });
        });

              
    });

    function recibidoForma14(){
        var formData = new FormData(document.getElementById("form_recibido_forma14"));
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url:'{{route("timbres_asignados.recibido_forma14") }}',
            type:'POST',
            contentType:false,
            cache:false,
            processData:false,
            async: true,
            data: formData,
            success: function(response){
                console.log(response);
                if (response.success) {
                    alert('EL LOTE SE HA RECIBIDO CORRECTAMENTE.');
                    window.location.href = "{{ route('timbres_asignados')}}";
                }else{
                    alert('Disculpe, ha ocurrido un error.');                  
                }  

            },
            error: function(error){
                
            }
        });
    }

    function recibidoEstampillas(){
        var formData = new FormData(document.getElementById("form_recibido_estampillas"));
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url:'{{route("timbres_asignados.recibido_estampillas") }}',
            type:'POST',
            contentType:false,
            cache:false,
            processData:false,
            async: true,
            data: formData,
            success: function(response){
                // console.log(response);
                if (response.success) {
                    alert('LAS ESTAMPILLAS SE HAN RECIBIDO CORRECTAMENTE.');
                    window.location.href = "{{ route('timbres_asignados')}}";
                }else{
                    alert('Disculpe, ha ocurrido un error.');                  
                }  

            },
            error: function(error){
                
            }
        });
    }

    
    

    </script>


  
@stop