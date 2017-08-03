/**
 * Created by eddy on 12/11/2015.
 */

$(document).ready(function () {
    $('#loading').addClass('ajax-loader');
    $.request('onStreamData',{
            data: {newItem: ''},
            update: {'@StreamUdbyder': '#StreamUdbyder'},
            complete:function(){
                $('#loading').removeClass('ajax-loader');
                $("#buscador").removeClass('hide');
                $("#buscador").addClass('show');
            }
        });
    $( " s " ).click(function() {
        $('#termswinows').modal('show')
    });
})
