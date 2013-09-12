<?php
/**
 * Template name: InfoMEA About page
 */
if(have_posts()): while(have_posts()) : the_post();
get_header();
?>
<body data-spy="scroll" data-target=".nav">...</body>
<div class="breadcrumb">
<a href='#'><?php echo get_bloginfo('url'); ?> </a>- <?php the_title(); ?>
<h1><?php the_title(); ?></h1></div>
<div class="row">
 <div class="span3" data-spy="scroll">
<?php wp_nav_menu(array('menu'=>'about_page_menu', 'menu_id'=>'nav','menu_class'=>'nav nav-list', 'container_class'=>'box')); ?>
</div>
   <div class="span9" id="content">  <?php  the_content(); ?> </div>
</div>

 <?php
endwhile; endif;
get_footer();
?>