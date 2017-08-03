/**
 * Created by eddy on 04/03/2016.
 */
$(document).ready(function () {
    $('#loading').addClass('ajax-loader');
    $.request('onMenuSystToo',{
        data: {newItem: ''},
        update: {'@menusistemtoo': '#menusistemtoo'},
        complete:function(){
            $('#loading').removeClass('ajax-loader');
            $("#buscador").removeClass('hide');
            $("#buscador").addClass('show');
        }
    });

})