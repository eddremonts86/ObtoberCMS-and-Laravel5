/**
 * Created by eddy on 12/11/2015.
 */

$(document).ready(function () {
    $('#loading').addClass('ajax-loader');
    $.request('onAddItem_Fodbold',{
            data: {newItem: ''},
            update: {'@Tv': '#Tv_result'},
            complete:function(){
                $('#loading').removeClass('ajax-loader');
                $("#buscador").removeClass('hide');
                $("#buscador").addClass('show');
            }
        });
    $('#edit').on( "click", function() {
        console.log( $( this ).text() );
    });
})
