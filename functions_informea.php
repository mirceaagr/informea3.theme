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


    /**
     * Retrieve the treaty member parties
     * @param $treaty
     * @return array Array with membership information
     */
    static function get_treaty_member_parties($treaty) {
        global $wpdb;
        $ret = array();
        $rows = $wpdb->get_results(
            $wpdb->prepare('
                SELECT a.*, b.name AS country, b.icon_medium AS flag
                    FROM ai_treaty_country a
                    INNER JOIN ai_country b ON a.id_country = b.id
                WHERE a.id_treaty = %d
                ORDER BY b.name', $treaty->id)
        );
        foreach($rows as $row) {
            $update = array_key_exists($row->id, $ret);
            $ob = $update ? $ret[$row->id] : new stdClass();
            $ob->country = $row->country;
            $ob->entryIntoForce = '';
            $ob->signed = '';
            $ob->notes = $row->notes;
            switch($row->status) {
                case 'entryIntoForce':
                    $ob->entryIntoForce = $row->date;
                    $ob->status = 'Party';
                    break;
                case 'signature':
                    $ob->signed = $row->date;
                    if(!$update) {
                        $ob->status = 'Signature';
                    }
                    break;
                case 'succesion':
                    $ob->signed = $row->date;
                    if(!$update) {
                        $ob->status = 'Succession';
                    }
                    break;
                case 'ratification':
                    $ob->signed = $row->date;
                    if(!$update) {
                        $ob->status = 'Ratification';
                    }
                    break;
                case 'acceptance':
                    $ob->signed = $row->date;
                    if(!$update) {
                        $ob->status = 'Acceptance';
                    }
                    break;
                case 'approval':
                    $ob->signed = $row->date;
                    if(!$update) {
                        $ob->status = 'Approval';
                    }
                    break;
                case 'accesion':
                    $ob->signed = $row->date;
                    if(!$update) {
                        $ob->status = 'Accesion';
                    }
                    break;
            }
            $ret[$row->id_country] = $ob;
        }
        return $ret;
    }


    static function get_treaty_cop_meetings($id_treaty) {
        global $wpdb;
        return $wpdb->get_results(
            $wpdb->prepare("
                SELECT a.* FROM ai_event a
                  INNER JOIN ai_decision b ON b.id_meeting = a.id
                  WHERE a.id_treaty = 1 AND LOWER(a.`type`) IN ('cop', 'mop')
                  GROUP BY a.id
                  ORDER BY a.`start` DESC
                ", $id_treaty
            )
        );
    }


    static function get_meeting_decisions($id_meeting) {
        global $wpdb;
        return $wpdb->get_results(
            $wpdb->prepare("
                SELECT * FROM ai_decision WHERE id_meeting = %d ORDER BY display_order
            ", $id_meeting)
        );
    }


    static function get_treaty_decisions_count($id_treaty) {
        global $wpdb;
        return $wpdb->get_var(
            $wpdb->prepare("
                SELECT COUNT(*) FROM ai_decision WHERE id_treaty = %d
            ", $id_treaty)
        );
    }
}