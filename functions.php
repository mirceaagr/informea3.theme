<?php

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


function i3_treaties_primary_topics() {
	global $wpdb;
	$sql = $wpdb->prepare("
		SELECT DISTINCT (a.theme) AS theme FROM ai_treaty a
			WHERE TRIM(a.theme) <> '' AND a.enabled = 1 AND a.use_informea = 1 ORDER BY theme",
		array()
	);
	return $wpdb->get_col($sql);
}

function i3_treaty_format_region($treaty) {
	echo !empty($treaty->region) ? $treaty->region : __('Global', 'informea');
}


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


function i3_treaty_regions_in_use() {
	global $wpdb;
	return $wpdb->get_results('SELECT a.* FROM ai_region a INNER JOIN ai_treaty_region b ON a.id = b.id_region GROUP BY a.id ORDER BY a.id');
}

function i3_treaties_title($title, $sep) {
	$id = get_request_variable('id');
	if(empty($id)) {
		$title .= get_bloginfo('name');
	}
	return $title;
}

function i3_treaty_url($treaty, $echo = FALSE) {
    if(is_string($treaty)) {
        $url = sprintf('%s/treaties/%s', get_bloginfo('url'), $treaty);
    } else {
        $url = sprintf('%s/treaties/%s', get_bloginfo('url'), $treaty->odata_name);
    }
    if($echo) {
        echo $url;
    } else {
        return $url;
    }
}


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