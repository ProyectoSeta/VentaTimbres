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
        <div class="row mb-3">
            <div class="col-md-6">
               <h3 class="text-navy titulo fw-bold fs-3">Emision de Denominaciones UCD</h3> 
               <h4 class="titulo text-muted fs-3">Estampillas</h4>
            </div>
            
            <div class="col-md-6 zoom_text px-5">
                <div class="text-center mb-3">
                    <h3 class=" fs-4 fw-bold titulo text-nay " style="color: #004cbd"><span class="text-muted">Lote Papel de Seguridad | </span>Estampillas</h3>
                </div>
                <div class="">
                    <div class="row">
                        <div class="col-lg -8 d-flex flex-column">
                            <div class=" fs-4 text-navy fw-bold" >Disponible en Inventario</div>
                            <div class="text-secondary">Para emitir denominaciones UCD</div>
                        </div>
                        <div class="col-lg -4">
                            <div class="fs-2 text-primary fw-bold bg-primary-subtle text-center rounded-4  px-2">{{$total_estampillas}} <span class="fs-5">Und.</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- cierra row -->


        <div class="text-center mb-3 mt-5">
            <h3 class=" fs-4 fw-bold titulo text-nay " style="color: #004cbd"><span class="text-muted">Estampillas por denominación | </span>Inventario</h3>
        </div>


        <div class="row gap-2">
            @foreach ($deno as $de)
                <div class="col border py-2 px-3 rounded-3">
                    <div class="row">
                        <div class="col-md-5">
                            <div class=" fs-4 text-navy fw-bold" >{{$de->denominacion}} UCD</div>
                            <div class="text-secondary">En Inventario</div>
                        </div>
                        <div class="col-md-7 d-flex align-items-center">
                            <div class="fs-2  fw-bold bg-dark-subtle text-center rounded-3 px-3">{{$de->total_timbres}} <span class="fs-5">Und.</span></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>


        <div class="d-flex justify-content-center my-4 mt-5">    
            <button type="button" class="btn bg-navy rounded-pill px-3 btn-sm fw-bold d-flex align-items-center" id="btn_emitir_ucd_estampillas" data-bs-toggle="modal" data-bs-target="#modal_emitir_ucd_estampillas">
                <i class='bx bx-plus fw-bold fs-6 pe-2'></i>
                <span>Emitir UCD Estampillas</span>
            </button>
        </div>


        <div class="table-responsive" style="font-size:12.7px">
            <table id="emisiones_ucd" class="table text-center border-light-subtle" style="font-size:12.7px">
                <thead>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Denominación</th>
                    <th>Cantidad</th>
                    <th>Detalle</th>  <!-- fecha entrega, emitidos en ucd, user -->
                    <th>Opción</th>  
                </thead>
                <tbody id="" class="border-light-subtle"> 
                        
                </tbody> 
            </table>
        </div>





        

        





        

        

    </div>
    
    

    

    
    
<!--****************** MODALES **************************-->
    <!-- ************ EMISIÓN ESTAMPILLAS POR DENOMINACIÓN  ************** -->
    <div class="modal fade" id="modal_emitir_ucd_estampillas" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_emitir_ucd_estampillas">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ************ CORRELATIVO ESTAMPILLAS X DENO  ************** -->
    <div class="modal fade" id="modal_correlativo_ucd_estampillas" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_correlativo_ucd_estampillas">
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
            $('#emisiones_ucd').DataTable(
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
        ///////////////////////////////////////AGREGAR CAMPOS A OTRA(S) DENOMINACIONES
            var maxFieldTramite = 2; //Input fields increment limitation
            var c = 1; //Initial field counter is 1

            $(document).on('click', '.add_button', function(e){ //Once add button is clicked
                if(c < maxFieldTramite){ //Check maximum number of input fields
                    c++; //Increment field counter

                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        type: 'POST',
                        url: '{{route("emision_ucd.denominacions") }}',
                        success: function(response) {
                            // console.log(response);
                            $('#row_emision_ucd').append('<div class="row">'+
                                    '<div class="col-md-5">'+
                                        '<select class="form-select form-select-sm denominacion" id="denominacion_'+c+'" i="'+c+'" name="emitir['+c+'][denominacion]">'+
                                            response+
                                        '</select>'+
                                    '</div>'+
                                    '<div class="col-md-6">'+
                                        '<input type="number" class="form-control form-control-sm cantidad" id="cantidad_'+c+'" i="'+c+'"  name="emitir['+c+'][cantidad]" required>'+
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
      
        /////////////////////////// MODAL EMITIR ESTAMPILLAS POR DENOMINACION
        $(document).on('click','#btn_emitir_ucd_estampillas', function(e) {
            e.preventDefault();
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("emision_ucd.modal_emitir") }}',
                success: function(response) {
                    // console.log(response);
                    $('#content_emitir_ucd_estampillas').html(response);
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


    });

    function emitirEstampillasUcd(){
        var formData = new FormData(document.getElementById("form_emitir_estampillas_ucd"));
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url:'{{route("emision_ucd.emitir_denominacion") }}',
            type:'POST',
            contentType:false,
            cache:false,
            processData:false,
            async: true,
            data: formData,
            success: function(response){
                console.log(response);
                $('#content_emitir_ucd_estampillas').html('<div class="my-5 py-5 d-flex flex-column text-center">'+
                                                            '<i class="bx bx-loader-alt bx-spin fs-1 mb-3" style="color:#0077e2"  ></i>'+
                                                            '<span class="text-muted">Cargando, por favor espere un momento...</span>'+
                                                        '</div>');
                if (response.success) {
                    $('#modal_emitir_ucd_estampillas').modal('hide');
                    $('#modal_correlativo_ucd_estampillas').modal('show');
                    $('#content_correlativo_ucd_estampillas').html(response.html);
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


  

    

</script>


  
@stop