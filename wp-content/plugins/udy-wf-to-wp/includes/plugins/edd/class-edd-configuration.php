<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 14/05/2018
 * Time: 17:08
 */

namespace UdyWfToWp\Plugins\Edd;

use UdyWfToWp\i18n\i18n;
use UdyWfToWp\Utils\Utils;

class Edd_Configuration {

	public static $assets_folder_url = UDY_WF_TO_WP_PLUGIN_DIRECTORY_URL . 'includes/plugins/edd/assets';

	public static function main_edd_category_add_meta_box( $post ) {
		add_meta_box( 'main_blog_category_meta_box', __( 'Main Category', i18n::$textdomain ), array(
			self::class,
			'main_edd_category_build_meta_box'
		), 'download', 'side', 'high' );
	}

	public static function main_edd_category_save_meta_boxes_data( $post_id ) {
		if ( ! isset( $_POST['main_edd_category_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['main_edd_category_meta_box_nonce'], basename( __FILE__ ) ) ) {
			return;
		}
		if ( isset( $_REQUEST['udesly_edd_main_cat'] ) ) {
			update_post_meta( $post_id, '_udesly_main_edd_category', sanitize_key( $_REQUEST['udesly_edd_main_cat'] ) );

		}

	}

	public static function main_edd_category_build_meta_box( $post ) {
		wp_nonce_field( basename( __FILE__ ), 'main_edd_category_meta_box_nonce' );
		$current_main_category = get_post_meta( $post->ID, '_udesly_main_edd_category', true );

		wp_dropdown_categories( array(
			'show_option_none' => __( 'No Main Category', i18n::$textdomain ),
			'include'          => wp_get_post_categories( $post->ID ),
			'selected'         => $current_main_category,
			'name'             => 'udesly_edd_main_cat',
			'taxonomy'         => 'download_category'
		) );
	}

	public static function add_custom_post_field_support($supports){

		$supports[] = 'custom-fields';

		return $supports;
	}

	public static function load_scripts(){
		wp_enqueue_script( 'udesly-edd', self::$assets_folder_url . '/js/udesly-edd.js', array('jquery'), Utils::getPluginVersion(), true );
		wp_enqueue_script( 'udesly-edd-mini-cart', self::$assets_folder_url . '/js/udesly-edd-mini-cart.js', array('udesly-edd'), Utils::getPluginVersion(), true );
	}

	public static function load_style(){
		wp_enqueue_style( 'udesly-edd', self::$assets_folder_url . '/css/udesly-edd.css', array(), Utils::getPluginVersion(), 'all' );
	}

	public static function add_cart_info($item){
        $item .= '<div style="display: none;" id="udesly-edd-mini-cart-items">' . json_encode(udesly_edd_get_cart_items()) . '</div>';
	    return $item;
    }

}