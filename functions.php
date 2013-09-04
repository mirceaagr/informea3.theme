<?php
function informea3_setup() {
	register_nav_menus(array(
		'primary' =>__('Primary Navigation', 'informea'),
		'footer' => __('Footer Menu', 'informea'),
	));
}
add_action('after_setup_theme', 'informea3_setup');
