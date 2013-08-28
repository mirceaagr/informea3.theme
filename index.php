<?php 
/**
*The template for displaying all pages.
*
*This is the template that displays all pages by default.
*/


get_header(); ?>
<div id="container" style="width: 100% !important;">
<div id="content" role="main">
	<?php if (have_posts()) { 
		while (have_posts()) : the_post(); ?>
	<h2><?php the_title(); ?></h2>
	<h4>Posted on <?php the_time('F jS, Y') ?></h4>
	<p><?php the_content(__('(more...)')); ?></p>
	<hr> <?php endwhile; else: ?>
	<p><?php _e('Sorry, no posts matched your criteria.'); ?></p><?php endif; ?>
	</div><!-- post #-->
	<div class="clear"></div>
		</div>
	</div><!-- #container -->
<?php get_footer(); ?>
