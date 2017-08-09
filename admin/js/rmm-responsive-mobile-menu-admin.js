(function($) {
    'use strict';


    $(document).ready(function() {

        $('input.wbb_ocm_colorpicker').wpColorPicker();

        if ( $(".wbb_checkbox").hasClass("activated") )
        {
            $("input[name='wbb_ocm_status']").val("activated");
            $(".wbb_ocm_status_result_activated").show();
            $(".wbb_ocm_status_result_deactivated").hide();
        }
        else
        {
            $("input[name='wbb_ocm_status']").val("deactivated");
            $(".wbb_ocm_status_result_deactivated").show();
            $(".wbb_ocm_status_result_activated").hide();
        }

        /**
         * Check if we check the On/Off button
         */
        $(".wbb_checkbox").click(function() {

            $(".wbb_checkbox").toggleClass("activated");

            if ( $(".wbb_checkbox").hasClass("activated") )
            {
                $("input[name='wbb_ocm_status']").val("activated");
                $(".wbb_ocm_status_result_activated").show();
                $(".wbb_ocm_status_result_deactivated").hide();
            }
            else
            {
                $("input[name='wbb_ocm_status']").val("deactivated");
                $(".wbb_ocm_status_result_deactivated").show();
                $(".wbb_ocm_status_result_activated").hide();
            }

        });


        $("#wbb_ocm_iframe").load(function() {

            var body_font_family = $(this).contents().find("body").css("font-family");

            $(".wbb_com_font_family_item").first().find("span").css("font-family", body_font_family);
            

        });



        /**
         * Activate / deactivate the devices to show the menu
         */
        $(".wbb_com_device").click(function() {

            if ( $(this).hasClass("wbb_devices_0") )
            {
                $(this).addClass("wbb_devices_1").removeClass("wbb_devices_0");
                $("input[name='" + $(this).attr("data-input") + "']").val("1");
            }
            else
            {
                $(this).addClass("wbb_devices_0").removeClass("wbb_devices_1");
                $("input[name='" + $(this).attr("data-input") + "']").val("0");
            }

        });


        /**
         * Activate / deactivate the trigger icon selected for the menu
         */
        $(".wbb_ocm_trigger_icon").click(function() {

            $(".wbb_ocm_trigger_icon").removeClass("active");
            $(this).addClass("active");
            var url = $("img", this).attr("src");
            $("input[name='wbb_ocm_trigger_icon']").val(url);
            $(".wbb_com_trigger_icon_selected").attr("src", url);

        });


        /**
         * 
         * WP MEDIA LIBRARY
         * 
         *
         **********************************************************************/
        var _custom_media = true,
                _orig_send_attachment = wp.media.editor.send.attachment;

        // ADJUST THIS to match the correct button
        $('.wbb_ocm_trigger_icon_button').click(function(e)
        {
            var send_attachment_bkp = wp.media.editor.send.attachment;
            var button = $(this);
            _custom_media = true;
            wp.media.editor.send.attachment = function(props, attachment)
            {
                if ( _custom_media )
                {
                    $("input[name='wbb_ocm_trigger_icon']").val(attachment.url);
                    $(".wbb_com_trigger_icon_selected").attr("src", attachment.url);
                } else {
                    return _orig_send_attachment.apply(this, [props, attachment]);
                }
                ;
            };

            wp.media.editor.open(button);
            return false;
        });

        $('.add_media').on('click', function()
        {
            _custom_media = false;
        });
        /***********************************************************************/

        if ( $(".wbb_ocm_settings_container").length > 0 )
        {

            setInterval(function() {
                $(".wbb_com_trigger_icon_selected").css("background-color", $("input[name='wbb_ocm_trigger_background']").val());
            }, 500);

        }


        // FONT-FAMILY
        if ( $(".wbb_com_font_family_item.active").length < 1 )
        {
            $(".wbb_com_font_family_item").first().addClass("active");
        }

        $(".wbb_com_font_family_item").click(function() {

            $(".wbb_com_font_family_item.active").removeClass("active");
            $(this).addClass("active");
            $('input[name="wbb_ocm_font_family"]').val($("span", this).css("font-family"));

        });


    });


    /**
     * Get the data and send via ajax to save them
     */
    $(document).on("click", ".wbb_ocm_settings_submit.button-primary", function() {

        var $this = $(this);

        // We change the text to help to users to notice that the system is updating.
        var original_text = $this.html();
        $this.html("Updating...").removeClass("button-primary");


        $.ajax({
            method: "POST"
            , url: MyAjax.ajaxurl
            , data: {
                action: "wbb_off_canvas_save_settings"
                , wbb_ocm_status: $("input[name='wbb_ocm_status']").val()
                , wbb_ocm_sidebar_side: $("select[name='wbb_ocm_sidebar_side']").val()
                , wbb_ocm_trigger_side: $("select[name='wbb_ocm_trigger_side']").val()
                , wbb_ocm_trigger_icon: $("input[name='wbb_ocm_trigger_icon']").val()
                , wbb_ocm_trigger_background: $("input[name='wbb_ocm_trigger_background']").val()
                , wbb_ocm_devices_desktop: $("input[name='wbb_ocm_devices_desktop']").val()
                , wbb_ocm_devices_laptop: $("input[name='wbb_ocm_devices_laptop']").val()
                , wbb_ocm_devices_tablet: $("input[name='wbb_ocm_devices_tablet']").val()
                , wbb_ocm_devices_mobile: $("input[name='wbb_ocm_devices_mobile']").val()
                , wbb_ocm_menu_name: $("select[name='wbb_ocm_menu_name']").val()
                , wbb_ocm_css_selector: $("input[name='wbb_ocm_css_selector']").val()
                , wbb_ocm_background: $("input[name='wbb_ocm_background']").val()
                , wbb_ocm_background_hover: $("input[name='wbb_ocm_background_hover']").val()
                , wbb_ocm_borders: $("input[name='wbb_ocm_borders']").val()
                , wbb_ocm_font_color: $("input[name='wbb_ocm_font_color']").val()
                , wbb_ocm_font_color_hover: $("input[name='wbb_ocm_font_color_hover']").val()
                , wbb_ocm_font_family: $("input[name='wbb_ocm_font_family']").val()
            }
            , success: function() {

                var trigger_selector = $("input[name='wbb_ocm_css_selector']").val();
                var trigger_div = $("#wbb_ocm_iframe").contents().find(trigger_selector).length;

                if ( trigger_div == 0 && trigger_selector != "" ) {

                    $(".alert_error").show();
                }

                else {

                    $(".alert_error").hide();

                }

                // It restore the original text for the submit button. 
                // The process is very fast, so we delay 1 second to help to users. 
                var delay_effect = setInterval(function() {

                    $this.html(original_text).addClass("button-primary");
                    clearInterval(delay_effect);

                }, 1000);

            }
        });

    });

})(jQuery);
