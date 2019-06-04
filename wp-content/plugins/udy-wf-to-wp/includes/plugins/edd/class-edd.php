<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 28/03/2018
 * Time: 17:39
 */

namespace UdyWfToWp\Plugins\Edd;

use UdyWfToWp\Core\Udy_Wf_To_Wp_Loader;
use UdyWfToWp\Interfaces\iPlugin;


class Edd implements iPlugin {
	public static function define_admin_hooks( Udy_Wf_To_Wp_Loader $loader ) {
        if ( !in_array( 'easy-digital-downloads/easy-digital-downloads.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
            return;
        }

		$loader->add_action ( 'edit_download_category_form_fields',  Edd_Terms::class,'extra_download_category_fields');
		$loader->add_action ( 'edited_download_category', Edd_Terms::class, 'save_extra_download_category_fields');

		$loader->add_action ( 'edit_download_tag_form_fields',  Edd_Terms::class,'extra_download_category_fields');
		$loader->add_action ( 'edited_download_tag', Edd_Terms::class, 'save_extra_download_category_fields');

		$loader->add_action('add_meta_boxes_download',Edd_Configuration::class,'main_edd_category_add_meta_box');

		$loader->add_action( 'save_post', Edd_Configuration::class,'main_edd_category_save_meta_boxes_data', 10, 2 );

		$loader->add_filter('edd_download_supports', Edd_Configuration::class, 'add_custom_post_field_support');
	}

	public static function define_public_hooks( Udy_Wf_To_Wp_Loader $loader ) {
        if ( !in_array( 'easy-digital-downloads/easy-digital-downloads.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
            return;
        }

		$loader->add_action('wp_enqueue_scripts', Edd_Configuration::class, 'load_scripts');
		$loader->add_action('wp_enqueue_scripts', Edd_Configuration::class, 'load_style');

		$loader->add_shortcode('udesly_edd_purchase_link',Edd_Shortcodes::class,'udesly_edd_purchase_link');

		$loader->add_filter('edd_cart_item',Edd_Configuration::class,'add_cart_info');

		remove_action( 'edd_after_download_content', 'edd_append_purchase_link' );
	}

	public static function activate() {

	}

	public static function deactivate() {

	}

}
