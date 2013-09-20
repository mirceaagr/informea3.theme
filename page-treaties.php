<?php
$odata_name = get_request_variable('odata_name');
$view = get_request_variable('view');
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

/**
 * Breadcrumbtrail set-up
 */
function informea_treaties_breadcrumbtrail($items) {
    global $treaty;
    if($treaty) {
        $items[] = sprintf('<li><a href="%s">%s</a> <span class="divider">/</span></li>', get_permalink(), get_the_title());
        $items[] = sprintf('<li class="active">%s</li>', $treaty->short_title);
    } else {
        $items[] = '<li class="active">Treaties</li>';
    }
    return $items;
}
add_filter('the_breadcrumb', 'informea_treaties_breadcrumbtrail');

if (have_posts()) : while (have_posts()) : the_post();
    get_template_part('pages/' . $view);
endwhile; endif;
