@extends('adminlte::page')

@section('title', 'Emisión Papel')

@section('content_header')
    
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <!-- <script src="{{asset('vendor/sweetalert.js') }}"></script>  -->
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>

    <!-- <img src="{{asset('assets/bf-1.svg')}}" class="w-100" alt="..."> -->
@stop

@section('content')
    
    <div class="container rounded-4 p-3" style="background-color:#ffff;">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h3 class="mb-3 text-navy titulo fw-bold">Papel de Seguridad <span class="text-secondary fs-4">| Emisión</span></h3>
        </div>

        <ul class="nav nav-pills mb-4 d-flex justify-content-center" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active position-relative" id="pills-f14-tab" data-bs-toggle="pill" data-bs-target="#pills-f14" type="button" role="tab" aria-controls="pills-f14" aria-selected="true">
                    Forma 14
                    @if ($total_tfe->total != 0)
                        <span class="position-absolute top-0 start-0 translate-middle" style="font-size:12.7px">
                            <span class="badge text-bg-primary">New</span>
                        </span>
                    @endif
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link position-relative" id="pills-estampillas-tab" data-bs-toggle="pill" data-bs-target="#pills-estampillas" type="button" role="tab" aria-controls="pills-estampillas" aria-selected="false">
                    Estampillas
                    @if ($total_est->total != 0)
                        <span class="position-absolute top-0 start-100 translate-middle" style="font-size:12.7px">
                            <span class="badge text-bg-primary">New</span>
                        </span>
                    @endif
                </button>
            </li>
        </ul>

        <!-- CONTENTS -->
        <div class="tab-content" id="pills-tabContent">
            <!-- *********************   FORMA 14   ************************ -->
            <div class="tab-pane fade show active" id="pills-f14" role="tabpanel" aria-labelledby="pills-f14-tab" tabindex="0">
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn bg-navy rounded-pill px-3 btn-sm fw-bold d-flex align-items-center" id="btn_emitir_papel_f14" data-bs-toggle="modal" data-bs-target="#modal_emitir_papel_f14">
                        <i class='bx bx-plus fw-bold fs-6 pe-2'></i>
                        <span>Emitir</span>
                    </button>
                </div>

                <div class="table-responsive" style="font-size:12.7px">
                    <table id="papel_f14_emitidos" class="table text-center border-light-subtle" style="font-size:12.7px">
                        <thead>
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Cantidad</th>
                            <th>Desde</th>
                            <th>Hasta</th>
                            <th>Detalle</th>  <!-- fecha entrega, emitidos en ucd, user -->
                            <th>Estado</th> 
                            <th>Eliminar</th> 
                            <th>Recibido</th>
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
                                        <span class="badge text-bg-primary p-2 py-1 d-flex justify-content-center align-items-center" style="font-size: 12px;"><i class='bx bx-history fs-6 me-2'></i>En proceso</span>
                                    </td>
                                    <td>
                                        @if ($q1->ultimo == true)
                                            <span class="badge delete_lote_tfes" style="background-color: #ed0000;" role="button" lote="{{$q1->id_lote_papel}}">
                                                <i class="bx bx-trash-alt fs-6"></i>
                                            </span> 
                                        @else
                                            <span class="badge" style="background-color: #ed00008c;">
                                                <i class="bx bx-trash-alt fs-6"></i>
                                            </span> 
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary enviar_inventario_tfes d-inline-flex align-items-center ms-2"  lote="{{$q1->id_lote_papel}}"  title="Enviar a Inventario" type="button">
                                            <i class='bx bxs-chevron-right'></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach           
                        </tbody> 
                    </table>
                </div>
            </div>
            
            <!-- *********************   ESTAMPILLAS   ************************ -->
            <div class="tab-pane fade" id="pills-estampillas" role="tabpanel" aria-labelledby="pills-estampillas-tab" tabindex="0">
                <div class="d-flex justify-content-center">    
                    <button type="button" class="btn bg-navy rounded-pill px-3 btn-sm fw-bold d-flex align-items-center" id="btn_emitir_papel_estampillas" data-bs-toggle="modal" data-bs-target="#modal_emitir_papel_estampillas">
                        <i class='bx bx-plus fw-bold fs-6 pe-2'></i>
                        <span>Emitir</span>
                    </button>
                </div>

                <div class="table-responsive" style="font-size:12.7px">
                    <table id="papel_estampillas_emitidos" class="table text-center border-light-subtle" style="font-size:12.7px">
                        <thead>
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Cantidad</th>
                            <th>Desde</th>
                            <th>Hasta</th>
                            <th>Detalle</th>  <!-- fecha entrega, emitidos en ucd, user -->
                            <th>Estado</th> 
                            <th>Eliminar</th> 
                            <th>Recibido</th>
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
                                        <span class="badge text-bg-primary p-2 py-1 d-flex justify-content-center align-items-center" style="font-size: 12px;"><i class='bx bx-history fs-6 me-2'></i>En proceso</span>
                                    </td>
                                    <td>
                                        @if ($q2->ultimo == true)
                                            <span class="badge delete_lote_estampillas" style="background-color: #ed0000;" role="button" lote="{{$q2->id_lote_papel}}">
                                                <i class="bx bx-trash-alt fs-6"></i>
                                            </span> 
                                        @else
                                            <span class="badge" style="background-color: #ed00008c;">
                                                <i class="bx bx-trash-alt fs-6"></i>
                                            </span> 
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary enviar_inventario_estampillas d-inline-flex align-items-center ms-2"  lote="{{$q2->id_lote_papel}}"  title="Enviar a Inventario" type="button">
                                            <i class='bx bxs-chevron-right'></i>
                                        </button>
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
    <!-- ************ EMITIR PAPEL DE SEGURIDAD: FORMA 14  ************** -->
    <div class="modal fade" id="modal_emitir_papel_f14" tabindex="-1" aria-hidden="true"  data-bs-keyboard="false" aria-hidden="true" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog">
            <div class="modal-content" id="content_emitir_papel_f14">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ************ EMITIR PAPEL DE SEGURIDAD: ESTAMPILLAS  ************** -->
    <div class="modal fade" id="modal_emitir_papel_estampillas" tabindex="-1" aria-hidden="true"  data-bs-keyboard="false" aria-hidden="true" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog">
            <div class="modal-content" id="content_emitir_papel_estampillas">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ************ DETALLE LOTE: ESTAMPILLAS  ************** -->
    <div class="modal fade" id="modal_detalle_lote_estampillas" tabindex="-1"  data-bs-backdrop="static" >
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
    <div class="modal fade" id="modal_detalle_lote_tfes" tabindex="-1"  data-bs-backdrop="static" >
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

            $('#papel_estampillas_emitidos').DataTable(
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

        /////////////////////////// MODAL EMISION PAPEL FORMA 14
        $(document).on('click','#btn_emitir_papel_f14', function(e) {
            e.preventDefault();

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("papel.modal_f14") }}',
                success: function(response) {                    
                    if (response.success) {
                        $('#content_emitir_papel_f14').html(response.html);
                    }else{
                        if (response.nota != '') {
                            alert(response.nota)
                        }else{
                            alert('Disculpe, ha ocurrido un error. Vuelva a intentarlo.')
                        }
                        window.location.href = "{{ route('emision_papel')}}";
                    }
                },
                error: function() {
                }
            });
        });


        /////////////////////////// MODAL EMISION PAPEL  ESTAMPILLAS
        $(document).on('click','#btn_emitir_papel_estampillas', function(e) {
            e.preventDefault();

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("papel.modal_estampillas") }}',
                success: function(response) {
                    // console.log(response);
                    $('#content_emitir_papel_estampillas').html(response);
                },
                error: function() {
                }
            });
        });


        /////////////////////////// ELIMINAR EMISIÓN PAPEL TFES
        $(document).on('click','.delete_lote_tfes', function(e) {
            e.preventDefault();
            var lote = $(this).attr('lote');
            if (confirm('¿Desea eliminar el Lote en emisión de Papel de Seguridad para TFE 14 con el ID. '+lote+'?')){
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("papel.delete_f14") }}',
                    data: {lote:lote},
                    success: function(response) {
                        // console.log(response);
                        if (response.success) {
                            alert('EL LOTE ID '+lote+', PARA TFE 14, SE HA ELIMINADO CORRECTAMENTE.');
                            window.location.href = "{{ route('emision_papel')}}";
                        }else{
                            alert('Disculpe, ha ocurrido un error.');
                        }  
                    },
                    error: function() {
                    }
                });
            }
        });


        /////////////////////////// ELIMINAR EMISIÓN PAPEL ESTAMPILLAS
        $(document).on('click','.delete_lote_estampillas', function(e) {
            e.preventDefault();
            var lote = $(this).attr('lote');
            if (confirm('¿Desea eliminar el Lote en emisión de Papel de Seguridad para Estampillas con el ID. '+lote+'?')){
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("papel.delete_estampillas") }}',
                    data: {lote:lote},
                    success: function(response) {
                        // console.log(response);
                        if (response.success) {
                            alert('EL LOTE ID '+lote+', PARA ESTAMPILLAS, SE HA ELIMINADO CORRECTAMENTE.');
                            window.location.href = "{{ route('emision_papel')}}";
                        }else{
                            alert('Disculpe, ha ocurrido un error.');
                        }  
                    },
                    error: function() {
                    }
                });
            }
        });


        /////////////////////////// ENVIAR A INVENTARION LOTE TFES
        $(document).on('click','.enviar_inventario_tfes', function(e) {
            e.preventDefault();
            var lote = $(this).attr('lote');
            if (confirm('¿El Lote de Papel de Seguridad ID.'+lote+' ha sido recibido?')){
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("papel.enviar_inv_f14") }}',
                    data: {lote:lote},
                    success: function(response) {
                        // console.log(response);
                        if (response.success) {
                            alert('EL LOTE ID '+lote+' HA SIDO ENVIADO A INVENTARIO CORRECTAMENTE.');
                            window.location.href = "{{ route('emision_papel')}}";
                        }else{
                            alert('Disculpe, ha ocurrido un error.');
                        }  
                    },
                    error: function() {
                    }
                });
            }
        });


        /////////////////////////// ENVIAR A INVENTARION LOTE ESTAMPILLAS
        $(document).on('click','.enviar_inventario_estampillas', function(e) {
            e.preventDefault();
            var lote = $(this).attr('lote');
            if (confirm('¿El Lote de Papel de Seguridad ID.'+lote+' ha sido recibido?')){
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("papel.enviar_inv_estampillas") }}',
                    data: {lote:lote},
                    success: function(response) {
                        // console.log(response);
                        if (response.success) {
                            alert('EL LOTE ID '+lote+' HA SIDO ENVIADO A INVENTARIO CORRECTAMENTE.');
                            window.location.href = "{{ route('emision_papel')}}";
                        }else{
                            alert('Disculpe, ha ocurrido un error.');
                        }  
                    },
                    error: function() {
                    }
                });
            }
        });


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

    function emitirPapelF14(){
        var formData = new FormData(document.getElementById("form_emitir_papel_f14"));
        $('#content_emitir_papel_f14').html('<div class="my-5 py-5 d-flex flex-column text-center">'+
                                                '<i class="bx bx-loader-alt bx-spin fs-1 mb-3" style="color:#0077e2"  ></i>'+
                                                '<span class="text-muted">Cargando, por favor espere un momento...</span>'+
                                            '</div>');
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url:'{{route("papel.emitir_f14") }}',
                type:'POST',
                contentType:false,
                cache:false,
                processData:false,
                async: true,
                data: formData,
                success: function(response){
                    // console.log(response);
                    if (response.success) {
                        $('#content_emitir_papel_f14').html(response.html);
                    
                    }else{
                        if (response.nota != '') {
                            alert(response.nota);
                        }else{
                            alert('Disculpe, ha ocurrido un error.');
                        }
                        window.location.href = "{{ route('emision_papel')}}";
                    }  

                },
                error: function(error){
                    
                }
            });
    }


    function emitirPapelEstampillas(){
        var formData = new FormData(document.getElementById("form_emitir_papel_estampillas"));
        $('#content_emitir_papel_estampillas').html('<div class="my-5 py-5 d-flex flex-column text-center">'+
                                                '<i class="bx bx-loader-alt bx-spin fs-1 mb-3" style="color:#0077e2"  ></i>'+
                                                '<span class="text-muted">Cargando, por favor espere un momento...</span>'+
                                            '</div>');
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url:'{{route("papel.emitir_estampillas") }}',
                type:'POST',
                contentType:false,
                cache:false,
                processData:false,
                async: true,
                data: formData,
                success: function(response){
                    // console.log(response);
                    if (response.success) {
                        $('#content_emitir_papel_estampillas').html(response.html);
                    
                    }else{
                        if (response.nota != '') {
                            alert(response.nota);
                        }else{
                            alert('Disculpe, ha ocurrido un error.');
                        }
                        window.location.href = "{{ route('emision_papel')}}";
                    }  
                },
                error: function(error){
                    
                }
            });
    }


  

    

</script>


  
@stop