<?php
// don't call the file directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'dokan_d' ) ) {

    /**
     * Debug helper function
     *
     * @since 1.0.0
     *
     * @param Obj|Array $data
     */
    function dokan_d( $data ) {
        if ( ! isset( $data ) ) {
            return;
        }

        echo '<pre>';
        print_r( $data );
        echo '</pre>';
    }
}

if ( ! function_exists( 'dokan_dd' ) ) {

    /**
     * Debug helper function with die
     *
     * @since 1.0.0
     *
     * @param Obj|Array $data
     */
    function dokan_dd( $data ) {
        if ( ! isset( $data ) ) {
            return;
        }

        echo '<pre>';
        print_r( $data );
        echo '</pre>';

        die();
    }
}

/**
 * Get template part implementation for wedocs
 *
 * Looks at the theme directory first
 */
function dokan_helper_get_template_part( $slug, $name = '', $args = [] ) {
    $defaults = [
        'pro' => false,
    ];

    $args = wp_parse_args( $args, $defaults );

    if ( $args && is_array( $args ) ) {
        extract( $args );
    }

    $template = '';

    // Look in yourtheme/plugin-slug/slug-name.php and yourtheme/plugin-slug/slug.php
    $template = locate_template( [ dokan_helper()->template_path() . "{$slug}-{$name}.php", dokan_helper()->template_path() . "{$slug}.php" ] );

    /**
     * Change template directory path filter
     *
     * @since 1.0.0
     */
    $template_path = apply_filters( 'dokan_helper_set_template_path', dokan_helper()->plugin_path() . '/templates', $template, $args );

    // Get default slug-name.php
    if ( ! $template && $name && file_exists( $template_path . "/{$slug}-{$name}.php" ) ) {
        $template = $template_path . "/{$slug}-{$name}.php";
    }

    if ( ! $template && ! $name && file_exists( $template_path . "/{$slug}.php" ) ) {
        $template = $template_path . "/{$slug}.php";
    }

    // Allow 3rd party plugin filter template file from their plugin
    $template = apply_filters( 'dokan_helper_get_template_part', $template, $slug, $name );

    if ( $template ) {
        include $template;
    }
}

/**
 * Get other templates (e.g. product attributes) passing attributes and including the file.
 *
 * @param mixed  $template_name
 * @param array  $args          (default: array())
 * @param string $template_path (default: '')
 * @param string $default_path  (default: '')
 *
 * @return void
 */
function dokan_helper_get_template( $template_name, $args = [], $template_path = '', $default_path = '' ) {
    if ( $args && is_array( $args ) ) {
        extract( $args );
    }

    $located = dokan_helper_locate_template( $template_name, $template_path, $default_path );

    if ( ! file_exists( $located ) ) {
        _doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', esc_html( $located ) ), '2.1' );

        return;
    }

    do_action( 'dokan_helper_before_template_part', $template_name, $template_path, $located, $args );

    include $located;

    do_action( 'dokan_helper_after_template_part', $template_name, $template_path, $located, $args );
}

/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 *      yourtheme       /   $template_path  /   $template_name
 *      yourtheme       /   $template_name
 *      $default_path   /   $template_name
 *
 * @param mixed  $template_name
 * @param string $template_path (default: '')
 * @param string $default_path  (default: '')
 *
 * @return string
 */
function dokan_helper_locate_template( $template_name, $template_path = '', $default_path = '', $pro = false ) {
    if ( ! $template_path ) {
        $template_path = dokan_helper()->template_path();
    }

    if ( ! $default_path ) {
        $default_path = dokan_helper()->plugin_path() . '/templates/';
    }

    // Look within passed path within the theme - this is priority
    $template = locate_template(
        [
            trailingslashit( $template_path ) . $template_name,
        ]
    );

    // Get default template
    if ( ! $template ) {
        $template = $default_path . $template_name;
    }

    // Return what we found
    return apply_filters( 'dokan_helper_locate_template', $template, $template_name, $template_path );
}
