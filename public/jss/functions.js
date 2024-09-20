$(document).ready(function () {
    ShowCantera();
    console.log('aaaaaa');
    
});

function ShowCantera(){
    $.get("{{ URL::to('resource/view/cantera') }}", function(data){
        $('#list_canteras').empty().html(data);
    })
}