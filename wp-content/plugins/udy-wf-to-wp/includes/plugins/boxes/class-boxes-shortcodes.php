<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 10/04/2018
 * Time: 14:21
 */

namespace UdyWfToWp\Plugins\Boxes;

use WP_Query;

class Boxes_Shortcodes{

	public static function render_box($atts){

		$output = '';

		extract( shortcode_atts( array(
			'slug' => ''
		), $atts ) );

		$args = array( 'post_type' => 'udesly_box' , 'name' => trim($slug));
		$box_query = new WP_Query( $args );

		if($box_query->have_posts()) :
			while( $box_query->have_posts() ) : $box_query->the_post();

				$output .= '<div class="clearfix">';
				$output .= the_content();
				$output .= '</div>';

			endwhile;
			endif;
		wp_reset_postdata();

		return $output;
	}


	public static function udesly_dynamic_box(){

		if(!udesly_has_dynamic_box())
			return;

		$post_id = get_the_ID();

		if(!$post_id)
			return '';

		$post_meta = get_post_meta($post_id, '_udesly_dynamic_box', true);
		
		$output = '';

		$output .= '<div class="clearfix">';
		$output .= apply_filters('the_content',$post_meta);
		$output .= '</div>';


		return $output;
	}

}