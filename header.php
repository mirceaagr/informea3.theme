<?php
global $post;
require_once (get_template_directory()."/template/index.php");
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>
	<?php
	wp_title('-', true, 'right'); 
	echo apply_filters('informea_page_title', '');
	bloginfo('name');
	?>
	</title>
     <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/logos.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/normalize.css">
   <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/sprite.css">
</head>
<body>
<header>
<div class="wrap">
<div class="logo"><a href="#"><img src="../images/informea_logo.png" alt="InforMea Logo" title="InforMEA" id="logo-image"></a></div>
 <ul id="top-menu" class="no-ul">
 <li>
 <div class="drop">
	<a href="#">Treaties</a>
	<div class="sub-menu">
	<div class="wrap clear">
	<div>
	<h3>Biological Diversity</h3>
	<ul class="no-ul">
	<li><a href="#">CBD</a></li>
	<li><a href="#">Cartagena Protocol</a></li>
	<li><a href="#">Nagoya Protocol</a></li>
	<li><a href="#">CITES</a></li>
	<li><a href="#">CMS</a></li>
	<li><a href="#">AEWA</a></li>
	<li><a href="#">ITPGRFA</a></li>
	<li><a href="#">Ramsar</a></li>
	<li><a href="#">WHCCBD</a></li>
	</ul>
	</div>
	<div>
<h3>Chemicals / Waste</h3>
	<ul class="no-ul">
	<li><a href="#">Basel</a></li>
	<li><a href="#">Rotterdam</a></li>
	<li><a href="#">Stockholm</a></li>
	</ul>
	<h3>Climate / Atmosphere</h3>
	<ul class="no-ul">
	<li><a href="#">UNFCCC</a></li>
	<li><a href="#">Kyoto Protocol</a></li>
	<li><a href="#">UNCCD</a></li>
	<li><a href="#">Vienna</a></li>
	<li><a href="#">Montreal Protocol</a></li>
	</ul>
	</div>
	<div class="span2col">
	<h3>Other Treaties</h3>
	<ul class="no-ul">
	<li><a href="#">Treaty</a></li>
	<li><a href="#">Treaty</a></li>
	<li><a href="#">Treaty</a></li>
	<li><a href="#">Treaty</a></li>
	<li><a href="#">Treaty</a></li>
	<li><a href="#">Treaty</a></li>
	<li><a href="#">Treaty</a></li>
	<li><a href="#">Treaty</a></li>
	<li><a href="#">Treaty</a></li>
	<li><a href="#">Treaty</a></li>
	<li><a href="#">Treaty</a></li>
	<li><a href="#">Treaty</a></li>
	<li><a href="#">Treaty</a></li>
	<li><a href="#">Treaty</a></li>
	<li><a href="#">Treaty</a></li>
	<li><a href="#">Treaty</a></li>
	<li><a href="#">Treaty</a></li>
	</ul>
	</div>
	</div>
	</div>
	</div>
					</li>
					<li><a href="#">Countries</a></li>
					<li><a href="#">Glossary</a></li>
				</ul>
				<form id="search-bar">
  					<input type="text" class="search" placeholder="Search InforMEA ..."><!-- DO NOT delete this comment
  				 --><div id="suggestions"><!-- Need Trigger for Suggestions and Listener for Keys -->
  						<p>Search InforMEA for '_keyword'</p>
  						
  				 		<p class="category">Treaties</p>
  						<a href="#" class="treaty-suggestion">
  							<img src="" alt="Treaty Logo" />
  							<span class="suggestion-name">Treaty</span>
  							<span class="additional-info">Treaty Topic</span>
  						</a>

  						<p class="category">Countries</p>
  						<a href="#" class="country-suggestion">
  							<img src="" alt="Country Flag" />
  							<span>Country<span>
  						</a>

  						<p class="category">Terms</p>
  						<a href="#" class="term-suggestion"><span>Term</span></a>
  						<a href="#" class="term-suggestion"><span>Term</span></a>
  					</div><!--
  				 --><button type="submit" class=""><i class="icon-search"> </i></button>
				</form>
			</div>
    <?php do_action('breadcrumbtrail'); ?>	
</div>
</div>
</header>

 
