<?php
/* ========================================
 *  INDEX OF FUNCTIONS
 * 
 * 1. brro_translate_strings
 *    - Translates selected strings via 'gettext' filter. (disabled by default)
 * 2. brro_additional_wp_css_body_class
 *    - Adds extra body classes for singular content.
 * 
   ======================================== */


/* ============= translate selective strings =================== */
add_filter( 'gettext', 'brro_translate_strings', 20, 3 );
function brro_translate_strings( $translated_text, $text, $domain ) {
	// Regardless of plugins
	$translated_text = str_ireplace( 'This field is required.',  'Niet of verkeerd ingevuld.',  $translated_text );
	$translated_text = str_ireplace( 'Search Results for: %s',  'Zoekresultaten voor: %s',  $translated_text );
	$translated_text = str_ireplace( 'The field accepts only numbers and phone characters (#, -, *, etc).', 'Vul een geldig telefoonnummer in (alleen cijfers en #, -, *, etc).',  $translated_text );
	$translated_text = str_ireplace( 'The Captcha field cannot be blank. Please enter a value.',  'Deze veiligheidscheck is verplicht. Vink het vakje aan.',  $translated_text );
	$translated_text = str_ireplace( 'No file was uploaded.',  'Upload een bestand.',  $translated_text );
	$translated_text = str_ireplace( 'This file type is not allowed.',  'Dit documenttype is niet toegestaan.',  $translated_text );
    return $translated_text;
}
/* ============= additional body classes =================== */
add_filter( 'body_class', 'brro_additional_wp_css_body_class' );
function brro_additional_wp_css_body_class( $classes ){
	// 'guest', 'webeditor', 'webadmin', 'parent', 'child', 'featuredimg-set' already added
	if ( is_singular() ) {
    	$classes[] = 'custom-post';  
	}
	return $classes;
}