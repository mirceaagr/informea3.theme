<?php
$id = get_request_variable('id');
get_header();
if (have_posts()) : while (have_posts()) : the_post();
	get_template_part("pages/treaties", empty($id) ? 'treaties' : 'treaty');
endwhile; endif;
get_footer();
