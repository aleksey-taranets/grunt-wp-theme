<?php
/*
 * Custom menu walker class
 */
class customMenuWalker extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<div class='right left'><ul>\n";
    }
    function end_lvl(&$output, $depth) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul></div>\n";
    }
	function start_el(&$output, $item, $depth, $args) {
		$class_names = join( ' ', $item->classes );
		$class_names = ' class="' .esc_attr( $class_names ). '"';
		$output.= '<li id="menu-item-' . $item->ID . '"' .$class_names.'>'; 
	 
		$newTitle = $item->title;
		$attributes.= !empty( $item->url ) ? ' href="' .esc_attr($item->url). '"' : ''; 
		$item_output = $args->before; 
	 
		if ($depth == 0) {
            $item_output.= '<a'. $attributes .'>';

            if (function_exists('get_woocommerce_term_meta')) {
                $thumbnail_id = get_woocommerce_term_meta( $item->object_id, 'thumbnail_id', true );
                if ($thumbnail_id) {
                    $image = wp_get_attachment_url( $thumbnail_id );
                    $item_output.= '<span class="image"><span><img src="'.$image.'" alt=""></span></span>';
                }
            }

            $item_output.= '<span class="txt">'.$args->link_before.$newTitle.$args->link_after.'</span>
                </a>';
		} else {
			$item_output.= '<a'. $attributes .'>'.$args->link_before.$newTitle.$args->link_after.'</a>';
		}
	 
		$item_output.= $args->after; 
		$output.= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args ); 
	}
	function end_el(&$output, $page, $depth) {
		$output .= "</li>\n";
	}
}