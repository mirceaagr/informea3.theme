<?php

$treaty_header_mode = '';
$organization = NULL;
$treaty = NULL;

require_once(dirname(__FILE__) . '/functions_informea.php');

wp_register_script('bootstrap', get_stylesheet_directory_uri() . '/scripts/bootstrap.js', array('jquery'));
wp_register_script('informea-common', get_stylesheet_directory_uri() . '/scripts/common.js', array('jquery'));
wp_register_script('informea-treaties', get_stylesheet_directory_uri() . '/scripts/treaties.js', array('jquery'));


function informea3_setup() {
	register_nav_menus(array(
		'primary' =>__('Primary Navigation', 'informea'),
		'footer' => __('Footer Menu', 'informea'),
	));
}
add_action('after_setup_theme', 'informea3_setup');

add_filter('nav_menu_css_class' , 'about_page_menu');
function about_page_menu($classes){
     if( in_array('current-menu-item', $classes) ){
             $classes[] = 'active ';
     }
     return $classes;
}


/**
 * Echo the formatted region of a treaty (empty regions are treated as global)
 * @param $treaty stdClass object
 */
function i3_treaty_print_region($treaty) {
	echo !empty($treaty->region) ? $treaty->region : __('Global', 'informea');
}


/**
 * Echo the formatted topic of a treaty (printing primary and secondary topics)
 * @param $treaty stdClass Treaty object
 */
function i3_treaty_print_topic($treaty) {
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
	echo $ret;
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
 */
function i3_treaty_print_topics($treaty) {
    if(!empty($treaty->theme) || !empty($treaty->theme_secondary)) {
        if(!empty($treaty->theme)) {
            echo sprintf('<strong>%s</strong>', $treaty->theme);
        }
        if(!empty($treaty->theme_secondary)) {
            if(!empty($treaty->theme)) {
                echo ', ';
            }
            echo $treaty->theme_secondary;
        }
    }
}


/**
 * Echo the year when treaty was created
 * @param $treaty stdClass Treaty object
 */
function i3_treaty_print_year($treaty) {
    if(!empty($treaty->start)) {
        $date = i3_format_mysql_date($treaty->start, 'Y');
        if(!empty($date)) {
            echo $date;
        }
    }
}


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


function i3_print_article_title($article) {
    $number = '';
    if(!empty($article->official_order)) {
        $number = $article->official_order;
        if(substr($number, -1) !== '.') {
            $number .= '. ';
        }
    }
    echo sprintf('%s %s', $number, $article->title);
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