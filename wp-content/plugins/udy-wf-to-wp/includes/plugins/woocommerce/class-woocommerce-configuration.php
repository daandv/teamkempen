<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 10/05/2018
 * Time: 11:04
 */

namespace UdyWfToWp\Plugins\Woocommerce;

use UdyWfToWp\i18n\i18n;
use UdyWfToWp\Utils\Utils;

class Woocommerce_Configuration {

	public static function main_woo_category_add_meta_box( $post ) {
		add_meta_box( 'main_woo_category_meta_box', __( 'Main Category', i18n::$textdomain ), array(
			self::class,
			'main_woo_category_build_meta_box'
		), 'product', 'side', 'high' );
	}

	public static function main_woo_category_build_meta_box( $post ) {
		wp_nonce_field( basename( __FILE__ ), 'main_woo_category_meta_box_nonce' );
		$current_main_category = get_post_meta( $post->ID, '_udesly_main_woo_category', true );

		wp_dropdown_categories( array(
			'show_option_none' => __( 'No Main Category', i18n::$textdomain ),
			'include'          => wp_get_post_terms( $post->ID, 'product_cat', array( 'fields' => 'ids' ) ),
			'selected'         => $current_main_category,
			'name'             => 'udesly_woo_main_cat',
			'taxonomy'         => 'product_cat'
		) );

	}

	public static function main_woo_category_save_meta_boxes_data( $post_id ) {
		if ( ! isset( $_POST['main_woo_category_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['main_woo_category_meta_box_nonce'], basename( __FILE__ ) ) ) {
			return;
		}
		if ( isset( $_REQUEST['udesly_woo_main_cat'] ) ) {
			update_post_meta( $post_id, '_udesly_main_woo_category', sanitize_key( $_REQUEST['udesly_woo_main_cat'] ) );

		}

	}

	public static function add_frontend_assets() {
		wp_enqueue_style( 'udesly-woo-public', plugin_dir_url( __FILE__ ) . 'assets/css/udesly-woo-public.css', array(), Utils::getPluginVersion(), 'all' );
		if ( is_shop() || is_product_category() || is_product_tag() ) {
			wp_enqueue_script( 'udesly-woo-shop', plugin_dir_url( __FILE__ ) . 'assets/js/udesly-woo-shop.js', array(), Utils::getPluginVersion(), true );
		}
		if ( is_product() ) {
			wp_enqueue_script( 'udesly-woo-product', plugin_dir_url( __FILE__ ) . 'assets/js/udesly-woo-product.js', array(), Utils::getPluginVersion(), true );
		}
		wp_enqueue_script( 'udesly-woo-mini-cart', plugin_dir_url( __FILE__ ) . 'assets/js/udesly-woo-mini-cart.js', array(), Utils::getPluginVersion(), true );
	}

	public static function remove_actions() {

		// Loop Actions
		remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
		remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

		// Shop Page Actions
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
		remove_action( 'woocommerce_before_shop_loop', 'wc_print_notices', 10 );
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
		remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );

		// Single Product Actions
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end ', 10 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
		remove_action( 'woocommerce_before_single_product', 'wc_print_notices', 10 );
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
	}

	public static function add_woocommerce_mini_cart_elements() {
		?>
        <div id="udesly-woocommerce-mini-cart-elements" style="display: none;">
            <div id="udesly-woocommerce-mini-cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></div>
            <div id="udesly-woocommerce-mini-cart-subtotal"><?php echo WC()->cart->get_cart_subtotal(); ?></div>
            <div id="udesly-woocommerce-mini-cart-items"><?php echo json_encode(udesly_woocommerce_get_cart_items()); ?></div>
        </div>
		<?php
	}

	public static function add_mini_cart_fragments( $fragments ) {
		ob_start();
		?>
        <div id="udesly-woocommerce-mini-cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></div>
		<?php
		$fragments['#udesly-woocommerce-mini-cart-count'] = ob_get_clean();

		ob_start();
		?>
        <div id="udesly-woocommerce-mini-cart-subtotal"><?php echo WC()->cart->get_cart_subtotal(); ?></div>
		<?php
		$fragments['#udesly-woocommerce-mini-cart-subtotal'] = ob_get_clean();

		ob_start();
		?>
        <div id="udesly-woocommerce-mini-cart-items"><?php echo json_encode(udesly_woocommerce_get_cart_items()); ?></div>
		<?php
        $fragments['#udesly-woocommerce-mini-cart-items'] = ob_get_clean();
		return $fragments;
	}

	public static function remove_css_conflicts($classes, $class, $post_id){
		$classes = array_filter($classes, array(self::class, 'filter_css_product'));
		$classes[] = 'udesly-product';
        return $classes;
    }

    public static function filter_css_product($class){
        return $class !== 'product';
    }

}