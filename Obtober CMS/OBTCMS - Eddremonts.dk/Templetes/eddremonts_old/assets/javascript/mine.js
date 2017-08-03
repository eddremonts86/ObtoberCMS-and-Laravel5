    var height =  $(window).height();
    var width =  $(window).width();
    $(document).ready(function () {
        /*$('.firts').css("min-height",(height+40) +"px");
        $('.firts').css("height","auto");
        $('.presentation').css("margin-top",height/2 +"px");
        $(window).resize(function() {
            $('.firts').css("min-height",height +"px");
            $('.firts').css("height","auto");
        });*/
    });
    (function($)     {
        "use strict"; // Start of use strict

        // jQuery for page scrolling feature - requires jQuery Easing plugin
        $('a.page-scroll').bind('click', function(event) {
            var $anchor = $(this);
            $('html, body').stop().animate({
                scrollTop: ($($anchor.attr('href')).offset().top - 50)}, 1000, 'easeInOutExpo');
            event.preventDefault();
        });

        // Highlight the top nav as scrolling occurs
        $('body').scrollspy({
            target: '.navbar-fixed-top',
            offset: 51
        })

        // Closes the Responsive Menu on Menu Item Click
        $('.navbar-collapse ul li a').click(function() {
            $('.navbar-toggle:visible').click();
        });

        // Fit Text Plugin for Main Header
        $("h1").fitText(
            1.2, {
                minFontSize: '35px',
                maxFontSize: '65px'
            }
        );

        // Offset for Main Navigation
        $('#mainNav').affix({
            offset: {
                top: 100
            }
        })

        // Initialize WOW.js Scrolling Animations
        new WOW().init();

    })(jQuery); // End of use strict
    $(document).ready(function() {
        //Set the carousel options
        $('#quote-carousel').carousel({
            pause: true,
            interval: 4000,
        });
    });