<?php
$request = WordPressHttpRequestFactory::createFromGlobals();
$type = $request->get('download_type');

switch($type) {
    case 'vcard':
        $id = $request->get('id_entity');
        $nfp = InforMEA::get_nfp($id);
        $name = InforMEA::format_nfp_name($nfp);
        $filename = sprintf('%s.vcf', $name);
        header("Content-type: text/x-vcard; charset=utf-8");
        header(sprintf("Content-Disposition: filename=\"%s\"", $filename));
        echo InforMEATemplate::nfp_format_vcard($nfp);
        break;
    case 'decision-document':
        $id = $request->get('id_entity');
        $row = InforMEA::get_document($id);
        if(empty($row)) {
            i3_404();
        } else {
            if(empty($row->url)) {
                i3_404();
            } else {
                $url = $row->url;
                $httpCode = check_remote_url($url);
                if ($httpCode != 200 && $httpCode != 302) { // On remote error, server local copy
                    $url = get_bloginfo('url') . '/' . $row->path;
                }
                header(sprintf("Location: %s", $url));
            }
        }
        break;
    default:
        die("Don't know what to do!");
}
exit();
