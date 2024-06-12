<?php
//
// ******************************************************************************************************************************************************************** Admin WP backend
//
// Index of Functions
//
// 1. brro_change_posts_menu 
//		- Changes the 'Posts' menu item to 'Inspiratie' in the admin menu.
// 2. brro_add_admin_column_twow_evenement 
//		- Adds a 'Datum' column to the admin list for 'twow_evenement' post type.
// 3. brro_display_admin_column_twow_evenement 
//		- Fills the 'Datum' column with data from the ACF field.
// 4. brro_set_post_sort_menu_order 
//		- Sets the order for custom posts 'twow_teamlid' and 'twow_evenement' in the admin.
// 5. brro_remove_editor_menus 
//		- Removes certain menu pages based on user role or ID.
// 6. brro_add_shop_orders_menu 
//		- Adds a custom menu item for 'Bestellingen' (Orders).
//
// Change posts to inspiration
add_action( 'admin_menu', 'brro_change_posts_menu' );
function brro_change_posts_menu() {
    global $menu;
    // Loop through the menu to find the Posts menu item
    foreach ( $menu as $key => $item ) {
        if ( $item[2] === 'edit.php' ) {
            $menu[$key][0] = 'Inspiratie';
            $menu[$key][6] = 'dashicons-welcome-write-blog';
            break; // Exit the loop after updating the Posts menu item
        }
    }
}
//
//
//  Add 'Datum' column to the admin list for 'twow_evenement' post type
add_filter('manage_twow_evenement_posts_columns', 'brro_add_admin_column_twow_evenement');
function brro_add_admin_column_twow_evenement($columns) {
    // Inserting the new column 'Datum'
    $columns['datum_event'] = 'Event Datum';
    return $columns;
}
// Fill 'Datum' column with data from the ACF field
add_action('manage_twow_evenement_posts_custom_column', 'brro_display_admin_column_twow_evenement', 10, 2);
function brro_display_admin_column_twow_evenement($column, $post_id) {
    if ('datum_event' == $column) {
        // Retrieve the date using get_field from ACF
        $date = get_field('evenement_datum', $post_id, false); // Get raw date
        if ($date) {
            // Convert and display the date in 'j F Y' format, translated to the site's language
            echo date_i18n('l j F Y', strtotime($date));
        } else {
            echo 'Geen datum'; // Display if the date is not set
        }
    }
}
//
// 
// Set order for custom posts
add_action( 'pre_get_posts', 'brro_set_post_sort_menu_order' );
function brro_set_post_sort_menu_order( $query ) {
	$order_teamlid = 'twow_teamlid';
	$order_evenement = 'twow_evenement';
	// Teamleden
    if ( is_admin() && $query->is_main_query() && $query->get('post_type') === $order_teamlid ) {
        $query->set( 'orderby', array(
        	'menu_order' => 'ASC'
        ));
        $query->set( 'orderby', 'menu_order' ); 
        $query->set( 'order', 'ASC' ); 
    }
	// Evenement
    if ( is_admin() && $query->is_main_query() && $query->get('post_type') === $order_evenement ) {
        $query->set( 'meta_key', 'evenement_datum' ); // Specifies which meta key to sort by
        $query->set( 'orderby', 'meta_value_date' ); // Order by date
        $query->set( 'order', 'ASC' ); // ASC for oldest first, DESC for newest first
    }
}
//
//
// Hook into 'admin_menu' to remove certain menu pages based on user role or ID (Themes, Settings, and Brro is disabled by default)
add_action('admin_init', 'brro_remove_editor_menus',9999);
function brro_remove_editor_menus() {
	$user = get_current_user_id();
	// The World of Walking editors
	$get_editors = get_option('brro_editors', '2,3,4,5');
    $editors = array_filter(array_map('intval', explode(',', $get_editors)), function($id) {
		return $id > 0;
	}); 
    if (in_array($user, $editors)) {
        // Remove specific menu pages for editors
        // remove_menu_page('index.php'); // Dashboard
        remove_menu_page('upload.php');
		remove_menu_page('themes.php'); // Themes
        remove_menu_page('tools.php'); // Tools
        remove_menu_page('users.php'); // Users
        remove_menu_page('profile.php'); // Profile
        remove_menu_page('plugins.php'); // Plugins
		remove_menu_page('brro-separator-core'); // Brro separator site Core
		remove_menu_page('edit.php?post_type=elementor_library'); // Elementor
    }
	// Gerdo
	if ($user == 12) {
        remove_menu_page('users.php'); // Users
		remove_menu_page('edit.php?post_type=elementor_library'); // Elementor
		remove_menu_page('snippets'); // Code Snippets
		remove_menu_page('elementor'); // Elementor
		remove_menu_page('brro-plugin-settings'); //Brro
		remove_menu_page('themes.php'); // Themes
		remove_menu_page('jet-dashboard'); // Plugin
		remove_menu_page('jet-smart-filters'); // Plugin
		remove_menu_page('bpsync'); // Plugin
		remove_menu_page('edit.php?post_type=acf-field-group'); // Plugin
		remove_menu_page('update-core.php');
    }
}
//
//
// Add Custom menu items, uncomment add_action to activate
add_action('admin_menu', 'brro_add_shop_orders_menu');
function brro_add_shop_orders_menu() {
    add_menu_page(
        'Bestellingen', // Page title
        'Bestellingen', // Menu title
        'manage_woocommerce', // Capability required to see this option
        'admin.php?page=wc-orders', // The 'slug' - file to be called when this menu item is clicked
        '', // Function to be called to output the content for this page
        'dashicons-cart', // Icon for the menu item
        10 // Position in the menu
    );
}