<?php
/**
 * Author: Cristian Romanescu <cristi _at_ eaudeweb dot ro>
 * Created: 201309171048
 */

class InforMEA {

    /**
     * Retrieve treaty by its odata_name identifier
     * @param $odata_name string as comes from OData protocol
     * @return stdClass Treaty object or NULL
     */
    static function get_treaty_by_odata_name($odata_name) {
        global $wpdb;
        return $wpdb->get_row(
            $wpdb->prepare('SELECT * FROM ai_treaty WHERE odata_name = %s', $odata_name)
        );
    }
}