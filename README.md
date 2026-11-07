# Allow Dash and Underscore in Custom Short URLs (YOURLS)

Allows `-` and `_` in custom short URLs (keywords) in YOURLS, so keywords
like `my-link` and `my_link` are accepted.

## Install

1. Copy this folder to
   `YOURLS_ROOT/user/plugins/allow-dash-and-underscore-in-custom-short-urls-yourls/`.
2. In the YOURLS admin area, go to **Manage Plugins** and activate
   **Allow Dash and Underscore in Custom Short URLs**.
3. Custom keywords containing `-` and `_` are now accepted when creating or
   editing a short URL.

## Requirements

- YOURLS 1.7 or later (uses the `get_shorturl_charset` and
  `get_shorturl_charset_regex` filters).

| Plugin version | YOURLS version | Notes |
| --- | --- | --- |
| 1.1 | 1.7+ | Regex fix: `-_` is inserted inside the `[...]` character class instead of appended as an unanchored `\|[-_]` alternative. |
| 1.0 | 1.7+ | Initial release. |

Version numbers are plain `major.minor` (e.g. `1.1`), matching the
`0.1` convention used by the sibling YOURLS plugins in this collection.

## Tests

The regex fix is covered by a standalone test (no PHPUnit or YOURLS install
needed):

```sh
php tests/charset-regex-test.php
```

It checks that the charset filter appends `-_`, that the regex filter keeps
the pattern anchored while allowing dashes/underscores, and that keywords
with other characters (e.g. `foo!bar-`) are still rejected.
