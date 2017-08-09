(function($) {
    'use strict';

//-------------------------------------------

    var opened_menus = [];

    $(document).ready(function() {
        init_menu();
    });
    $(window).resize(function() {

        if ( $(".rmm-responsive-mobile-menu-container").length > 0 )
        {
            $(".rmm-responsive-mobile-menu-container, .rmm-responsive-mobile-menu-trigger").remove();
        }
        init_menu();
    });

    function init_menu()
    {

        var delay_init_menu = setInterval(function() {

            $.ajax({
                method: "POST"
                , url: MyAjax.ajaxurl
                , data: {
                    action: "wbb_ocm_return_menu"
                    , screen_size: $(window).width()
                }
                , dataType: "json"
                , success: function(data) {

                    if ( $(".rmm-responsive-mobile-menu-container").length < 1 )
                    {

                        $("body").prepend(data.menu_object).addClass(data.sidebar_side);

                        add_style();
                        add_events();
                        rebuild_menu();

                    }

                }
            });

            $.ajax({
                method: "POST"
                , url: MyAjax.ajaxurl
                , data: {
                    action: "add_trigger_button"
                    , screen_size: $(window).width()
                }
                , dataType: "json"
                , success: function(data) {

                    if ( data !== null )
                    {
                        
                        $(".rmm-responsive-mobile-menu-trigger").remove();

                        var trigger_div = $(data.trigger_target);

                        if ( trigger_div.length > 0 ) {

                            $(data.trigger_target).prepend(data.trigger_object);

                        }

                        else {

                            $("body").prepend(data.trigger_object);

                        }


                    }

                }
            });

            clearInterval(delay_init_menu);

        }, 500);



    }

    function add_style()
    {

        $.ajax({
            method: "POST"
            , url: MyAjax.ajaxurl
            , data: {
                action: "wbb_ocm_add_style"
            }
            , dataType: "json"
            , success: function(style) {

                // Background
                $("\
  .rmm-responsive-mobile-menu-container\n\
, .rmm-responsive-mobile-menu-container menu\n\
, .rmm-responsive-mobile-menu-submenu, .rmm-responsive-mobile-menu-container menuitem").css("background-color", style.wbb_ocm_background);

                $(".rmm-responsive-mobile-menu-trigger").css("background-color", style.wbb_ocm_trigger_background)


                $(".rmm-responsive-mobile-menu-container menuitem").mouseenter(function() {
                    $(this).css("background-color", style.wbb_ocm_background_hover);
                }).mouseleave(function() {
                    $(this).css("background-color", style.wbb_ocm_background);
                });

                // wbb_ocm_borders
                $("menu.rmm-responsive-mobile-menu-submenu").css("border-right-color", style.wbb_ocm_borders);
                $("menuitem").css("border-bottom-color", style.wbb_ocm_borders);

                //Font color
                $(".rmm-responsive-mobile-menu-container menuitem").css("color", style.wbb_ocm_font_color);
                $(".rmm-responsive-mobile-menu-container menuitem").mouseenter(function() {
                    $(this).css("color", style.wbb_ocm_font_color_hover);
                }).mouseleave(function() {
                    $(this).css("color", style.wbb_ocm_font_color);
                });

                //Font Family
                $(".rmm-responsive-mobile-menu-container menuitem").css("font-family", style.wbb_ocm_font_family);

            }
        });




    }

    function rebuild_menu()
    {

        var delay_rebuild = setInterval(function() {

            var lis = $(".rmm-responsive-mobile-menu-container .rmm-responsive-mobile-menu-main menuitem");

            $.each(lis, function(key, val) {

                var this_id = $(this).attr("data-post-id");
                var parent_id = $(this).attr("data-parent-id");
                var url = $(this).attr("data-url-target");

                if ( parent_id > 0 )
                {

                    if ( $("menuitem[data-post-id='" + parent_id + "']").find("menu").length < 1 )
                    {
                        $("menuitem[data-post-id='" + parent_id + "']").append("<menu><menuitem class='rmm-responsive-mobile-menu-submenu-close'>Back</menuitem></menu>");
                    }

                    $("menuitem[data-post-id='" + parent_id + "'] menu").append("<menuitem data-post-id='" + this_id + "' data-url-target='" + url + "'>" + $(this).html() + "</menuitem>")

                    $(this).remove();

                }


            });

            clearInterval(delay_rebuild);

        }, 500);

    }

    function add_events()
    {

        $(document).on("click", ".rmm-responsive-mobile-menu-submenu menuitem, .rmm-responsive-mobile-menu-container menuitem", function() {

            var $this = $(this)
            var data_post_id = $(this).attr("data-post-id");

            if ( !$(this).parents("menu").hasClass("rmm-responsive-mobile-menu-main-title") )
            {

                if ( $(this).find("menu").length > 0 )
                {

                    if ( parseInt(opened_menus.indexOf(data_post_id)) < 0 )
                    {

                        $(".rmm-responsive-mobile-menu-container").append("<menu class='rmm-responsive-mobile-menu-submenu' data-menu-id='" + data_post_id + "'>" + $(this).find("menu").html() + "</menu>");

                        var delay_submenu = setInterval(function() {

                            $(".rmm-responsive-mobile-menu-submenu").addClass("active");

                            $(".rmm-responsive-mobile-menu-main, .rmm-responsive-mobile-menu-main-title").css("opacity", 0);

                            opened_menus.push(data_post_id);
                            add_style();
                            clearInterval(delay_submenu);

                        }, 100);

                    }



                }
                else if ( $(this).attr("data-url-target") === "#" || $(this).hasClass("rmm-responsive-mobile-menu-submenu-close") )
                {
                    // Do Nothing
                }
                else
                {
                    location.href = $(this).attr("data-url-target");
                }

            }



        });

        $(document).on("click", ".rmm-responsive-mobile-menu-submenu-close", function() {

            var $this = $(this);

            $this.parents(".rmm-responsive-mobile-menu-submenu").removeClass("active");
            var menu_id = $this.parents(".rmm-responsive-mobile-menu-submenu").attr("data-menu-id");

            var delay_submenu = setInterval(function() {

                opened_menus.splice(parseInt(opened_menus.indexOf(menu_id)), 1);

                $this.parents(".rmm-responsive-mobile-menu-submenu").remove();

                if ( $(".rmm-responsive-mobile-menu-submenu").length < 1 )
                {
                    $(".rmm-responsive-mobile-menu-main, .rmm-responsive-mobile-menu-main-title").css("opacity", 1);
                }

                clearInterval(delay_submenu);

            }, 250);

        });

        $(document).on("click", ".rmm-responsive-mobile-menu-trigger, .rmm-responsive-mobile-menu-close", function() {
            $("body, .rmm-responsive-mobile-menu-container").toggleClass("active");
            $(".rmm-responsive-mobile-menu-trigger").toggleClass("active");
        });


    }


    /**
     * CONNECT TEXT BLOCKS TO TEXT PATH.
     $(document).ready(function(){
     
     var original_text = $(".orinigal-text").html();
     
     var temp_point = 0;
     
     $.each( $(".connected-text"), function(i,val){
     
     var height = $(this).height();
     var line_height = $(this).css("line-height");
     
     var lines_per_block = Math.floor( height / parseInt(line_height) );
     
     var m_width = $(this).append("<span>M</span>");
     m_width = $(this).find("span").width();
     
     var characters_by_line = Math.floor( $(this).width() / m_width );
     
     
     
     
     
     });
     
     
     });
     */

//-------------------------------------------

})(jQuery);
