<?php
$request = WordPressHttpRequestFactory::createFromGlobals();
$odata_name = $request->get('odata_name');
$view = $request->get('view');
$modal = $request->get('display') == 'modal';
$treaty = InforMEA::get_treaty_by_odata_name($odata_name);
$act = $request->get('act');
$is_print = $act == 'print';
$organization = FALSE;
$id_decision = $request->get('id_decision');

if($treaty) {
    $organization = InforMEA::get_organization($treaty->id_organization);

    add_action('wp_enqueue_scripts', function() {
        global $treaty;
        // Inject treaty into the JS scripts as config object
        wp_localize_script('informea-treaties', 'i3_config_treaty', array('id' => $treaty->id));
    });
}

add_filter('wp_title', function($title, $sep) use ($treaty, $act, $view, $id_decision) {
        if($treaty) {
            if($view == 'text') {
                $title = sprintf('%sText of the %s', $sep, $treaty->short_title);
            } else if($view == 'decision') {
                $decision = InforMEA::get_decision($id_decision);
                $title = sprintf('%sDecision %s of the %s', $sep, $decision->number, $treaty->short_title);
            } else {
                $title = sprintf('%s %s', $sep, $treaty->short_title);
            }
        }
        return $title;
    }
    , 1, 2);

add_filter('the_breadcrumb',function ($items) use ($treaty, $view, $id_decision) {
    if($treaty) {
        $items[] = sprintf('<li><a href="%s">%s</a> <span class="divider">/</span></li>', get_permalink(), get_the_title());
        if($view == 'text') {
            $items[] = sprintf('<li><a href="%s">%s</a> <span class="divider">/</span></li>', i3_url_treaty($treaty), $treaty->short_title);
            $items[] = '<li class="active">Treaty text</li>';
        } else if($view == 'decision') {
            $decision = InforMEA::get_decision($id_decision);
            $items[] = sprintf('<li><a href="%s">%s</a> <span class="divider">/</span></li>', i3_url_treaty($treaty), $treaty->short_title);
            $items[] = sprintf('<li class="active">Decision %s</li>', $decision->number);
        } else {
            $items[] = sprintf('<li class="active">%s</li>', $treaty->short_title);
        }
    } else {
        $items[] = '<li class="active">Treaties</li>';
    }
    return $items;
});


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
            if($is_print) {
                add_action('wp_enqueue_scripts', function() { wp_enqueue_style('informea-print'); });
            }
            echo InforMEATemplate::treaty_text_viewer($treaty, $organization, $modal, $is_print);
            break;
        case 'decision':
            echo InforMEATemplate::treaty_decision_viewer($id_decision, $treaty, $organization, $modal);
            break;
        default:
            die("There nothing to do here. Nothing!");
    }
endwhile; endif;
