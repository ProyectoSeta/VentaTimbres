@extends('adminlte::page')

@section('title', 'Canteras')

@section('content_header')
    
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{asset('vendor/sweetalert.js') }}"></script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>

    <!-- <img src="{{asset('assets/bf-1.svg')}}" class="w-100" alt="..."> -->
@stop

@section('content')
    
    <div class="container rounded-4 p-3" style="background-color:#ffff;">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h3 class="mb-3 text-navy titulo fw-bold">Registro <span class="text-secondary fs-4">| Canteras y Desazolves</span></h3>
            <div class="mb-3">
                <button type="button" class="btn bg-navy rounded-pill px-3 btn-sm fw-bold d-flex align-items-center" id="new_cantera" data-bs-toggle="modal" data-bs-target="#modal_new_cantera">
                    <i class='bx bx-plus fw-bold fs-6 pe-2'></i>
                    <span>Registrar Cantera</span>
                </button>
            </div>
        </div>

        

        <div class="table-responsive" style="font-size:14px">
            <table id="example" class="table text-center border-light-subtle" style="font-size:12.7px">
                <thead>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Direccion</th>
                    <th>Producción</th>
                    <!-- <th>Guias a solicitar cada tres (3) meses</th> -->
                    <th>Estado</th>
                    <th>Opciones</th> 
                </thead>
                <tbody id="list_canteras" class="border-light-subtle"> 
                
                    @foreach ( $canteras as $cantera )            
                        <tr>
                            <td>{{ $cantera->id_cantera }}</td>
                            <td class="fw-bold">{{ $cantera->nombre }}</td>
                            <td>{{ $cantera->lugar_aprovechamiento }}</td>
                            <td>
                                <p class="text-primary fw-bold info_cantera" role="button" id_cantera='{{ $cantera->id_cantera }}' data-bs-toggle="modal" data-bs-target="#modal_info_cantera">Ver más</p>
                            </td>
                            
                            <td>
                                @if ($cantera->status == 'Verificando')
                                    <span class="badge text-bg-secondary p-2 py-1 d-flex justify-content-center align-items-center" style="font-size: 12px;"><i class='bx bx-error-circle fs-6 me-2'></i>Verificando cantera</span>
                                @elseif ($cantera->status == 'Verificada')
                                    <span role="button" class="badge text-bg-success p-2 py-1 d-flex justify-content-center align-items-center cantera_verificada" style="font-size: 12px;" data-bs-toggle="modal" data-bs-target="#modal_info_limite" id_cantera='{{ $cantera->id_cantera }}'><i class='bx bx-check-circle fs-6 me-2'></i>Cantera verificada</span> 
                                @elseif ($cantera->status == 'Denegada')
                                    <span role="button" class="badge text-bg-danger p-2 py-1 d-flex justify-content-center align-items-center cantera_denegada" style="font-size: 12px;" data-bs-toggle="modal" data-bs-target="#modal_info_denegada" id_cantera='{{ $cantera->id_cantera }}'><i class='bx bx-x-circle fs-6 me-2'></i>Denegada</span> 
                                @endif
                            </td>
                            <td>
                                <span class="badge me-1 delete_cantera" style="background-color: #ed0000;" role="button" id_cantera='{{ $cantera->id_cantera }}' nombre="{{ $cantera->nombre }}">
                                    <i class='bx bx-trash-alt fs-6'></i>
                                </span>
                                <span class="badge edit_cantera" style="background-color: #169131;" role="button" data-bs-toggle="modal" data-bs-target="#modal_edit_cantera" id_cantera="{{ $cantera->id_cantera }}">
                                    <i class="bx bx-pencil fs-6"></i>
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody> 
                
            </table>
            
        </div>
    </div>
    
    

      

    
    
  <!--****************** MODALES **************************-->
    <!-- ********* NUEVA CANTERA ******** -->
    <div class="modal" id="modal_new_cantera" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="content_new_cantera">
                <div class="py-4 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
             </div><!--  cierra modal-content  -->
        </div>  <!-- cierra modal-dialog -->
    </div>

  
    <!-- ********* EDITAR CANTERA ******** -->
    <div class="modal" id="modal_edit_cantera" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="content_edit_cantera">
                <div class="py-4 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!--  cierra modal-content  -->
        </div>  <!-- cierra modal-dialog -->
    </div>



    <!-- ********* INFO CANTERA ******** -->
    <div class="modal" id="modal_info_cantera" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" id="info_produccion">
                <div class="py-4 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
                
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- *********INFO CANTERA DENEGADA ******** -->
    <div class="modal" id="modal_info_denegada" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_info_denegada">
                <div class="py-4 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- *********INFO CANTERA VERIFICADA: LIMITE DE GUÍAS ******** -->
    <div class="modal" id="modal_info_limite" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_info_limite">
                <div class="py-4 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ********* INFO USER DENEGADO ******** -->
    <div class="modal" id="modal_info_access_denegado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class='bx bx-error-circle bx-tada fs-2' style='color:#e40307' ></i>
                        <h1 class="modal-title fs-5" id="exampleModalLabel" style="color: #0072ff">Acceso Denegado</h1>
                    </div>
                </div>
                <div class="modal-body" style="font-size:15px;">
                    <div class="d-flex flex-column text-center" id="info_produccion">
                        <span class="fw-bold">Observaciones de la Denegación</span>
                        <p class="mx-3 mt-1" id="observacion_access">
            
                        </p>

                        <div class="mt-3 mb-2">
                            <p class="text-muted me-3 ms-3" style="font-size:13px"><span class="fw-bold">Nota:
                                </span>Las <span class="fw-bold">Observaciones </span>
                                realizadas cumplen con el objetivo de notificarle
                                del porque el Usuario no fue verificado. Para que así, pueda rectificar y cumplir con el deber formal.
                            </p>
                        </div>
                    </div>
                </div>  <!-- cierra modal-body -->
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
            $('#example').DataTable(
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
        ////////AGREGAR CAMPOS A OTRO(S) MINERAL
            var maxField = 10; //Input fields increment limitation
            var addButton = $('.add_button'); //Add button selector
            var wrapper = $('.otros_minerales'); //Input field wrapper
            var fieldHTML = '<div class="row">'+
                                '<div class="col-9">'+
                                    '<input class="form-control form-control-sm" type="text" name="mineral[]">'+
                                '</div>'+
                                '<div class="col-2">'+
                                    '<a  href="javascript:void(0);" class="btn remove_button" >'+
                                    '<i class="bx bx-x fs-4"></i>'+
                                    '</a>'+
                               '</div>'+
                           '</div>';
                                //New input field html 
            var x = 1; //Initial field counter is 1
            $(document).on('click', '.add_button', function(e){ //Once add button is clicked
                if(x < maxField){ //Check maximum number of input fields
                    x++; //Increment field counter
                    $('.otros_minerales').append(fieldHTML); // Add field html
                }
            });
            $(document).on('click', '.remove_button', function(e){ //Once remove button is clicked
                e.preventDefault();
                $(this).parent('div').parent('div').remove(); //Remove field html
                x--; //Decrement field counter
            });

        
        ///////MODAL: INFO CANTERA DENEGADA
        $(document).on('click','#new_cantera', function(e) { 
            e.preventDefault(e);
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("cantera.modal_new") }}',
                success: function(response) {
                    // alert(response);                 
                    $('#content_new_cantera').html(response);
                },
                error: function() {
                }
            });
        });


        ///////MODAL: EDITAR CANTERA
        $(document).on('click','.edit_cantera', function(e) { 
            e.preventDefault(e); 
            var cantera = $(this).attr('id_cantera');
            // alert(cantera);
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("cantera.modal_edit") }}',
                data: {cantera:cantera},
                success: function(response) {
                    // console.log(response);                 
                    $('#content_edit_cantera').html(response);
                },
                error: function() {
                }
            });
        });


        ///////MODAL: INFO CANTERA
        $(document).on('click','.info_cantera', function(e) { 
            e.preventDefault(e); 
            var cantera = $(this).attr('id_cantera');
            // alert(cantera);
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("cantera.minerales") }}',
                data: {cantera:cantera},
                success: function(response) {
                    // alert(response);                 
                    $('#info_produccion').html(response);
                },
                error: function() {
                }
            });
        });

        //////ELIMINAR CANTERA
        $(document).on('click','.delete_cantera', function(e) { 
            e.preventDefault(e); 
            var cantera = $(this).attr('id_cantera');
            var nombre = $(this).attr('nombre');
    
            if (confirm("¿ESTA SEGURO QUE DESEA ELIMINAR LA CANTERA: " + nombre + "?")) {
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("cantera.destroy") }}',
                    data: {cantera:cantera},
                    success: function(response) {
                        if (response.success == 'sin permiso'){
                            alert("LA CANTERA NO PUEDE SER ELIMINADA, PORQUE HAY REGISTROS DE GUÍAS CON ESTA CANTERA");
                        }
                        else if (response.success){
                            alert("CANTERA ELIMINADA EXITOSAMENTE");
                            window.location.href = "{{ route('cantera')}}";
                        } else{
                            alert("SE HA PRODUCIDO UN ERROR AL ELIMINAR LA CANTERA");
                        }              
                    },
                    error: function() {
                    }
                });
            }else{

            }
            
        });

        ///////MODAL: INFO CANTERA DENEGADA
        $(document).on('click','.cantera_denegada', function(e) { 
            e.preventDefault(e); 
            var cantera = $(this).attr('id_cantera');
            // alert(cantera);
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("cantera.info_denegada") }}',
                data: {cantera:cantera},
                success: function(response) {
                    // alert(response);                 
                    $('#content_info_denegada').html(response);
                },
                error: function() {
                }
            });
        });

        
        ///////MODAL: INFO CANTERA VERIFICADA: LIMITE DE GUÍAS
        $(document).on('click','.cantera_verificada', function(e) { 
            e.preventDefault(e); 
            var cantera = $(this).attr('id_cantera');
            // alert(cantera);
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("cantera.info_limite") }}',
                data: {cantera:cantera},
                success: function(response) {
                    // alert(response);                 
                    $('#content_info_limite').html(response);
                },
                error: function() {
                }
            });
        });

        /////////////PARROQUIAS
        $(document).on('change','#municipio', function(e) {
            var municipio = $(this).val();

            switch (municipio) {
                case 'Bolívar':
                    $('#parroquia').html('<option value="Bolívar (San Mateo)">Bolívar (San Mateo)</option>');
                    break;
                case 'Camatagua':
                    $('#parroquia').html('<option value="Camatagua">Camatagua</option>'+
                                        '<option value="Carmen de Cura">Carmen de Cura</option>');
                    break;
                case 'Francisco Linares Alcántara':
                    $('#parroquia').html('<option value="Santa Rita">Santa Rita</option>'+
                                        '<option value="Francisco de Miranda">Francisco de Miranda</option>'+
                                        '<option value="Moseñor Feliciano González">Moseñor Feliciano González</option>');
                    break;
                case 'Girardot':
                    $('#parroquia').html('<option value="Pedro José Ovalles">Pedro José Ovalles</option>'+
                                        '<option value="Joaquín Crespo">Joaquín Crespo</option>'+
                                        '<option value="José Casanova Godoy">José Casanova Godoy</option>'+
                                        '<option value="Madre María de San José">Madre María de San José</option>'+
                                        '<option value="Andrés Eloy Blanco">Andrés Eloy Blanco</option>'+
                                        '<option value="Los Tacarigua">Los Tacarigua</option>'+
                                        '<option value="Las Delicias">Las Delicias</option>'+
                                        '<option value="Choroní">Choroní</option>');

                break;
                case 'José Ángel Lamas':
                    $('#parroquia').html('<option value="Santa Cruz">Santa Cruz</option>');
                    break;
                case 'José Félix Ribas':
                    $('#parroquia').html('<option value="José Félix Ribas">José Félix Ribas</option>'+
                                        '<option value="Castor Nieves Ríos">Castor Nieves Ríos</option>'+
                                        '<option value="Las Guacamayas">Las Guacamayas</option>'+
                                        '<option value="Pao de Zárate">Pao de Zárate</option>'+
                                        '<option value="Zuata">Zuata</option>');
                break;
                case 'José Rafael Revenga':
                    $('#parroquia').html('<option value="José Rafael Revenga">José Rafael Revenga</option>');
                    break;
                case 'Libertador':
                    $('#parroquia').html('<option value="Palo Negro">Palo Negro</option>'+
                                        '<option value="San Martín de Porres">San Martín de Porres</option>');
                    break;
                case 'Mario Briceño Iragorry':
                    $('#parroquia').html('<option value="El Limón">El Limón</option>'+
                                        '<option value="Caña de Azúcar">Caña de Azúcar</option>');
                break;
                case 'Ocumare de la Costa de Oro':
                    $('#parroquia').html('<option value="Ocumare de la Costa">Ocumare de la Costa</option>');
                    break;
                case 'San Casimiro':
                    $('#parroquia').html('<option value="San Casimiro">San Casimiro</option>'+
                                        '<option value="Güiripa">Güiripa</option>'+
                                        '<option value="Ollas de Caramacate">Ollas de Caramacate</option>'+
                                        '<option value="Valle Morín">Valle Morín</option>');
                    break;
                case 'San Sebastián':
                    $('#parroquia').html('<option value="San Sebastián">San Sebastián</option>');
                    break;
                case 'Santiago Mariño':
                    $('#parroquia').html('<option value="Turmero">Turmero</option>'+
                                        '<option value="Arévalo Aponte">Arévalo Aponte</option>'+
                                        '<option value="Chuao">Chuao</option>'+
                                        '<option value="Samán de Güere">Samán de Güere</option>'+
                                        '<option value="Alfredo Pacheco Miranda">Alfredo Pacheco Miranda</option>');
                    break;
                case 'Santos Michelena':
                    $('#parroquia').html('<option value="Santos Michelena">Santos Michelena</option>'+
                                        '<option value="Tiara">Tiara</option>');
                    break;
                case 'Sucre':
                    $('#parroquia').html('<option value="Cagua">Cagua</option>'+
                                        '<option value="Bella Vista">Bella Vista</option>');
                break;
                case 'Tovar':
                    $('#parroquia').html('<option value="Tovar">Tovar</option>');
                    break;
                case 'Urdaneta':
                    $('#parroquia').html('<option value="Urdaneta">Urdaneta</option>'+
                                        '<option value="Las Peñitas">Las Peñitas</option>'+
                                        '<option value="San Francisco de Cara">San Francisco de Cara</option>'+
                                        '<option value="Taguay">Taguay</option>');
                    break;
                case 'Zamora':
                    $('#parroquia').html('<option value="Zamora">Zamora</option>'+
                                        '<option value="Magdaleno">Magdaleno</option>'+
                                        '<option value="San Francisco de Asís">San Francisco de Asís</option>'+
                                        '<option value="Valles de Tucutunemo">Valles de Tucutunemo</option>'+
                                        '<option value="Augusto Mijares">Augusto Mijares</option>');
                    break;
                default:
                    break;
            }

        });   

    });

    function newCantera(){
        var formData = new FormData(document.getElementById("form_new_cantera"));
        // console.log("alo");
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url:'{{route("cantera.store") }}',
            type:'POST',
            contentType:false,
            cache:false,
            processData:false,
            async: true,
            data: formData,
            success: function(response){
                console.log(response);
                if (response.success) {
                    alert('La cantera ha sido registrada exitosamente');
                    $('#form_new_cantera')[0].reset();
                    $('#modal_new_cantera').modal('hide');
                    window.location.href = "{{ route('cantera')}}";
                    
                }else{
                    if (response.nota == 'Rachazado') {
                        $('#modal_new_cantera').modal('hide');
                        $('#modal_info_access_denegado').modal('show');
                        $('#observacion_access').html(response.obv);
                    }else{
                        alert(response.nota);
                    }
                }
            },
            error: function(error){
                
            }
        });
    }


    function editCantera(){
        var formData = new FormData(document.getElementById("form_edit_cantera"));
        // console.log("alo");
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url:'{{route("cantera.editar") }}',
            type:'POST',
            contentType:false,
            cache:false,
            processData:false,
            async: true,
            data: formData,
            success: function(response){
                console.log(response);
                if (response.success) {
                    alert('La cantera ha sido editada exitosamente');
                    $('#form_edit_cantera')[0].reset();
                    $('#modal_edit_cantera').modal('hide');
                    window.location.href = "{{ route('cantera')}}";
                    
                }else{
                    if (response.nota == 'Rachazado') {
                        $('#modal_edit_cantera').modal('hide');
                        $('#modal_info_access_denegado').modal('show');
                        $('#observacion_access').html(response.obv);
                    }else{
                        alert(response.nota);
                    }
                }
            },
            error: function(error){
                
            }
        });
    }


    </script>


  
@stop