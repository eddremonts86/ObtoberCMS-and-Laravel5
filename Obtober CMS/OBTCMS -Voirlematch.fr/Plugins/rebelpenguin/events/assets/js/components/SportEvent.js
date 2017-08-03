/**
 * Created by eddy on 11/12/2015.
 */
$(document).ready(function () {
    $('#loading').addClass('ajax-loader');
    $.request('onInitData',{
        data: {newItem: ''},
        update: {'@sportevents': '#sportevents'},
        complete:function(){
            $('#loading').removeClass('ajax-loader');
            $("#buscador").removeClass('hide');
            $("#buscador").addClass('show');
        }
    });
    $('#edit').on( "click", function() {
        console.log( $( this ).text() );
    });


    $('#blogcarousel').carousel({
        interval:"false",
        pause: "true"
    });
})