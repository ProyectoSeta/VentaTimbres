@extends('adminlte::page')

@section('title', 'Inventario Papel')

@section('content_header')
    
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
@stop

@section('content')
    
    <div class="container rounded-4 p-3" style="background-color:#ffff;">
        <div class="d-flex justify-content-center align-items-center mb-2">
            <h3 class="mb-3 text-navy titulo fw-bold fs-2">Estampillas | Undidad Tributaria</h3>
        </div>

        <div class="row my-5">
            <div class="col-sm-6 border-end zoom_text px-5">
                <div class="text-center">
                    <h2 class="fw-bold titulo text-nay " style="color: #004cbd"><span class="text-muted">Lote | </span>20 U.T. </h2>
                </div>
                <div class="">
                    <div class="row">
                        <div class="col-lg -8 d-flex flex-column">
                            <div class=" fs-3 text-navy fw-bold" >Disponible en Inventario</div>
                            <div class="text-secondary">Para asignar a Taquilla</div>
                        </div>
                        <div class="col-lg -4">
                            <div class="fs-1 text-primary fw-bold bg-primary-subtle text-center rounded-4  px-2">{{$cant_20ut}} <span class="fs-5">Und.</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 px-5 zoom_text"> 
                <div class="text-center">
                    <h2 class="fw-bold titulo text-nay" style="color: #004cbd"><span class="text-muted">Lote | </span>50 U.T.</h2>
                </div>
                <div class="">
                    <div class="row">
                        <div class="col-lg -8 d-flex flex-column">
                            <div class=" fs-3 text-navy fw-bold" >Disponible en Inventario</div>
                            <div class="text-secondary">Para asignar a Taquilla</div>
                        </div>
                        <div class="col-lg -4">
                            <div class="fs-1 text-primary fw-bold bg-primary-subtle text-center rounded-4 px-2">{{$cant_50ut}} <span class="fs-5">Und.</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="fs-4 titulo fw-semibold text-muted text-center">Asignadas a Taquillas</div>

        <div class="table-responsive" style="font-size:12.7px">
            <table id="table_asignados_ut" class="table text-center border-light-subtle" style="font-size:12.7px">
                <thead>
                    <th>#</th>
                    <th>Asignado a (Taquilla)</th>
                    <th>Ubicación</th>
                    <th>Fecha</th>
                    <th>Detalles</th>
                    <th>Constancia</th> 
                </thead>
                <tbody id="" class="border-light-subtle"> 
                    @foreach ($asignado_estampillas as $estampillas)
                        <tr>
                            <td>{{$estampillas->id_asignacion}}</td>
                            <td>
                                <a href="#" class="taquilla" taquilla="{{$estampillas->key_taquilla}}" data-bs-toggle="modal" data-bs-target="#modal_info_taquilla">Taquilla ID {{$estampillas->key_taquilla}}</a>
                            </td>
                            <td>
                                <span class="fw-bold text-navy titulo">{{$estampillas->sede}}</span>
                            </td>
                            <td class="text-muted">{{$estampillas->fecha}}</td>
                            <td>
                                <a href="" class="detalle_asignacion_estampillas" vista="asignacion" asignacion="{{$estampillas->id_asignacion}}" data-bs-toggle="modal" data-bs-target="#modal_asignado_estampillas">Ver</a>
                            </td>
                            <td>
                                <a href="{{route('asignar.pdf_estampillas', ['asignacion' => $estampillas->id_asignacion])}}">Imprimir</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody> 
            </table>
        </div>

    </div>
    
    

    

    
    
<!--****************** MODALES **************************-->
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

    <!-- ********* INFO SUJETO ******** -->
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
            $('#table_asignados_ut').DataTable(
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

      


    });

  


  

    

</script>


  
@stop