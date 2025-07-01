@extends('adminlte::page')

@section('title', 'Ajustes')

@section('content_header')
    
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">

    <link type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" rel="stylesheet">
    <link type="text/css" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap4.css" rel="stylesheet">
    <link type="text/css" href="https://cdn.datatables.net/buttons/3.2.3/css/buttons.bootstrap4.css" rel="stylesheet">




    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
@stop

@section('content')
    <div class="mx-5">
        
        <div class="row d-flex align-items-center mb-4">
            <div class="col-md-6 text-navy fs-2 titulo fw-bold">Ajustes |  <span class="text-muted fs-3">Generales</span> </div>
        </div>


        <p class="text-muted fw-semibold fs-4 text-center titulo">Emisión de TFE-14</p>

        <div class="table-responsive mb-4" style="font-size:12.7px">
            <table id="table_ajustes_tfe" class="table text-center border-light-subtle" style="font-size:13px">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Valor</th>
                        @can('ajustes.update')
                            <th>Opción</th> 
                        @endcan
                        <th>Ultima actualización</th>
                    </tr> 
                </thead>
                <tbody>
                    @php
                        $c = 0;
                    @endphp
                    @foreach ($con_14 as $a14)
                        @php
                            $c++;
                        @endphp
                        <tr>
                            <td><span class="text-muted">{{$c}}</span></td>
                            <td><span class="text-navy fw-semibold">{{$a14->nombre}}</span></td>
                            <td>{{$a14->descripcion}}</td>
                            <td>
                                @if ($a14->valor == NULL)
                                    <span class="text-secondary fst-italic">Sin asignar.</span>
                                @else
                                    @if ($a14->correlativo == 3)
                                        <span class="fw-semibold">No. {{$a14->valor}}</span>
                                    @else
                                        <span class="fw-semibold">{{$a14->valor}} {{$a14->nombre_clf}}.</span> 
                                    @endif
                                @endif
                            </td>
                            @can('ajustes.update')
                                <td>
                                    @if ($a14->correlativo == 3 && $a14->valor != NULL)
                                        <span class="text-secondary fst-italic">No editable.</span>
                                    @else
                                        <span class="badge editar" style="background-color: #169131;" i="{{$a14->correlativo}}" var="ajustes" role="button" data-bs-toggle="modal" data-bs-target="#modal_editar_valor">
                                            <i class="bx bx-pencil fs-6"></i>
                                        </span>
                                    @endif
                                </td> 
                            @endcan
                            
                            <td>
                                <span class="text-muted">{{date("d-m-Y | h:i A",strtotime($a14->updated_at))}}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <p class="text-muted fw-semibold fs-4 text-center titulo">Venta</p>

        <div class="table-responsive mb-4" style="font-size:12.7px">
            <table id="table_ajustes_venta" class="table text-center border-light-subtle" style="font-size:13px">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Valor</th>
                        @can('ajustes.update')
                            <th>Opción</th> 
                        @endcan
                        <th>Ultima actualización</th>
                    </tr> 
                </thead>
                <tbody>
                    @foreach ($con_venta as $av)
                        @php
                            $c++;
                        @endphp
                        <tr>
                            <td><span class="text-muted">{{$c}}</span></td>
                            <td><span class="text-navy fw-semibold">{{$av->nombre}}</span></td>
                            <td>{{$av->descripcion}}</td>
                            <td> <span class="fw-semibold">{{$av->valor}} {{$av->nombre_clf}}.</span></td>
                            @can('ajustes.update')
                                <td>
                                    <span class="badge editar" style="background-color: #169131;" i="{{$av->correlativo}}" var="ajustes" role="button" data-bs-toggle="modal" data-bs-target="#modal_editar_valor">
                                        <i class="bx bx-pencil fs-6"></i>
                                    </span>
                                </td>
                            @endcan
                            
                            <td>
                                <span class="text-muted">{{date("d-m-Y | h:i A",strtotime($av->updated_at))}}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


        <p class="text-muted fw-semibold fs-4 text-center titulo">Emisión de Estampillas</p>

        <div class="table-responsive mb-4" style="font-size:12.7px">
            <table id="table_ajustes_est" class="table text-center border-light-subtle" style="font-size:13px">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Valor</th>
                        @can('ajustes.update')
                            <th>Opción</th> 
                        @endcan
                        <th>Ultima actualización</th>
                    </tr> 
                </thead>
                <tbody>
                    @foreach ($con_est as $est)
                        @php
                            $c++;
                        @endphp
                        <tr>
                            <td><span class="text-muted">{{$c}}</span></td>
                            <td><span class="text-navy fw-semibold">{{$est->nombre}}</span></td>
                            <td>{{$est->descripcion}}</td>
                            <td> <span class="fw-semibold">{{$est->valor}} {{$est->nombre_clf}}.</span></td>
                            @can('ajustes.update')
                                <td>
                                    <span class="badge editar" style="background-color: #169131;" i="{{$est->correlativo}}" var="ajustes" role="button" data-bs-toggle="modal" data-bs-target="#modal_editar_valor">
                                        <i class="bx bx-pencil fs-6"></i>
                                    </span>
                                </td>
                            @endcan
                            <td>
                                <span class="text-muted">{{date("d-m-Y | h:i A",strtotime($est->updated_at))}}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


        <p class="text-muted fw-semibold fs-4 text-center titulo">U.C.D</p>

        <div class="table-responsive mb-4" style="font-size:12.7px">
            <table id="table_ajustes_ucd" class="table text-center border-light-subtle" style="font-size:13px">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Valor</th>
                        <th>Moneda</th>
                        @can('ajustes.update')
                            <th>Opción</th> 
                        @endcan
                        <th>Ultima actualización</th>
                    </tr> 
                </thead>
                <tbody>
                    @php
                        $c++;
                    @endphp
                    <tr>
                        <td><span class="text-muted">{{$c}}</span></td>
                        <td><span class="text-navy fw-semibold">Precio U.C.D</span></td>
                        <td>{{$ucd->valor}}</td>
                        <td> <span class="fw-semibold">{{$ucd->moneda}}</span></td>
                        @can('ajustes.update')
                            <td>
                                <span class="badge editar" style="background-color: #169131;" i="{{$ucd->id}}" var="ucd" role="button" data-bs-toggle="modal" data-bs-target="#modal_editar_valor">
                                    <i class="bx bx-pencil fs-6"></i>
                                </span>
                            </td>
                        @endcan
                        <td>
                            <span class="text-muted">{{date("d-m-Y | h:i A",strtotime($ucd->fecha))}}</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        
    </div>
    

<!-- *********************************  MODALES ******************************* -->
    <!-- ************ APERTURA DE TAQUILLAS ************** -->
    <div class="modal fade" id="modal_editar_valor" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_editar_valor">
                
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
    
    <script src="https://cdn.datatables.net/buttons/3.2.3/js/dataTables.buttons.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.bootstrap4.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js" type="text/javascript"></script>

    
    <!-- <script src="" type="text/javascript"></script>
    <script src="" type="text/javascript"></script> -->
   

@stop

@section('js')
    
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
    <script src="{{ asset('jss/datatable.min.js') }}" defer ></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#table_ajustes_tfe').DataTable(
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
                    },
                    buttons: ['copy', 'excel', 'pdf'],
                }
            );
            $('#table_ajustes_venta').DataTable(
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
            $('#table_ajustes_est').DataTable(
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
            $('#table_ajustes_ucd').DataTable(
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
           //////////////////////////// MODAL EDITAR
           $(document).on('click','.editar', function(e) {
                e.preventDefault(); 
                var correlativo =  $(this).attr('i');
                var variable =  $(this).attr('var');
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("ajustes.modal_editar") }}',
                    data: {correlativo:correlativo,variable:variable},
                    success: function(response) {
                        if (response.success) {
                            $('#content_editar_valor').html(response.html);
                        }else{
                            if (response.nota) {
                                alert(response.nota);
                                window.location.href = "{{ route('ajustes')}}";
                            }
                        }
                       
                    },
                    error: function() {
                    }
                });
            });

        });

        function editarValor(){
            var formData = new FormData(document.getElementById("form_editar_valor_ajustes"));
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url:'{{route("ajustes.update") }}',
                type:'POST',
                contentType:false,
                cache:false,
                processData:false,
                async: true,
                data: formData,
                success: function(response){
                    console.log(response);
                    if (response.success) {
                        alert('ACTUALIZACIÓN EXITOSA.');
                        window.location.href = "{{ route('ajustes')}}";
                    }else{
                        if (response.nota) {
                            alert(response.nota);
                        }else{
                            alert('Disculpe, ha ocurrido un error');
                        }
                    }

                },
                error: function(error){
                    
                }
            });
        }

        
    </script>
  
@stop