/**
 * Created by Bruger on 09-11-2015.
 */


$(document).ready(function(){
    
    var obj = document.getElementById('allbody');
    console.log(obj.offsetHeight);
    
    var site="sesport";
    if(location.pathname == "/"+site+"/"){
        $('#logo').addClass('animated rubberBand');
    }
    /*Fodbold Menu*/
    if(location.pathname == "/"+site+"/fodbold"){
            $('#Fodbold_').addClass('fl_active');
            $('#Fodbold').addClass('active');
        }
    if(location.pathname == "/"+site+"/fodbold_live_stream"){
        $('#Live').addClass('fl_active');
        $('#Fodbold').addClass('active');
    }
    if(location.pathname == "/"+site+"/tv_guide"){
        $('#guide').addClass('fl_active');
        $('#Fodbold').addClass('active');
    }
    if(location.pathname == "/"+site+"/blog"){
        $('#Blog').addClass('fl_active');
        $('#Fodbold').addClass('active');
    }

    $( ".terms" ).click(function() {
        $('#terms_winows').modal('show')
    });
    $("#data").click(function () {
            if($("#articlecaption").hasClass( "show" )=== true){
                $("#articlecaption").removeClass("fadein show").addClass("fadeout hidden");
                $("#articleBody").removeClass("fadeout hidden").addClass("fadein show");
                $("#data").html("Skjul"); 
            }
            else{
                $("#articlecaption").removeClass("hidden").addClass("show");
                $("#articleBody").removeClass("show").addClass("hidden");
                $("#data").html("Læs mere her");
            }
        });
    $( window ).scroll(function(){
        if ($(window).scrollTop() > $(window).height()- $(window).height()/2  && typeof(game) != "undefined"){
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth()+1; 
            var yyyy = today.getFullYear();
            if(dd<10){dd='0'+dd} 
            if(mm<10){mm='0'+mm} 
            var today = dd+'/'+mm+'/'+yyyy;
            if(typeof(game) != "undefined") {
                if("day" in localStorage){
                       if(localStorage.getItem('day')== today){
                       }
                        else if(localStorage.getItem('day')!= today){
                            localStorage.setItem('day',today);
                            $('#b365_popup').modal('show');
                        }        
                    } else {
                        localStorage.setItem('day',today);
                        $('#b365_popup').modal('show');
                        
                    }
            }
          }     
        
    });
});

function Alders(){
   $('#Alderspolitik').modal('show')
}


