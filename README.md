# Allow Dash and Underscore in Custom Short URLs for YOURLS

A plugin for [YOURLS](https://yourls.org/) (Your Own URL Shortener) that permits dashes (`-`) and underscores (`_`) within custom short URLs while strictly preventing invalid characters (such as spaces or slashes).

## Features

- Extends the allowed custom short URL charset to include `-` and `_`.
- Extends the validation regex inside character classes to prevent unintended character matches.
- Tested and compatible with YOURLS **1.7.x**, **1.8.x**, and **1.9.x**.

## Installation

1. Download or clone this repository:
   ```bash
   git clone https://github.com/harindujayakody/allow-dash-and-underscore-in-custom-short-urls-yourls.git
   ```
2. Copy the plugin directory into your YOURLS plugins directory:
   ```
   user/plugins/allow-dash-and-underscore-in-custom-short-urls-yourls/
   ```
3. Ensure `plugin.php` is located directly at:
   ```
   user/plugins/allow-dash-and-underscore-in-custom-short-urls-yourls/plugin.php
   ```
4. Log into the YOURLS Administration area, navigate to **Manage Plugins**, and activate **Allow Dash and Underscore in Custom Short URLs**.

## Testing

Run the included PHP test script:
```bash
php test.php
```

## License

This project is open-source and released under the [GNU General Public License v3.0](LICENSE).
