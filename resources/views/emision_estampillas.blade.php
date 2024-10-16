@extends('adminlte::page')

@section('title', 'Emisión Estampillas')

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
            <h3 class="mb-3 text-navy titulo fw-bold">Estampillas <span class="text-secondary fs-4">| Emitiendo</span></h3>
            <div class="mb-3">
                <button type="button" class="btn bg-navy rounded-pill px-3 btn-sm fw-bold d-flex align-items-center" id="btn_emitir_estampillas" data-bs-toggle="modal" data-bs-target="#modal_emitir_estampillas">
                    <i class='bx bx-plus fw-bold fs-6 pe-2'></i>
                    <span>Emitir</span>
                </button>
            </div>
        </div>

        

        <div class="table-responsive" style="font-size:12.7px">
            <table id="example" class="table text-center border-light-subtle" style="font-size:12.7px">
                <thead>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Detalles</th>
                    <th>Estado</th>
                    <th>Opciones</th> 
                </thead>
                <tbody id="" class="border-light-subtle"> 
                    @foreach ($query as $emision)
                        <tr>
                            <td>{{$emision->id_emision}}</td>
                            <td class="text-secondary">{{$emision->fecha_emision}}</td>
                            <td>
                                <a href="#" class="detalle_emision" emision="{{$emision->id_emision}}" data-bs-toggle="modal" data-bs-target="#modal_detalle_emision">Ver</a>
                            </td>
                            <td>
                                <span class="badge bg-primary-subtle border border-primary-subtle text-primary-emphasis rounded-pill" style="font-size:12px">En Proceso</span>
                            </td>
                            <td class="d-flex align-items-center justify-content-center">
                                @if ($emision->ultimo == true)
                                    <span class="badge py-1 delete_emision" emision="{{$emision->id_emision}}" style="background-color: #ed0000;" role="button" >
                                        <i class="bx bx-trash-alt fs-6"></i>
                                    </span> 
                                @else
                                    <span class="badge py-1" style="background-color: #ed00008c;">
                                        <i class="bx bx-trash-alt fs-6"></i>
                                    </span> 
                                @endif

                                <button class="btn btn-sm btn-primary enviar_inventario d-inline-flex align-items-center ms-2" emision="{{$emision->id_emision}}" title="Enviar a Inventario" type="button" data-bs-toggle="modal" data-bs-target="#modal_enviar_inventario_tiras">
                                    <i class='bx bxs-chevron-right'></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach                  
                </tbody> 
            </table>
        </div>
    </div>
    
    

      

    
    
<!--****************** MODALES **************************-->
    <div class="modal fade" id="modal_emitir_estampillas" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_emitir_estampillas">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>


    <!-- ************  CORRELATIVO TIRAS  ************** -->
    <div class="modal fade" id="modal_correlativo_tiras" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_correlativo_tiras">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>
    

    <!-- *****************  ENVIAR A INVENTARIO  *************** -->
    <div class="modal fade" id="modal_enviar_inventario_tiras" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_enviar_inventario_tiras">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>


    <!-- ************  DETALLE EMISIÓN ************** -->
    <div class="modal fade" id="modal_detalle_emision" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_detalle_emision">
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
            $('#example').DataTable(
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
                        url: '{{route("emision_estampillas.denominacions") }}',
                        success: function(response) {
                            // console.log(response);
                            $('#conten_detalle_emision_estampillas').append('<div class="row">'+
                                    '<div class="col-md-4">'+
                                        '<select class="form-select form-select-sm denominacion" id="denominacion_'+c+'" i="'+c+'" name="emitir['+c+'][denominacion]">'+
                                            response+
                                        '</select>'+
                                    '</div>'+
                                    '<div class="col-md-3">'+
                                        '<input type="number" class="form-control form-control-sm cantidad" id="cantidad_'+c+'" i="'+c+'"  name="emitir['+c+'][cantidad]" required>'+
                                    '</div>'+
                                    '<div class="col-md-4">'+
                                        '<input type="number" class="form-control form-control-sm" id="timbres_'+c+'" disabled>'+
                                    '</div>'+
                                    '<div class="col-md-1">'+
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


        /////////////////////////// MODAL EMITIR ESTAMPILLAS
        $(document).on('click','#btn_emitir_estampillas', function(e) {
            e.preventDefault();
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("emision_estampillas.modal_emitir") }}',
                success: function(response) {
                    // console.log(response);
                    $('#content_emitir_estampillas').html(response);
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

        //////////////////////////// CALCULAR  TIMBRES A EMITIR
        $(document).on('keyup','.cantidad', function(e) {
            var value = $(this).val();
            var i = $(this).attr('i');
            var cantidad = value * 160;

            $('#timbres_'+i).val(cantidad);
            
        });

        /////////////////////////// MODAL DETALLE EMISIÓN
        $(document).on('click','.detalle_emision', function(e) {
            e.preventDefault();
            var emision = $(this).attr('emision');

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("emision_estampillas.detalles") }}',
                data: {emision:emision},
                success: function(response) {
                    // console.log(response);
                    $('#content_detalle_emision').html(response);
                },
                error: function() {
                }
            });
        });

        /////////////////////////// MODAL ENVIAR A INVENTARIO
        $(document).on('click','.enviar_inventario', function(e) {
            e.preventDefault();
            var emision = $(this).attr('emision');
            // $('#btn_enviar_inventario').attr('disabled', true);

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("emision_estampillas.modal_enviar") }}',
                data: {emision:emision},
                success: function(response) {
                    // console.log(response);
                    $('#content_enviar_inventario_tiras').html(response);
                },
                error: function() {
                }
            });
        });

        /////////////////////////// ELIMINAR EMISIÓN TIRAS
        $(document).on('click','.delete_emision', function(e) {
            e.preventDefault();
            var emision = $(this).attr('emision');
            if (confirm('¿Desea eliminar la ID Emision '+emision+'?')){
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("emision_estampillas.delete") }}',
                    data: {emision:emision},
                    success: function(response) {
                        // console.log(response);
                        if (response.success) {
                            alert('LA EMISIÓN ID '+emision+' SE HA ELIMINADO CORRECTAMENTE.');
                            window.location.href = "{{ route('emision_estampillas')}}";
                        }else{
                            alert('Disculpe, ha ocurrido un error.');
                        }  
                    },
                    error: function() {
                    }
                });
            }
        });

    });

   
    function emitirEstampillas(){
        var formData = new FormData(document.getElementById("form_emitir_estampillas"));
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url:'{{route("emision_estampillas.emitir_estampillas") }}',
            type:'POST',
            contentType:false,
            cache:false,
            processData:false,
            async: true,
            data: formData,
            success: function(response){
                // console.log(response);
                if (response.success) {
                    $('#modal_emitir_estampillas').modal('hide');
                    $('#modal_correlativo_tiras').modal('show');
                    $('#content_correlativo_tiras').html(response.html);
                }else{
                    if (response.nota != '') {
                        alert(response.nota);
                    }else{
                        alert('Disculpe, ha ocurrido un error en la emisión. Vuelva a intentarlo.');
                    }
                    
                }
            },
            error: function(error){
                
            }
        });
    }


    function enviarTirasInventario(){
        var formData = new FormData(document.getElementById("form_enviar_inventario_tiras"));
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url:'{{route("emision_estampillas.enviar_inventario") }}',
            type:'POST',
            contentType:false,
            cache:false,
            processData:false,
            async: true,
            data: formData,
            success: function(response){
                // console.log(response);
                if (response.success) {
                    alert('LAS ESTAMPILLAS SE HAN ENVIADO AL INVENTARIO EXITOSAMENTE');
                    window.location.href = "{{ route('emision_estampillas')}}";
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