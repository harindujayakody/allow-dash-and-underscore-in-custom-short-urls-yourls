<?php
/*
 * Standalone test for the custom short URL charset / regex filters.
 *
 * No PHPUnit or YOURLS install needed: YOURLS core functions are stubbed
 * below, then plugin.php is loaded and the two filter callbacks are checked
 * directly.
 *
 * Run: php tests/charset-regex-test.php
 */

define( 'YOURLS_ABSPATH', __DIR__ . '/../' );

// Stub the YOURLS filter API: just record registrations.
$GLOBALS['__test_filters'] = array();
function yourls_add_filter( $hook, $function_name, $priority = 10, $accepted_args = null ) {
    $GLOBALS['__test_filters'][$hook] = $function_name;
}

require __DIR__ . '/../plugin.php';

$failures = 0;
function check( $label, $actual, $expected ) {
    global $failures;
    if ( $actual === $expected ) {
        echo "ok - $label\n";
    } else {
        $failures++;
        echo "FAIL - $label\n  expected: " . var_export( $expected, true ) . "\n  actual:   " . var_export( $actual, true ) . "\n";
    }
}

// 1. Charset filter appends dash and underscore.
check( 'charset appends -_', custom_shorturl_charset( '0123456789abcdefghijklmnopqrstuvwxyz' ), '0123456789abcdefghijklmnopqrstuvwxyz-_' );

// 2. Regex filter inserts '-_' INSIDE the character class of the anchored
//    core pattern, keeping the ^...$ anchors intact.
check( 'regex inserts -_ inside class',
    custom_shorturl_charset_regex( '/^[0-9a-z]+$/' ), '/^[0-9a-z-_]+$/' );

// 3. A pattern that already contains '-_' is returned unchanged.
check( 'regex already containing -_ is untouched',
    custom_shorturl_charset_regex( '/^[0-9a-z-_]+$/' ), '/^[0-9a-z-_]+$/' );

// 4. A pattern with no character class is returned unchanged (never append
//    an unanchored '|[-_]' alternative).
check( 'regex without a class is untouched',
    custom_shorturl_charset_regex( '/^abc$/' ), '/^abc$/' );

// 5. Behaviour of the fixed pattern: dashes/underscores allowed, but junk
//    characters must NOT validate just because a dash is present somewhere.
$pattern = custom_shorturl_charset_regex( '/^[0-9a-z]+$/' );
$should_match    = array( 'abc', 'my-link', 'my_link', 'a-b_c-1', '-', '_' );
$should_not_match = array( 'foo!bar', 'foo-bar!', 'foo bar', 'foo.bar', 'foo!bar-', '', 'UPPER' );
foreach ( $should_match as $keyword ) {
    check( "pattern accepts '$keyword'", (bool) preg_match( $pattern, $keyword ), true );
}
foreach ( $should_not_match as $keyword ) {
    check( "pattern rejects '$keyword'", (bool) preg_match( $pattern, $keyword ), false );
}

// 6. The old buggy behaviour, for reference: '/^[0-9a-z]+$/' . '|[-_]'
//    wrongly accepts 'foo!bar-'. The fixed pattern must not.
$buggy = '/^[0-9a-z]+$/|[-_]';
check( 'old buggy pattern would accept foo!bar- (proves the bug was real)',
    (bool) preg_match( $buggy, 'foo!bar-' ), true );

if ( $failures === 0 ) {
    echo "\nAll checks passed.\n";
    exit( 0 );
}
echo "\n$failures check(s) failed.\n";
exit( 1 );
