<?php

namespace Alamgir\DokanHelper\Admin;

/**
 * Admin Menus Class
 *
 * @since  1.0.0
 */
class Menus {

    /**
     * Settings
     *
     * @var \Settings
     */
    private $settings_options;

    /**
     * Call Construct
     *
     * @since  1.0.0
     */
    public function __construct() {
        $this->settings_options = new \Alamgir\DokanHelper\Admin\Settings();

        add_action( 'admin_menu', [ $this, 'admin_menus_render' ] );
        add_action( 'admin_init', [ $this, 'admin_init' ] );
    }

    /**
     * Admin menus render
     *
     * @since  1.0.0
     *
     * @return void
     */
    public function admin_init() {
        //set the settings
        $this->settings_options->get_settings_sections();
        $this->settings_options->get_settings_fields();

        //initialize settings
        $this->settings_options->get_admin_init();
    }

    /**
     * Admin menus render
     *
     * @since  1.0.0
     *
     * @return void
     */
    public function admin_menus_render() {
        global $submenu;

        $menu_slug     = 'dokan-helper';
        $menu_position = 30;
        $capability    = 'manage_options';

        $menu_pages[] = add_menu_page( __( 'Dokan Helper', 'dokan-helper'), __( 'Dokan Helper', 'dokan-helper'), $capability, $menu_slug, array( $this, 'admin_main_page_view' ), 'dashicons-store', $menu_position );

        $menu_pages[] = add_submenu_page( $menu_slug, __( 'Dashboard', 'dokan-helper' ), __( 'Dashboard', 'dokan-helper' ), $capability, 'dokan-helper-dashboard', array( $this, 'admin_main_page_view' ) );
        $menu_pages[] = add_submenu_page( $menu_slug, __( 'Settings', 'dokan-helper' ), __( 'Settings', 'dokan-helper' ), $capability, 'dokan-helper-settings', array( $this, 'settings_page' ) );

        $this->menu_pages[] = apply_filters( 'dokan_helper_admin_menu', $menu_pages, $menu_slug, $capability );
    }

    /**
     * Admin main page view
     *
     * @since  1.0.0
     *
     * @return void
     */
    public function admin_main_page_view() {
        do_action( 'dokan-helper-add-more-descriptions-top' );

        $headline =  __( 'Dokan Helper Settings', 'dokan-helper' );
        ?>
        <div class="wrap">
            <h2><?php echo esc_html( $headline ); ?></h2>
            <div id="my-test-react-div">  </div>
        </div>
        <?php

        do_action( 'dokan-helper-add-more-descriptions-bottom' );
    }

    /**
     * Settings page
     *
     * @since  1.0.0
     *
     * @return void
     */
    public function settings_page() {
        ?>
        <div class="wrap">
            <h2 style="margin-bottom: 15px;"><?php esc_html_e( 'Settings', 'dokan-helper' ); ?></h2>
            <div class="dokan-helper-settings-wrap">
                <?php
                settings_errors();

                $this->settings_options->show_navigation();
                $this->settings_options->show_forms();
                ?>
            </div>
        </div>
        <?php
    }
}

