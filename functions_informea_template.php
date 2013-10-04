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
        $twig->addFunction(new Twig_SimpleFunction('i3_url', function($type, $ob = NULL) {
            switch($type) {
                case 'glossary_term':
                    echo i3_url_glossary_term($ob);
            }
        }));
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
     * @param $treaty stdClass Treaty object
     * @return string Rendered template
     */
    public static function treaty_text_viewer($treaty) {
        $ctx = array();
        $treaty->articles = InforMEA::load_full_treaty_text($treaty->id);
        foreach($treaty->articles as $row) {
            $row->title_formatted = i3_format_article_title($row);
        }
        $ctx['treaty'] = $treaty;
        $twig = self::get_twig_template();
        return $twig->render('treaty-text-viewer.twig', $ctx);
    }


    private static function _nfp_format_ctx($nfp, $show_actions) {
       $name = Informea::format_nfp_name($nfp);
       return array('nfp' => $nfp, 'name' => $name, 'show_actions' => $show_actions);
    }
}