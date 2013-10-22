<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

$post = get_page_by_title('404', OBJECT, 'post');

get_header(); ?>

    <div class="container">
        <h1>Page not found</h1>
        <?php if(empty($post)) {
            echo "Create a post with title 404 to override this text.";
        } else {
            echo $post->post_content;
        } ?>
    </div><!-- #primary -->

<?php get_footer(); ?>