<?php

/**
 * Class Name: WH Nav Walker
 * Plugin URI:  https://github.com/webberhub/wp-bootstrap4-nav-walker
 * Description: This is a custom WordPress Bootstrap Nav Walker Class for Wordpress Developers.
 * Author: Nirosh Webber (Niroshan Wanigasingha)
 * Version: 1.0.0
 * Author URI: https://webberhub.com
 * GitHub Branch: master
 * License: MIT
 */

if ( !defined( 'ABSPATH' ) ) {
  die( 'Access is forbidden.' );
}


class WH_Nav_Walker extends Walker_Nav_Menu{

	public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
    }

    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ){

		$indent = ($depth) ? str_repeat("\t", $depth) : '';

		$li_attributes = '';
		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		$classes[] = ($args->walker->has_children) ? 'dropdown' : '';
		$classes[] = ($item->current || $item->current_item_anchestor)? 'active' : '';
		$classes[] = 'nav-item menu-item-'.$item->ID;

		if( $depth && $args->walker->has_children ){
			$classes[] = 'dropdown-submenu';
		}

		$class_names =  join(' ', apply_filters('nav_menu_css_class', array_filter( $classes ), $item, $args ));
		$class_names = ' class="' . esc_attr($class_names) . '"';


		$id = apply_filters('nav_menu_item_id', 'menu-item-'.$item->ID, $item, $args);
		$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names . $li_attributes . '>';




		$attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
		$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr($item->target) . '"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
		$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr($item->url) . '"' : '';
		
		// $attributes .= ( $args->walker->has_children ) ? ' class=" nav-link dropdown-toggle" data-toggle="dropdown"' : '';
		if($args->walker->has_children){
			$attributes .= ( $args->walker->has_children ) ? ' class=" nav-link dropdown-toggle" data-toggle="dropdown"' : '';
		}else{
			$attributes .= ' class="nav-link"';
		}

		$item_output = $args->before;
		$item_output .= '<a' . $attributes . '>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= ( $depth == 0 && $args->walker->has_children ) ? ' <b class="caret"></b></a>' : '</a>';
		$item_output .= $args->after;

		$output .= apply_filters ( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );


	}

}
