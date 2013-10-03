<?php
/**
 * Author: Cristian Romanescu <cristi _at_ eaudeweb dot ro>
 * Created: 201310021250
 */

add_action('wp_ajax_nopriv_get_nfp_for_treaty_country', 'informea_get_nfp_for_treaty_country_callback');
add_action('wp_ajax_get_nfp_for_treaty_country', 'informea_get_nfp_for_treaty_country_callback');
function informea_get_nfp_for_treaty_country_callback() {
    $request = WordPressHttpRequestFactory::createFromGlobals();
    $id_treaty = $request->get('id_treaty');
    $iso = $request->get('iso');
    $contacts = InforMEA::get_treaty_country_nfp($id_treaty, $iso);
    foreach($contacts as $row) {
        i3_treaty_nfp_format($row);
    }
    die();
}
