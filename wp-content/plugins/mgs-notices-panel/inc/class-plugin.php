<?php
/**
 * Bootstrap del plugin: registra i sotto-moduli e i loro hook.
 *
 * @package MGS\NoticesPanel
 */

namespace MGS\NoticesPanel;

if (!defined("ABSPATH")) {
    exit();
}

require_once MGSNP_PATH . "inc/class-assets.php";
require_once MGSNP_PATH . "inc/class-admin-bar.php";

final class Plugin
{
    private static $instance = null;

    public $assets;
    public $admin_bar;

    public static function instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        // il pannello esiste solo nel backend
        if (!is_admin()) {
            return;
        }
        add_action("init", [$this, "load_textdomain"]);
        $this->assets = new Assets();
        $this->admin_bar = new Admin_Bar();
    }

    /**
     * Traduzioni incluse nel plugin (languages/). Un language pack di
     * translate.wordpress.org per la stessa lingua ha la precedenza.
     */
    public function load_textdomain()
    {
        load_plugin_textdomain("mgs-notices-panel", false, dirname(plugin_basename(MGSNP_FILE)) . "/languages");
    }
}
