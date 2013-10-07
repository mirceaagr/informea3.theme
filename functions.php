<?php

$treaty_header_mode = '';
$organization = NULL;
$treaty = NULL;

require_once(dirname(__FILE__) . '/functions_informea.php');
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
 * Build the treaty URL (use this instead of hard-coding the URL inside pages)
 * @param $treaty stdClass Treaty object
 * @param $suffix string Add suffix at the end of the URL
 * @param bool $echo (Optional) echo the URL instead of returning it
 * @return string The treaty URL
 */
function i3_treaty_url($treaty, $suffix = '', $echo = TRUE) {
    if(!is_string($treaty)) {
        $treaty = $treaty->odata_name;
    }
    $url = sprintf('%s/treaties/%s%s', get_bloginfo('url'), $treaty, $suffix);
    if($echo) {
        echo $url;
    }
    return $url;
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
 * Echo the year when treaty was created
 * @param $treaty stdClass Treaty object
 */
function i3_treaty_format_year($treaty) {
    $ret = '';
    if(!empty($treaty->start)) {
        $date = i3_format_mysql_date($treaty->start, 'Y');
        if(!empty($date)) {
            $ret = $date;
        }
    }
    return $ret;
}

/**
 * Format MySQL datetime or timestamp field
 * @param $mysql_date string date/timestamp
 * @param string $format Output format
 * @param string $empty Add this character when date is invalid. Default &nbsp;
 * @return string formatted date
 */
function i3_format_mysql_date($mysql_date, $format = 'd F Y', $empty = '&nbsp;') {
    $ret = $empty;
    if(!empty($mysql_date)) {
        $date = strtotime($mysql_date);
        if(!empty($date)) {
            $ret = date($format, $date);
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
 */
function i3_treaty_decision_caption($cop, $c) {
    $ret = sprintf('%d decisions.',  $c);
    $ret .= sprintf(' Meeting was held on %s, ', i3_format_mysql_date($cop->start));
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
function i3_country_flag($country, $version = 'medium') {
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
    if($ob) {
        $url = sprintf('%s/glossary', get_bloginfo('url'));
    } else {
        $url = sprintf('%s/glossary/%d', get_bloginfo('url'), $ob->id);
    }
    return $url . $suffix;
}


/**
 * Build URLs to the treaty pages.
 *
 * @param stdClass $ob Entity object
 * @param string $suffix Additional suffix
 * @return string URL
 */
function i3_url_treaty($ob = NULL, $suffix = '') {
    if(!$ob) {
        $url = sprintf('%s/treaties', get_bloginfo('url'));
    } else {
        $url = sprintf('%s/treaties/%s', get_bloginfo('url'), $ob->odata_name);
    }
    return $url . $suffix;
}
