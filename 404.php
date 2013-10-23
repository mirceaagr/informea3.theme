<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

$page = get_posts(
    array(
        'name'      => 'page-not-found',
        'post_type' => 'page'
    )
);
$post = current($page);
get_header(); ?>

    <div class="container">
    <?php if(empty($post)) { ?>
        <h1>Page not found</h1>
        <p>Create a post with slug 'page-not-found' to override this page.</p>
    <?php } else { ?>
        <h1><?php echo $post->post_title; ?></h1>
        <?php echo $post->post_content;
        } ?>
    </div><!-- #primary -->

<?php get_footer(); ?>