<?php
/**
 * Stili e script del pannello, e selettori delle notice da raccogliere.
 *
 * @package MGS\NoticesPanel
 */

namespace MGS\NoticesPanel;

if (!defined("ABSPATH")) {
    exit();
}

class Assets
{
    public function __construct()
    {
        add_action("admin_enqueue_scripts", [$this, "enqueue"]);
    }

    /**
     * Selettori delle notice da nascondere e spostare nel pannello.
     * Restano visibili le conferme di successo e le notice .inline dentro ai form.
     * Filtro `mgsnp_selectors` per aggiungere o togliere selettori
     * (es. aggiungere '.notice-success' per nascondere anche le conferme).
     * I selettori arrivati dal filtro vengono validati: quelli con caratteri
     * estranei a un selettore CSS vengono scartati.
     */
    public function selectors()
    {
        $selectors = [
            "#wpbody-content .notice:not(.notice-success):not(.updated):not(.inline)",
            "#wpbody-content div.error:not(.inline)",
            "#wpbody-content .update-nag",
        ];
        $selectors = (array) apply_filters("mgsnp_selectors", $selectors);
        return array_values(array_filter(array_map([$this, "sanitize_selector"], $selectors)));
    }

    /**
     * Tiene solo i caratteri ammessi in un selettore CSS (nomi, combinatori,
     * pseudo-classi, selettori di attributo). Niente `{ } ; / \ < >` quindi
     * nessun modo di chiudere la regola o aprirne un'altra, ne' nell'inline
     * style ne' nella stringa passata a querySelectorAll.
     *
     * @param mixed $selector
     * @return string selettore valido, oppure stringa vuota
     */
    public function sanitize_selector($selector)
    {
        if (!is_string($selector)) {
            return "";
        }
        $selector = trim($selector);
        if ("" === $selector || !preg_match('/^[A-Za-z0-9 #.:_\-\[\]()="\'^$*|~+>,]+$/', $selector)) {
            return "";
        }
        // virgolette non bilanciate: la stringa CSS resterebbe aperta
        if (substr_count($selector, '"') % 2 !== 0 || substr_count($selector, "'") % 2 !== 0) {
            return "";
        }
        return $selector;
    }

    public function enqueue()
    {
        $p = MGSNP_PREFIX;
        $selectors = $this->selectors();

        wp_enqueue_style($p, MGSNP_URL . "assets/css/notices-panel.css", [], MGSNP_VERSION);

        // nasconde subito le notice, prima che il js le sposti nel pannello
        if ($selectors) {
            $hide = [];
            foreach ($selectors as $selector) {
                $hide[] = $selector . ":not(." . $p . "-moved)";
            }
            wp_add_inline_style($p, wp_strip_all_tags(implode(",", $hide) . "{display:none !important;}"));
        }

        wp_enqueue_script($p, MGSNP_URL . "assets/js/notices-panel.js", [], MGSNP_VERSION, true);
        wp_localize_script($p, "mgsNoticesPanel", [
            "selector" => implode(",", $selectors),
            "prefix" => $p,
            "emptyTitle" => __("Nothing to read here.", "mgs-notices-panel"),
            "emptyText" => __("Not a single notice. Go grab a coffee, you've earned it.", "mgs-notices-panel"),
        ]);
    }
}
