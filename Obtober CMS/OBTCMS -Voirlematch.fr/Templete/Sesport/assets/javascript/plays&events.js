/**
 * Created by eddy on 12/11/2015.
 */

$(document).ready(function(){
   /* $.getJSON("http://web1.livegoals.dk:8585/services/soccer/")
        .done(function(data_){
                $.each(data_, function(indice,valor){
                    $("blog_test").append("<li>"+ valor.continent+"</li>");

                })
            }
        )
*/

    $( ".tv_guide" ).click(function() {
        $('.tv_guide').addClass('animated infinite bounce');
    });

})

