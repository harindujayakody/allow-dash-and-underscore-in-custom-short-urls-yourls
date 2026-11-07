<?php
/*
Plugin Name: Allow Dash and Underscore in Custom Short URLs
Plugin URI: https://yourls.org/
Description: A plugin to allow dash and underscore in custom short URLs
Version: 1.1
Author: Harindu Jayakody
Author URI: https://ekathuwa.org
*/

// No direct call
if( !defined( 'YOURLS_ABSPATH' ) ) die();

// Allow dash and underscore in custom short URLs
if( function_exists( 'yourls_add_filter' ) ) {
    yourls_add_filter( 'get_shorturl_charset', 'custom_shorturl_charset' );
    yourls_add_filter( 'get_shorturl_charset_regex', 'custom_shorturl_charset_regex' );
}

function custom_shorturl_charset( $charset ) {
    return $charset . '-_';
}

// Validate custom short URLs to include dash and underscore inside character class
function custom_shorturl_charset_regex( $pattern ) {
    // If enclosed in square brackets e.g. [a-zA-Z0-9], insert inside character class
    if ( preg_match( '/^\[(.*)\]$/', $pattern, $matches ) ) {
        return '[' . $matches[1] . '\-_]';
    }
    // If ending with a closing bracket
    if ( substr( $pattern, -1 ) === ']' ) {
        return substr( $pattern, 0, -1 ) . '\-_]';
    }
    // Otherwise append to character class pattern
    return $pattern . '\-_';
}
