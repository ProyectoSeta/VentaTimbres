@extends('adminlte::page')

@section('title', 'Inventario Papel')

@section('content_header')
    
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <!-- <script src="{{asset('vendor/sweetalert.js') }}"></script>  -->
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>

    <!-- <img src="{{asset('assets/bf-1.svg')}}" class="w-100" alt="..."> -->
@stop

@section('content')
    
    <div class="container rounded-4 p-3" style="background-color:#ffff;">
        <div class="d-flex justify-content-center align-items-center mb-2">
            <h3 class="mb-3 text-navy titulo fw-bold fs-2">Papel de Seguridad</h3>
        </div>

        <div class="row my-5">
            <div class="col-sm-6 border-end zoom_text px-5">
                <div class="text-center">
                    <h2 class="fw-bold titulo text-nay " style="color: #004cbd"><span class="text-muted">Lote | </span>TFE 14 </h2>
                </div>
                <div class="">
                    <div class="row">
                        <div class="col-lg -8 d-flex flex-column">
                            <div class=" fs-3 text-navy fw-bold" >Disponible en Inventario</div>
                            <div class="text-secondary">Para asignar a Taquilla</div>
                        </div>
                        <div class="col-lg -4">
                            <div class="fs-1 text-primary fw-bold bg-primary-subtle text-center rounded-4  px-2">{{$total_f14}} <span class="fs-5">Und.</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 px-5 zoom_text"> 
                <div class="text-center">
                    <h2 class="fw-bold titulo text-nay" style="color: #004cbd"><span class="text-muted">Lote | </span>Estampillas</h2>
                </div>
                <div class="">
                    <div class="row">
                        <div class="col-lg -8 d-flex flex-column">
                            <div class=" fs-3 text-navy fw-bold" >Disponible en Inventario</div>
                            <div class="text-secondary">Para emitir U.C.D.</div>
                        </div>
                        <div class="col-lg -4">
                            <div class="fs-1 text-primary fw-bold bg-primary-subtle text-center rounded-4 px-2">{{$total_estampillas}} <span class="fs-5">Und.</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>





        <ul class="nav nav-pills mb-4 d-flex justify-content-center" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-f14-tab" data-bs-toggle="pill" data-bs-target="#pills-f14" type="button" role="tab" aria-controls="pills-f14" aria-selected="true">
                    Forma 14
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-estampillas-tab" data-bs-toggle="pill" data-bs-target="#pills-estampillas" type="button" role="tab" aria-controls="pills-estampillas" aria-selected="false">
                    Estampillas
                </button>
            </li>
        </ul>

        <!-- CONTENTS -->
        <div class="tab-content" id="pills-tabContent">
            <!-- *********************   FORMA 14   ************************ -->
            <div class="tab-pane fade show active" id="pills-f14" role="tabpanel" aria-labelledby="pills-f14-tab" tabindex="0">

                <div class="table-responsive" style="font-size:12.7px">
                    <table id="papel_f14_emitidos" class="table text-center border-light-subtle" style="font-size:12.7px">
                        <thead>
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Cantidad</th>
                            <th>Desde</th>
                            <th>Hasta</th>
                            <th>Detalle</th>  <!-- fecha entrega, emitidos en ucd, user -->
                            <th>Asignaciones</th>
                            <th>Estado</th>  
                        </thead>
                        <tbody id="" class="border-light-subtle"> 
                            @foreach ($query_tfes as $q1)
                                <tr>
                                    <td>{{$q1->id_lote_papel}}</td>
                                    <td class="fst-italic text-muted">{{$q1->fecha_emision}}</td>
                                    <td class="text-navy fw-bold">{{$q1->cantidad_timbres}} und.</td>
                                    <td class="fw-bold">{{$q1->desde}}</td>
                                    <td class="fw-bold">{{$q1->hasta}}</td>
                                    <td>
                                        <a href="#" class="detalle_emision_lote_tfes" lote="{{$q1->id_lote_papel}}" data-bs-toggle="modal" data-bs-target="#modal_detalle_lote_tfes">Ver</a> 
                                    </td>
                                    <td>
                                        @if ($q1->estado == 18)
                                            <span class="fst-italic text-secondary">No Aplica</span>
                                        @else
                                            
                                        @endif
                                    </td>
                                    <td>
                                        @if ($q1->estado == 18)
                                            <!-- EN PROCESO -->
                                            <span class="badge text-bg-primary p-2 py-1 d-flex justify-content-center align-items-center" style="font-size: 12px;"><i class='bx bx-history fs-6 me-2'></i>En proceso</span>
                                        @elseif ($q1->estado == 1)
                                            <!-- INVENTARIO -->
                                              <span class="badge bg-warning p-2 py-1 d-flex justify-content-center align-items-center" style="font-size: 12px;"><i class='bx bx-collection fs-6 me-2'></i> Inventario</span>
                                        @else
                                            <!-- ASIGNADO -->
                                              <span class="badge text-bg-secondary p-2 py-1 d-flex justify-content-center align-items-center" style="font-size: 12px;"><i class='bx bx-check-circle fs-6 me-2'></i> Asignado</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach       
                        </tbody> 
                    </table>
                </div>
            </div>
            
            <!-- *********************   ESTAMPILLAS   ************************ -->
            <div class="tab-pane fade" id="pills-estampillas" role="tabpanel" aria-labelledby="pills-estampillas-tab" tabindex="0">

                <div class="table-responsive" style="font-size:12.7px">
                    <table id="papel_estampillas_emitidos" class="table text-center border-light-subtle" style="font-size:12.7px">
                        <thead>
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Cantidad</th>
                            <th>Desde</th>
                            <th>Hasta</th>
                            <th>Detalle</th>  <!-- fecha entrega, emitidos en ucd, user -->
                            <th>Emisiones UCD</th> 
                            <th>Estado</th> 
                        </thead>
                        <tbody id="" class="border-light-subtle"> 
                            @foreach ($query_estampillas as $q2)
                                <tr>
                                    <td>{{$q2->id_lote_papel}}</td>
                                    <td class="fst-italic text-muted">{{$q2->fecha_emision}}</td>
                                    <td class="text-navy fw-bold">{{$q2->cantidad_timbres}} und.</td>
                                    <td class="fw-bold">{{$q2->desde}}</td>
                                    <td class="fw-bold">{{$q2->hasta}}</td>
                                    <td>
                                        <a href="#" class="detalle_emision_lote_estampillas" lote="{{$q2->id_lote_papel}}" data-bs-toggle="modal" data-bs-target="#modal_detalle_lote_estampillas">Ver</a> 
                                    </td>
                                    <td>
                                        @if ($q2->estado == 18)
                                            <span class="fst-italic text-secondary">No Aplica</span>
                                        @else
                                            
                                        @endif
                                    </td>
                                    <td>
                                        @if ($q2->estado == 18)
                                            <!-- EN PROCESO -->
                                            <span class="badge text-bg-primary p-2 py-1 d-flex justify-content-center align-items-center" style="font-size: 12px;"><i class='bx bx-history fs-6 me-2'></i>En proceso</span>
                                        @elseif ($q2->estado == 1)
                                            <!-- INVENTARIO -->
                                              <span class="badge bg-warning p-2 py-1 d-flex justify-content-center align-items-center" style="font-size: 12px;"><i class='bx bx-collection fs-6 me-2'></i> Inventario</span>
                                        @else
                                            <!-- ASIGNADO -->
                                              <span class="badge text-bg-secondary p-2 py-1 d-flex justify-content-center align-items-center" style="font-size: 12px;"><i class='bx bx-check-circle fs-6 me-2'></i> Asignado</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach      
                        </tbody> 
                    </table>
                </div>

            </div>
        </div>

    </div>
    
    

    

    
    
<!--****************** MODALES **************************-->
    <!-- ************ DETALLE LOTE: ESTAMPILLAS  ************** -->
    <div class="modal fade" id="modal_detalle_lote_estampillas" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_detalle_lote_estampillas">
                 <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ************ DETALLE LOTE: TFES  ************** -->
    <div class="modal fade" id="modal_detalle_lote_tfes" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_detalle_lote_tfes">
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
        // const myModal = document.getElementById('myModal');
        // const myInput = document.getElementById('myInput');

        // myModal.addEventListener('shown.bs.modal', () => {
        //     myInput.focus();
        // });
    </script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
    <script src="{{ asset('jss/datatable.min.js') }}" defer ></script>
    <script src="{{ asset('jss/datatable.bootstrap.js') }}" ></script>
    <script src="{{ asset('jss/toastr.js') }}" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" ></script>
   
    <script type="text/javascript">
        $(document).ready(function () {
            $('#papel_f14_emitidos').DataTable(
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

            $('#papel_estampillas_emitidos').DataTable(
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
        /////////////////////////// VER DETALLES LOTE ESTAMPILLAS
        $(document).on('click','.detalle_emision_lote_estampillas', function(e) {
            e.preventDefault();
            var lote = $(this).attr('lote');
            
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("papel.detalle_estampillas") }}',
                data: {lote:lote},
                success: function(response) {
                    console.log(response);
                    $('#content_detalle_lote_estampillas').html(response);
                },
                error: function() {
                }
            });
        });

        /////////////////////////// VER DETALLES LOTE TFES
        $(document).on('click','.detalle_emision_lote_tfes', function(e) {
            e.preventDefault();
            var lote = $(this).attr('lote');
            
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("papel.detalle_f14")}}',
                data: {lote:lote},
                success: function(response) {
                    console.log(response);
                    $('#content_detalle_lote_tfes').html(response);
                },
                error: function() {
                }
            });
        });
      


    });

  


  

    

</script>


  
@stop