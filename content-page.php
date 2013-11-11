<?php
/**
 * Add the scrollspy classes to the body tag
 */
function informea_page_body_attributes($c) {
    $c[] = '" data-spy="scroll" data-target=".scrollspy';
    return $c;
}
add_filter('body_class','informea_page_body_attributes');

/**
 * Breadcrumbtrail set-up for the about page
 */
function informea_page_breadcrumbtrail($items) {
    $items[] = '<li class="active">'.the_title('', '', FALSE).'</li>';
    return $items;
}
add_filter('the_breadcrumb', 'informea_page_breadcrumbtrail');

add_action('wp_enqueue_scripts',
            function() {
                wp_enqueue_script('informea-general-page');
            }
        );
get_header();
?>
    <div class="container">
        <?php echo informea_the_breadcrumb(); ?>
        <h1><?php the_title(); ?></h1>
        <div class="row">
            <div class="span3 affix-menu affix hidden-phone">
                <div class="well scrollspy" data-spy="scroll">
                    <ul id="menu-page-menu" class="nav nav-list"></ul>
                </div>
            </div>
            <div class="user-article span9 pull-right" id="content">  <?php  the_content(); ?> </div>
        </div>
    </div>
<?php
get_footer();
?>
