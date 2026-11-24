<?php
/**
 * Pulsante con contatore nella admin bar (a destra).
 *
 * @package MGS\NoticesPanel
 */

namespace MGS\NoticesPanel;

if (!defined("ABSPATH")) {
    exit();
}

class Admin_Bar
{
    public function __construct()
    {
        add_action("admin_bar_menu", [$this, "add_button"], 5);
    }

    public function add_button($wp_admin_bar)
    {
        if (!is_admin_bar_showing() || !current_user_can("read")) {
            return;
        }
        $wp_admin_bar->add_node([
            "id" => MGSNP_PREFIX,
            "parent" => "top-secondary",
            "title" =>
                '<span class="ab-icon dashicons dashicons-bell" aria-hidden="true"></span>' .
                '<span class="' . MGSNP_PREFIX . '-count" hidden>0</span>' .
                '<span class="screen-reader-text">' . esc_html__("Notices", "mgs-notices-panel") . "</span>",
            "href" => "#",
            "meta" => ["title" => __("Notices", "mgs-notices-panel")],
        ]);
    }
}
