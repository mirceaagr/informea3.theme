<?php
/**
 * Author: Cristian Romanescu <cristi _at_ eaudeweb dot ro>
 * Created: 201310021250
 */

add_action('wp_ajax_nopriv_get_nfp_for_treaty_country', 'informea_get_nfp_for_treaty_country_callback');
add_action('wp_ajax_get_nfp_for_treaty_country', 'informea_get_nfp_for_treaty_country_callback');
add_action('wp_ajax_nopriv_get_search_result', 'informea_get_search_result_callback');
add_action('wp_ajax_get_search_result', 'informea_get_search_result_callback');
add_action('wp_ajax_nopriv_get_country_nfp_from_treaty', 'informea_get_country_nfp_from_treaty_callback');
add_action('wp_ajax_get_country_nfp_from_treaty', 'informea_get_country_nfp_from_treaty_callback');

function informea_get_nfp_for_treaty_country_callback() {
    $request = WordPressHttpRequestFactory::createFromGlobals();
    $id_treaty = $request->get('id_treaty');
    $iso = $request->get('iso');
    $contacts = InforMEA::get_treaty_country_nfp($id_treaty, $iso);
    foreach($contacts as $row) {
        echo InforMEATemplate::nfp_format_li($row);
    }
    die();
}


function informea_get_search_result_callback(){
    $request = WordPressHttpRequestFactory::createFromGlobals();
    $q = $request->get('q');
    $treaties = InforMEA::search_treaty_by_name($q);
    $countries = InforMEA::search_country_by_name($q);
    $terms = InforMEA::search_term_by_name($q);
    $result['treaties'] = array();
    $result['countries'] = array();
    $result['terms'] = array();
    if ($treaties) {
        foreach ($treaties as $row) {
            $treaty = array();
            $treaty['display_name'] = $row->short_title;
            $treaty['display_logo'] = $row->logo_medium;
            $treaty['display_link'] = i3_url_treaty($row);
            $result['treaties'] []= $treaty;
        }
    }
    if ($countries) {
        foreach ($countries as $row) {
            $country = array();
            $country['display_name'] = $row->name;
            $country['display_logo'] = i3_url_country_flag($row);
            $country['display_link'] = i3_url_country($row);
            $result['countries'][] = $country;
        }
    }
    if ($terms) {
        foreach ($terms as $row) {
            $term = array();
            $term['display_name'] = $row->term;
            $term['display_link'] = i3_url_terms($row);
            $result['terms'][] = $term;
        }
    }

    echo json_encode($result);
    exit();
}
function informea_get_country_nfp_from_treaty_callback(){
    $request = WordPressHttpRequestFactory::createFromGlobals();
    $id_treaty = $request->get('id_treaty');
    $id_country = $request->get('id_country');
    $nfps = InforMEA::get_country_nfp_from_treaty($id_country, $id_treaty);
    foreach($nfps as $nfp) {
        echo InforMEATemplate::nfp_format_li($nfp);
    }
    die();
}
