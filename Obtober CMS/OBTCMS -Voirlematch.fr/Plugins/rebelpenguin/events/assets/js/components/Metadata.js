/**
 * Created by eddy on 01/03/2016.
 */
$(document).ready(function () {
    $('#loading').addClass('ajax-loader');
    $.request('onAddItemFodbold',{
        data: {newItem: ''},
        update: {'@metadata': '#metadato'},
        complete:function(){
            $('#loading').removeClass('ajax-loader');
        }
    });

})