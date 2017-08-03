/**
 * Created by eddy on 04/03/2016.
 */
$(document).ready(function () {
    $('#loading').addClass('ajax-loader');
    $.request('onMenuSyst',{
        data: {newItem: ''},
        update: {'@menusistem': '#menusistem'},
        complete:function(){
            $('#loading').removeClass('ajax-loader');
            $("#buscador").removeClass('hide');
            $("#buscador").addClass('show');
        }
    });

})