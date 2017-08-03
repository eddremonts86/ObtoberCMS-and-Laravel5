/**
 * Created by eddy on 12/11/2015.
 */

$(document).ready(function () {
    $('#loading').addClass('ajax-loader');
    $.request('onAddItem_Fodbold',{
            update: {'@Events': '#EVT_result'},
            complete:function(){
                $('#loading').removeClass('ajax-loader');
                $("#buscador").removeClass('hide');
                $("#buscador").addClass('show');
            }
        });
    $('#edit').on( "click", function() {
        console.log( $( this ).text() );
    });

    $("divhead").on("click", function () {
        var role = $(this).context.id;
        alert(role);
        if (role.search('headingOne_') != -1) {

            if ($(this).hasClass("collapse") === false) {
                $('i').removeClass("fa-plus").addClass("fa-minus");
            }
            else {
                $('i').removeClass("fa-minus").addClass("fa-plus");
            }
        }
    });

})
