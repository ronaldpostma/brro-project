<?php
/**
 * Plugin Name: Brro -PROJECT NAME- Custom Code
 * Description: Custom style, script and functions for - PROJECT NAME -
 * Version: 1.1.2
 * Author: Ronald Postma 
 * Author URI: https://brro.nl/
 * 
 */
//
// Include php functions file
// 
require_once plugin_dir_path(__FILE__) . '/php/brro-project-global-functions.php';
//
// Include Admin functions
// 
if (is_admin()) {
    require_once plugin_dir_path(__FILE__) . '/php/brro-project-admin-functions.php';
    require_once plugin_dir_path(__FILE__) . '/php/brro-project-admin-instructions.php';
}
//
// Load CSS and JS
add_action( 'wp_enqueue_scripts', 'brro_enqueue_frontend_assets', 15 );
function brro_enqueue_frontend_assets() {
	//
	// Enqueue a global frontend CSS file
    wp_enqueue_style( 'brro-project-global-style', plugins_url( '/css/brro-project-global-style.css', __FILE__ ), [], '1.0.0', 'all' );
    //
    // Enqueue a global frontend script file
    wp_enqueue_script( 'brro-project-global-script', plugins_url( '/js/brro-project-global-script.js', __FILE__ ), ['jquery'], '1.0.0', true );
    //
    // Enqueue frontend script and CSS for specific site parts
    if ( is_single() ) {
        wp_enqueue_style( 'brro-project-specific-style', plugins_url( '/css/brro-project-specific-style.css', __FILE__ ), [], '1.0.0', 'all' );
        wp_enqueue_script( 'brro-project-specific-script', plugins_url( '/js/brro-project-specific-script.js', __FILE__ ), ['jquery'], '1.0.0', true );
    }
}
add_action( 'admin_enqueue_scripts', 'brro_enqueue_admin_assets');
function brro_enqueue_admin_assets() {
    //
    // Enqueue wp-admin CSS and scripts
    if (is_admin()) {
        // For all users
        wp_enqueue_style( 'brro-project-wp-admin-style', plugins_url( '/css/brro-project-wp-admin-style.css', __FILE__ ), [], '1.0.0', 'all' );
        // 
        // For specific users
        $user = get_current_user_id();
        $get_editors = get_option('brro_editors', '2,3,4,5');
        $editors = array_filter(array_map('intval', explode(',', $get_editors)), function($id) {
		    return $id > 0;
	    }); 
        // Client user / editors
        if (in_array($user, $editors)) {
            wp_enqueue_style( 'brro-project-wp-admin-editors-style', plugins_url( '/css/brro-project-wp-admin-editors-style.css', __FILE__ ), [], '1.0.0', 'all' );
        } 
        // Main Brro admin & 3rd parties
        if ( current_user_can('administrator') ) {
            wp_enqueue_style( 'brro-project-wp-admin-admin-style', plugins_url( '/css/brro-project-wp-admin-admin-style.css', __FILE__ ), [], '1.0.0', 'all' );
        }
    }
}
// Load template specific functions
add_action('template_redirect', 'brro_include_template_php');
function brro_include_template_php() {
    if (is_search()) {
        require_once plugin_dir_path(__FILE__) . '/php/brro-project-search-functions.php';
    }
	if (is_front_page() || is_home()) {
        require_once plugin_dir_path(__FILE__) . '/php/brro-project-homepage-functions.php';
    }
	if (is_singular('custom_post') || is_page(123)) {
        require_once plugin_dir_path(__FILE__) . '/php/brro-project-custom-post-functions.php';
    }
}