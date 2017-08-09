<div class="rmm-responsive-mobile-menu-container <?php echo $sidebar_side ?>">
    <menu class="rmm-responsive-mobile-menu-main-title">
        <menuitem class="rmm-responsive-mobile-menu-close"><?php _e( "Close Menu", "wbb-offcanvas-menu" ); ?> <span class="close-menu-right"><img src="<?php echo plugin_dir_url( __DIR__ ); ?>img/close-icon.png"></span></menuitem>
    </menu>
    <?php
    $menu = wp_get_nav_menu_object( $menu_name );

    $menu_items = wp_get_nav_menu_items( $menu->term_id );

    $menu_list = '<menu class="rmm-responsive-mobile-menu-main" id="menu-' . $menu_name . '">';

    foreach ( (array) $menu_items as $key => $menu_item )
    {

        $title = $menu_item->title;
        $url   = $menu_item->url;
        $menu_list .= '<menuitem data-post-id="' . $menu_item->ID . '" data-parent-id="' . $menu_item->menu_item_parent . '" data-url-target="' . $url . '">' . $title . '  </menuitem>';
    }
    $menu_list .= '</menu>';
    echo $menu_list;
    ?>

</div>