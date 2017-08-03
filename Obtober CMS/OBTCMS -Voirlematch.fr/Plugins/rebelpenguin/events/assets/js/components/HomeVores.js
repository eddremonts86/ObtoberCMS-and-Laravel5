/**
 * Created by eddy on 21/12/2015.
 */
$(document).ready(function () {
    $('#loading').addClass('ajax-loader');

    $.request('onHomev',{
        data: {newItem: ''},
        update: {'@frontpagepartners': '#VRES_result'},
        complete:function(){
            $('#loading').removeClass('ajax-loader');

        }
    });







})