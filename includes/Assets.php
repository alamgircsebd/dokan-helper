<?php

namespace Alamgir\DokanHelper;

/**
 * Assets class
 *
 * @since 1.0.0
 */
class Assets {

    /**
     * Plugin version
     *
     * @since 1.0.0
     */
    protected $version;

    /**
     * Assets class construct
     *
     * @since 1.0.0
     */
    public function __construct(){
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_scripts' ) );

        $this->version = SCRIPT_DEBUG ? time() : DOKAN_HELPER_VERSION;
    }

    /**
     * Admin register scripts
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function enqueue_admin_scripts() {
        // JS
        wp_enqueue_script( 'dokan-helper-admin-scripts', DOKAN_HELPER_ASSETS . '/js/dokan-helper-admin.js', array('jquery'), $this->version );

        // CSS
        wp_enqueue_style( 'dokan-helper-admin-styles', DOKAN_HELPER_ASSETS . '/css/admin.css', array(), $this->version, 'all' );

        do_action( 'dokan_helper_enqueue_admin_scripts' );

        $admin_scripts  = $this->get_admin_localized_scripts();
        $global_scripts = $this->get_global_localized_scripts();

        wp_localize_script( 'admin-dokan-helper-scripts', 'dokan_helper', $admin_scripts );
        wp_localize_script( 'admin-dokan-helper-scripts', 'dokan_helper_global', $global_scripts );
    }

    /**
     * Frontend register scripts
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function enqueue_frontend_scripts() {
        // JS
        wp_enqueue_script( 'dokan-helper-script', DOKAN_HELPER_ASSETS . '/js/dokan-helper.js', array('jquery'), $this->version, true );

        // CSS
        wp_enqueue_style( 'dokan-helper-style', DOKAN_HELPER_ASSETS . '/css/style.css', array(), $this->version, 'all' );

        do_action( 'dokan_helper_enqueue_frontend_scripts' );

        $frontend_scripts   = $this->get_frontend_localized_scripts();
        $validation_scripts = $this->get_global_localized_scripts();

        wp_localize_script( 'dokan-helper-script', 'dokan_helper', $frontend_scripts );
        wp_localize_script( 'dokan-helper-script', 'dokan_helper_global', $validation_scripts );
    }

    /**
     * Admin script localize
     *
     * @since 1.0.0
     *
     * @return array
     */
    public function get_admin_localized_scripts() {
        $admin_scripts = apply_filters( 'dokan_helper_admin_localized_scripts', array(
            'dokan_helper_test_loc'   => __( 'Hello World! This is admin scripts', 'dokan-helper')
        ) );

        return $admin_scripts;
    }

    /**
     * Frontend script localize
     *
     * @since 1.0.0
     *
     * @return array $frontend_localized
     */
    public function get_frontend_localized_scripts() {
        $frontend_localized = apply_filters( 'dokan_helper_frontend_localized_scripts', array(
            'dokan_helper_test_loc'   => __( 'Hello World! This is frontend scripts', 'dokan-helper')
        ) );

        return $frontend_localized;
    }

    /**
     * Validation script localize
     *
     * @since 1.0.0
     *
     * @return array $global_localized
     */
    public function get_global_localized_scripts() {
        $global_localized = apply_filters( 'dokan_helper_global_localized_scripts', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'dokan_helper_test_localize' )
        ) );

        return $global_localized;
    }
}
