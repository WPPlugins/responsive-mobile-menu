<?php

/**
 * @link              clindberg.com
 * @since             1.0.0
 * @package           Responsive_mobile_menu
 *
 * @wordpress-plugin
 * Plugin Name:       Responsive Mobile Menu
 * Description:       Get a minimalistic looking off canvas mobile menu, it be set to be shown only on tablet, mobile phone, desktop and more. If you have questions or need help please contact me at casperlindbrg@gmail.com - To set up the menu go to Appearance > Responsive Mobile Menu
 * Version:           1.0.0
 * Author:            Lindbergsw
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wbb-offcanvas-menu
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) )
{
    die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-rmm-responsive-mobile-menu-activator.php
 */
function activate_wbb_push_menu()
{
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-rmm-responsive-mobile-menu-activator.php';
    WBB_Off_Canvas_Menu_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-rmm-responsive-mobile-menu-deactivator.php
 */
function deactivate_wbb_push_menu()
{
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-rmm-responsive-mobile-menu-deactivator.php';
    WBB_Off_Canvas_Menu_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wbb_push_menu' );
register_deactivation_hook( __FILE__, 'deactivate_wbb_push_menu' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-rmm-responsive-mobile-menu.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wbb_push_menu()
{

    $plugin = new WBB_Off_Canvas_Menu();
    $plugin->run();
}

run_wbb_push_menu();