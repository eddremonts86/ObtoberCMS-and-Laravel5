
/**
 * Created by eddy on 01/03/2016.
 */
$(document).ready(function () {
    $('#loading').addClass('ajax-loader');
    $.request('onSlideSport',{
        data: {newItem: ''},
        update: {'@slidesport': '#slide'},
        complete:function(){
            $('#loading').removeClass('ajax-loader');
        }
    });
    $('#carousel-example-generic').carousel();
})