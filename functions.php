<?php
function build_breadcrumbtrail($items) {
    $ret = '<div id="breadcrumbtrail">';
    $ret .= '<ul>';
    $ret .= sprintf('<li>%s</li>', __('You are here:', 'informea'));
    $c = count($items);
    $i = 0;
	foreach($items as $label => $url) {
	$raquo = $i < $c - 1 ? '<span class="separator">$raquo;</span>' : '';
	if(!empty($url)) {
   	 $ret .= sprintf('<li><a href="%s">%s</a>%s</li>', $url, $label, $raquo);
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
	     <a href="' .get_bloginfo('url') .'" title="">' .__('Home', 'informea') .'</a>' .applyfilters('breadcrumbtrail', '') . '</div>';

}
return $ret;
}

function informea3_setup() {
  register_nav_menus(array(
	'primary' =>__('Primary Navigation', 'informea'),
	'footer' => __('Footer Menu', 'informea'),
  ));
}
add_action('after_setup_theme', 'informea3_setup');

/*Theme navigation : treaties*/
class informea3_walker extends Walker_Nav_Menu 
 {
    function start_el(&$output, $item, $depth, $args)
	{
	  global $wp_query;	 
          $indent = ($depth) ? str_repeat("\t",$depth) : '';
	 
	  $class_names = $value ='';

	  $classes = empty($item->classes) ? array() : (array) $item->classes;
	  
	  $class_names = join('', apply_filters('nav_menu_css_class', array_filter($classes), $item) );

	  $class_names = ' class="'.esc_attr( $class_names ) . '"';

          $output .= $indent .'<li id="menu-item-'. $item->ID . '"'. $value .$class_names .'>';
          
          $attributes = ! empty($item->attr_title) ?' title =" '. esc_attr($item->attr_title  ) .'"': '';
	  $attributes = ! empty($item->target) ?' target =" '. esc_attr($item->attr_target  ) .'"': '';
          $attributes = ! empty($item->xfn) ?' rel =" '. esc_attr($item->attr_xfn  ) .'"': '';
          $attributes = ! empty($item->url) ?' href =" '. esc_attr($item->attr_url  ) .'"': '';
	
          $prepend = '';
	  $append = '';
	  $description =! empty( $item->description ) ? '<span>'.esc_attr($item->description). '<span>' : '';

          if($depth != 0)
	{
		$description = $append = $prepend = "";
	}
	$item_output =$args->before;
	$item_output .='<a' .$attributes .'>';
	$item_output .=$args->link_before .$prepend.apply_filters('the_title', $item->title, $item->ID).$append; 
	$item_output .=$description.$args->link_after;
	$item_output .='</a>';
	$item_output .=$args->after;

	$output .= apply_filters ('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}
}
?>
