<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 12/04/2018
 * Time: 12:00
 */

namespace UdyWfToWp\Plugins\FrontendEditor;

class FrontendEditor_Shortcodes{

	public static function fee_image_shortcode(){
		add_shortcode('udesly_fee_image', function($atts){
			$a = shortcode_atts( array(
				'id' => -1,
			), $atts );

			$id = intval($a['id']);

			if( $id != -1 ){
				$feat_image_url = wp_get_attachment_url( $id );
				echo 'background-image:url('.$feat_image_url.');';
			}
		});
	}

}