<?php
function build_breadcrumbtrail($items) {
    $ret = '<div id="breadcrumbtrail">';
    $ret .='<ul>';
    $ret .=sprintf('<li>%s</li>', __('You are here:', 'informea'));
    $c = count($items);
    $i = 0;
	foreach($items as $label => $url) {
	$raquo = $i < $c -1 ? '<span class="separator">$raquo;</span>' : '';
	if(!empty($url)) {
   	 $ret .=sprintf('<li><a href="%s">%s</a>%s</li>', $url, $label, $raquo);
	} else {
	    $ret .= sprintf('<li>%s%s</li>', $label, $raquo);
	}
	$i++;

     }
	$ret .= '</ul>';
	$ret .= '</div>';
	return $ret;
}

function informea_breadcrumbtrail() {
     global $post;
     $ret = '';
     if ($post !== NULL && $post ->post_name != 'index') {
	 return '<div id="breadcrumb" class=clear">
	     <span class="breadcrumb-name">' .__('You are here:', 'informea') .'</span>
	     <a href="' .get_bloginfo('url') .'" title="">' .__('Home', 'informea') .'</a>' .applyfilters('breadcrumbtrail', '') .
		'</div>';

 }
return $ret;
}
?>
