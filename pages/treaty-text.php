<?php
global $treaty, $organization;
$request = WordPressHttpRequestFactory::createFromGlobals();
$display = $request->get('display');
if(!$display) {
    get_header();
    get_template_part('pages/treaty-header-tpl');
    get_template_part('pages/treaty-toolbar-tpl');
}
echo InforMEATemplate::treaty_text_viewer($treaty, $request);
if(!$display) {
    get_footer();
}
