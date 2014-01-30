<?php
/**
 * Breadcrumbtrail set-up for the about page
 */
function informea_page_breadcrumbtrail($items) {
    $items[] = '<li class="active">'.the_title('', '', FALSE).'</li>';
    return $items;
}
add_filter('the_breadcrumb', 'informea_page_breadcrumbtrail');
get_header();
?>
    <div class="container">
        <?php echo informea_the_breadcrumb(); ?>
        <h1><?php the_title(); ?></h1>
        <div class="row-fluid">
            <?php the_content();?>
            <hr>
            <small>
            Posted on:
            <?php the_date();?>
            </small>
        </div>
    </div>
<?php
get_footer();
?>
