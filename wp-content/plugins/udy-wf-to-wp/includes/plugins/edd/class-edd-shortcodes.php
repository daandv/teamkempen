<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 24/05/2018
 * Time: 10:57
 */

namespace UdyWfToWp\Plugins\Edd;

class Edd_Shortcodes{
	public static function udesly_edd_purchase_link($atts){
		extract( shortcode_atts( array(
			'id' => '0'
		), $atts ) );
		
		if($id != '0') {
			return'<div style="display: none;">' . do_shortcode( '[purchase_link id="'.$id.'"]' ) . '</div>';
		}else{
			return '<div style="display: none;">' . do_shortcode( '[purchase_link]' ) . '</div>';
		}
	}
}