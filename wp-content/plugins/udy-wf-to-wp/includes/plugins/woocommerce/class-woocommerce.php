<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 28/03/2018
 * Time: 17:39
 */

namespace UdyWfToWp\Plugins\Woocommerce;

use UdyWfToWp\Core\Udy_Wf_To_Wp_Loader;
use UdyWfToWp\Interfaces\iPlugin;
use UdyWfToWp\Plugins\ContentManager\Settings\Settings_Woocommerce;


class Woocommerce implements iPlugin {
	public static function define_admin_hooks( Udy_Wf_To_Wp_Loader $loader ) {
		if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			return;
		}
		$loader->add_action('add_meta_boxes_product',Woocommerce_Configuration::class,'main_woo_category_add_meta_box');
		$loader->add_action( 'save_post', Woocommerce_Configuration::class,'main_woo_category_save_meta_boxes_data', 10, 2 );
	}

	public static function define_public_hooks( Udy_Wf_To_Wp_Loader $loader ) {
		if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			return;
		}
		$loader->add_action('wp_enqueue_scripts', Woocommerce_Configuration::class, 'add_frontend_assets');

		// Loop Actions
		$loader->add_action('init', Woocommerce_Configuration::class, 'remove_actions');
		$loader->add_action('wp_footer', Woocommerce_Configuration::class, 'add_woocommerce_mini_cart_elements');
		$loader->add_filter( 'woocommerce_add_to_cart_fragments', Woocommerce_Configuration::class,'add_mini_cart_fragments');
		$loader->add_filter( 'wc_get_template', Woocommerce_Utils::class,'woo_alternative_template', 10, 5);
		$loader->add_filter('post_class', Woocommerce_Configuration::class, 'remove_css_conflicts', 99, 3);

        $loader->add_action( 'wp_enqueue_scripts', Settings_Woocommerce::class, 'disable_select2', 100 );
		$loader->add_filter('woocommerce_form_field_args', Woocommerce_Utils::class,'woo_alter_input_fields', 10, 3);
	}

	public static function activate() {

	}

	public static function deactivate() {

	}

}
