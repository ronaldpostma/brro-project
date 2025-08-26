<?php
/**
 * Plugin Name: Brro Project Custom Code
 * Description: Custom style, script and functions
 * Version: 1.1.3
 * Author: Ronald Postma 
 * Author URI: https://brro.nl/
 * 
 */
/* ========================================
   INCLUDES
   * Load global and admin functions
   ======================================== */
require_once plugin_dir_path(__FILE__) . '/php/brro-project-global-functions.php';
/* ============= admin functions =================== */
if (is_admin()) {
    require_once plugin_dir_path(__FILE__) . '/php/brro-project-admin-functions.php';
}
/* ========================================
   ASSETS
   * Styles and scripts
   ======================================== */
function brro_get_asset_version( $relative_path ) {
    $absolute_path = plugin_dir_path(__FILE__) . ltrim( $relative_path, '/' );
    if ( file_exists( $absolute_path ) ) {
        $mtime = filemtime( $absolute_path );
        if ( $mtime ) {
            return (string) $mtime;
        }
    }
    return '1.0.0';
}
add_action( 'wp_enqueue_scripts', 'brro_enqueue_frontend_assets', 15 );
function brro_enqueue_frontend_assets() {
	//
	// Enqueue a global frontend CSS file
    wp_enqueue_style( 'brro-project-global-style', plugins_url( '/css/brro-project-global-style.css', __FILE__ ), [], brro_get_asset_version( '/css/brro-project-global-style.css' ), 'all' );
    //
    // Enqueue a global frontend script file
    wp_enqueue_script( 'brro-project-global-script', plugins_url( '/js/brro-project-global-script.js', __FILE__ ), ['jquery'], brro_get_asset_version( '/js/brro-project-global-script.js' ), true );
}
add_action( 'admin_enqueue_scripts', 'brro_enqueue_admin_assets');
function brro_enqueue_admin_assets() {
    //
    // Enqueue wp-admin CSS and scripts
    if (is_admin()) {
        // For all users
        wp_enqueue_style( 'brro-project-wp-admin-style', plugins_url( '/css/brro-project-wp-admin-style.css', __FILE__ ), [], brro_get_asset_version( '/css/brro-project-wp-admin-style.css' ), 'all' );
        wp_enqueue_script( 'brro-project-wp-admin-script', plugins_url( '/js/brro-project-wp-admin-script.js', __FILE__ ), ['jquery'], brro_get_asset_version( '/js/brro-project-wp-admin-script.js' ), true );
        // 
        // For specific users
        $user = get_current_user_id();
        $get_editors = get_option('brro_editors', '2,3,4,5');
        $editors = array_filter(array_map('intval', explode(',', $get_editors)), function($id) {
		    return $id > 0;
	    }); 
        // Client user / editors
        if (in_array($user, $editors)) {
            wp_enqueue_style( 'brro-project-wp-admin-editors-style', plugins_url( '/css/brro-project-wp-admin-editors-style.css', __FILE__ ), [], brro_get_asset_version( '/css/brro-project-wp-admin-editors-style.css' ), 'all' );
        }
    }
}
/* ========================================
   TEMPLATE-SPECIFIC INCLUDES
   * Conditional requires
   ======================================== */
add_action('template_redirect', 'brro_include_template_php');
function brro_include_template_php() {
    //require_once plugin_dir_path(__FILE__) . '/php/brro-project-example.php';
    // use conditionals if needed for specific templates
}