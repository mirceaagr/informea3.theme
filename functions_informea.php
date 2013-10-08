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
    static function get_treaties_enabled($order_by = 'a.`order`') {
        global $wpdb;
        $sql = $wpdb->prepare('SELECT a.* FROM ai_treaty a WHERE a.enabled = 1 AND a.use_informea = 1', array());
        $sql .= " ORDER BY $order_by";
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
     * Retrieve the treaty member parties.
     *
     * @param $id_treaty integer ID of the treaty
     * @return array Array with membership information
     */
    static function get_treaty_member_parties($id_treaty) {
        global $wpdb;
        $ret = array();
        $rows = $wpdb->get_results(
            $wpdb->prepare('
                SELECT a.*, b.name AS country, b.icon_medium AS flag
                    FROM ai_treaty_country a
                    INNER JOIN ai_country b ON a.id_country = b.id
                WHERE a.id_treaty = %d
                ORDER BY b.name', $id_treaty), OBJECT_K
        );
        foreach($rows as $id => $row) {
            $update = array_key_exists($id, $ret);
            $ob = $update ? $ret[$id] : new stdClass();
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
                  WHERE a.id_treaty = %d AND LOWER(a.`type`) IN ('cop', 'mop')
                  GROUP BY a.id
                  ORDER BY a.`start` DESC
                ", $id_treaty
            )
        );
    }


    static function get_treaty_decisions_count($id_treaty) {
        global $wpdb;
        return $wpdb->get_var(
            $wpdb->prepare('SELECT COUNT(*) FROM ai_decision a WHERE a.id_treaty = %d', $id_treaty)
        );
    }


    static function get_treaty_decisions_by_cop($id_event) {
        global $wpdb;
        return $wpdb->get_results(
            $wpdb->prepare('
                SELECT a.id, a.short_title, a.number, a.type, a.status
                  FROM ai_decision a
                  INNER JOIN ai_event b ON a.id_meeting = b.id
                  WHERE b.id = %d
                  ORDER BY b.start DESC, a.`display_order` ASC
            ', $id_event)
        );
    }


    /**
     * Retrieve articles for a treaty
     *
     * @param $id_treaty integer Treaty ID
     * @return array Array with article objects
     */
    static function get_treaty_articles($id_treaty) {
        global $wpdb;
        return $wpdb->get_results($wpdb->prepare(
                'SELECT a.* FROM ai_treaty_article a WHERE a.id_treaty = %d ORDER BY a.order',
                $id_treaty
            ), OBJECT_K
        );
    }


    /**
     * Retrieve all paragraphs for a treaty
     *
     * @param $id_treaty integer Treaty ID
     * @return array Array of paragraph objects keyed by article ID
     */
    static function get_treaty_paragraphs($id_treaty) {
        global $wpdb;
        return $wpdb->get_results(
            $wpdb->prepare('
                SELECT a.id, a.id_treaty_article AS id_article, a.official_order, a.`order`, a.`indent`, a.`content`
                  FROM ai_treaty_article_paragraph a
                  INNER JOIN ai_treaty_article b ON b.id = a.id_treaty_article
                  WHERE b.id_treaty = %d
                  ORDER BY a.`order`',
                $id_treaty
            ), OBJECT_K
        );
    }

    /**
     * Load all tags for a treaty, broken down by paragraph
     * @param $id_treaty integer ID of the treaty
     * @return array id_paragraph as key, array of tags as values
     */
    private static function get_treaty_paragraph_tags($id_treaty) {
        global $wpdb;
        $rows = $wpdb->get_results(
            $wpdb->prepare('
                SELECT c.*, a.id_treaty_article_paragraph AS id_paragraph
                    FROM ai_treaty_article_paragraph_vocabulary a
                    INNER JOIN ai_treaty_article b ON a.id_treaty_article_paragraph = b.id
                    INNER JOIN voc_concept c ON a.id_concept = c.id
                    WHERE b.id_treaty = %d;
            ', $id_treaty)
        );
        $ret = array();
        foreach($rows as $row) {
            $ret[$row->id_paragraph][$row->id] = $row;
        }
        return $ret;
    }

    /**
     * @param $id_treaty integer ID of the treaty
     * @return array id_paragraph as key, array of tags as values
     */
    private static function get_treaty_article_tags($id_treaty) {
        global $wpdb;
        $rows = $wpdb->get_results(
            $wpdb->prepare('
                SELECT c.*, a.id_treaty_article AS id_article
                    FROM ai_treaty_article_vocabulary a
                    INNER JOIN ai_treaty_article b ON a.id_treaty_article = b.id
                    INNER JOIN voc_concept c ON a.id_concept = c.id
                    WHERE b.id_treaty = %d;
            ', $id_treaty)
        );
        $ret = array();
        foreach($rows as $row) {
            $ret[$row->id_article][$row->id] = $row;
        }
        return $ret;
    }

    /**
     * This method loads all the treaty articles, paragraphs and tags.
     * @param $id_treaty integer ID of the treaty
     * @return array Array of articles. Each article has a property tags and one paragraphs.
     *      array(id_article => article)
     *          article->tags = array(id_concept => term)
     *          article->paragraphs = array(id_paragraph => paragraph)
     *              paragraph->tags = array(id_concept => term)
     */
    static function load_full_treaty_text($id_treaty) {
        $paragraphs = self::get_treaty_paragraphs($id_treaty);
        $paragraph_tags = self::get_treaty_paragraph_tags($id_treaty);
        foreach($paragraphs as $id_paragraph => &$row) {
            if(array_key_exists($id_paragraph, $paragraph_tags)) {
                $row->tags = $paragraph_tags[$id_paragraph];
            }
        }

        $grouped_paragraphs = array();
        foreach($paragraphs as $row) {
            $grouped_paragraphs[$row->id_article][] = $row;
        }

        $articles = self::get_treaty_articles($id_treaty);
        $article_tags = self::get_treaty_article_tags($id_treaty);

        // Assign paragraphs to articles
        foreach($articles as $id_article => &$row) {
            // Article tags
            if(array_key_exists($id_article, $article_tags)) {
                $row->tags = $article_tags[$id_article];
            }
            $row->paragraphs = FALSE;
            if(array_key_exists($id_article, $grouped_paragraphs)) {
                $row->paragraphs = $grouped_paragraphs[$id_article];
            }
        }
        return $articles;
    }

    /**
     * Retrieve the list of countries. Statically cached.
     *
     * @return array Array of objects with country information
     */
    static function get_countries() {
        static $ret = array();
        if(empty($ret)) {
            global $wpdb;
            $ret = $wpdb->get_results('SELECT * FROM ai_country ORDER BY name', OBJECT_K);
        }
        return $ret;
    }


    /**
     * Retrieve a country by its ISO code.
     *
     * @param $code string ISO code
     * @return mixed Country object or FALSE if not found
     */
    static function get_country($code) {
        $countries = self::get_countries();
        foreach($countries as $c) {
            if($c->code == $code || $c->code2l == $code) {
                return $c;
            }
        }
        return FALSE;
    }


    /**
     * Return the top terms used to tag a treaty (articles, paragraphs, decisions etc.).
     *
     * @param $id_treaty integer Treaty ID
     * @param $limit integer Number of terms to return
     *
     * @return array Array of terms;
     */
    static function get_treaty_popular_tags($id_treaty, $limit = 10) {
        global $wpdb;
        $ret = array();
        $tmp = array();

        // Treaty / Article / Paragraph / Tags
        $rows = $wpdb->get_results(
            $wpdb->prepare('SELECT a.id_concept, COUNT(a.id_concept) AS c
                    FROM ai_treaty_article_paragraph_vocabulary a
                    INNER JOIN ai_treaty_article b ON a.id_treaty_article_paragraph = b.id
                    WHERE b.id_treaty = %d GROUP BY a.id_concept HAVING COUNT(a.id_concept) > 1
                    ORDER BY count(a.id_concept) DESC', $id_treaty),
            OBJECT_K
        );
        foreach($rows as $id => $row) {
            if(!array_key_exists($id, $tmp)) {
                $tmp[$id] = 0;
            }
            $tmp[$id] += $row->c;
        }

        // Treaty / Article / Tags
        $rows = $wpdb->get_results(
            $wpdb->prepare('SELECT a.id_concept, COUNT(a.id_concept) AS c
                    FROM ai_treaty_article_vocabulary a
                    INNER JOIN ai_treaty_article b ON a.id_treaty_article = b.id
                    WHERE b.id_treaty = %d GROUP BY a.id_concept HAVING COUNT(a.id_concept) > 1
                    ORDER BY count(a.id_concept) DESC', $id_treaty), OBJECT_K
        );
        foreach($rows as $id => $row) {
            if(!array_key_exists($id, $tmp)) {
                $tmp[$id] = 0;
            }
            $tmp[$id] += $row->c;
        }

        // Treaty / Tags
        $rows = $wpdb->get_results(
            $wpdb->prepare('SELECT a.id_concept, COUNT(a.id_concept) AS c
                    FROM ai_treaty_vocabulary a WHERE a.id_treaty = %d GROUP BY a.id_concept
                    HAVING COUNT(a.id_concept) > 1 ORDER BY count(a.id_concept) DESC', $id_treaty),
            OBJECT_K
        );
        foreach($rows as $id => $row) {
            if(!array_key_exists($id, $tmp)) {
                $tmp[$id] = 0;
            }
            $tmp[$id] += $row->c;
        }

        // Treaty / Decisions / Paragraphs / Tags
        $rows = $wpdb->get_results(
            $wpdb->prepare('SELECT a.id_concept, COUNT(a.id_concept) AS c
                    FROM ai_decision_paragraph_vocabulary a
                    INNER JOIN ai_decision_paragraph b ON a.id_decision_paragraph = b.id
                    INNER JOIN ai_decision c ON b.id_decision = c.id
                    WHERE c.id_treaty = %d GROUP BY a.id_concept HAVING COUNT(a.id_concept) > 1
                    ORDER BY count(a.id_concept) DESC', $id_treaty), OBJECT_K
        );
        foreach($rows as $id => $row) {
            if(!array_key_exists($id, $tmp)) {
                $tmp[$id] = 0;
            }
            $tmp[$id] += $row->c;
        }

        // Treaty / Decisions / Tags
        $rows = $wpdb->get_results(
            $wpdb->prepare('
                SELECT a.id_concept, COUNT(a.id_concept) AS c
                    FROM ai_decision_vocabulary a INNER JOIN ai_decision b ON a.id_decision = b.id
                    WHERE b.id_treaty = %d GROUP BY a.id_concept HAVING COUNT(a.id_concept) > 1
                    ORDER BY count(a.id_concept) DESC', $id_treaty), OBJECT_K
        );
        foreach($rows as $id => $row) {
            if(!array_key_exists($id, $tmp)) {
                $tmp[$id] = 0;
            }
            $tmp[$id] += $row->c;
        }

        // Build an array of terms and set weight on each term
        $tmp = array_slice($tmp, 0, $limit, TRUE);
        $objects = $wpdb->get_results(
            sprintf(
                'SELECT * FROM voc_concept WHERE id IN (%s)',
                implode(',', array_keys($tmp))
            ),
            OBJECT_K
        );
        // Attach weight
        $keys = array_keys($tmp);
        $c = count($keys);
        foreach($keys as $weight => $id_term) {
            $term = $objects[$id_term];
            $term->weight = ($c - $weight);
            $ret[] = $term;
        }
        return $ret;
    }


    /**
     * Retrieve the list of countries that have NFPs for the specified treaty
     * @param $id_treaty integer ID of the treaty
     * @return array List of country classes
     */
    static function get_treaty_nfp_countries($id_treaty) {
        global $wpdb;
        return $wpdb->get_results(
            $wpdb->prepare('
                SELECT c.*
                  FROM ai_people a
                  INNER JOIN ai_people_treaty b ON a.id = b.id_people
                  INNER JOIN ai_country c ON a.id_country = c.id
                  WHERE b.id_treaty = %d GROUP BY c.id ORDER BY c.name', $id_treaty
                ), OBJECT_K
        );
    }


    /**
     * Retrieve the total number of focal points for a treaty.
     *
     * @param $id_treaty integer ID of the treaty
     * @return integer Global focal points count
     */
    static function get_treaty_nfp_count($id_treaty) {
        global $wpdb;
        return $wpdb->get_var(
            $wpdb->prepare('SELECT COUNT(*) FROM ai_people_treaty WHERE id_treaty = %d', $id_treaty)
        );
    }


    /**
     * Retrieve the NFPs for a treaty within a country.
     *
     * @param $id_treaty integer ID of the treaty
     * @param $iso string Country ISO code
     *
     * @return array Array of people objects
     */
    static function get_treaty_country_nfp($id_treaty, $iso) {
        global $wpdb;
        return $wpdb->get_results(
            $wpdb->prepare('
                SELECT a.*
                  FROM ai_people a
                  INNER JOIN ai_people_treaty b ON a.id = b.id_people
                  INNER JOIN ai_country c ON a.id_country = c.id
                  WHERE b.id_treaty = %d AND (c.code = %s OR c.code2l = %s)
            ', $id_treaty, $iso, $iso)
        );
    }


    /**
     * Load national focal point by its ID
     *
     * @param $id_people integer People ID
     * @return mixed stdClass Object with 'treaties' property that keeps all the treaties for the person
     */
    static function get_nfp($id_people) {
        global $wpdb;
        $ret = $wpdb->get_row(
            $wpdb->prepare('
                SELECT a.*, b.icon_medium, b.icon_large, b.name AS country_name, LOWER(b.code) AS country_code
                    FROM ai_people a
                    LEFT JOIN ai_country b ON a.id_country = b.id
                    WHERE a.id = %d
            ', $id_people)
        );
        if(!empty($ret)) {
            $ret->treaties = $wpdb->get_results(
                $wpdb->prepare('
                    SELECT a.* FROM ai_treaty a
                        INNER JOIN ai_people_treaty b ON a.id = b.id_treaty
                        WHERE b.id_people = %d
                ', $id_people)
            );
        }
        return $ret;
    }

    /**
     * Build NFP name field based on what is filled-in.
     *
     * @param $nfp stdClass Person object
     * @return string Name
     */
    static function format_nfp_name($nfp) {
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
        return $name;
    }
}