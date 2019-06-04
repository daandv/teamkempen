<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 10/05/2018
 * Time: 11:04
 */

namespace UdyWfToWp\Plugins\Blog;

use UdyWfToWp\i18n\i18n;

class Blog_Configuration {

	public static function main_blog_category_add_meta_box( $post ) {
		add_meta_box( 'main_blog_category_meta_box', __( 'Main Category', i18n::$textdomain ), array(
			self::class,
			'main_blog_category_build_meta_box'
		), 'post', 'side', 'high' );
	}

	public static function main_blog_category_build_meta_box( $post ) {
		wp_nonce_field( basename( __FILE__ ), 'main_blog_category_meta_box_nonce' );
		$current_main_category = get_post_meta( $post->ID, '_udesly_main_blog_category', true );

		wp_dropdown_categories( array(
			'show_option_none' => __( 'No Main Category', i18n::$textdomain ),
			'include'          => wp_get_post_categories( $post->ID ),
			'selected'         => $current_main_category,
			'name'             => 'udesly_blog_main_cat'
		) );


	}

	public static function main_blog_category_save_meta_boxes_data( $post_id ) {
		if ( ! isset( $_POST['main_blog_category_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['main_blog_category_meta_box_nonce'], basename( __FILE__ ) ) ) {
			return;
		}
		if ( isset( $_REQUEST['udesly_blog_main_cat'] ) ) {
			update_post_meta( $post_id, '_udesly_main_blog_category', sanitize_key( $_REQUEST['udesly_blog_main_cat'] ) );

		}

	}

	public static function home_redirect( $template ) {

		$show_on_front = get_option( 'show_on_front' );
		if ( is_home() && $show_on_front == 'posts' ) {
			return get_index_template();
		}

		if ( is_front_page() && $show_on_front == 'page' ) {
			$template_page_on_front = get_page_template( get_option( 'page_on_front' ) );
			if ( get_post()->post_name !== 'index' && ! empty( $template_page_on_front ) ) {
				return $template_page_on_front;
			}
		}

		return $template;
	}
}