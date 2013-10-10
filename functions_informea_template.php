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
        $twig->addFunction(new Twig_SimpleFunction('i3_url', function($type, $ob = NULL, $suffix = NULL, $parent = NULL) {
            switch($type) {
                case 'glossary-term':
                    $url = i3_url_glossary($ob, $suffix);
                    break;
                case 'treaty':
                    $url = i3_url_treaty($ob, $suffix);
                    break;
                case 'decision':
                    $url = sprintf('%s/decision/%s%s', i3_url_treaty($parent), $ob->id, $suffix);
                    break;
                case 'decision-document':
                    $url = sprintf('%s/download/decision-document/%s', get_bloginfo('url'), $ob->id);
                    break;
                case 'image':
                    $url = sprintf('%s/images/%s', get_template_directory_uri(), $ob);
                    break;
                case 'country':
                    $url = i3_url_country($ob, $suffix);
                    break;
                case 'page':
                    $url = get_permalink(get_page_by_title($ob));
                    break;
                case 'flag':
                    $url = i3_url_country_flag($ob, $suffix);
                    break;
                case 'term':
                    $url = i3_url_terms($ob, $suffix);
                    break;
                default:
                    $url = "javascript:alert('An internal error occurred while processing URL'); return false;";
            }
            echo $url;
        }));
        $twig->addFunction(new Twig_SimpleFunction('get_header', 'get_header'));
        $twig->addFunction(new Twig_SimpleFunction('get_footer', 'get_footer'));
        $twig->addFunction(new Twig_SimpleFunction('the_title', 'the_title'));
        $twig->addFunction(new Twig_SimpleFunction('informea_the_breadcrumb', 'informea_the_breadcrumb'));
        $twig->addFunction(new Twig_SimpleFunction('wp_footer', 'wp_footer'));
        $twig->addFunction(new Twig_SimpleFunction('wp_head', 'wp_head'));
        $twig->addFunction(new Twig_SimpleFunction('language_attributes', 'language_attributes'));
        $twig->addFunction(new Twig_SimpleFunction('bloginfo', 'bloginfo'));
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
     * @param boolean $print Show the print dialog
     *
     * @return string Rendered template
     */
    public static function treaty_text_viewer($treaty, $organization, $modal, $print = FALSE) {
        $ctx = array();
        $treaty->articles = InforMEA::load_full_treaty_text($treaty->id);
        foreach($treaty->articles as $row) {
            $row->title_formatted = i3_format_article_title($row);
        }

        // Required by treaty-header.twig
        $treaty->topics = i3_treaty_format_topics($treaty);
        $treaty->coverage = i3_treaty_format_coverage($treaty);
        $treaty->enter_into_force = i3_treaty_format_year($treaty);


        $ctx['treaty'] = $treaty;
        $ctx['organization'] = $organization;
        $ctx['modal'] = $modal;
        $ctx['print'] = $print;
        $twig = self::get_twig_template();
        if($print) {
            return $twig->render('treaty-text-viewer-print.twig', $ctx);
        } else {
            return $twig->render('treaty-text-viewer.twig', $ctx);
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


    public static function treaty($treaty) {
        $treaties = Informea::get_treaties_enabled('a.short_title');
        $organization = InforMEA::get_organization($treaty->id_organization);
        $parties = InforMEA::get_treaty_member_parties($treaty->id);
        $cop_meetings = InforMEA::get_treaty_cop_meetings($treaty->id);
        $decisions_c = InforMEA::get_treaty_decisions_count($treaty->id);
        $tags = InforMEA::get_treaty_popular_tags($treaty->id);
        $nfp_c = InforMEA::get_treaty_nfp_count($treaty->id);
        $countries_nfps = InforMEA::get_treaty_nfp_countries($treaty->id);
        $nfps = array(); $c0 = NULL;
        if($nfp_c > 0) {
            $c0 = current($countries_nfps);
            $nfps = InforMEA::get_treaty_country_nfp($treaty->id, $c0->code);
        }

        foreach($cop_meetings as &$row) {
            $row->decisions = InforMEA::get_treaty_decisions_by_cop($row->id);
            $row->meeting_title = !empty($row->abbreviation) ? $row->abbreviation : $row->title;
            $row->caption = i3_treaty_decision_caption($row, count($row->decisions));
            foreach($row->decisions as &$decision) {
                $decision->status = ucfirst($decision->status);
            }
        }

        foreach($parties as &$row) {
            $row->entry_into_force_formatted = format_mysql_date($row->entryIntoForce, 'Y');
            $row->signed_formatted = format_mysql_date($row->signed, 'Y');
        }

        $ctx = array(
            'treaties' => $treaties,
            'treaty' => $treaty,
            'organization' => $organization,
            'parties' => $parties,
            'cop_meetings' => $cop_meetings,
            'decisions_count' => $decisions_c,
            'countries_nfps' => $countries_nfps,
            'tags' => $tags,
            'nfp_count' => $nfp_c,
            'first_country' => $c0,
            'first_country_nfps' => $nfps
        );

        // Required by treaty-header.twig
        $treaty->topics = i3_treaty_format_topics($treaty);
        $treaty->coverage = i3_treaty_format_coverage($treaty);
        $treaty->enter_into_force = i3_treaty_format_year($treaty);
        $ctx['treaty'] = $treaty;
        $ctx['organization'] = $organization;
        $ctx['modal'] = FALSE;

        $twig = self::get_twig_template();
        return $twig->render('treaty.twig', $ctx);
    }

    public static function treaty_decision_viewer($id_decision, $treaty, $organization, $modal) {
        $decision = InforMEA::load_full_decision($id_decision);
        // Prepare the decision for rendering
        $decision->title = !empty($decision->long_title) ? $decision->long_title : $decision->short_title;
        if($decision->meeting) {
            $decision->meeting->title = !empty($decision->meeting->abbreviation)
                ? $decision->meeting->abbreviation : $decision->meeting->title;
        }
        $decision->published_formatted = format_mysql_date($decision->published);
        $decision->tag_cloud = array();
        if(count($decision->tags)) {
            $decision->tag_cloud = array_slice($decision->tags, 0, 10);
            foreach($decision->tag_cloud as $idx => &$row) {
                $row->popularity = 10 - $idx;
            }
        }

        $ctx = array(
            'treaty' => $treaty,
            'decision' => $decision,
            'modal' => $modal
        );

        // Required by treaty-header.twig
        $treaty->topics = i3_treaty_format_topics($treaty);
        $treaty->coverage = i3_treaty_format_coverage($treaty);
        $treaty->enter_into_force = i3_treaty_format_year($treaty);
        $ctx['treaty'] = $treaty;
        $ctx['organization'] = $organization;

        $twig = self::get_twig_template();
        return $twig->render('treaty-decision-viewer.twig', $ctx);
    }

    /**
     * Render the template for the index page.
     *
     * @return string Rendered template
     */
    public static function index() {
        $ctx = array();
        $twig = self::get_twig_template();
        return $twig->render('index.twig', $ctx);
    }

    /**
     * Render the template for the countries listing page.
     *
     * @return string Rendered template
     */
    public static function countries() {
        $ctx = array();
        $ctx['countries'] = InforMEA::get_countries();
        $twig = self::get_twig_template();
        return $twig->render('countries.twig', $ctx);
    }

    /**
     * Render the template for the country profile page.
     *
     * @param stdClass $country Country object
     * @return string Rendered template
     */
    public static function country($country) {
        $ctx = array();
        $ctx['country'] = $country;
        $twig = self::get_twig_template();
        return $twig->render('country.twig', $ctx);
    }

    /**
     * Render the template for the glossary listing page.
     *
     * @return string Rendered template
     */
    public static function terms() {
        $ctx = array();
        $twig = self::get_twig_template();
        return $twig->render('terms.twig', $ctx);
    }

    /**
     * Render the template for the term index page.
     *
     * @param stdClass $term Vocabulary term object
     * @return string Rendered template
     */
    public static function term($term) {
        $ctx = array();
        $ctx['term'] = $term;
        $twig = self::get_twig_template();
        return $twig->render('term.twig', $ctx);
    }

    /**
     * Render the footer template.
     *
     * @return string Rendered template
     */
    public static function template_footer() {
        $ctx = array();
        $twig = self::get_twig_template();
        return $twig->render('footer.twig', $ctx);
    }


    public static function template_header() {
        $ctx = array();

        $page_title = get_bloginfo( 'name' );
        $site_description = get_bloginfo('description', 'display');
        if ($site_description && (is_home() || is_front_page()))
            $page_title .= " | $site_description";
        $page_title .= wp_title(' - ', FALSE, 'left');
        $ctx['html_page_title'] = $page_title;
        $ctx['body_tag_class'] = 'class="' . join(' ', get_body_class(isset($class) ? $class : '')) . '"';
        $ctx['url_home'] = get_bloginfo('url');

        $twig = self::get_twig_template();
        return $twig->render('header.twig', $ctx);
    }
}