/**
 * Created by eddy on 04/12/2015.
 */

$(document).ready(function () {
    $('#loading_strteam').addClass('ajax-loader');
    $.request('onStreamProvide',{
        data: {newItem: ''},
        update: {'@streamproviders': '#streamproviders'},
        complete:function(){
            $('#loading_strteam').removeClass('ajax-loader');
            $("#buscador").removeClass('hide');
            $("#buscador").addClass('show');
        }
    });

})