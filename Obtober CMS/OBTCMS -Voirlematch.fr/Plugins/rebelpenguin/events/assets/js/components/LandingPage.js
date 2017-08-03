/**
 * Created by eddy on 01/03/2016.
 */
$(document).ready(function () {
    $('#loading').addClass('ajax-loader');
    $.request('onLandingPages',{
        data: {newItem: ''},
        update: {'@landingpage': '#landing'},
        complete:function(){
            $('#loading').removeClass('ajax-loader');
        }
    });

})/**
 * Created by eddy on 01/03/2016.
 */
