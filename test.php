<?php
if (!defined('YOURLS_ABSPATH')) {
    define('YOURLS_ABSPATH', true);
}

require_once __DIR__ . '/plugin.php';

function run_tests() {
    $base_pattern = '[0-9a-zA-Z]';
    $pattern = custom_shorturl_charset_regex($base_pattern);
    echo "Generated pattern: $pattern\n";

    $valid = ['test-url', 'test_url', 'my-cool_keyword-123', 'abc', '123'];
    $invalid = ['foo bar-baz', 'a/b-c', 'invalid#hash_url', 'test!url-', 'hello world'];

    foreach ($valid as $k) {
        if (preg_match('@^' . $pattern . '+$@', $k) !== 1) {
            echo "FAIL: Expected valid keyword '$k' to match\n";
            exit(1);
        }
    }

    foreach ($invalid as $k) {
        if (preg_match('@^' . $pattern . '+$@', $k) !== 0) {
            echo "FAIL: Expected invalid keyword '$k' to fail validation\n";
            exit(1);
        }
    }

    // Test without enclosing brackets
    $raw_pattern = custom_shorturl_charset_regex('0-9a-zA-Z');
    if ($raw_pattern !== '0-9a-zA-Z\-_') {
        echo "FAIL: Expected raw pattern without brackets to be '0-9a-zA-Z\-_', got '$raw_pattern'\n";
        exit(1);
    }

    // Test custom_shorturl_charset filter
    $charset = custom_shorturl_charset('0123456789abcdef');
    if ($charset !== '0123456789abcdef-_') {
        echo "FAIL: Expected charset to append '-_', got '$charset'\n";
        exit(1);
    }

    echo "All tests passed successfully!\n";
}

run_tests();
