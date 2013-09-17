<?php

wp_enqueue_script('informea-treaties');

add_filter('wp_title', 'i3_treaties_title', 10, 3);
$id = get_request_variable('id');

get_header();

if (have_posts()) : while (have_posts()) : the_post();
	get_template_part("pages/treaties", empty($id) ? 'treaties' : 'treaty');
endwhile; endif;

get_footer();
