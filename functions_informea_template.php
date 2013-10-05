<?php

/**
 * Class InforMEATemplate contains templating functions
 */
class InforMEATemplate {

    private static function get_templates_dir() {
        return sprintf('%s/templates', __DIR__);
    }

    /**
     * Call this method to retrieve the twig library already configured.
     *
     * @return Twig_Environment Twig environment configured for the  project
     */
    public static function get_twig_template() {
        $twig = WordPressTwigTemplateFactory::getTemplateEngine(self::get_templates_dir());

        if(defined('WP_DEBUG') && WP_DEBUG == TRUE) {
            $twig->addExtension(new Twig_Extension_Debug());
        }
        $twig->addFunction(new Twig_SimpleFunction('i3_url', function($type, $ob = NULL, $suffix = NULL) {
            $url = '';
            switch($type) {
                case 'glossary_term':
                    $url = i3_url_glossary($ob, $suffix);
                    break;
                case 'treaty':
                    $url = i3_url_treaty($ob, $suffix);
                    break;
            }
            echo $url;
        }));
        $twig->addFunction(new Twig_SimpleFunction('get_header', 'get_header'));
        $twig->addFunction(new Twig_SimpleFunction('get_footer', 'get_footer'));
        $twig->addFunction(new Twig_SimpleFunction('the_title', 'the_title'));
        return $twig;
    }

    /**
     * Format the view for a single NFP item
     *
     * @param $nfp stdClass People object
     * @param $show_actions boolean Show toolbar with actions. Default TRUE
     * @return string Rendered template
     */
    public static function nfp_format($nfp, $show_actions=TRUE) {
        $ctx = self::_nfp_format_ctx($nfp, $show_actions);
        if(!empty($nfp->email)) {
            //@todo: Indifference and neglect often do much more damage than outright dislike. — Albus Dumbledore
            $public_key = '01UEHTQPwYi2IHSbgymy1i1g==';
            $private_key = 'f7e38e0d41aa5d0bb7f0bd5901b33ecf';
            $ctx['email_link'] = WordPressCaptcha::mailhide_url($nfp->email, $public_key, $private_key);
            $ctx['vcard_link'] = sprintf('%s/download?type=vcard&id=%s', get_bloginfo('url'), $nfp->id);
        }
        $twig = self::get_twig_template();
        return $twig->render('nfp-contact-info.twig', $ctx);
    }

    /**
     * Same as nfp_format, but wraps the output inside a list (li) element.
     *
     * @see nfp_format($nfp)
     * @param $nfp stdClass People object
     * @param $show_actions boolean Show toolbar with actions. Default TRUE
     * @return string Rendered template
     */
    public static function nfp_format_li($nfp, $show_actions=TRUE) {
        return sprintf('<li class="focal-point">%s</li>', self::nfp_format($nfp, $show_actions));
    }

    /**
     * Output vCard format for the NFP.
     *
     * @param $nfp stdClass People object
     * @return string vCard 2.1 format
     */
    public static function nfp_format_vcard($nfp) {
        $ctx = self::_nfp_format_ctx($nfp, FALSE);
        if(!empty($nfp->rec_updated)) {
            $ctx['rec_updated'] = format_mysql_date($nfp->rec_updated, 'c');
        }
        $notes = 'National focal point for ';
        $c = count($nfp->treaties);
        foreach($nfp->treaties as $i => $row) {
            $notes .= $row->short_title;
            if($i < $c - 1) {
                $notes .= ', ';
            }
        }
        $ctx['notes'] = $notes;
        $twig = self::get_twig_template();
        return $twig->render('nfp-contact-vcard.twig', $ctx);
    }

    /**
     * Build the structure for the treaty text viewer (set-up articles, paragraphs tags etc.).
     *
     * @param stdClass $treaty Treaty object
     * @param stdClass $organization Organization object
     * @param boolean $modal Is modal or full
     * @return string Rendered template
     */
    public static function treaty_text_viewer($treaty, $organization, $modal) {
        $ctx = array();
        $treaty->articles = InforMEA::load_full_treaty_text($treaty->id);
        foreach($treaty->articles as $row) {
            $row->title_formatted = i3_format_article_title($row);
        }
        $ctx['treaty'] = $treaty;
        $ctx['organization'] = $organization;
        $ctx['modal'] = $modal;
        $twig = self::get_twig_template();
        if($modal) {
            return $twig->render('treaty-text-viewer.twig', $ctx);
        } else {
            return $twig->render('treaty-text-viewer-full.twig');
        }
    }

    public static function treaty_text_viewer_dlg($treaty, $modal) {
        $ctx['treaty'] = $treaty;
        $ctx['modal'] = $modal;
        $twig = self::get_twig_template();
        if($modal) {
            return $twig->render('treaty-text-viewer.twig', $ctx);
        } else {
            return $twig->render('treaty-text-viewer-full.twig');
        }
    }

    public static function treaty_header($treaty, $organization, $modal) {
        $ctx = array();
        $treaty->topics = i3_treaty_format_topics($treaty);
        $treaty->coverage = i3_treaty_format_coverage($treaty);
        $treaty->enter_into_force = i3_treaty_format_year($treaty);
        $ctx['treaty'] = $treaty;
        $ctx['organization'] = $organization;
        $ctx['modal'] = $modal;
        $twig = self::get_twig_template();
        return $twig->render('treaty-header.twig', $ctx);
    }

    private static function _nfp_format_ctx($nfp, $show_actions) {
       $name = Informea::format_nfp_name($nfp);
       return array('nfp' => $nfp, 'name' => $name, 'show_actions' => $show_actions);
    }


    public static function treaties() {
        $ctx = array(
            'count' => InforMEA::get_treaties_enabled_count(),
            'count_total' => InforMEA::get_treaties_enabled_count(),
            'topics' => InforMEA::get_treaties_enabled_primary_topics(),
            'regions' => InforMEA::get_treaties_enabled_regions_in_use()
        );
        $treaties = InforMEA::get_treaties_enabled();
        $ctx['treaties'] = $treaties;
        foreach($treaties as &$row) {
            $row->coverage = i3_treaty_format_coverage($row);
            $row->topic = i3_treaty_format_topic($row);
        }
        wp_enqueue_script('informea-treaties');
        $twig = self::get_twig_template();
        return $twig->render('treaties.twig', $ctx);
    }
}