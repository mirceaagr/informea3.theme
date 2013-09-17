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


    /**
     * Retrieve organization by primary key
     * @param $id int Organization ID
     * @return stdClass Organization object
     */
    static function get_organization($id) {
        global $wpdb;
        return $wpdb->get_row(
            $wpdb->prepare('SELECT * FROM ai_organization WHERE id = %d', $id)
        );
    }


    /**
     * Retrieve InforMEA enabled treaties
     * @return array Array of treaty objects
     */
    static function get_treaties_enabled() {
        global $wpdb;
        $sql = $wpdb->prepare('SELECT a.* FROM ai_treaty a WHERE a.enabled = 1 AND a.use_informea = 1', array());
        $sql .= ' ORDER BY a.`order`';
        return $wpdb->get_results($sql);
    }


    /**
     * Count the total number of InforMEA enabled treaties
     * @return int Count
     */
    static function get_treaties_enabled_count() {
        global $wpdb;
        $sql = $wpdb->prepare('SELECT count(*) FROM ai_treaty a WHERE a.enabled = 1 AND a.use_informea = 1', array());
        return $wpdb->get_var($sql);
    }


    /**
     * Retrieve the primary treaty topics from the database
     * @return array Array of string with the terms
     */
    static function get_treaties_enabled_primary_topics() {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT DISTINCT (a.theme) AS theme FROM ai_treaty a
              WHERE TRIM(a.theme) <> '' AND a.enabled = 1 AND a.use_informea = 1 ORDER BY theme",
            array()
        );
        return $wpdb->get_col($sql);
    }


    /**
     * Retrieve the unique regions in use within a treaty
     * @return array Array of object classes from ai_region table
     */
    static function get_treaties_enabled_regions_in_use() {
        global $wpdb;
        return $wpdb->get_results('SELECT a.* FROM ai_region a INNER JOIN ai_treaty_region b ON a.id = b.id_region GROUP BY a.id ORDER BY a.id');
    }
}