<?php

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
 * Treaties listing page
 * @return array treaties
 */
function i3_treaties_listing() {
	global $wpdb;
	$sql = $wpdb->prepare('SELECT a.* FROM ai_treaty a WHERE a.enabled = 1 AND a.use_informea = 1', array());
	$sql .= ' ORDER BY a.`order`';
	return $wpdb->get_results($sql);
}


/**
 * Treaties listing page
 * @return int
 */
function i3_treaties_count() {
	global $wpdb;
	$sql = $wpdb->prepare('SELECT count(*) FROM ai_treaty a WHERE a.enabled = 1 AND a.use_informea = 1', array());
	return $wpdb->get_var($sql);
}


/**
 * Retrieve the primary treaty topics from the database
 * @return array Array of string with the terms
 */
function i3_treaties_primary_topics() {
	global $wpdb;
	$sql = $wpdb->prepare("
		SELECT DISTINCT (a.theme) AS theme FROM ai_treaty a
			WHERE TRIM(a.theme) <> '' AND a.enabled = 1 AND a.use_informea = 1 ORDER BY theme",
		array()
	);
	return $wpdb->get_col($sql);
}


/**
 * Echo the formatted region of a treaty (empty regions are treated as global)
 * @param $treaty Treaty object
 */
function i3_treaty_format_region($treaty) {
	echo !empty($treaty->region) ? $treaty->region : __('Global', 'informea');
}


/**
 * Echo the formatted topic of a treaty (printing primary and secondary topics)
 * @param $treaty Treaty object
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
	echo $ret;
}


/**
 * Retrieve the unique regions in use within a treaty
 * @return array Array of object classes from ai_region table
 */
function i3_treaty_regions_in_use() {
	global $wpdb;
	return $wpdb->get_results('SELECT a.* FROM ai_region a INNER JOIN ai_treaty_region b ON a.id = b.id_region GROUP BY a.id ORDER BY a.id');
}


/**
 * Build the treaty URL (use this instead of hard-coding the URL inside pages)
 * @param $treaty stdClass Treaty object
 * @param bool $echo (Optional) echo the URL instead of returning it
 * @return string The treaty URL
 */
function i3_treaty_url($treaty, $echo = TRUE) {
    if(is_string($treaty)) {
        $url = sprintf('%s/treaties/%s', get_bloginfo('url'), $treaty);
    } else {
        $url = sprintf('%s/treaties/%s', get_bloginfo('url'), $treaty->odata_name);
    }
    if($echo) {
        echo $url;
    }
    return $url;
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
        echo '<ul class="breadcrumb">';
        foreach($items as $item) {
            echo $item;
        }
        echo '</ul>';
    }
}