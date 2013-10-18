<?php

$treaty_header_mode = '';
$organization = NULL;
$treaty = NULL;

require_once(dirname(__FILE__) . '/functions_informea_ajax.php');
require_once(dirname(__FILE__) . '/functions_informea_template.php');

function i3_setup() {
	register_nav_menus(array(
		'primary' =>__('Primary Navigation', 'informea'),
		'footer' => __('Footer Menu', 'informea'),
	));
}
add_action('after_setup_theme', 'i3_setup');

add_filter('nav_menu_css_class' , 'about_page_menu');
function about_page_menu($classes){
     if( in_array('current-menu-item', $classes) ){
             $classes[] = 'active ';
     }
     return $classes;
}

function i3_enqueue_styles() {
    global $wp_styles;

    //jQuery and migrate are always loaded in the header
    //http://blog.cloudfour.com/getting-all-javascript-into-the-footer-in-wordpress-not-so-fast-buster/

    wp_register_script('bootstrap', get_stylesheet_directory_uri() . '/scripts/bootstrap.js', array('jquery'), FALSE, TRUE);
    wp_register_script('informea-common', get_stylesheet_directory_uri() . '/scripts/common.js', array('jquery'), FALSE, TRUE);
    wp_register_script('informea-treaties', get_stylesheet_directory_uri() . '/scripts/treaties.js', array('jquery'), FALSE, TRUE);
    wp_register_script('informea-about', get_template_directory_uri() . '/scripts/about.js', array('jquery'), FALSE, TRUE);
    wp_register_script('jquery-scrollto', get_template_directory_uri() . '/scripts/jquery.scrollto.min.js', array('jquery'), FALSE, TRUE);

    wp_register_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.css');
    wp_register_style('bootstrap-responsive', get_template_directory_uri() . '/css/bootstrap-responsive.css');
    wp_register_style('font-awesome', get_template_directory_uri() . '/font-awesome/css/font-awesome.min.css');
    wp_register_style('font-awesome-ie7', get_template_directory_uri() . '/font-awesome/css/font-awesome-ie7.min.css');
    wp_register_style('informea-style', get_bloginfo('stylesheet_url'));
    wp_register_style('informea-style-responsive', get_template_directory_uri() . '/css/style-responsive.css');
    wp_register_style('informea-logos', get_template_directory_uri() . '/css/logos.css');
    wp_register_style('informea-print', get_template_directory_uri() . '/css/print.css');

    // Add this to all the front-end pages
    wp_enqueue_script('informea-common');
    wp_enqueue_script('bootstrap');
    wp_enqueue_script('jquery-scrollto');

    wp_enqueue_style('bootstrap');
    wp_enqueue_style('bootstrap-responsive');
    wp_enqueue_style('informea-style');
    wp_enqueue_style('informea-style-responsive');
    wp_enqueue_style('informea-logos');
    wp_enqueue_style('font-awesome');

    wp_enqueue_style('font-awesome-ie7');

    $wp_styles->add_data('font-awesome-ie7', 'conditional', 'IE 7');
}
add_action('wp_enqueue_scripts', 'i3_enqueue_styles');

/**
 * Echo the formatted region of a treaty (empty regions are treated as global)
 * @param $treaty stdClass object
 * @return string
 */
function i3_treaty_format_coverage($treaty) {
    return !empty($treaty->region) ? $treaty->region : __('Global', 'informea');
}
function i3_treaty_format_coverage_multiple_regions($regions) {
    $coverage = array();
    foreach ($regions as $region) {
        $coverage []= $region->name;
    }
    return implode(", ", $coverage);
}


/**
 * Echo the formatted topic of a treaty (printing primary and secondary topics)
 * @param $treaty stdClass Treaty object
 * @return string Formatted topic
 */
function i3_treaty_format_topic($treaty) {
	$ret = '';
	if(!empty($treaty->theme)) {
		$ret = sprintf('<strong>%s</strong>', $treaty->theme);
	}
	if(!empty($treaty->theme_secondary) && $treaty->theme_secondary != $treaty->theme) {
		if(!empty($treaty->theme)) {
			$ret .= ', ';
		}
		$ret .= sprintf('%s', $treaty->theme_secondary);
	}
	return $ret;
}

/**
 * Build the URL to the treaty pages.
 *
 * @param mixed $treaty Treaty object
 * @param string $suffix Additional URL suffix
 * @return string The URL to the treaty page
 */
function i3_url_treaty($treaty, $suffix = '') {
    if(is_object($treaty)) {
        $t = $treaty->odata_name;
    } else {
        $t = $treaty;
    }
    $base_url = get_permalink(get_page_by_title('treaties'));
    return sprintf('%s%s%s', $base_url, $t, $suffix);
}

/**
 * Echo the trety primary topics, in treaty index page
 * @param $treaty stdClass Treaty object
 * @return string Treaty topics
 */
function i3_treaty_format_topics($treaty) {
    $ret = '';
    if(!empty($treaty->theme) || !empty($treaty->theme_secondary)) {
        if(!empty($treaty->theme)) {
            $ret = sprintf('<strong>%s</strong>', $treaty->theme);
        }
        if(!empty($treaty->theme_secondary)) {
            if(!empty($treaty->theme)) {
                $ret .= ', ';
            }
            $ret .= $treaty->theme_secondary;
        }
    }
    return $ret;
}


/**
 * Echo the year when treaty was created.
 *
 * @param $treaty stdClass Treaty object
 * @return string Year with 4-letters
 */
function i3_treaty_format_year($treaty) {
    $ret = '';
    if(!empty($treaty->start)) {
        $date = format_mysql_date($treaty->start, 'Y');
        if(!empty($date)) {
            $ret = $date;
        }
    }
    return $ret;
}

function i3_format_article_title($article) {
    $number = '';
    if(!empty($article->official_order)) {
        $number = $article->official_order;
        if(substr($number, -1) !== '.') {
            $number .= '. ';
        }
    }
    return sprintf('%s %s', $number, $article->title);
}

/**
 * Print the caption table for the decision listing inside treaty page
 *
 * @param stdClass $cop COP meeting
 * @param integer $c Number of decisions
 * @return string Formatted caption
 */
function i3_treaty_decision_caption($cop, $c) {
    $ret = sprintf('%d decisions.',  $c);
    $ret .= sprintf(' Meeting was held on %s, ', format_mysql_date($cop->start));
    if(!empty($cop->location)) {
        $ret .= sprintf(' %s', $cop->location);
    }
    if(!empty($cop->city)) {
        $ret .= sprintf(' in %s', $cop->city);
    }
    $countries = InforMEA::get_countries();
    if(!empty($countries[$cop->id_country])) {
        $c = $countries[$cop->id_country];
        $ret .= sprintf(', %s', $c->name);
    }
    return $ret;
}

/**
 * Build the website breadcrumbtrail
 */
function informea_the_breadcrumb() {
    $items = array();
    if(!is_front_page()) {
        $items[] = sprintf('<li><a href="%s">Home</a> <span class="divider">/</span></li>', get_bloginfo('url'));
    }
    $items = apply_filters('the_breadcrumb', $items);
    if(!empty($items)) {
        echo '<ul class="breadcrumb hidden-phone">';
        foreach($items as $item) {
            echo $item;
        }
        echo '</ul>';
    }
}


/**
 * Retrieve the country flag URL.
 *
 * @param $country stdClass Country object
 * @param $version string Size. Supported values: 'medium' (default) or 'large'
 * @return string URL to the country flag image
 */
function i3_url_country_flag($country, $version = 'medium') {
    $ret = 'http://placehold.it/60x60';
    $field = 'icon_' . $version;
    if(!empty($country->$field)) {
        $ret = sprintf('%s/%s', get_template_directory_uri(), $country->$field);
    }
    return $ret;
}

/**
 * Build URLs to the glossary pages.
 *
 * @param stdClass $ob Entity object
 * @param string $suffix Additional suffix
 * @return string URL
 */
function i3_url_glossary($ob = NULL, $suffix = '') {
    $base_url = get_permalink(get_page_by_title('treaties'));
    if(!$ob) {
        return $base_url;
    } else {
        return sprintf('%s%s%s', $base_url , slugify($ob->term), $suffix);
    }
}

/**
 * Build URLs to the country pages.
 *
 * @param stdClass $ob Entity object
 * @param string $suffix Additional suffix
 * @return string URL
 */
function i3_url_country($ob = NULL, $suffix = '') {
    $base_url = get_permalink(get_page_by_title('countries'));
    if(!$ob) {
        return $base_url;
    } else {
        return sprintf('%s%s%s', $base_url, $ob->code, $suffix);
    }
}


/**
 * Build URLs to the glossary pages.
 *
 * @param stdClass $ob Entity object
 * @param string $suffix Additional suffix
 * @return string URL
 */
function i3_url_terms($ob = NULL, $suffix = '') {
    $base_url = get_permalink(get_page_by_title('terms'));
    if(!$ob) {
        return $base_url;
    } else {
        return sprintf('%s%s%s', $base_url, slugify($ob->term), $suffix);
    }
}

/**
 * Server the 404 error page.
 */
function i3_404() {
    global $wp_query;
    $wp_query->set_404();
    status_header(404);
    get_template_part(404);
}
