@extends('adminlte::page')

@section('title', 'Detalle Reserva')

@section('content_header')
    
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{asset('vendor/sweetalert.js') }}"></script>

    <!-- <img src="{{asset('assets/bf-2.svg')}}" class="w-100" alt="..."> -->
@stop

@section('content')
    <div class="container rounded-4 p-3" style="background-color:#ffff;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-1 text-navy fw-bold titulo">Detalle de Talonario <span class="text-secondary fs-4">| Asignaciones</span><br>
                <span class="text-secondary text-start fst-italic" style="font-size:15px">Guías Asignadas | Reservas</span>
            </h3>
            
            <div class="d-flex flex-column">
                <p class="fs-4 text-navy fw-bold titulo my-0">Talonario No. {{$id_talonario}}</p>
                <p class="text-muted text-end fs-6">Asignado: {{$asignado->asignado}} Guía(s)</p>
            </div>
        </div>
        
        
        <div class="table-responsive" style="font-size:14px">        
            <table id="example" class="table display border-light-subtle text-center" style="width:100%; font-size:12.7px">
                <thead class="bg-primary border-light-subtle">
                    <tr>
                        <th scope="col">No. Asignación</th>
                        <th scope="col">Detalles</th>
                        <th scope="col">Contribuyente</th>
                        <th scope="col">R.I.F.</th>
                        <th scope="col">Cant. Guías</th> 
                        <th scope="col">Correlativo</th>
                        <!-- <th scope="col">Emisión</th> -->
                        <th scope="col">Soporte</th>
                        <th scope="col">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($asignaciones as $a)
                        <tr>
                            @php
                                $desde = $a->desde;
                                $hasta = $a->hasta;
                                $length = 6;
                                $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
                                $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);
                            @endphp
                            <td>{{$a->id_asignacion}}</td>
                            <td>
                                <a class="detalle_asignacion" role="button" id_asignacion='{{ $a->id_asignacion }}' tipo="{{ $a->contribuyente }}" data-bs-toggle="modal" data-bs-target="#modal_detalle_asignacion">Ver</a>
                            </td>
                            <td class="text-navy fw-bold">{{$a->razon_social}}</td>
                            <td>
                                <a class="info_sujeto" role="button" id_sujeto='{{ $a->id_sujeto }}' data-bs-toggle="modal" data-bs-target="#modal_info_sujeto">{{$a->rif_condicion}}-{{$a->rif_nro}}</a>
                            </td>
                            <td  class="table-primary fw-bold">{{$a->cantidad_guias}} Guías</td>
                            <td class="text-secondary fst-italic">{{$formato_desde}} - {{$formato_hasta}}</td>
                            <!-- <td class="text-secondary">{{$a->fecha_emision}}</td> -->
                            <td>
                                <a target="_blank" class="ver_pago" href="{{asset($a->soporte)}}">Ver</a>
                            </td>
                            <td>
                                @switch($a->id_estado)
                                    @case('17')  
                                        <span class="badge text-bg-primary p-2 py-1 d-flex justify-content-center align-items-center" style="font-size: 12px;"><i class='bx bx-history fs-6 me-2'></i>En proceso</span>
                                    @break
                                    @case('29')  
                                        <span class="badge text-bg-warning p-2 py-1 d-flex justify-content-center align-items-center" style="font-size: 12px;background-color: #ef7f00;"><i class='bx bx-error-circle fs-6 me-2'></i>QR Listo</span>
                                    @break
                                    @case('19')  
                                        <span class="badge text-bg-success p-2 py-1 d-flex justify-content-center align-items-center" style="font-size: 12px;"><i class='bx bx-check-circle fs-6 me-2'></i>Entregado</span>
                                    @break
                                    @default
                                @endswitch
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    
    

    
    
<!--****************** MODALES **************************-->
    <!-- ********* INFO SUJETO ******** -->
    <div class="modal" id="modal_info_sujeto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="html_info_sujeto">
                <div class="py-4 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ********* DETALLES ASIGNACIÓN ******** -->
    <div class="modal fade" id="modal_detalle_asignacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_detalle_asignacion">
                <div class="modal-body">
                    <div class="my-5 py-5 d-flex flex-column text-center">
                        <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                        <span class="text-muted">Cargando, por favor espere un momento...</span>
                    </div>
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
        const myModal = document.getElementById('myModal');
        const myInput = document.getElementById('myInput');

        myModal.addEventListener('shown.bs.modal', () => {
            myInput.focus()
        });
    </script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
    <script src="{{ asset('jss/datatable.min.js') }}" defer ></script>
    <script src="{{ asset('jss/datatable.bootstrap.js') }}" ></script>
    <script src="{{ asset('jss/toastr.js') }}" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" ></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#example').DataTable({
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
            });
        });
    </script> 

    <script type="text/javascript">
        $(document).ready(function (){
            ///////MODAL: INFO SUJETO PASIVO
            $(document).on('click','.info_sujeto', function(e) { 
                    e.preventDefault(e); 
                var sujeto = $(this).attr('id_sujeto');
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("aprobacion.sujeto") }}',
                    data: {sujeto:sujeto},
                    success: function(response) {              
                        $('#html_info_sujeto').html(response);
                    },
                    error: function() {
                    }
                });
            });

            ///////MODAL: INFO SUJETO PASIVO
            $(document).on('click','.detalle_asignacion', function(e) { 
                e.preventDefault(e); 
                var asignacion = $(this).attr('id_asignacion');
                var tipo = $(this).attr('tipo');
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("asignar.detalle") }}',
                    data: {asignacion:asignacion,tipo:tipo},
                    success: function(response) {              
                        $('#content_detalle_asignacion').html(response);
                    },
                    error: function() {
                    }
                });
            });

           


        });  

       

       

    </script>
@stop