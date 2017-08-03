/**
 * Created by eddy on 01/03/2016.
 */
$(document).ready(function () {
    $('#loading').addClass('ajax-loader');
    $.request('onGamepage',{
        data: {newItem: ''},
        update: {'@gamepage': '#game'},
        complete:function(){
            $('#loading').removeClass('ajax-loader');
        }
    });
 })
function data(){
    if($("#articlecaption").hasClass( "show" )=== true){
        $("#articlecaption").removeClass("fadein show").addClass("fadeout hidden");
        $("#articleBody").removeClass("fadeout hidden").addClass("fadein show");
        $("#data").html("Cacher");
    }
    else{
        $("#articlecaption").removeClass("hidden").addClass("show");
        $("#articleBody").removeClass("show").addClass("hidden");
        $("#data").html("Lire plus");
    }
}