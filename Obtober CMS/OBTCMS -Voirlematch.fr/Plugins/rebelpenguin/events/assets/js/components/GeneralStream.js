/**
 * Created by eddy on 08/01/2016.
 */
$(document).ready(function () {
    $('#loading').addClass('ajax-loader');
    $.request('onStreamData',{
        data: {newItem: ''},
        update: {'@GeneralStream': '#generalstream'},
        complete:function(){
            $('#loading').removeClass('ajax-loader');
            $("#buscador").removeClass('hide');
            $("#buscador").addClass('show');
        }
    });
})