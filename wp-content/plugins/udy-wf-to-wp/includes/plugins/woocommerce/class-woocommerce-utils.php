<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 24/07/2018
 * Time: 15:03
 */

namespace UdyWfToWp\Plugins\Woocommerce;

class Woocommerce_Utils{

	/**
	 * Return true if user has purchased at least one products within the given array
	 *
	 * @param $products
	 *
	 * @return bool
	 */
	public static function has_current_user_purchased($products) {

		$current_user = wp_get_current_user();

		if ( 0 == $current_user->ID )
			return false;

		$results = false;
		foreach ($products as $product) {
			if(wc_customer_bought_product( $current_user->user_email, $current_user->ID, $product )){
				$results = true;
				break;
			}
		}

		return $results;
	}

	public static function woo_alternative_template($located, $template_name, $args, $template_path, $default_path){

        if (is_ajax() && ( $template_name === 'checkout/payment.php' || $template_name === 'checkout/payment-method.php')) {
            if (file_exists(UDY_WF_TO_WP_PLUGIN_DIRECTORY_PATH . 'templates/woocommerce/' . str_replace('/', '/new-', $template_name))) {
                return UDY_WF_TO_WP_PLUGIN_DIRECTORY_PATH . 'templates/woocommerce/' . str_replace('/', '/new-', $template_name);
            }
        }

	    if( defined('UDESLY_WOO_WEBFLOW_CHECKOUT') && UDESLY_WOO_WEBFLOW_CHECKOUT === true ) {

            if (file_exists(UDY_WF_TO_WP_PLUGIN_DIRECTORY_PATH . 'templates/woocommerce/' . str_replace('/', '/new-', $template_name))) {
                return UDY_WF_TO_WP_PLUGIN_DIRECTORY_PATH . 'templates/woocommerce/' . str_replace('/', '/new-', $template_name);
            }
        }
        if(file_exists(UDY_WF_TO_WP_PLUGIN_DIRECTORY_PATH . 'templates/woocommerce/' . $template_name)){
			return UDY_WF_TO_WP_PLUGIN_DIRECTORY_PATH . 'templates/woocommerce/' . $template_name;
		}
		return $located;
	}

	public static function woo_alter_input_fields( $args, $key, $value) {
        global $udesly_checkout_classes;
        if ($udesly_checkout_classes){
            $args['label_class'] = explode(' ', $udesly_checkout_classes['l']);
            $args['input_class'] = $args['type'] === 'country' ?  explode(' ', $udesly_checkout_classes['o']): explode(' ', $udesly_checkout_classes['i']);
            return $args;
        } else {
            return $args;
        }
    }



}