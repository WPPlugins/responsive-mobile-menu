(function($) {

    wp.customize('wbb_ocm_sidebar_side', function(value) {

        var value_back = $(value);

        value.bind(function(to) {

            var tostring = to.toString();

            var delay_update_sidebar = setInterval(function() {

                if ( to.toString() === "right" )
                {

                    $(".rmm-responsive-mobile-menu-container").removeClass("left");
                    $(".rmm-responsive-mobile-menu-container").addClass("right");

                    $("body").removeClass("left");
                    $("body").addClass("right");

                }
                else if ( to.toString() === "left" )
                {

                    $(".rmm-responsive-mobile-menu-container").removeClass("right");
                    $(".rmm-responsive-mobile-menu-container").addClass("left");

                    $("body").removeClass("right");
                    $("body").addClass("left");

                }

                //clearInterval(delay_update_sidebar);

            }, 1000);

        });

    });

    wp.customize('wbb_ocm_trigger_side', function(value) {

        var value_back = $(value);

        value.bind(function(to) {

            var tostring = to.toString();

            var delay_update = setInterval(function() {

                if ( to.toString() === "right" )
                {

                    $(".rmm-responsive-mobile-menu-trigger").removeClass("left");
                    $(".rmm-responsive-mobile-menu-trigger").addClass("right");

                }
                else if ( to.toString() === "left" )
                {

                    $(".rmm-responsive-mobile-menu-trigger").removeClass("right");
                    $(".rmm-responsive-mobile-menu-trigger").addClass("left");

                }

                //clearInterval(delay_update);

            }, 1000);

        });

    });


})(jQuery);