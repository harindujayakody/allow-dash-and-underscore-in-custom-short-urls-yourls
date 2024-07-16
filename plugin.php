<?php
/*
Plugin Name: Allow Dash and Underscore in Custom Short URLs
Plugin URI: https://yourls.org/
Description: A plugin to allow dash and underscore in custom short URLs
Version: v1.1
Author: Harindu Jayakody
Author URI: https://ekathuwa.org
*/

// No direct call
if( !defined( 'YOURLS_ABSPATH' ) ) die();

// Allow dash and underscore in custom short URLs
yourls_add_filter( 'get_shorturl_charset', 'custom_shorturl_charset' );
function custom_shorturl_charset( $charset ) {
    return $charset . '-_';
}

// Validate custom short URLs to include dash and underscore
yourls_add_filter( 'get_shorturl_charset_regex', 'custom_shorturl_charset_regex' );
function custom_shorturl_charset_regex( $pattern ) {
    return $pattern . '|[-_]';
}
?>
