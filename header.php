<?php 
/** 
*The header for InforMEA3.
*
*/
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta charset="<?php bloginfo('charset'); ?>"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0 , maximum-scale=2.0 , user-scalable=yes"/>

  <title>
	<?php
	wp_title('-', true, 'right');
	bloginfo('name');
	?>
	</title>
     <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/icons.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/bootstrap-style.css">
   <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/informea.css">
</head>
<body>
<header>
  <div class="navbar">
     <div class="navbar-inner">
	 <div class="container">
		<a class="brand" href="#"><img src="<?php bloginfo('template_directory')?>/images/informea_logo.png"/></a>
               <?php wp_nav_menu(array('menu' => 'primary', 'theme_location' =>'primary', 'menu_class'=>'nav', 'container_id' => 'top-menu' ) );?>

						</div>
			</div>
		</div>
</header>
