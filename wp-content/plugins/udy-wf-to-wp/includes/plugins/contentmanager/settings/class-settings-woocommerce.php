<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 26/04/2018
 * Time: 18:03
 */

namespace UdyWfToWp\Plugins\ContentManager\Settings;

class Settings_Woocommerce {

    public static function disable_select2() {
        $settings = Settings_Manager::get_saved_settings();
        if ( isset($settings['woo_disable_select2']) && $settings['woo_disable_select2']) {
            if ( class_exists( 'woocommerce' ) ) {
                wp_dequeue_style( 'selectWoo' );
                wp_deregister_style( 'selectWoo' );

                wp_dequeue_script( 'selectWoo');
                wp_deregister_script('selectWoo');
            }
        }
    }
	public static function new_subcategory_hierarchy( $templates ) {

		$settings = Settings_Manager::get_saved_settings();

		if ( ! is_product_category() ) {
			return $templates;
		}

		if ( isset( $settings['woo_use_template_parent_child'] ) && $settings['woo_use_template_parent_child'] == '1' ) {

			$category = get_queried_object();

			$parent_id = $category->category_parent;

			$templates = array();

			if ( $parent_id == 0 ) {
				// Use default values from get_category_template()
				$templates[] = "taxonomy-product_cat-{$category->slug}.php";
				$templates[] = "taxonomy-product_cat-{$category->term_id}.php";
				$templates[] = 'taxonomy-product_cat.php';
			} else {
				// Create replacement $templates array
				$parent = get_term( $parent_id, 'product_cat' );

				// Current first
				$templates[] = "taxonomy-product_cat-{$category->slug}.php";
				$templates[] = "taxonomy-product_cat-{$category->term_id}.php";

				// Parent second
				$templates[] = "taxonomy-product_cat-{$parent->slug}.php";
				$templates[] = "taxonomy-product_cat-{$parent->term_id}.php";
				$templates[] = 'taxonomy-product_cat.php';
			}
			return locate_template( $templates );
		}

		return $templates;
	}

}