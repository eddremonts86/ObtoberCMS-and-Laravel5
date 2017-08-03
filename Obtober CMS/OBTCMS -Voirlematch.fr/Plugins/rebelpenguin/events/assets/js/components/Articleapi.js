/**
 * Created by eddy on 12/11/2015.
 */

$(document).ready(function () {
    $('#loading').addClass('ajax-loader');
    $.request('onArticles',{
            update: {'@Articleapi': '#Articleapi'},
            complete:function(){
                $('#loading').removeClass('ajax-loader');
                $("#buscador").removeClass('hide');
                $("#buscador").addClass('show');
            }
        });

})
