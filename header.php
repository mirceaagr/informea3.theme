<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="<?php bloginfo('charset'); ?>" />
    <title><?php
        bloginfo( 'name' );
        $site_description = get_bloginfo('description', 'display');
        if ($site_description && (is_home() || is_front_page()))
            echo " | $site_description";
        wp_title(' - ', true, 'left');
    ?></title>
    <?php
        wp_head();
    ?>
</head>
<body <?php body_class(isset($class) ? $class : ''); ?>>
    <div class="navbar navbar-static-top">
        <div class="navbar-inner">
            <div class="container">
                <a class="btn btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse.menu">
                    <i class="icon-reorder"></i>
                </a>
                <a class="brand" href="/"><img src="<?php echo get_template_directory_uri(); ?>/images/informea_logo.png" alt="InforMEA logo"></a>
                <div class="nav-collapse menu collapse">
                    
                    <form class="navbar-search pull-right">
                        <input id="search" type="text" class="search-query" data-provide="typeahead" data-source="" placeholder="Explore InforMEA">
                        <button type="submit" class="btn hidden-phone hidden-tablet"><i class="icon-search"></i></button>
                        <ul class="typehead dropdown-menu">
                            <li class="typehead-keyword">
                                <a href="">Search InforMEA for</a>
                            </li>
                            <li class="typehead-category">
                                Treaties
                            </li>
                            <li>
                                <a href="">
                                    <img class="logo logo-left" src="http://placehold.it/60x60" alt="Treaty Logo"/>
                                    Cartagen Protocol
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <img class="logo logo-left" src="http://placehold.it/60x60" alt="Treaty Logo"/>
                                    AEWA Convention
                                </a>
                            </li>
                            <li class="typehead-category">
                                Countries
                            </li>
                            <li>
                                <a href="">
                                    Romania
                                </a>
                            </li>
                            <li class="typehead-category">
                                Terms
                            </li>
                            <li>
                                <a href="">Biological Diversity</a>
                            </li>
                        </ul>
                    </form>
                    <ul class="nav pull-left">
                        <li class="sub-menu"><a href="<?php echo get_permalink(get_page_by_title('treaties')); ?>">Treaties<span class="caret"></span></a>
                            <div class="sub-menu">
                                <div class="container">
                                    <div class="row">
                                        <ul class="nav-list span3">
                                            <li class="nav-header">Biological Diversity</li>
                                            <li><a href="<?php i3_url_treaty('cartagena'); ?>">Cartagena Protocol</a></li>
                                            <li><a href="<?php i3_url_treaty('cbd'); ?>">CBD</a></li>
                                            <li><a href="<?php i3_url_treaty('cites'); ?>">CITES</a></li>
                                            <li><a href="<?php i3_url_treaty('cms'); ?>">CMS</a></li>
                                            <li><a href="<?php i3_url_treaty('nagoya'); ?>">Nagoya Protocol</a></li>
                                            <li><a href="<?php i3_url_treaty('plant-treaty'); ?>">Plant Treaty</a></li>
                                            <li><a href="<?php i3_url_treaty('ramsar'); ?>">Ramsar</a></li>
                                            <li><a href="<?php i3_url_treaty('whc'); ?>">WHC</a></li>
                                        </ul>
                                        <ul class="nav-list span3">
                                            <li class="nav-header">Chemicals / Waste</li>
                                            <li><a href="<?php i3_url_treaty('basel'); ?>">Basel</a></li>
                                            <li><a href="<?php i3_url_treaty('rotterdam'); ?>">Rotterdam</a></li>
                                            <li><a href="<?php i3_url_treaty('stockholm'); ?>">Stockholm</a></li>
                                            <li class="nav-header">Climate / Atmosphere</li>
                                            <li><a href="<?php i3_url_treaty('unccd'); ?>">UNCCD</a></li>
                                            <li><a href="<?php i3_url_treaty('unfccc'); ?>">UNFCCC</a></li>
                                            <li><a href="<?php i3_url_treaty('kyoto'); ?>">Kyoto Protocol</a></li>
                                            <li><a href="<?php i3_url_treaty('montreal'); ?>">Montreal Protocol</a></li>
                                            <li><a href="<?php i3_url_treaty('vienna'); ?>">Vienna</a></li>
                                        </ul>
                                        <ul class="nav-list span6">
                                            <li class="nav-header">Regional Treaties</li>
                                            <li><a href="<?php i3_url_treaty('aarhus'); ?>">Aarhus Convention</a></li>
                                            <li><a href="<?php i3_url_treaty('abidjan'); ?>">Abidjan Convention</a></li>
                                            <li><a href="<?php i3_url_treaty('aewa'); ?>">AEWA</a></li>
                                            <li><a href="<?php i3_url_treaty('antigua'); ?>">Antigua Convention</a></li>
                                            <li><a href="<?php i3_url_treaty('apia'); ?>">Apia Convention</a></li>
                                            <li><a href="<?php i3_url_treaty('barcelona'); ?>">Barcelona</a></li>
                                            <li><a href="<?php i3_url_treaty('dumping'); ?>">Barcelona Dumping Protocol</a></li>
                                            <li><a href="<?php i3_url_treaty('bamako'); ?>">Bamako Convention</a></li>
                                            <li><a href="<?php i3_url_treaty('cartagena-conv'); ?>">Cartagena Convention</a></li>
                                            <li><a href="<?php i3_url_treaty('espoo'); ?>">Espoo Convention</a></li>
                                            <li><a href="<?php i3_url_treaty('hazardous'); ?>">Hazardous Wastes Protocol</a></li>
                                            <li><a href="<?php i3_url_treaty('industrialaccidents'); ?>">Industrial Accidents Convention</a></li>
                                            <li><a href="<?php i3_url_treaty('jeddah'); ?>">Jeddah Convention</a></li>
                                            <li><a href="<?php i3_url_treaty('pollutantrelease'); ?>">Kiev Protocol</a></li>
                                            <li><a href="<?php i3_url_treaty('kuwait'); ?>">Kuwait Regional Convention</a></li>
                                            <li><a href="<?php i3_url_treaty('lrtp'); ?>">Long-Range Transboundary Air Pollution</a></li>
                                            <li><a href="<?php i3_url_treaty('lusakaagreement'); ?>">Lusaka Agreement</a></li>
                                            <li><a href="<?php i3_url_treaty('nairobi'); ?>">Nairobi Convention</a></li>
                                            <li><a href="<?php i3_url_treaty('noumea'); ?>">Noumea Convention</a></li>
                                            <li><a href="<?php i3_url_treaty('land-based'); ?>">Land-Based Sources Protocol</a></li>
                                            <li><a href="<?php i3_url_treaty('offshore'); ?>">Offshore Protocol</a></li>
                                            <li><a href="<?php i3_url_treaty('preventionemergency'); ?>">Prevention and Emergency Protocol</a></li>
                                            <li><a href="<?php i3_url_treaty('barc-spa'); ?>">Specially Protected Areas Protocol</a></li>
                                            <li><a href="<?php i3_url_treaty('kyivsea'); ?>">The Kyiv Protocol</a></li>
                                            <li><a href="<?php i3_url_treaty('protocolwaterhealth'); ?>">Protocol on Water and Health</a></li>
                                            <li><a href="<?php i3_url_treaty('waterconvention'); ?>">Water Convention</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li><a href="<?php echo get_permalink(get_page_by_title('countries')); ?>">Countries</a></li>
                        <li><a href="<?php echo get_permalink(get_page_by_title('glossary')); ?>">Glossary</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
