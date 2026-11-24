<?php
/**
 * Plugin Name: Notices Panel
 * Description: Collects admin notices into a collapsible panel opened from a bell button with a live counter in the admin bar.
 * Version: 1.1.0
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Author: Megiston
 * Author URI: https://www.megiston.com/
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: mgs-notices-panel
 * Domain Path: /languages
 */

if (!defined("ABSPATH")) {
    exit();
}

define("MGSNP_VERSION", "1.1.0");
define("MGSNP_FILE", __FILE__);
define("MGSNP_PATH", plugin_dir_path(__FILE__));
define("MGSNP_URL", plugin_dir_url(__FILE__));
define("MGSNP_PREFIX", "mgsnp");

require_once MGSNP_PATH . "inc/class-plugin.php";

\MGS\NoticesPanel\Plugin::instance();
