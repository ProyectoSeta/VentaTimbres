@extends('adminlte::page')

@section('title', 'Configuración')

@section('content_header')
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{asset('vendor/sweetalert.js') }}"></script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
@stop

@section('content')
    <div class="container rounded-4 p-3 pt-1" style="background-color:#ffff;">
        <div class="d-flex align-items-center mb-4">
            <h3 class="mb-3 text-navy fw-bold titulo">Administración <span class="text-secondary fs-4">| Configuración de datos </span></h3>
        </div> 

        <div class="table-responsive" style="font-size:14px">
            <table id="example" class="table text-center border-light-subtle" style="font-size:12.7px">
                <thead>
                    <th></th>
                    <th>Acción</th>
                    <th>(Día / Cant.)</th>
                    <th>Opción</th> 
                </thead>
                <tbody id="list_canteras" class="border-light-subtle"> 
                    @foreach ($variables as $var)
                        <tr>
                            <td>{{$var->id}}</td>
                            <td>
                                @switch($var->nombre)
                                    @case('cierre_libro')
                                        Cierre de Libro
                                    @break
                                    @case('inicio_declaracion')
                                        Primer día para Declarar
                                    @break
                                    @case('fin_declaracion')
                                        Ultimo día para Declarar
                                    @break
                                    @case('talonarios_min_imprenta')
                                        Nro. Mínimo de Talonarios que se pueden mandar a la Imprenta
                                    @break
                                    @default
                                @endswitch
                            </td>
                            <td>
                                @if ($var->nombre == 'talonarios_min_imprenta')
                                    {{$var->valor}} Unidades
                                @else
                                    Día {{$var->valor}}
                                @endif
                            </td>
                            <td>
                                <span class="badge editar_variable" style="background-color: #169131;" role="button" data-bs-toggle="modal" variable="{{$var->id}}" data-bs-target="#modal_editar_variable">
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
    <!-- ********* ACTUALIZAR CONTRASEÑA ******** -->
    <div class="modal fade" id="modal_editar_variable" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" id="content_editar_variable">
                
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
            ///////MODAL: EDITAR VARIABLE
            $(document).on('click','.editar_variable', function(e) { 
                e.preventDefault(e); 
                var variable = $(this).attr('variable');
                // alert(cantera);
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("config.modal") }}',
                    data: {variable:variable},
                    success: function(response) {
                        // console.log(response);                 
                        $('#content_editar_variable').html(response);
                    },
                    error: function() {
                    }
                });
            });
           
           
        });

        function editarVariable(){
            var formData = new FormData(document.getElementById("form_editar_variable"));
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url:'{{route("config.update") }}',
                type:'POST',
                contentType:false,
                cache:false,
                processData:false,
                async: true,
                data: formData,
                success: function(response){
                    // console.log(response);
                    if (response.success) {
                        alert('LA ACCIÓN FUE ACTUALIZADA CORRECTAMENTE');
                        window.location.href = "{{ route('config')}}";
                    } else {
                        alert('Disculpe, ha ocurrido un error al actualizar la variable.');
                    } 

                },
                error: function(error){
                    
                }
            });
        }

   
        
    </script>
  
@stop