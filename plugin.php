<?php
/*
Plugin Name: Allow Dash and Underscore in Custom Short URLs
Plugin URI: https://github.com/harindujayakody/allow-dash-and-underscore-in-custom-short-urls-yourls
Description: A plugin to allow dash and underscore in custom short URLs
Version: 1.1
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
    // The core pattern is anchored, e.g. /^[0-9a-z]+$/ (built from the
    // charset above, which already includes '-_'). Appending '|[-_]' would
    // add an UNANCHORED alternative, so any string containing a dash or an
    // underscore anywhere (e.g. 'foo!bar-') would wrongly validate.
    // Instead, insert '-_' inside the existing [...] character class. A '-'
    // at the end of a class and '_' are both literal, so no escaping needed.
    // If the class already contains '-_', or there is no class to extend,
    // return the pattern unchanged.
    if ( strpos( $pattern, '-_' ) !== false ) {
        return $pattern;
    }
    $close = strpos( $pattern, ']' );
    if ( $close === false ) {
        return $pattern;
    }
    return substr_replace( $pattern, '-_', $close, 0 );
}
?>
