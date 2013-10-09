<?php
$request = WordPressHttpRequestFactory::createFromGlobals();
$view = $request->get('view');
$iso = $request->get('iso');
$country = InforMEA::get_country_by_iso($iso);

if (have_posts()) : while (have_posts()) : the_post();
    switch($view) {
        case 'countries':
            echo InforMEATemplate::countries();
            break;
        case 'country':
            echo InforMEATemplate::country($country);
            break;
        default:
            die("There nothing to do here. Nothing!");
    }
endwhile; endif;
