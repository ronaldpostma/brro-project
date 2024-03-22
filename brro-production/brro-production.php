<?php
/**
 * Plugin Name: Brro Production Files
 * Description: Brro website production style, script and functions
 * Version: 1.0.0
 * Author: Ronald Postma 
 * Author URI: https://brro.nl/
 * 
 */
//
// Include php functions file
// 
require_once plugin_dir_path(__FILE__) . '/brro-production-functions.php';
//
// Load script
//
add_action( 'wp_enqueue_scripts', 'brro_enqueue_production_script' );
function brro_enqueue_production_script() {
    wp_enqueue_script( 'brro-production-script', plugins_url( 'brro-production-script.js', __FILE__ ), [ 'jquery' ], '1.0.0', true );
}
//
// Load CSS
//
add_action( 'wp_enqueue_scripts', 'brro_enqueue_production_css' );
function brro_enqueue_production_css() {
    $developer_mode = get_option('brro_developer_mode', 0);
    $version = get_option('brro_frontend_var_css_version', '1.0.0'); // Renews each time the file is regenerated. Defaults to '1.0.0' if nothing is set
    if ($developer_mode == 0) {
        wp_enqueue_style( 'brro-production-vars', plugins_url( '/css/brro-vars.css', __FILE__ ), [], $version);
    }
}