@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{asset('vendor/sweetalert.js') }}"></script>
@stop

@section('content')
    <div class="container rounded-4 p-3" style="background-color:#ffff;">
        
        <!-- <h3 class="mb-2 text-navy fw-bold text-center titulo">UCD <span class="text-muted fs-4">(Unidad de Cuenta Dinámica) <span class="text-secondary fs-4">| Actualización </span></span></h3>
        <p class="fs-5 text-center mb-4 text-muted bg-warning-subtle rounded-pill">UCD del día: <span class="fw-bold text-navy">{{$actual->valor}} ({{$actual->moneda}})</span></p> -->
        



        <div>
            <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg" style="background-image: url({{asset('assets/banner-ucd.png')}});">
                <div class="d-flex flex-column h-100 p-4 pb-2 text-shadow-1">
                    <h3 class="pt-5 mt-0 mb-1 display-6 lh-1 fw-bold">UCD | Unidad de Cuenta Dinámica</h3>
                    <ul class="d-flex list-unstyled mt-auto align-items-center ">
                        <li class="me-auto">
                            <!-- <img src="{{asset('assets/M.svg')}}" alt="Bootstrap" width="40" height="40" class="rounded-circle border border-white"> -->
                        </li>
                        <div class="d-flex align-items-center justify-content-end flex-column">
                            <li class="d-flex me-3 fw-bold fs-2">
                                <span>{{$actual->valor}} bs.</span>
                            </li>
                            <li class="d-flex align-items-end fs-6">
                                <small>Moneda: {{$actual->moneda}}</small>
                            </li>
                        </div>
                    </ul>
                </div>
            </div>
        </div>

        <div class="mb-4 d-flex justify-content-center" id="div_btn_update_ucd">
            <button type="button" class="btn bg-success rounded-pill px-3 btn-sm fw-bold d-flex align-items-center text-center" id="btn_update_ucd" data-bs-toggle="modal" data-bs-target="#modal_new_user"> 
                <i class='bx bx-refresh  fs-5 pe-2' ></i> 
                <span>Actualizar</span>
            </button>
        </div>



        <div class="d-flex justify-content-center d-none mt-5 mb-4" style="font-size:13px" id="div_update_ucd">
            <div class="w-25">
                <form id="form_update_ucd" method="post" onsubmit="event.preventDefault(); updateUcd()">
                    <div class="mb-2">
                        <label class="form-label" for="valor">Valor</label><span class="text-danger">*</span>
                        <input type="text" id="valor" class="form-control form-control-sm" name="valor" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="moneda">Moneda</label><span class="text-danger">*</span>
                        <input type="text" id="moneda" class="form-control form-control-sm" name="moneda" required>
                    </div>

                    <div class="d-flex justify-content-center mt-4 mb-3">
                        <button type="button" class="btn btn-secondary btn-sm me-3" data-bs-dismiss="modal" id="btn_cancel_update_ucd">Cancelar</button>
                        <button type="submit" class="btn btn-success btn-sm" >Actualizar</button>
                    </div>
                </form>
                
            </div>
        </div>






        <div class="d-flex justify-content-center">
            <div class="table-responsive w-75" style="font-size:14px">
                <table id="table_ucd" class="table text-center border-light-subtle " style="font-size:13px">
                    <thead>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Valor</th>
                        <th>Moneda</th>
                    </thead>
                    <tbody id="list_canteras" class="border-light-subtle"> 
                    
                        @foreach ( $ucd as $u )            
                            <tr>
                                <td>{{ $u->id }}</td>
                                <td class="text-secondary">
                                    {{ $u->fecha }}
                                </td>
                                <td class="text-navy fw-bold">
                                    {{ $u->valor }}
                                </td>
                                <td class="fw-bold">{{ $u->moneda }}</td>
                            </tr>
                        @endforeach
                    </tbody> 
                    
                </table>
                
            </div>
        </div>
        
       
    </div>
   
    


      

    
    
<!--****************** MODALES **************************-->
    

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
            $('#table_ucd').DataTable({
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
        $(document).ready(function () {
            /////////////habilitar el form para actualizar ucd
            $(document).on('click','#btn_update_ucd', function(e) { 
                $('#div_update_ucd').removeClass('d-none');
                $('#div_btn_update_ucd').addClass('d-none');
            });

            /////////////ocultar el form para actualizar ucd
            $(document).on('click','#btn_cancel_update_ucd', function(e) { 
                $('#div_update_ucd').addClass('d-none');
                $('#div_btn_update_ucd').removeClass('d-none');
            });
        });

            

        function updateUcd(){
            $("#btn_aceptar_edit_user").attr('disabled', true);
            var formData = new FormData(document.getElementById("form_update_ucd"));
            // console.log("alo");
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url:'{{route("ucd.update") }}',
                type:'POST',
                contentType:false,
                cache:false,
                processData:false,
                async: true,
                data: formData,
                success: function(response){
                    console.log(response);
                    if (response.success) {
                        alert('SE HA ACTUALIZADO EL VALOR DEL UCD CORRECTAMENTE.');
                        $('#form_update_ucd')[0].reset();
                        $('#div_update_ucd').addClass('d-none');
                        $('#div_btn_update_ucd').removeClass('d-none');
                        window.location.href = "{{ route('ucd')}}";
                    }else{
                        alert('DISCULPE, HA OCURRIDO UN ERROR AL ACTUALIZAR EL VALOR DEL UCD.');
                    }
                },
                error: function(error){
                    
                }
            });
        }
      
            
    </script>
@stop