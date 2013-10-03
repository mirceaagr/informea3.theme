<?php

/**
 * Class InforMEATemplate contains templating functions
 */
class InforMEATemplate {

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
        }
        $twig = WordPressTwigTemplateFactory::getTemplateEngine(__DIR__ . '/templates');
        return $twig->render('nfp-contact-info.twig', $ctx);
    }

    /**
     * Same as nfp_format, but wraps the output inside a list (li) element
     * @see nfp_format($nfp)
     * @param $nfp stdClass People object
     * @param $show_actions boolean Show toolbar with actions. Default TRUE
     * @return string Rendered template
     */
    public static function nfp_format_li($nfp, $show_actions=TRUE) {
        return sprintf('<li class="focal-point">%s</li>', self::nfp_format($nfp, $show_actions));
    }


    private static function _nfp_format_ctx($nfp, $show_actions) {
        $name = '';
        if(!empty($nfp->prefix)) {
            $name .= $nfp->prefix . ' ';
        }
        if(!empty($nfp->first_name)) {
            if(strlen($name)) {
                $name .= ' ';
            }
            $name .= $nfp->first_name;
        }
        if(!empty($nfp->last_name)) {
            if(strlen($name)) {
                $name .= ' ';
            }
            $name .= $nfp->last_name;
        }
        return array('nfp' => $nfp, 'name' => $name, 'show_actions' => $show_actions);
    }
}