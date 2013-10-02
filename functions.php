<?php

$treaty_header_mode = '';
$organization = NULL;
$treaty = NULL;

require_once(dirname(__FILE__) . '/functions_informea.php');

//jQuery and migrate are always loaded in the header
//http://blog.cloudfour.com/getting-all-javascript-into-the-footer-in-wordpress-not-so-fast-buster/

wp_register_script('bootstrap', get_stylesheet_directory_uri() . '/scripts/bootstrap.js', array('jquery'), FALSE, TRUE);
wp_register_script('informea-common', get_stylesheet_directory_uri() . '/scripts/common.js', array('jquery'), FALSE, TRUE);
wp_register_script('informea-treaties', get_stylesheet_directory_uri() . '/scripts/treaties.js', array('jquery'), FALSE, TRUE);
wp_register_script('informea-about', get_template_directory_uri() . '/scripts/about.js', array('jquery'), FALSE, TRUE);

wp_enqueue_script('informea-common');
wp_enqueue_script('bootstrap');

wp_register_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.css');
wp_register_style('bootstrap-responsive', get_template_directory_uri() . '/css/bootstrap-responsive.css');
wp_register_style('font-awesome', get_template_directory_uri() . '/font-awesome/css/font-awesome.min.css');
wp_register_style('font-awesome-ie7', get_template_directory_uri() . '/font-awesome/css/font-awesome-ie7.min.css');
wp_register_style('informea-style', get_bloginfo('stylesheet_url'));
wp_register_style('informea-style-responsive', get_template_directory_uri() . '/css/style-responsive.css');
wp_register_style('informea-logos', get_template_directory_uri() . '/css/logos.css');


wp_enqueue_style('bootstrap');
wp_enqueue_style('informea-style');
wp_enqueue_style('bootstrap-responsive');
wp_enqueue_style('informea-style-responsive');
wp_enqueue_style('informea-logos');
wp_enqueue_style('font-awesome');


function i3_enqueue_styles() {
    global $wp_styles;

    wp_enqueue_style('font-awesome-ie7');
    $wp_styles->add_data('font-awesome-ie7', 'conditional', 'IE 7');
}
add_action('wp_enqueue_scripts', 'i3_enqueue_styles');


function i3_setup() {
	register_nav_menus(array(
		'primary' =>__('Primary Navigation', 'informea'),
		'footer' => __('Footer Menu', 'informea'),
	));
}
add_action('after_setup_theme', 'i3_setup');

add_filter('nav_menu_css_class' , 'about_page_menu');
function about_page_menu($classes){
     if( in_array('current-menu-item', $classes) ){
             $classes[] = 'active ';
     }
     return $classes;
}


/**
 * Echo the formatted region of a treaty (empty regions are treated as global)
 * @param $treaty stdClass object
 */
function i3_treaty_print_region($treaty) {
	echo !empty($treaty->region) ? $treaty->region : __('Global', 'informea');
}


/**
 * Echo the formatted topic of a treaty (printing primary and secondary topics)
 * @param $treaty stdClass Treaty object
 */
function i3_treaty_print_topic($treaty) {
	$ret = '';
	if(!empty($treaty->theme)) {
		$ret = sprintf('<strong>%s</strong>', $treaty->theme);
	}
	if(!empty($treaty->theme_secondary) && $treaty->theme_secondary != $treaty->theme) {
		if(!empty($treaty->theme)) {
			$ret .= ', ';
		}
		$ret .= sprintf('%s', $treaty->theme_secondary);
	}
	echo $ret;
}


/**
 * Build the treaty URL (use this instead of hard-coding the URL inside pages)
 * @param $treaty stdClass Treaty object
 * @param $suffix string Add suffix at the end of the URL
 * @param bool $echo (Optional) echo the URL instead of returning it
 * @return string The treaty URL
 */
function i3_treaty_url($treaty, $suffix = '', $echo = TRUE) {
    if(!is_string($treaty)) {
        $treaty = $treaty->odata_name;
    }
    $url = sprintf('%s/treaties/%s%s', get_bloginfo('url'), $treaty, $suffix);
    if($echo) {
        echo $url;
    }
    return $url;
}


/**
 * Echo the trety primary topics, in treaty index page
 * @param $treaty stdClass Treaty object
 */
function i3_treaty_print_topics($treaty) {
    if(!empty($treaty->theme) || !empty($treaty->theme_secondary)) {
        if(!empty($treaty->theme)) {
            echo sprintf('<strong>%s</strong>', $treaty->theme);
        }
        if(!empty($treaty->theme_secondary)) {
            if(!empty($treaty->theme)) {
                echo ', ';
            }
            echo $treaty->theme_secondary;
        }
    }
}


/**
 * Echo the year when treaty was created
 * @param $treaty stdClass Treaty object
 */
function i3_treaty_print_year($treaty) {
    if(!empty($treaty->start)) {
        $date = i3_format_mysql_date($treaty->start, 'Y');
        if(!empty($date)) {
            echo $date;
        }
    }
}


function i3_format_mysql_date($mysql_date, $format = 'd F Y', $empty = '&nbsp;') {
    $ret = $empty;
    if(!empty($mysql_date)) {
        $date = strtotime($mysql_date);
        if(!empty($date)) {
            $ret = date($format, $date);
        }
    }
    return $ret;
}


function i3_print_article_title($article) {
    $number = '';
    if(!empty($article->official_order)) {
        $number = $article->official_order;
        if(substr($number, -1) !== '.') {
            $number .= '. ';
        }
    }
    echo sprintf('%s %s', $number, $article->title);
}


/**
 * Print the caption table for the decision listing inside treaty page
 *
 * @param $cop stdClass COP meeting
 * @param $c integer Number of decisions
 */
function i3_treaty_decision_caption($cop, $c) {
    echo sprintf('%d decisions.',  $c);
    echo sprintf(' Meeting was held on %s, ', i3_format_mysql_date($cop->start));
    if(!empty($cop->location)) {
        echo sprintf(' %s', $cop->location);
    }
    if(!empty($cop->city)) {
        echo sprintf(' in %s', $cop->city);
    }
    $countries = InforMEA::get_countries();
    if(!empty($countries[$cop->id_country])) {
        $c = $countries[$cop->id_country];
        echo sprintf(', %s', $c->name);
    }
}


/**
 * Build the website breadcrumbtrail
 */
function informea_the_breadcrumb() {
    $items = array();
    if(!is_front_page()) {
        $items[] = sprintf('<li><a href="%s">Home</a> <span class="divider">/</span></li>', get_bloginfo('url'));
    }
    $items = apply_filters('the_breadcrumb', $items);
    if(!empty($items)) {
        echo '<ul class="breadcrumb hidden-phone">';
        foreach($items as $item) {
            echo $item;
        }
        echo '</ul>';
    }
}


/**
 * Retrieve the country flag URL
 * @param $country stdClass Country object
 * @param $version string Size. Supported values: 'medium' (default) or 'large'
 * @return string URL to the country flag image
 */
function i3_country_flag($country, $version = 'medium') {
    $ret = 'http://placehold.it/60x60';
    $field = 'icon_' . $version;
    if(!empty($country->$field)) {
        $ret = sprintf('%s/%s', get_template_directory_uri(), $country->$field);
    }
    return $ret;
}

/**
 * Format the view for a single NFP listing inside treaty page
 * @param $nfp stdClass People object
 */
function i3_treaty_nfp_format($nfp) {
    $name = '';
    if(!empty($nfp->prefix)) {
        $name .= $nfp->prefix . ' ';
    }
    if(!empty($nfp->first_name)) {
        if(strlen($name)) {
            $name .= ' ';
        }
        $name .= $nfp->first_name;
    }
    if(!empty($nfp->last_name)) {
        if(strlen($name)) {
            $name .= ' ';
        }
        $name .= $nfp->last_name;
    }
    $position = !empty($nfp->position) ? sprintf('<p class="occupation">%s</p>', $nfp->position) : '';
    $department = !empty($nfp->department) ? sprintf('<dt>Department</dt><dd>%s</dd>', $nfp->department) : '';
    $institution = !empty($nfp->institution) ? sprintf('<dt>Institution</dt><dd>%s</dd>', $nfp->institution) : '';
    $address = !empty($nfp->address) ? sprintf('<dt>Address</dt><dd>%s</dd>', $nfp->address) : '';
    $telephone = !empty($nfp->telephone) ? sprintf('<dt>Telephone</dt><dd>%s</dd>', $nfp->telephone) : '';
    $fax = !empty($nfp->fax) ? sprintf('<dt>Fax</dt><dd>%s</dd>', $nfp->fax) : '';
?>
    <li class="focal-point">
        <h3><?php echo $name; ?></h3>
        <?php echo $position; ?>
        <dl class="dl-horizontal">
            <?php echo $department; ?>
            <?php echo $institution; ?>
            <?php echo $address; ?>
            <?php echo $telephone; ?>
            <?php echo $fax; ?>
        </dl>
        <div class="focal-point-actions">
            <?php if(!empty($nfp->email)): ?>
            <a class="btn btn-inline" href=""><i class="icon-envelope-alt"></i> Send e-mail</a>&ensp;|&ensp;
            <?php endif; ?>
            <a class="btn btn-inline disabled informea-tooltip" href="javascript:void(0);"
               data-toggle="tooltip" data-placement="right"
               title="Download information in vCard format">Download vCard</a>
        </div>
    </li>
<?php
}