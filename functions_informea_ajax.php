<?php
/**
 * Author: Cristian Romanescu <cristi _at_ eaudeweb dot ro>
 * Created: 201310021250
 */

// Inject ajaxurl into the front-end scripts as config object
wp_localize_script('informea-treaties', 'i3_config_ajax', array('ajaxurl' => admin_url('admin-ajax.php')));


