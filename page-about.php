<?php
/**
 * Template name: InfoMEA About page
 */
if(have_posts()): while(have_posts()) : the_post();
$about = get_page_by_title('About');
get_header();
?>
<div class="breadcrumb">
<h1><?php echo $about->post_title; ?></h1>

<?php wp_nav_menu(array('menu'=>'about_page_menu', 'menu_class'=>'nav nav-list', 'container_class'=>'box span3')); ?>
<div class="content">
     <?php  the_content() ; ?>
</div>
</div>
    <?php
endwhile; endif;
get_footer();
?>