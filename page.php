<?php
global $post;
$breadcrumbtrail_handler = sprintf('informea_%s_breadcrumbtrail', $post-> post_name);
 if(function_exists($breadcrumbtrail_handler)) {
	add_action('breadcrumbtrail', $breadcrumbtrail_handler);
}
get_header();
?>

<!---Page Content will go here -->

<h2> This is the page template</h2>

<?php
get_footer();
?>
