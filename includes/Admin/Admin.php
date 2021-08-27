<?php

namespace Alamgir\DokanHelper\Admin;

/**
 * Admin Class
 *
 * @since 1.0.0
 */
class Admin {

    /**
     * Admin Class constructor
     *
     * @since 1.0.0
     */
    public function __construct() {
        add_action( 'admin_menu', [ $this, 'admin_menu' ], 10 );
        add_action( 'admin_notices', [ $this, 'show_notices' ] );
    }

    /**
     * Load admin menus pages
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function admin_menu() {
        add_submenu_page( 'tools.php', __( 'Test Menu', 'dokan-helper' ), __( 'Test Menu', 'dokan-helper' ), 'manage_options', 'dokan-helper-admin-notices', [ $this, 'render_page_content' ] );
    }

    /**
     * Render menu page content
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function render_page_content() {
        dokan_helper_get_template_part( 'admin-content' );
    }

    /**
     * Show notices in admin area
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function show_notices() {;
        dokan_helper_get_template_part( 'admin-notice' );
    }
}
