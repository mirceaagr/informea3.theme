<?php
$request = WordPressHttpRequestFactory::createFromGlobals();
$view = $request->get('view');
$identifier = $request->get('identifier');
$term = InforMEA::get_term_by_slug_or_id($identifier);

if (have_posts()) : while (have_posts()) : the_post();
    switch($view) {
        case 'terms':
            echo InforMEATemplate::terms();
            break;
        case 'term':
            echo InforMEATemplate::term($term);
            break;
        case 'terms-list-az':
            echo InforMEATemplate::terms_list_az();
            break;
        default:
            die("Emergency! Four-0-four (404).");
    }
endwhile; endif;
