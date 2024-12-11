@extends('adminlte::page')

@section('title', 'Sedes y Taquillas')

@section('content_header')
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
@stop

@section('content')
    
    <div class="container rounded-4 p-3" style="background-color:#ffff;">
        <div class="row g-4 g-xl-5 mt-1">
			<!-- NUEVA SEDE -->
			<div class="col-sm-6 col-lg-4 mb-4">
				<div class="card text-center rounded-4 p-4 pb-0 position-relative car_trasit shadow-none card-icon-transition" role="button" data-bs-toggle="modal" data-bs-target="#modal_nueva_sede">
                    <!--  -->
                    <div class="position-absolute top-0 start-50 translate-middle">
                        <span class="badge bg-primary rounded-circle p-3">
                            <i class='bx bx-map fs-1'></i>
                        </span>
                    </div>

					<!-- Card body -->
					<div class="card-footer border-0 bg-transparent pt-4 pb-2">
						<h6 class="mb-3 titulo fw-bold text-navy fs-4">Nueva Sede</h6>
                        <p class="text-muted">Haz click y crea una nueva sede de la institución.</p>
						<!-- <a href="#" class="btn btn-sm btn-secondary">Crear</a> -->
					</div>
				</div>
                <div class="text-center">
                    <button type="button" class="btn btn-secondary btn-sm" id="btn_ver_sedes">Ver Sedes</button>
                </div>
			</div>

            <!-- NUEVO TAQUILLERO -->
            <div class="col-sm-6 col-lg-4 mb-4">
				<div class="card text-center rounded-4 p-4 pb-0 position-relative car_trasit shadow-none" role="button" data-bs-toggle="modal" data-bs-target="#modal_nuevo_taquillero">
                    <!--  -->
                    <div class="position-absolute top-0 start-50 translate-middle">
                        <span class="badge bg-info rounded-circle p-3">
                            <i class='bx bx-user-circle fs-1'></i>
                        </span>
                    </div>

					<!-- Card body -->
					<div class="card-footer border-0 bg-transparent pt-4 pb-2">
						<h6 class="mb-3 titulo fw-bold text-navy fs-4">Nuevo Taquillero</h6>
                        <p class="text-muted">Haz click y crea una nueva sede de la institución.</p>
						<!-- <a href="#" class="btn btn-sm btn-secondary">Crear</a> -->
					</div>
				</div>
                <div class="text-center">
                    <button type="button" class="btn btn-secondary btn-sm">Ver Taquilleros</button>
                </div>
			</div>

            <!-- NUEVA TAQUILLA -->
            <div class="col-sm-6 col-lg-4 mb-4" id="new_taquilla">
				<div class="card text-center rounded-4 p-4 pb-0 position-relative car_trasit shadow-none" role="button" data-bs-toggle="modal" data-bs-target="#modal_nueva_taquilla">
                    <!--  -->
                    <div class="position-absolute top-0 start-50 translate-middle">
                        <span class="badge bg-warning rounded-circle p-3">
                            <i class='bx bxs-carousel fs-1 text-white'></i>
                        </span>
                    </div>

					<!-- Card body -->
					<div class="card-footer border-0 bg-transparent pt-4 pb-2">
						<h6 class="mb-3 titulo fw-bold text-navy fs-4">Nueva Taquilla</h6>
                        <p class="text-muted">Haz click y crea una nueva sede de la institución.</p>
						<!-- <a href="#" class="btn btn-sm btn-secondary">Crear</a> -->
					</div>
				</div>
                <div class="text-center">
                    <button type="button" class="btn btn-secondary btn-sm">Ver Taquillas</button>
                </div>
			</div>
		</div>


        <div id="content_ver_registros">
            <div class="d-flex justify-content-between align-items-center mb-2 mt-5">
                <h3 class="mb-3 text-navy titulo fw-bold">Taquillas <span class="text-secondary fs-4">| Registradas</span></h3>
            </div>

            <div class="table-responsive" style="font-size:12.7px">
                <table id="taquillas" class="table text-center border-light-subtle" style="font-size:12.7px">
                    <thead>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Detalle</th>
                        <th>¿Recibido?</th> 
                    </thead>
                    <tbody class="border-light-subtle"> 
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody> 
                </table>
            </div>
        </div>

        

        
    </div>
    
    

      

    
    
<!--****************** MODALES **************************-->
    <!-- ************ NUEVA SEDE  ************** -->
    <div class="modal fade" id="modal_nueva_sede" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_nueva_sede">
                <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class='bx bx-plus-circle fs-2 text-muted me-2'></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">Nueva Sede</h1>
                        <span>Agrega una nueva sede foránea</span>
                    </div>
                </div> 
                <div class="modal-body px-5 py-3" style="font-size:13px">
                    <form id="form_nueva_sede" method="post" onsubmit="event.preventDefault(); nuevaSede()">
                        
                        <div class="row d-flex align-items-center mt-3">
                            <div class="col-3">
                                <label for="clave" class="form-label">Ubicación:<span class="text-danger"> *</span></label>
                            </div>
                            <div class="col-9">
                                <input type="text" id="ubicacion" class="form-control form-control-sm" name="ubicacion" required>
                            </div>
                        </div>

                        <p class="text-muted text-end"><span style="color:red">*</span> Campo requerido.</p>

                        <div class="d-flex justify-content-center mt-3 mb-3">
                            <button type="button" class="btn btn-secondary btn-sm me-2" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success btn-sm">Aceptar</button>
                        </div>
                    </form>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>


    <!-- ************ NUEVO TAQUILLERO  ************** -->
    <div class="modal fade" id="modal_nuevo_taquillero" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="content_nueo_taquillero">
                <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class='bx bx-plus-circle fs-2 text-muted me-2'></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">Nuevo Taquillero</h1>
                        <span>Agrega un nuevo Taquillero</span>
                    </div>
                </div> 
                <div class="modal-body px-5 py-3" style="font-size:13px">
                    <form id="form_nuevo_taquillero" method="post" onsubmit="event.preventDefault(); nuevoTaquillero()">
                        <p class="text-navy fw-bold fs-6 my-2">Datos generales</p>
                        <div class="row mb-4">
                            <!-- ci -->
                            <div class="col-sm-4">
                                <label for="ci_nro" class="form-label">C.I.:<span class="text-danger"> *</span></label>
                                <div class="row">
                                    <div class="col-4">
                                        <select class="form-select form-select-sm" aria-label="Small select example" id="ci_condicion" name="ci_condicion">
                                            <option value="V">V</option>
                                            <option value="E">E</option>
                                        </select>
                                    </div>
                                    <div class="col-8">
                                        <input type="number" id="ci_nro" class="form-control form-control-sm" name="ci_nro" required>
                                    </div>
                                </div>
                            </div>
                            <!-- nombre -->
                            <div class="col-sm-4">
                                <label for="nombre" class="form-label">Nombre Completo:<span class="text-danger"> *</span></label>
                                <input type="text" id="nombre" class="form-control form-control-sm" name="nombre" required>
                            </div>
                            <!-- cargo -->
                            <div class="col-sm-4">
                                <label for="cargo" class="form-label">Cargo:<span class="text-danger"> *</span></label>
                                <input type="text" class="form-control form-control-sm" value="Taquillero" disabled>
                            </div>
                        </div>

                        <p class="text-navy fw-bold fs-6 my-2">Datos del Usuario</p>
                        <div class="row">
                            <!-- email -->
                            <div class="col-sm-4">
                                <label class="form-label" for="email">Correo electrónico</label><span class="text-danger"> *</span>
                                <input type="email" id="email" class="form-control form-control-sm" placeholder="example@gmail.com" name="email" value="{{ old('email') }}" required autocomplete="email">
                            </div>
                            <!-- pass -->
                            <div class="col-sm-4">
                                <label class="form-label" for="password">Contraseña</label><span class="text-danger"> *</span>
                                <input type="password" id="password" class="form-control form-control-sm" name="password" required>
                            </div>
                            <!-- confirm pass -->
                            <div class="col-sm-4">
                                <label for="password-confirm" class="form-label">Confirmar Contraseña</label><span class="text-danger"> *</span>
                                <input id="password-confirm" type="password" class="form-control form-control-sm"  name="password_confirmation" required>
                            </div>
                        </div>

                        <p class="text-muted text-end"><span style="color:red">*</span> Campos requeridos.</p>

                        <div class="text-muted mt-2 mb-3" style="font-size:14px">
                            <span>La Contraseña debe contener:</span> 
                            <ol>
                                <li>Mínimo 8 caracteres.</li>
                                <li>Caracteres alfanuméricos.</li>
                                <li>Caracteres especiales (Ejemplo: ., @, $, *, %, !, &, entre otros.).</li>
                            </ol>
                        </div>

                        <div class="d-flex justify-content-center mt-3 mb-3">
                            <button type="button" class="btn btn-secondary btn-sm me-2" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success btn-sm">Aceptar</button>
                        </div>
                    </form>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>


    <!-- ************ NUEVA TAQUILLA  ************** -->
    <div class="modal fade" id="modal_nueva_taquilla" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_nueva_taquilla">
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
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
    <script src="{{ asset('jss/datatable.min.js') }}" defer ></script>
    <!-- <script src="{{ asset('jss/datatable.bootstrap.js') }}" ></script> -->
    <script src="{{ asset('jss/toastr.js') }}" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" ></script>
   
    <script type="text/javascript">
        $(document).ready(function () {
            $('#taquillas').DataTable(
                {
                    // "order": [[ 0, "desc" ]],
                    "language": {
                        "lengthMenu": " Mostrar  _MENU_  Registros por página",
                        "zeroRecords": "No hay Timbres Forma 14 asignados a esta Taquilla.",
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
           ///////////////// MODAL NUEVA TAQUILLA
           $(document).on('click', '#new_taquilla', function(e){ 
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("sede_taquilla.modal_new_taquilla") }}',
                    success: function(response) {
                        $('#content_nueva_taquilla').html(response);
                        
                    },
                    error: function() {
                    }
                });
            });

            ///////////////// VER SEDES
           $(document).on('click', '#btn_ver_sedes', function(e){ 
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("sede_taquilla.sedes") }}',
                    success: function(response) {
                        $('#content_ver_registros').html(response);
                        
                    },
                    error: function() {
                    }
                });
            });

        });

        function nuevaSede(){
            var formData = new FormData(document.getElementById("form_nueva_sede"));
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url:'{{route("sede_taquilla.new_sede") }}',
                    type:'POST',
                    contentType:false,
                    cache:false,
                    processData:false,
                    async: true,
                    data: formData,
                    success: function(response){
                        console.log(response);
                        if (response.success) {
                            alert('REGISTRO DE SEDE EXITOSO.');
                            window.location.href = "{{ route('sede_taquilla')}}";
                        }else{
                            alert('Disculpe, ha ocurrido un error.');
                        }  
                    },
                    error: function(error){
                        
                    }
                });
        }

        function nuevaTaquilla(){
            var formData = new FormData(document.getElementById("form_nueva_taquilla"));
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url:'{{route("sede_taquilla.new_taquilla") }}',
                    type:'POST',
                    contentType:false,
                    cache:false,
                    processData:false,
                    async: true,
                    data: formData,
                    success: function(response){
                        console.log(response);
                        if (response.success) {
                            alert('REGISTRO DE TAQUILLA EXITOSO.');
                            window.location.href = "{{ route('sede_taquilla')}}";
                        }else{
                            if (response.nota != '') {
                                alert(response.nota);
                            }else{
                                alert('Disculpe, ha ocurrido un error.');
                            }
                            
                        }  
                    },
                    error: function(error){
                        
                    }
                });
        }

        function nuevoTaquillero(){
            var formData = new FormData(document.getElementById("form_nuevo_taquillero"));
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url:'{{route("sede_taquilla.new_taquillero") }}',
                    type:'POST',
                    contentType:false,
                    cache:false,
                    processData:false,
                    async: true,
                    data: formData,
                    success: function(response){
                        console.log(response);
                        if (response.success) {
                            alert('REGISTRO DE TAQUILLERO EXITOSO.');
                            window.location.href = "{{ route('sede_taquilla')}}";
                        }else{
                            if (response.error != '') {
                                alert(response.error);
                            }else{
                                alert('Disculpe, ha ocurrido un error.');
                            }
                            
                        }  
                    },
                    error: function(error){
                        
                    }
                });
        }


    </script>


  
@stop