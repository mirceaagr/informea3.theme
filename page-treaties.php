<?php

$request = WordPressHttpRequestFactory::createFromGlobals();
$odata_name = $request->get('odata_name');
$view = $request->get('view');
$modal = $request->get('display') == 'modal';
$treaty = InforMEA::get_treaty_by_odata_name($odata_name);
$act = $request->get('act');
$is_print = $act == 'print';

if($treaty) {
    add_action('wp_enqueue_scripts', function() {
        global $treaty;
        // Inject treaty into the JS scripts as config object
        wp_localize_script('informea-treaties', 'i3_config_treaty', array('id' => $treaty->id));
    });
}

/**
 * Filter used by the treaty pages
 */
function i3_treaties_title($title, $sep) {
    global $treaty;
    if($treaty) {
        $title = sprintf('%s %s', $sep, $treaty->short_title);
    }
    return $title;
}
add_filter('wp_title', 'i3_treaties_title', 1, 2);

/**
 * Breadcrumbtrail set-up
 */
function informea_treaties_breadcrumbtrail($items) {
    global $treaty;
    if($treaty) {
        $items[] = sprintf('<li><a href="%s">%s</a> <span class="divider">/</span></li>', get_permalink(), get_the_title());
        $items[] = sprintf('<li class="active">%s</li>', $treaty->short_title);
    } else {
        $items[] = '<li class="active">Treaties</li>';
    }
    return $items;
}
add_filter('the_breadcrumb', 'informea_treaties_breadcrumbtrail');


if (have_posts()) : while (have_posts()) : the_post();
    switch($view) {
        case 'treaties':
            echo InforMEATemplate::treaties();
            break;
        case 'treaty':
            /** Add the scrollspy classes to the body tag */
            function informea_treaties_body_attributes($c) {
                $c[] = '" data-spy="scroll" data-target=".scrollspy';
                return $c;
            }
            add_filter('body_class','informea_treaties_body_attributes');
            // Inject ajaxurl into the front-end scripts as config object
            add_action('wp_enqueue_scripts',
                function() {
                    wp_enqueue_script('informea-treaties');
                    wp_localize_script('informea-treaties', 'i3_config_ajax', array('ajaxurl' => admin_url('admin-ajax.php')));
                }
            );
            echo InforMEATemplate::treaty($treaty);
            break;
        case 'text': // Normal page and Ajax call
            $organization = InforMEA::get_organization($treaty->id_organization);
            if($is_print) {
                add_action('wp_enqueue_scripts', function() { wp_enqueue_style('informea-print'); });
            }
            echo InforMEATemplate::treaty_text_viewer($treaty, $organization, $modal, $is_print);
            break;
        case 'decision':
            $id_decision = $request->get('id_decision');
            break;
        default:
            die("There nothing to do here. Nothing!");
    }
endwhile; endif;
