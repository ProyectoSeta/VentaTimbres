@extends('adminlte::page')

@section('title', 'Exenciones Solventes')

@section('content_header')
    
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
@stop

@section('content')
    
    <div class="container rounded-4 p-3 px-0" style="background-color:#ffff;">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-3 text-navy titulo fw-bold">Historial Solventes <span class="text-secondary fs-4">| Exenciones </span></h3>
        </div>


        <div class="table-response" style="font-size:12.7px">
            <table id="table_exenciones_solventes" class="table align-middle border-light-subtle text-center " style="font-size:12.7px">
                <thead class="bg-primary border-light-subtle">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Fecha Emisión</th>
                        <th scope="col">Contribuyente</th>
                        <th scope="col">Sub Total</th>
                        <th scope="col">Exención (%)</th>
                        <th scope="col">Total</th>
                        <th scope="col">Detalles</th>
                        <th scope="col">Taquillero</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($exenciones as $ex)
                        <tr>
                            <td>{{$ex->id_exencion}}</td>
                            <td><span class="text-muted fst-italic">{{$ex->fecha}}</span></td>
                            <td>
                                <a class="info_sujeto_exencion d-flex flex-column" role="button" exencion="{{$ex->id_exencion}}" sujeto="{{$ex->key_contribuyente}}" data-bs-toggle="modal" data-bs-target="#modal_info_sujeto_exencion">
                                    <span>{{$ex->nombre_razon}}</span>
                                    <span>{{$ex->identidad_condicion}}-{{$ex->identidad_nro}}</span>
                                </a>
                            </td>
                            <td>
                                <span class="text-muted fw-bold">{{$ex->total_ucd}} U.C.D.</span>                                    
                            </td>
                            <td>
                                <span class="badge bg-primary-subtle border border-primary-subtle text-primary-emphasis rounded-pill" style="font-size:12.7px">{{$ex->porcentaje_exencion}}%</span>
                            </td>
                                @php
                                    $total_pagar = $ex->total_ucd - (($ex->total_ucd * $ex->porcentaje_exencion)/100);
                                @endphp
                            <td>
                                <span class="text-navy fw-bold">{{$total_pagar}} U.C.D.</span>                                    
                            </td>
                            <td>
                                <a href="#" class="detalle_exencion" exencion="{{$ex->id_exencion}}" vista="1" data-bs-toggle="modal" data-bs-target="#modal_detalle_exencion">Ver</a>
                            </td>
                            <td>
                                <a href="#" class="taquilla" taquilla="{{$ex->key_taquilla}}" data-bs-toggle="modal" data-bs-target="#modal_info_taquilla">Taquilla ID {{$ex->key_taquilla}} </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>








         
    

        
        

       

        

       
    </div>
    
    

      
<!-- <p class="text-muted ms-2"><span class="text-danger">*</span><span class="fw-bold">IMPORTANTE: </span>En caso de <span class="fw-bold">Anulación</span> del Timbre, debe <span class="fw-bold">solicitarle al Director de Recaudación</span> la Anulación del mismo.</p> -->
    
    
<!--****************** MODALES **************************-->
    <!-- INFO CONTRIBUYENTE EXENCIONES -->
    <div class="modal fade" id="modal_info_sujeto_exencion" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_info_sujeto_exencion">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ********* INFO TAQUILLA ******** -->
    <div class="modal" id="modal_info_taquilla" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" id="html_info_taquilla">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ********* DETALLE EXENCION ******** -->
    <div class="modal" id="modal_detalle_exencion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_detalle_exencion">
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
    </script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
    <script src="{{ asset('jss/datatable.min.js') }}" defer ></script>
    <script src="{{ asset('jss/datatable.bootstrap.js') }}" ></script>
    <script src="{{ asset('jss/toastr.js') }}" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" ></script>
   
    <script type="text/javascript">
        $(document).ready(function () {
            $('#table_exenciones_solventes').DataTable(
                {
                    "order": [[ 0, "desc" ]],
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
        /////////////////////// MODAL INFO SUJETO EXENCION
        $(document).on('click','.info_sujeto_exencion', function(e) {
            e.preventDefault();
            var sujeto = $(this).attr('sujeto');
            var exencion = $(this).attr('exencion');

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("exenciones.sujeto") }}',
                data: {sujeto:sujeto,exencion:exencion},
                success: function(response) {
                    console.log(response);
                    $('#content_info_sujeto_exencion').html(response);
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

        /////////////////////////// DETALLES EXENCION
        $(document).on('click','.detalle_exencion', function(e) {
            e.preventDefault(); 
            var exencion = $(this).attr('exencion');
            var vista = $(this).attr('vista');

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("exenciones.detalles") }}',
                data: {exencion:exencion,vista:vista},
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        $('#content_detalle_exencion').html(response.html);       
                    }else{
                        alert('Disculpe, ha ocurrido un error.');
                    }     
                },
                error: function() {
                }
            });
        });


        

        
          
    });


    
    

    


   


    


    


    


    
    

    </script>


  
@stop