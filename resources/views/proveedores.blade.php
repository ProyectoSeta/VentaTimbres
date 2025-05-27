@extends('adminlte::page')

@section('title', 'Proveedores')

@section('content_header')
    <!-- <script src="{{ asset('jss/bundle.js') }}" defer></script> -->
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <!-- <script src="{{asset('vendor/sweetalert.js') }}"></script> -->
@stop

@section('content')
    <div class="container rounded-4 p-3" style="background-color:#ffff;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-3 text-navy fw-bold titulo">Proveedores <span class="text-secondary fs-4">| Papel de Seguridad</span></h3>
            @can('proveedores.store')
                <div class="mb-3">
                    <button type="button" class="btn bg-navy rounded-pill px-3 btn-sm fw-bold d-flex align-items-center" id="new_prov" data-bs-toggle="modal" data-bs-target="#modal_new_prov"> 
                        <i class='bx bx-plus fw-bold fs-6 pe-2'></i>
                        <span>Nuevo Proveedor</span>
                    </button>
                </div> 
            @endcan
            
        </div>

        
        <div class="table-responsive" style="font-size:12.7px">
            <table id="table_proveedores" class="table display border-light-subtle text-center" style="width:100%; font-size:13px">
                <thead class="bg-primary border-light-subtle">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Razón Social</th>
                            <th scope="col">R.I.F.</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Dirección</th>
                            <th scope="col">Representante</th>
                            <th scope="col">Contacto</th>
                        </tr>
                </thead>
                <tbody>
                    @foreach ($proveedores as $proveedor)
                        <tr>
                            <td>{{ $proveedor->id_proveedor }}</td>
                            <td class="text-navy fw-semibold">{{ $proveedor->razon_social }}</td>
                            <td><span class="text-muted">{{ $proveedor->condicion_identidad }}-{{ $proveedor->nro_identidad}}</span></td>
                            <td>{{ $proveedor->email }}</td>
                            <td><span class="text-muted fst-italic">{{ $proveedor->direccion }}</span></td>
                            <td class="text-navy fst-italic">{{ $proveedor->nombre_representante }}</td>
                            <td class="fw-semibold">
                                {{ $proveedor->tlf_movil }} 
                                @if ($proveedor->tlf_fijo != NULL)
                                    | 
                                    {{ $proveedor->tlf_fijo }} 
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        

       
    </div>
   
    


      

    
    
<!--****************** MODALES **************************-->
     

    <!-- ********* REGISTRO DE NUEVO PROVEEDOR ******* -->
    <div class="modal" id="modal_new_prov" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="html_info_prov">
                <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-plus fs-2 text-navy"></i>                       
                        <h1 class="modal-title fw-bold text-navy fs-5" id="exampleModalLabel">Nuevo Proveedor</h1>
                    </div>
                </div>
                <div class="modal-body px-4" style="font-size:13px">
                    <form id="form_new_prov" method="post" onsubmit="event.preventDefault(); newProveedor()">
                        <div class="mb-2">
                            <label class="form-label" for="razon">Razón Social</label><span class="text-danger">*</span>
                            <input type="text" id="razon" class="form-control form-control-sm" name="razon" required>
                        </div>

                        <div class="row mb-2">
                            <div class="col-6">
                                <label class="form-label" for="rif_condicion">R.I.F</label><span class="text-danger">*</span>
                                <div class="row">
                                    <div class="col-4">
                                        <select class="form-select form-select-sm" id="rif_condicion" name="rif_condicion" required>
                                            <option value="J">J</option>
                                            <option value="G">G</option>
                                        </select>
                                    </div>
                                    <div class="col-8">
                                        <input type="number" id="rif_nro" class="form-control form-control-sm" name="rif_nro" placeholder="Ejemplo: 8456122" required>
                                        <p class="text-end text-muted mb-0" style="font-size:12px;">Ejemplo: 8456122</p>
                                    </div>
                                </div>                                
                            </div>
                            <div class="col-6">
                                <label class="form-label" for="direccion">Dirección</label><span class="text-danger">*</span>
                                <input type="text" id="direccion" name="direccion" class="form-control form-control-sm"  required>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="form-label" for="email">Correo Electrónico</label><span class="text-danger">*</span>
                            <input type="email" id="email" name="email" class="form-control form-control-sm" placeholder="example@gmail.com" required>
                            <p class="text-end text-muted mb-0" style="font-size:12px;">Ejemplo: ejemplo@gmail.com</p>
                        </div>

                        <div class="mb-2">
                            <label class="form-label" for="nombre">Nombre del Representante</label><span class="text-danger">*</span>
                            <input type="text" id="nombre" class="form-control form-control-sm" name="nombre" required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label" for="tlf_movil">Teléfono Móvil</label><span class="text-danger">*</span>
                            <input type="text" id="tlf_movil" class="form-control form-control-sm" name="tlf_movil" required>
                            <p class="text-end text-muted mb-0" style="font-size:12px;">Ejemplo: 0414-4521325</p>
                        </div>

                        <div class="mb-2">
                            <label class="form-label" for="tlf_fijo">Teléfono Fijo</label>
                            <input type="text" id="tlf_fijo" class="form-control form-control-sm" name="tlf_fijo">
                            <p class="text-end text-muted mb-0" style="font-size:12px;">Ejemplo: 0244-4125412</p>
                        </div>



                        
                        

                        

                        <p class="text-muted text-end"><span style="color:red">*</span> Campos requeridos.</p>
                        

                       

                        <div class="d-flex justify-content-center mt-4 mb-3">
                            <button type="submit" class="btn btn-success btn-sm me-3">Aceptar</button>
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                            
                        </div>
                    </form>
                    

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
    <script src="{{ asset('jss/datatable.bootstrap.js') }}" ></script>
    <script src="{{ asset('jss/toastr.js') }}" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" ></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#table_proveedores').DataTable({
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
            

        });

        function newProveedor(){
            var formData = new FormData(document.getElementById("form_new_prov"));
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url:'{{route("proveedores.store") }}',
                type:'POST',
                contentType:false,
                cache:false,
                processData:false,
                async: true,
                data: formData,
                success: function(response){
                    console.log(response);
                    if (response.success) {
                        alert('PROVEEDOR INGRESADO CORRECTAMENTE.');
                        window.location.href = "{{ route('proveedores')}}";
                        
                    }else{
                      
                    }
                },
                error: function(error){
                    
                }
            });
        }


      
            
    </script>
@stop