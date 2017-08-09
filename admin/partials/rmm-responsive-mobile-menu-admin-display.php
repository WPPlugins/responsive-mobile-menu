<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       
 * @since      1.0.0
 *
 * @package    Responsive_mobile_menu
 * @subpackage Responsive_mobile_menu/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wbb_ocm_settings_container">

    <h1 class="responsive-mobile-menu-headline">Responsive Mobile</h1>
    <div class="section-one">
    <div class="wbb_ocm_setting_block wbb_ocm_status_block split-thirty noshow">
        <h2>Activate Menu</h2>
        <p class="sub-information">Deactivate/Activate the menu </p>
        <div class="on-and-off">
            <div class="wbb_checkbox <?php echo ( $ocm_status === "activated" ? "activated" : "" ) ?>">

                <span class="on"><?php _e( "On", "wbb-offcanvas-menu" ); ?></span>
                <span class="off"><?php _e( "Off", "wbb-offcanvas-menu" ); ?></span>

                <span class="indicator"></span>
            </div>
        </div>
        <div class="on-or-off-text">
            <div class="wbb_ocm_status_result wbb_ocm_status_result_activated" style="display: none;">Menu is Activated</div>

            <div class="wbb_ocm_status_result wbb_ocm_status_result_deactivated" style="display: none;">Menu is Deactivated</div>
        </div>
        <br>
        <input type="hidden" name="wbb_ocm_status" value="<?php echo $ocm_status ?>" />

    </div>


    <div class="wbb_ocm_setting_block split-seventy">

        <div class="left-col">
            <h2>Pick a Menu</h2>
            <p class="sub-information">Choose a menu to show in the menu </p>
            <label>
                <span class="menuname">Menu Name</span>

                <select name="wbb_ocm_menu_name">
                    <?php
                    $menus = get_terms( 'nav_menu', array (
                        'hide_empty' => false) );
                    
                    foreach ( $menus as $menu ) :
                        echo ( $menu->name === $menu_name ? "<option value='$menu->name' selected>$menu->name</option>" : "<option value='$menu->name'>$menu->name</option>" );
                    endforeach;
                    ?>

                </select>

            </label>

            <label>
                <p>
                    <a href="<?php echo admin_url(); ?>/nav-menus.php?action=edit&menu=0">
                        Don't have a menu? Click here to create one!
                    </a>
                </p>

            </label>
        </div>
        <div class="right-col">
            <h2>Screen sizes</h2>
            <p class="sub-information">Choose what screen sizes the menu will show on </p>
            <label>

                <div class="wbb_ocm_device_inputs_container">

                    <input type="text" class="wbb_ocm_devices_inputs" name="wbb_ocm_devices_desktop" value="<?php echo $devices_desktop ?>" />
                    <input type="text" class="wbb_ocm_devices_inputs" name="wbb_ocm_devices_laptop" value="<?php echo $devices_laptop ?>" />
                    <input type="text" class="wbb_ocm_devices_inputs" name="wbb_ocm_devices_tablet"  value="<?php echo $devices_tablet ?>" />
                    <input type="text" class="wbb_ocm_devices_inputs" name="wbb_ocm_devices_mobile"  value="<?php echo $devices_mobile ?>" />

                </div>

                <ul class="wbb_ocm_devices_list">
                    <li class="wbb_com_device wbb_devices_<?php echo $devices_desktop ?>" data-input="wbb_ocm_devices_desktop"></li>
                    <li class="wbb_com_device wbb_devices_<?php echo $devices_laptop ?>" data-input="wbb_ocm_devices_laptop"></li>
                    <li class="wbb_com_device wbb_devices_<?php echo $devices_tablet ?>" data-input="wbb_ocm_devices_tablet"></li>
                    <li class="wbb_com_device wbb_devices_<?php echo $devices_mobile ?>" data-input="wbb_ocm_devices_mobile"></li>
                </ul>
 <p class="sub-information" style="border-bottom:0;"><strong>Click on the devices you wish to show the menu on.</strong><br> Mobile: 768 - Tablet: 992 <br> Laptop: 1200 - Desktop: 1200+</p>
            </label>
        </div>

    </div>

</div>
<br>

    <div class="wbb_ocm_settings_submit button button-primary button-update-style"><?php _e( "Update Settings", "wbb-offcanvas-menu" ); ?></div>

<br>
<div class="secondrow-wrapper">
    <div class="wbb_ocm_setting_block second-row-layout">

        <div>
            <label>
                <h2>Design</h2>
            <p class="sub-information">How would you like the sidebar to look?</p>
                <select name="wbb_ocm_sidebar_side">
                    <option value="left" <?php echo ($sidebar_side === "left" ? "selected" : "") ?>><?php _e( "Left", "wbb-offcanvas-menu" ); ?></option>
                    <option value="right" <?php echo ($sidebar_side === "right" ? "selected" : "") ?>><?php _e( "Right", "wbb-offcanvas-menu" ); ?></option>
                </select>
            </label>

            <label>
                <span class="info-span"><?php _e( "Select Font Family", "wbb-offcanvas-menu" ); ?></span>

                <input type="hidden" name="wbb_ocm_font_family" value="<?php echo str_replace( "\\", "", $font_family ) ?>" />

                <ul>
                    <li class="wbb_com_font_family_item"><span style="font-family: <?php echo str_replace( "\\", "", $font_family ) ?>;">Theme style</span></li>
                    <li class="wbb_com_font_family_item <?php echo ( str_replace( "\\", "", $font_family ) === "Georgia, serif" ? "active" : "" ) ?>" ><span style='font-family: Georgia, serif'>Serif</span></li>
                    <li class="wbb_com_font_family_item <?php echo ( str_replace( "\\", "", $font_family ) === "Arial, Helvetica, sans-serif" ? "active" : "" ) ?>" ><span style='font-family: Arial, Helvetica, sans-serif'>Sans-serif</span></li>
                    <li class="wbb_com_font_family_item <?php echo ( str_replace( "\\", "", $font_family ) === "'Courier New', Courier, monospace" ? "active" : "" ) ?>" ><span style='font-family: "Courier New", Courier, monospace'>Monospace</span></li>
                </ul>

            </label>

        </div>

        <div class="right-col">
            <fieldset>

                <label>
                    <span class="info-span"><?php _e( "Background", "wbb-offcanvas-menu" ); ?></span>
                    <input type="text" data-palette="true" class="wbb_ocm_colorpicker pluto-color-control" name="wbb_ocm_background" value="<?php echo $background ?>" >
                </label>
                <label>
                    <span class="info-span"><?php _e( "Background on mouse over", "wbb-offcanvas-menu" ); ?></span>
                    <input type="text" data-palette="true" class="wbb_ocm_colorpicker pluto-color-control" name="wbb_ocm_background_hover" value="<?php echo $background_hover ?>" >
                </label>
                <label>
                    <span class="info-span"><?php _e( "Borders", "wbb-offcanvas-menu" ); ?></span>
                    <input type="text" data-palette="true" class="wbb_ocm_colorpicker pluto-color-control" name="wbb_ocm_borders" value="<?php echo $borders ?>" >
                </label>
                <label>
                    <span class="info-span"><?php _e( "Font color", "wbb-offcanvas-menu" ); ?></span>
                    <div class="color-container">
                        <input type="text" data-palette="true" class="wbb_ocm_colorpicker pluto-color-control" name="wbb_ocm_font_color" value="<?php echo $font_color ?>" >
                    </div>
                </label>
                <label>
                    <span class="info-span"><?php _e( "Font color on mouse over", "wbb-offcanvas-menu" ); ?></span>
                    <input type="text" data-palette="true" class="wbb_ocm_colorpicker pluto-color-control" name="wbb_ocm_font_color_hover" value="<?php echo $font_color_hover ?>" >
                </label>

            </fieldset>
        </div>

    </div>


    <div class="wbb_ocm_setting_block third-row-layout">

        <div class="">
                <h2>Menu Trigger Button</h2>
            <p class="sub-information">Settings for the button that opens the menu</p>

            <label>

                <span class="info-span"><?php _e( "As default the menu button wil be shown in the body. <br>
                if you want to use a different selector then add it below. <br> 
                    Use ID or Class (css selector) where the push menu trigger button will appear.", "wbb-offcanvas-menu" ); ?></span>
                <span class="alert_error"> <?php _e( "This selector doesn't exists", "wbb-offcanvas-menu" ); ?> </span>
                <input type="text" name="wbb_ocm_css_selector" value="<?php echo $css_selector ?>" placeholder=".class or #id" > 
                
            </label>

            <label>
                <span class="info-span"><?php _e( "Button position", "wbb-offcanvas-menu" ); ?></span>
                <select name="wbb_ocm_trigger_side">
                    <option value="left" <?php echo ($trigger_side === "left" ? "selected" : "") ?>>Left</option>
                    <option value="right" <?php echo ($trigger_side === "right" ? "selected" : "") ?>>Right</option>
                </select>
            </label>
        </div>
        <div class="right-col">
            <label>

                <span class="info-span"><?php _e( "Select the menu button icon", "wbb-offcanvas-menu" ); ?></span>

                <input type="hidden" name="wbb_ocm_trigger_icon" value="<?php echo $trigger_icon ?>" />

                <ul class="wbb_ocm_trigger_icon_list">

                    <li class="wbb_ocm_trigger_icon <?php echo ( $trigger_icon === plugin_dir_url( __DIR__ ) . "img/trigger-icon-1.png" ? "active" : "" ); ?>"><img src="<?php echo plugin_dir_url( __DIR__ ); ?>img/trigger-icon-1.png"></li>
                    <li class="wbb_ocm_trigger_icon <?php echo ( $trigger_icon === plugin_dir_url( __DIR__ ) . "img/trigger-icon-2.png" ? "active" : "" ); ?>"><img src="<?php echo plugin_dir_url( __DIR__ ); ?>img/trigger-icon-2.png"></li>
                    <li class="wbb_ocm_trigger_icon <?php echo ( $trigger_icon === plugin_dir_url( __DIR__ ) . "img/trigger-icon-3.png" ? "active" : "" ); ?>"><img src="<?php echo plugin_dir_url( __DIR__ ); ?>img/trigger-icon-3.png"></li>
                    <li class="wbb_ocm_trigger_icon <?php echo ( $trigger_icon === plugin_dir_url( __DIR__ ) . "img/trigger-icon-4.png" ? "active" : "" ); ?>"><img src="<?php echo plugin_dir_url( __DIR__ ); ?>img/trigger-icon-4.png"></li>
                    <li class="wbb_ocm_trigger_icon <?php echo ( $trigger_icon === plugin_dir_url( __DIR__ ) . "img/trigger-icon-5.png" ? "active" : "" ); ?>"><img src="<?php echo plugin_dir_url( __DIR__ ); ?>img/trigger-icon-5.png"></li>
                    <li class="wbb_ocm_trigger_icon <?php echo ( $trigger_icon === plugin_dir_url( __DIR__ ) . "img/trigger-icon-6.png" ? "active" : "" ); ?>"><img src="<?php echo plugin_dir_url( __DIR__ ); ?>img/trigger-icon-6.png"></li>
                    <li class="wbb_ocm_trigger_icon <?php echo ( $trigger_icon === plugin_dir_url( __DIR__ ) . "img/trigger-icon-7.png" ? "active" : "" ); ?>"><img src="<?php echo plugin_dir_url( __DIR__ ); ?>img/trigger-icon-7.png"></li>
                    <li class="wbb_ocm_trigger_icon <?php echo ( $trigger_icon === plugin_dir_url( __DIR__ ) . "img/trigger-icon-8.png" ? "active" : "" ); ?>"><img src="<?php echo plugin_dir_url( __DIR__ ); ?>img/trigger-icon-8.png"></li>

                </ul>
                <hr>

                <div class="button wbb_ocm_trigger_icon_button"><?php _e( "Upload your icon", "wbb-offcanvas-menu" ); ?></div>

                <hr>

                <span class="info-span"><?php _e( "Menu button background", "wbb-offcanvas-menu" ); ?></span><br>
                <input type="text" data-palette="true" class="wbb_ocm_colorpicker trigger_background pluto-color-control" name="wbb_ocm_trigger_background" value="<?php echo $trigger_background ?>" >

                <span class="info-span"><?php _e( "Icon preview:", "wbb-offcanvas-menu" ); ?></span>
                <img class="wbb_com_trigger_icon_selected" src="<?php echo $trigger_icon ?>" style="background-color: <?php echo $trigger_background ?>">



            </label>
        </div>

    </div>
</div>
<div class="submit-button-wrapper">
    <div class="wbb_ocm_settings_submit button button-primary button-update-style"><?php _e( "Update Settings", "wbb-offcanvas-menu" ); ?></div>

</div></div>
<iframe id="wbb_ocm_iframe" src="<?php echo bloginfo( "url" ) ?>"></iframe><div class="info-space"><a target="_blank" href="https://goo.gl/wY97fU"><img src="https://goo.gl/h2ft12" alt="Contact us"></a></div>

