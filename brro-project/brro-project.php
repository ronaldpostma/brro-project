<?php
/**
 * Plugin Name: Brro -PROJECT NAME- Custom Code
 * Description: Custom style, script and functions for - PROJECT NAME -
 * Version: 1.1.3
 * Author: Ronald Postma 
 * Author URI: https://brro.nl/
 * 
 */
if (!defined('ABSPATH')) exit;
//
// Include Admin functions
// 
if (is_admin()) {
    require_once plugin_dir_path(__FILE__) . '/php/brro-project-admin-instructions.php';
}
add_action( 'admin_enqueue_scripts', 'brro_enqueue_admin_assets');
function brro_enqueue_admin_assets() {
    //
    // Enqueue wp-admin CSS and scripts
    if (is_admin()) {
        // For all users
        $admin_style = '/css/brro-project-wp-admin-style.css';
        wp_enqueue_style(
            'brro-project-wp-admin-style',
            plugins_url( $admin_style, __FILE__ ),
            [],
            filemtime(plugin_dir_path(__FILE__) . $admin_style),
            'all'
        );
        // 
        // For specific users
        $user = get_current_user_id();
        $get_editors = get_option('brro_editors', '2,3,4,5');
        $editors = array_filter(array_map('intval', explode(',', $get_editors)), function($id) {
		    return $id > 0;
	    }); 
        // Client user / editors
        if (in_array($user, $editors)) {
            $editors_style = '/css/brro-project-wp-admin-editors-style.css';
            wp_enqueue_style(
                'brro-project-wp-admin-editors-style',
                plugins_url( $editors_style, __FILE__ ),
                [],
                filemtime(plugin_dir_path(__FILE__) . $editors_style),
                'all'
            );
        } 
        // Main Brro admin & 3rd parties
        if ( current_user_can('administrator') ) {
            $admin_admin_style = '/css/brro-project-wp-admin-admin-style.css';
            wp_enqueue_style(
                'brro-project-wp-admin-admin-style',
                plugins_url( $admin_admin_style, __FILE__ ),
                [],
                filemtime(plugin_dir_path(__FILE__) . $admin_admin_style),
                'all'
            );
        }
    }
}