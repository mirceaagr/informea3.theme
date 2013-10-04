<?php

$request = WordPressHttpRequestFactory::createFromGlobals();
$entity = $request->get('type');

switch($entity) {
    case 'vcard':
        $id = $request->get('id');
        $nfp = InforMEA::get_nfp($id);
        $name = InforMEA::format_nfp_name($nfp);
        $filename = sprintf('%s.vcf', $name);
        header("Content-type: text/x-vcard; charset=utf-8");
        header(sprintf("Content-Disposition: filename=\"%s\"", $filename));
        echo InforMEATemplate::nfp_format_vcard($nfp);
        break;
    default:
        die("Don't know what to do!");
}
exit();