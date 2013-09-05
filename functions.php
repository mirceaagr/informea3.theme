<?php

wp_register_script('bootstrap', get_stylesheet_directory_uri() . '/scripts/bootstrap.js', array('jquery'));
wp_register_script('informea-common', get_stylesheet_directory_uri() . '/scripts/common.js', array('jquery'));


function informea3_setup() {
	register_nav_menus(array(
		'primary' =>__('Primary Navigation', 'informea'),
		'footer' => __('Footer Menu', 'informea'),
	));
}
add_action('after_setup_theme', 'informea3_setup');
