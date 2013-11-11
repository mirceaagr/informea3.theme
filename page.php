<?php
global $post;

$breadcrumbtrail_handler = sprintf('informea_%s_breadcrumbtrail', $post->post_name);
if(function_exists($breadcrumbtrail_handler)) {
    add_action('breadcrumbtrail', $breadcrumbtrail_handler);
}
if (function_exists('get_request_variable')) {
    //this part was here and it caused some errors, i don't know what it is for so I kept it (Dragos)
    get_header();
    if (have_posts()) : while (have_posts()) : the_post();
        global $post;
            $id = get_request_variable('id');
            $specific_template = $post->post_name . (empty($id) ? '' : '-item');
        ?>
            <div id="page-title">
                <?php get_template_part("pages/titles/title", $specific_template); ?>
            </div>
            <div class="col2-left col2">
                <?php get_template_part("pages/left_column/sidebar", $specific_template); ?>
                <div class="clear"></div>
            </div>
            <div class="col2-center col2">
                <?php get_template_part("pages/content/page", $specific_template); ?>
            </div>
    <?php
    endwhile; endif;
} else {
    //this part I;ve added to deal with pages in general, those without a template file (Dragos)
    if (have_posts()) : while (have_posts()) : the_post();
    global $post;
    get_template_part( 'content', 'page' );
    endwhile; endif;
}
get_footer();
