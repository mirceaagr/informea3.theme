<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="<?php bloginfo('charset'); ?>" />
	<title><?php wp_title('-', true, 'right'); ?></title>
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/bootstrap.css">
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/bootstrap-responsive.css">
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/icons.css">
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/logos.css">
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/informea.css">
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/style-responsive.css">
</head>
<body>
	<div class="navbar navbar-static-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="btn btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse.menu">
			        <span class="icon-more"></span>
			    </a>
			    <a class="btn btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse.search">
			        <span class="icon-search"></span>
			    </a>
				<a class="brand" href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/informea_logo.png"></a>
				<div class="nav-collapse menu collapse">
					<ul class="nav">
						<li class="sub-menu"><a href="/treaties">Treaties<span class="caret"></span></a>
							<div class="sub-menu">
								<div class="container">
									<div class="row">
										<ul class="nav-list span3">
											<li class="nav-header">Biological Diversity</li>
											<li><a href="#">AEWA</a></li>
											<li><a href="#">Cartagena Protocol</a></li>
											<li><a href="#">CBD</a></li>
											<li><a href="#">CITES</a></li>
											<li><a href="#">CMS</a></li>
											<li><a href="#">Nagoya Protocol</a></li>
											<li><a href="#">Plant Treaty</a></li>
											<li><a href="#">Ramsar</a></li>
											<li><a href="#">WHC</a></li>
										</ul>
										<ul class="nav-list span3">
											<li class="nav-header">Chemicals / Waste</li>
											<li><a href="#">Basel</a></li>
											<li><a href="#">Rotterdam</a></li>
											<li><a href="#">Stockholm</a></li>
											<li class="nav-header">Climate / Atmosphere</li>
											<li><a href="#">UNCCD</a></li>
											<li><a href="#">UNFCCC</a></li>
											<li><a href="#">Kyoto Protocol</a></li>
											<li><a href="#">Montreal Protocol</a></li>
											<li><a href="#">Vienna</a></li>
										</ul>
										<ul class="nav-list span6">
											<li class="nav-header">Regional Treaties</li>										
											<!-- <li class="nav-header">Africa</li> -->
											<li><a href="#">Abidjan Convention</a></li>
											<li><a href="#">Nairobi Convention</a></li>
											<li><a href="#">Bamako Convention</a></li>
											<li><a href="#">Lusaka Agreement</a></li>

											<!-- <li class="nav-header">Asia Pacific</li> -->
											<li><a href="#">Noumea Convention</a></li>
											<li><a href="#">Apia Convention</a></li>

											<!-- <li class="nav-header">Europe</li> -->
											<li><a href="#">Barcelona</a></li>
											<li><a href="#">Barcelona Dumping Protocol</a></li>
											<li><a href="#">Specially Protected Areas Protocol</a></li>
											<li><a href="#">Prevention and Emergency Protocol</a></li>
											<li><a href="#">Offshore Protocol</a></li>
											<li><a href="#">Land-Based Sources Protocol</a></li>
											<li><a href="#">Hazardous Wastes Protocol</a></li>
											<li><a href="#">Aarhus Convention</a></li>
											<li><a href="#">Espoo Convention</a></li>
											<li><a href="#">Long-Range Transmoundary Air Pollution</a></li>
											<li><a href="#">The Kyiv Protocol</a></li>
											<li><a href="#">Protocol on Water and Health</a></li>
											<li><a href="#">Water Convention</a></li>
											<li><a href="#">Kiev Protocol</a></li>
											<li><a href="#">Industrial Accidents Convention</a></li>

											<!-- <li class="nav-header">Latin America and the Carribean</li> -->
											<li><a href="#">Cartagena Convention</a></li>
											<li><a href="#">Antigua Convention</a></li>

											<!-- <li class="nav-header">West Asia</li> -->
											<li><a href="#">Jeddah Convention</a></li>
											<li><a href="#">Kuwait Regional Convention</a></li>
										</ul>
									</div>
								</div>
							</div>
						</li>
						<li><a href="#">Countries</a></li>
						<li><a href="#">Glossary</a></li>
					</ul>
				</div>
				<div class="nav-collapse search collapse">
					<form class="navbar-search pull-right">
						<input id="search" type="text" class="search-query" data-provide="typeahead" placeholder="Search">
						<button type="submit" class="btn"><i class="icon-search"></i> <span class="hidden-desktop">Go</span></button>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
