/**
 * Created by eddy on 02/03/2016.
 */
$(document).ready(function () {
    $('#loading').addClass('ajax-loader');
    $.request('onStreamPageDinamic',{
        data: {newItem: ''},
        update: {'@streampagedinamic': '#streampagedinamic'},
        complete:function(){
            $('#loading').removeClass('ajax-loader');
            $("#buscador").removeClass('hide');
            $("#buscador").addClass('show');
        }
    });
 $('#blogcarousel').carousel({
        interval:"false",
        pause: "true"
    });
})