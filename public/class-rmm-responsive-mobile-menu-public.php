<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       
 * @since      1.0.0
 *
 * @package    Responsive_mobile_menu
 * @subpackage Responsive_mobile_menu/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Responsive_mobile_menu
 * @subpackage Responsive_mobile_menu/public
 * @author     Lindberg
 */
class WBB_Off_Canvas_Menu_Public
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version )
    {

        $this->plugin_name = $plugin_name;
        $this->version     = $version;

        add_action( 'wp_ajax_wbb_ocm_return_menu', array (
            $this,
            'wbb_ocm_return_menu') );
        add_action( 'wp_ajax_nopriv_wbb_ocm_return_menu', array (
            $this,
            'wbb_ocm_return_menu') );

        add_action( 'wp_ajax_add_trigger_button', array (
            $this,
            'add_trigger_button') );
        add_action( 'wp_ajax_nopriv_add_trigger_button', array (
            $this,
            'add_trigger_button') );

        add_action( 'wp_ajax_wbb_ocm_add_style', array (
            $this,
            'wbb_ocm_add_style') );
        add_action( 'wp_ajax_nopriv_wbb_ocm_add_style', array (
            $this,
            'wbb_ocm_add_style') );
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in WBB_Off_Canvas_Menu_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The WBB_Off_Canvas_Menu_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/rmm-responsive-mobile-menu-public.css', array (), $this->version, 'all' );
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in WBB_Off_Canvas_Menu_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The WBB_Off_Canvas_Menu_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/rmm-responsive-mobile-menu-public.js', array (
            'jquery'), $this->version, true );
        wp_localize_script( $this->plugin_name, 'MyAjax', array (
            'ajaxurl' => admin_url( 'admin-ajax.php' )) );
    }

    /**
     * Function that reads the settings variables, and returns the <menu>
     * if we are in a device selected in settings
     */
    public function wbb_ocm_return_menu()
    {

        if ( self::check_device_available( $_POST["screen_size"] ) )
        {

            $menu_name = get_theme_mod( "wbb_ocm_menu_name" );

            if ( $menu_name != "" )
            {

                $sidebar_side = ( get_theme_mod( "wbb_ocm_sidebar_side" ) !== "" ? get_theme_mod( "wbb_ocm_sidebar_side" ) : "left" );

                ob_start();
                include plugin_dir_path( dirname( __FILE__ ) ) . "public/partials/menu-object.php";
                $menu_object = ob_get_clean();
                

                echo json_encode(array(
                          "menu_object" => $menu_object
                        , "sidebar_side" => $sidebar_side
                ));
                
            }
        }

        die();
    }

    /**
     * Function that read settings, generates the trigger button and returns values via ajax
     */
    public function add_trigger_button()
    {

        if ( WBB_Off_Canvas_Menu_Public::check_device_available( $_POST["screen_size"] ) )
        {
            $trigger_target = get_option( "wbb_ocm_css_selector", true );
            $trigger_icon   = ( get_option( "wbb_ocm_trigger_icon" ) !== "" ? get_option( "wbb_ocm_trigger_icon" ) : plugin_dir_url( __FILE__ ) . "img/trigger_icon1.png" );


            $trigger_target = (get_option( "wbb_ocm_css_selector" ) !== "" ? get_option( "wbb_ocm_css_selector" ) : "" );

            ob_start();
            include plugin_dir_path( dirname( __FILE__ ) ) . "public/partials/trigger-button.php";
            $trigger_button = ob_get_clean();


            echo json_encode( array (
                "trigger_target" => $trigger_target
                , "trigger_object" => $trigger_button
            ) );
        }

        die();
    }

    /**
     * Function that set the device type by screen width If the user its a administrator, the menu always is shown.
     *
     * @param $screen_width
     *
     * @return bool
     */
    public function check_device_available( $screen_width )
    {

        $ocm_status = ( get_theme_mod( "wbb_ocm_status" ) !== "" ? get_theme_mod( "wbb_ocm_status" ) : "deactivated" );

        // This line always allow to the admins see the menu, even if is deactivated.
        if ( current_user_can( 'administrator' ) )
        {
            $ocm_status = "activated";
        }

        if ( $ocm_status === "activated" )
        {

            if ( $screen_width < 768 )
            {
                return ( get_option( "wbb_ocm_devices_mobile", true ) > 0 ? true : false );
            }
            else if ( $screen_width < 992 )
            {
                return ( get_option( "wbb_ocm_devices_tablet", true ) > 0 ? true : false );
            }
            else if ( $screen_width < 1200 )
            {
                return ( get_option( "wbb_ocm_devices_laptop", true ) > 0 ? true : false );
            }
            else if ( $screen_width >= 1200 )
            {

                return ( get_option( "wbb_ocm_devices_desktop", true ) > 0 ? true : false );
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    /**
     * Function that reads settings and send style variables via ajax
     */
    public function wbb_ocm_add_style()
    {
        echo json_encode( array (
            "wbb_ocm_background"            => get_option( "wbb_ocm_background" )
            , "wbb_ocm_background_hover"    => get_option( "wbb_ocm_background_hover" )
            , "wbb_ocm_borders"             => get_option( "wbb_ocm_borders" )
            , "wbb_ocm_font_color"          => get_option( "wbb_ocm_font_color" )
            , "wbb_ocm_font_color_hover"    => get_option( "wbb_ocm_font_color_hover" )
            , "wbb_ocm_font_family"         => get_option( "wbb_ocm_font_family" )
            , "wbb_ocm_trigger_background"  => ( get_theme_mod( "wbb_ocm_trigger_background" ) !== "" ? get_theme_mod( "wbb_ocm_trigger_background" ) : "#321321" )
        ) );
        
        die();
    }

}
