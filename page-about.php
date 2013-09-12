<?php
// Add the appropriate scrollspy classes to the body tag
function about_body_attributes($c) {
    $c[] = '" data-spy="scroll" data-target=".scrollspy"';
    return $c;
}
add_filter('body_class','about_body_attributes');

get_header();

if(have_posts()): while(have_posts()) : the_post();
?>
    <div class="container">
        <ul class="breadcrumb">
            <li><a href='#'><?php echo get_bloginfo('url'); ?></a></li>
            <li><?php the_title(); ?></li>
        </ul>

        <h1><?php the_title(); ?></h1></div>
        <div class="row">
            <div class="span3" data-spy="scroll">
                <div class="scrollspy affix" data-spy="scroll affix">
                    <?php wp_nav_menu(
                        array(
                            'menu' => 'About Page Menu', 'menu_class' => 'nav nav-list', 'container' => false
                        )
                    ); ?>
                </div>
            </div>
            <div class="span9" id="content">  <?php  the_content(); ?> </div>
        </div>
<?php
endwhile; endif;
get_footer();
?>
