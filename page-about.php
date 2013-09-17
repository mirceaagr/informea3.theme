<?php
/**
 * Add the scrollspy classes to the body tag
 */
function about_body_attributes($c) {
    $c[] = '" data-spy="scroll" data-target=".scrollspy"';
    return $c;
}
add_filter('body_class','about_body_attributes');

/**
 * Breadcrumbtrail set-up for the about page
 */
function informea_about_breadcrumbtrail($items) {
    $items[] = sprintf('<li class="active">About InforMEA</li>');
    return $items;
}
add_filter('the_breadcrumb', 'informea_about_breadcrumbtrail');

wp_register_script('informea.about', get_template_directory_uri() . '/scripts/about.js', array('jquery'));
wp_enqueue_script('informea.about');

get_header();
if(have_posts()): while(have_posts()) : the_post();
?>
    <div class="container">
        <h1><?php the_title(); ?></h1></div>
        <div class="row">
            <div class="span3 affix hidden-phone">
                <div class="well scrollspy" data-spy="scroll affix" data-offset-top="">
                    <ul id="menu-about-page-menu" class="nav nav-list"></ul>
                </div>
            </div>
            <div class="user-article span9 pull-right" id="content">  <?php  the_content(); ?> </div>
        </div>
<?php
endwhile; endif;
get_footer();
?>
