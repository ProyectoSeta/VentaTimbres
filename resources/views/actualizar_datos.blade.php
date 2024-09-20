@extends('adminlte::page')

@section('title', 'Configuración')

@section('content_header')
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{asset('vendor/sweetalert.js') }}"></script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
@stop

@section('content')
    <div class="container rounded-4 p-3" style="background-color:#ffff;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class=" text-navy fw-bold titulo me-3">Mis Datos <span class="text-secondary fs-4">| Actualización </span></h3>

            <div class="text-end">
                <h5 class="text-secondary  mb-0 titulo">{{$sp->razon_social}}</h5>
                <span class="text-muted">{{$sp->rif_condicion}}-{{$sp->rif_nro}}</span>
            </div>
        </div>  

        <div class="row" style="font-size:12.7px">
            <div class="col-xl-8">
                <form id="form_edit_data_user" method="post" onsubmit="event.preventDefault(); editUser()">
                    <!-- DATOS DEL USUARIO -->
                    <h5 class="text-navy titulo text-center fw-bold">Datos del Usuario</h5>
                    <div class="mb-2">
                        <label class="form-label" for="correo">Correo Electrónico</label><span class="text-danger">*</span>
                        <input type="email" id="correo" name="correo" class="form-control form-control-sm" value="{{ $sp->email}}" placeholder="example@gmail.com" disabled>
                        <p class="text-end text-muted mb-0" style="font-size:12px;">Ejemplo: ejemplo@gmail.com</p>
                    </div>

                    <!-- DATOS DEL CONTRIBUYENTE -->
                    <h5 class="text-navy titulo text-center fw-bold my-4">Datos del Contribuyente</h5>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="mb-3">
                                <label class="form-label" for="rif_condicion_sp">R.I.F.</label><span class="text-danger">*</span>
                                <div class="row">
                                    <div class="col-4">
                                        <select class="form-select form-select-sm" id="rif_condicion_sp" aria-label="Default select example" name="rif_condicion_sp" disabled>
                                            @php
                                                if($sp->rif_condicion == 'G'){
                                            @endphp
                                                <option value="G" id="rif_gubernamental">G</option>
                                                <option value="J" id="rif_juridico">J</option>
                                            @php
                                                }else{
                                            @endphp
                                                <option value="J" id="rif_juridico">J</option>
                                                <option value="G" id="rif_gubernamental">G</option>
                                            @php  
                                                }
                                            @endphp
                                        </select>
                                    </div>
                                    
                                    <div class="col-8">
                                        <input type="number" id="rif_nro_sp" class="form-control form-control-sm" name="rif_nro_sp" placeholder="Ejemplo: 30563223" value="{{ $sp->rif_nro}}" disabled>
                                        <!-- <p class="text-end text-muted mb-0" style="font-size:12px;">Ejemplo: 30563223</p> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="mb-3">
                                <label class="form-label" for="razon_social">Razon Social</label><span class="text-danger">*</span>
                                <input type="text" id="razon_social" name="razon_social" class="form-control form-control-sm" value="{{ $sp->razon_social}}" disabled>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label" for="direccion">Dirección</label><span class="text-danger">*</span>
                        <input type="text" id="direccion" name="direccion" class="form-control form-control-sm" value="{{ $sp->direccion}}" disabled>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="tlf_movil_sp">Teléfono Móvil</label><span class="text-danger">*</span>
                                <input type="number" id="tlf_movil_sp" class="form-control form-control-sm" name="tlf_movil_sp" value="{{ $sp->tlf_movil}}" placeholder="Ejemplo: 04125231102" disabled>
                                <p class="text-end text-muted mb-0" style="font-size:12px;">Ejemplo: 04125231102</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="tlf_fijo_sp">Teléfono Fijo</label>
                                <input type="number" id="tlf_fijo_sp" class="form-control form-control-sm" name="tlf_fijo_sp" value="{{ $sp->tlf_fijo}}" placeholder="Ejemplo: 02432632201" disabled>
                                <p class="text-end text-muted mb-0" style="font-size:12px;">Ejemplo: 02432632201</p>
                            </div>
                        </div>
                    </div>
                    

                    <!-- DATOS DEL REPRESENTANTE LEGAL -->
                    <h5 class="text-navy titulo text-center fw-bold my-4">Datos del Representante Legal</h5>
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label class="form-label" for="ci_condicion_repr">C.I. del Representante</label><span class="text-danger">*</span>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <select class="form-select form-select-sm" id="ci_condicion_repr" aria-label="Default select example" name="ci_condicion_repr" disabled>
                                        @php
                                            if($sp->ci_condicion_repr == 'V'){
                                        @endphp
                                            <option value="V">V</option>
                                            <option value="E">E</option>
                                        @php
                                            }else{
                                        @endphp
                                            <option value="E">E</option>
                                            <option value="V">V</option>
                                        @php  
                                            }
                                        @endphp
                                    </select>
                                </div>
                                
                                <div class="col-8">
                                    <input type="number" id="ci_nro_repr" class="form-control form-control-sm" name="ci_nro_repr" value="{{ $sp->ci_nro_repr}}" placeholder="Ejemplo: 8456122" disabled>
                                    <p class="text-end text-muted mb-0" style="font-size:12px;">Ejemplo: 8456122</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="rif_nro_repr">R.I.F.</label><span class="text-danger">*</span>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <select class="form-select form-select-sm" id="rif_condicion_repr" aria-label="Default select example" name="rif_condicion_repr" disabled>
                                        @php
                                            if($sp->rif_condicion_repr == 'V'){
                                        @endphp
                                            <option value="V">V</option>
                                            <option value="E">E</option>
                                        @php
                                            }else{
                                        @endphp
                                            <option value="E">E</option>
                                            <option value="V">V</option>
                                        @php  
                                            }
                                        @endphp
                                    </select>
                                </div>
                                
                                <div class="col-8">
                                    <input type="number" id="rif_nro_repr" class="form-control form-control-sm" name="rif_nro_repr" value="{{ $sp->rif_nro_repr}}" placeholder="Ejemplo: 084561221" disabled>
                                    <p class="text-end text-muted mb-0" style="font-size:12px;">Ejemplo: 084561221</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <label class="form-label" for="nombre_repr">Nombre y Apellido</label><span class="text-danger">*</span>
                            <input type="text" id="nombre_repr" class="form-control form-control-sm" name="nombre_repr" value="{{ $sp->name_repr}}" disabled>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="tlf_movil_repr">Teléfono móvil</label><span class="text-danger">*</span>
                            <input type="number" id="tlf_movil_repr" class="form-control form-control-sm" name="tlf_movil_repr" value="{{ $sp->tlf_repr}}" disabled>
                            <p class="text-end text-muted mb-0" style="font-size:12px;">Ejemplo: 04125231102</p>
                        </div>
                    </div>
                    
                    <p class="text-muted text-end"><span style="color:red">*</span> Campos requeridos.</p>
                    <input type="hidden" value="{{$sp->id_sujeto}}" name="id_sujeto">


                    <div class="d-flex justify-content-center mb-4" id="div_edit_user">
                        <button type="button" class="btn btn-primary btn-sm" id="edit_data_user">Editar datos</button>
                    </div>


                    <div class="d-flex justify-content-center d-none mb-4" id="btns_edit_user">
                        <button type="submit" class="btn btn-success btn-sm me-3">Actualizar</button>
                        <button type="button" class="btn btn-secondary btn-sm" id="cancelar_edit_user">Cancelar</button>
                    </div>
                </form>
           </div> <!--  cierra cols-sm-8 -->


            <div class="col-xl-4">
                <!-- PARTE 1 -->
                <div class="d-flex justify-content-center">
                    <table class="table w-50 text-center table-borderless table-sm">
                        <tr>
                            <td>
                                <div class="text-center">
                                    <img src="{{asset('assets/icon-user.svg')}}" class="rounded-circle w-50" alt="...">
                                </div>
                            </td>
                            <td>
                                <div class="text-center">
                                    <img src="{{asset('assets/icon-cantera.svg')}}" class="rounded-circle w-50" alt="...">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="titulo text-navy fs-5 px-3">Usuario</th>
                            <th class="titulo text-navy fs-5 px-3">Canteras</th>
                        </tr>
                        <tr>
                            <td class="text-muted fs-6">{{$sp->estado}}</td>
                            <td class="text-muted fs-6">{{$canteras->total}}</td>
                        </tr>
                    </table>
                </div>

                <div class="d-flex justify-content-center mb-3">
                    <img src="{{asset('assets/banner-micuenta.svg')}}" class="rounded" alt="...">
                </div>
                <div class="d-flex justify-content-center">
                    <img src="{{asset('assets/banner-micuenta-2.svg')}}" class="rounded" alt="...">
                </div>
            </div> <!--  cierra cols-sm-4 -->
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
            
            $(document).on('click','#div_edit_user', function(e) { 
                e.preventDefault(e); 
                $("#correo").attr('disabled', false);
                $("#pass").attr('disabled', false);
                $("#confirmar").attr('disabled', false);

                $("#razon_social").attr('disabled', false);
                $("#direccion").attr('disabled', false);
                $("#tlf_movil_sp").attr('disabled', false);
                $("#tlf_fijo_sp").attr('disabled', false);

                $("#rif_condicion_repr").attr('disabled', false);
                $("#rif_nro_repr").attr('disabled', false);
                $("#ci_condicion_repr").attr('disabled', false);
                $("#ci_nro_repr").attr('disabled', false);
                $("#nombre_repr").attr('disabled', false);
                $("#tlf_movil_repr").attr('disabled', false);

                $("#div_edit_user").addClass('d-none');
                $('#btns_edit_user').removeClass('d-none');
            });

            ///////CANCELAR: DATOS CONTRIBUYENTE
            $(document).on('click','#cancelar_edit_user', function(e) { 
                e.preventDefault(e); 
                $("#correo").attr('disabled', true);
                $("#pass").attr('disabled', true);
                $("#confirmar").attr('disabled', true);

                $("#razon_social").attr('disabled', true);
                $("#direccion").attr('disabled', true);
                $("#tlf_movil_sp").attr('disabled', true);
                $("#tlf_fijo_sp").attr('disabled', true);

                $("#rif_condicion_repr").attr('disabled', true);
                $("#rif_nro_repr").attr('disabled', true);
                $("#ci_condicion_repr").attr('disabled', true);
                $("#ci_nro_repr").attr('disabled', true);
                $("#nombre_repr").attr('disabled', true);
                $("#tlf_movil_repr").attr('disabled', true);

                $("#div_edit_user").removeClass('d-none');
                $('#btns_edit_user').addClass('d-none');
               
            });

           
        });

        function editUser(){
            var formData = new FormData(document.getElementById("form_edit_data_user"));
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url:'{{route("actualizar_datos.editar") }}',
                    type:'POST',
                    contentType:false,
                    cache:false,
                    processData:false,
                    async: true,
                    data: formData,
                    success: function(response){
                        console.log(response);
                        if (response.success) {
                            alert('ACTUALIZACIÓN DE DATOS EXITOSO');
                            window.location.href = "{{ route('actualizar_datos')}}";
                        } else {
                            alert('Ha ocurrido un error al Actualizar los Datos.');
                        } 

                    },
                    error: function(error){
                        
                    }
                });
        }

   
        
    </script>
  
@stop