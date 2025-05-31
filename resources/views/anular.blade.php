@extends('adminlte::page')

@section('title', 'Consulta')


@section('content')
    


    <main>
        <div class="my-4 pt-5">
           <h1 class="display-6 text-danger text-center fw-bold">Anular | <span class="text-navy">Timbre Fiscal TFE-14</span></h1> 
        </div>
        <div class="d-flex flex-column align-items-center justify-content-center" style="font-size:13px">
           <!-- FORM SEARCH TFE14 -->
            <form id="form_search_tfe" method="post" onsubmit="event.preventDefault(); searchTFE()">
                <label for="timbre" class="form-label"><span class="text-danger">*</span> Ingresa el CORRELATIVO DE PAPEL del Timbre a Anular.</label>
                <div class="d-flex mb-0 pb-0">
                    <input type="text" id="timbre" class="form-control" name="timbre" required>
                    <button type="submit" class="btn btn-primary mb-3 ms-3"> <i class=" bx bx-search-alt"></i> </button>
                </div>
                <span class="text-muted">El número de timbre debe estar sin guión o algun carecter especial.</span>
            </form>
            
        
        </div>
        
        

        <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 bg-white container-fluid bg_arqueo" style="background-image: url({{asset('assets/fondo2.png')}});">
            <div class="p-lg-5 mx-auto" id="content_info_search">
                
                
                

                
            </div>
        </div>


    </main>
    
<!-- *********************************  MODALES ******************************* -->
    <!-- DETALLE VENTA -->
    <div class="modal fade" id="modal_detalle_venta" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="content_detalle_venta">
                
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
@stop

@section('js')
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
    <script src="{{ asset('jss/toastr.js') }}" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" ></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        $(document).ready(function () {
           /////////////////////// DETALLE VENTA
            $(document).on('click','.detalle_venta', function(e) {
                e.preventDefault();
                var venta = $(this).attr('venta');

                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("arqueo.detalle_venta") }}',
                    data: {venta:venta},
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            $('#content_detalle_venta').html(response.html);
                        }else{
                            alert('Disculpe, vuelva a cargar la pagina.');
                        }
                        
                    },
                    error: function() {
                    }
                });
            });

            /////LIMPIAR CONTENT
            $(document).on('click','.nav-link', function(e) {
                $('#content_info_search').html('');
            });
        });

        function searchTFE(){
            var formData = new FormData(document.getElementById("form_search_tfe"));
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url:'{{route("anular.search_tfe") }}',
                type:'POST',
                contentType:false,
                cache:false,
                processData:false,
                async: true,
                data: formData,
                success: function(response){
                    console.log(response);
                    if (response.success) {
                        $('#content_info_search').html(response.html);
                    }else{
                        if (response.html != '')  {
                            $('#content_info_search').html(response.html);
                        }else{
                            alert('Disculpe, ha ocurrido un error. Vuelva a intentarlo.');
                            window.location.href = "{{ route('anular')}}";
                        }
                        
                    }
                },
                error: function(error){
                    
                }
            });
        }



        function anularTFE(){
            var formData = new FormData(document.getElementById("form_anular_tfe"));
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url:'{{route("anular.anular") }}',
                type:'POST',
                contentType:false,
                cache:false,
                processData:false,
                async: true,
                data: formData,
                success: function(response){
                    console.log(response);
                    if (response.success) {
                       alert('TIMBRE ANULADO EXITOSAMENTE.');
                       window.location.href = "{{ route('anular')}}";
                    }else{
                        if (response.nota != '')  {
                            alert(response.nota);
                        }else{
                            alert('Disculpe, ha ocurrido un error. Vuelva a intentarlo.');
                            window.location.href = "{{ route('anular')}}";
                        }
                        
                    }
                },
                error: function(error){
                    
                }
            });
        }


    </script>
  
@stop