<?php

global $wp_query;
$odata_name = get_request_variable('odata_name');
$treaty = InforMEA::get_treaty_by_odata_name($odata_name);

/**
 * Filter used by the treaty pages
 */
function i3_treaties_title($title, $sep) {
    global $treaty;
    if($treaty) {
        $title = sprintf('%s %s', $sep, $treaty->short_title);
    }
    return $title;
}
add_filter('wp_title', 'i3_treaties_title', 1, 2);

wp_enqueue_script('informea-treaties');
get_header();
if (have_posts()) : while (have_posts()) : the_post();
    get_template_part(empty($odata_name) ? 'pages/treaties' : 'pages/treaty');
endwhile; endif;
get_footer();
