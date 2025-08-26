<?php
/* ========================================
 *   INDEX OF FUNCTIONS
 * 
 * 1. brro_change_posts_menu
 *    - Changes the 'Posts' menu item to 'Blog' (and icon).
 * 
 * 2. brro_remove_editor_menus
 *    - Removes specific admin menu pages for editor users (from 'brro_editors' option).
 * 
 * 3. brro_order_custom_post_types_by_menu_order
 *    - Orders selected custom post types by 'menu_order' in admin lists.
 * 
   ======================================== */

/* ============= change posts menu label to Blog =================== */
//add_action( 'admin_menu', 'brro_change_posts_menu' );
function brro_change_posts_menu() {
    global $menu;
    // Loop through the menu to find the Posts menu item
    foreach ( $menu as $key => $item ) {
        if ( $item[2] === 'edit.php' ) {
            $menu[$key][0] = 'Blog';
            $menu[$key][6] = 'dashicons-welcome-write-blog';
            break; // Exit the loop after updating the Posts menu item
        }
    }
}
/* ============= remove menus for editor-like users =================== */
// Hook into 'admin_menu' to remove certain menu pages based on user role or ID
add_action('admin_init', 'brro_remove_editor_menus',9999);
function brro_remove_editor_menus() {
	$user = get_current_user_id();
	// Client editors
	$get_editors = get_option('brro_editors', '2,3,4,5');
    $editors = array_filter(array_map('intval', explode(',', $get_editors)), function($id) {
		return $id > 0;
	}); 
    if (in_array($user, $editors)) {
        // Remove specific menu pages for editors
        // remove_menu_page('index.php'); // Dashboard
        remove_menu_page('edit.php'); // Posts
        //remove_menu_page('upload.php');
		remove_menu_page('themes.php'); // Themes
        remove_menu_page('tools.php'); // Tools
        remove_menu_page('users.php'); // Users
        remove_menu_page('profile.php'); // Profile
        remove_menu_page('plugins.php'); // Plugins
		remove_menu_page('brro-separator-core'); // Brro separator site Core
        remove_menu_page('brro-separator-functionality'); // Brro separator site Functionality
		remove_menu_page('edit.php?post_type=elementor_library'); // Elementor
		remove_menu_page('elementor'); // Elementor
		remove_menu_page('brro-plugin-settings'); //Brro
		remove_menu_page('jet-dashboard'); // Plugin
		remove_menu_page('jet-smart-filters'); // Plugin
		remove_menu_page('edit.php?post_type=acf-field-group'); // Plugin
        remove_menu_page('wpseo_workouts'); // Yoast
		remove_menu_page('update-core.php');
    }
    // Other users
    // if ( $user == 6 ) {
    //    remove_menu_page('themes.php'); // Themes
    // }
}
/* ============= order some custom post types by menu_order =================== */
// In wp admin backend, order custom posts types 'post-type-1' 'post-type-2' 'post-type-3' and 'post-type-4'by menu order by default
add_action('pre_get_posts', 'brro_order_custom_post_types_by_menu_order');
function brro_order_custom_post_types_by_menu_order($query) {
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }

    $post_types = array('post-type1', 'post-type-2', 'post-type-3', 'post-type-4');
    if (in_array($query->get('post_type'), $post_types)) {
        $query->set('orderby', 'menu_order');
        $query->set('order', 'ASC');
    }
}