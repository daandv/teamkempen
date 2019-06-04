<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 14/05/2018
 * Time: 15:05
 */

function udesly_get_edd_archive_title(){

	$saved_settings = \UdyWfToWp\Plugins\ContentManager\Settings\Settings_Manager::get_saved_settings();

	isset($saved_settings['edd_category_title']) ? $category_title = $saved_settings['edd_category_title'] : $category_title = 'Category: %s';
	isset($saved_settings['edd_archive_title']) ? $shop_title = $saved_settings['edd_archive_title'] : $shop_title = 'Downloads';
	isset($saved_settings['edd_tag_title']) ? $tag_title = $saved_settings['edd_tag_title'] : $tag_title = 'Tag: %s';
	isset($saved_settings['edd_author_title']) ? $author_title = $saved_settings['edd_author_title'] : $author_title = 'Tag: %s';

	if ( is_post_type_archive() ) {
		$title = __( $shop_title );
	} elseif ( is_tax('download_category') ) {
		$tax = get_taxonomy( get_queried_object()->taxonomy );
		$title = sprintf( __( '%1$s %2$s' ), $category_title, single_term_title( '', false ) );
	}
	elseif ( is_tax('download_tag') ) {
		$tax = get_taxonomy( get_queried_object()->taxonomy );
		$title = sprintf( __( '%1$s %2$s' ), $tag_title, single_term_title( '', false ) );
	}
	elseif ( is_author() ) {
		$title = sprintf( $author_title, '<span class="vcard">' . get_the_author() . '</span>' );
	} elseif ( is_year() ) {
		$title = sprintf( __( 'Year: %s' ), get_the_date( _x( 'Y', 'yearly archives date format' ) ) );
	} elseif ( is_month() ) {
		$title = sprintf( __( 'Month: %s' ), get_the_date( _x( 'F Y', 'monthly archives date format' ) ) );
	} elseif ( is_day() ) {
		$title = sprintf( __( 'Day: %s' ), get_the_date( _x( 'F j, Y', 'daily archives date format' ) ) );
	} elseif ( is_tax( 'post_format' ) ) {
		if ( is_tax( 'post_format', 'post-format-aside' ) ) {
			$title = _x( 'Asides', 'post format archive title' );
		} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
			$title = _x( 'Galleries', 'post format archive title' );
		} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
			$title = _x( 'Images', 'post format archive title' );
		} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
			$title = _x( 'Videos', 'post format archive title' );
		} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
			$title = _x( 'Quotes', 'post format archive title' );
		} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
			$title = _x( 'Links', 'post format archive title' );
		} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
			$title = _x( 'Statuses', 'post format archive title' );
		} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
			$title = _x( 'Audio', 'post format archive title' );
		} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
			$title = _x( 'Chats', 'post format archive title' );
		}
	} else {
		$title = $shop_title;
	}
	echo $title;
}

function udesly_get_edd_archive_categories(){
	$settings = \UdyWfToWp\Plugins\ContentManager\Settings\Settings_Manager::get_saved_settings();

	$subcategories_type = isset($settings['edd_archive_categories']) ? $settings['edd_archive_categories'] : 0;

	if ( $subcategories_type == 0 ) {
		return new WP_Term_Query();
	}
	$args = array(
		'taxonomy' => 'download_category'
	);

	if ( is_category() ) {
		$category = get_category( get_query_var( 'cat' ) );
		$cat_id   = $category->term_id;
		if ( $subcategories_type == 1 ) {
			$args['parent'] = $cat_id;
		} else {
			$args['child_of'] = $cat_id;
		}

		return new WP_Term_Query( $args );

	} elseif ( is_home() ) {
		if ( $subcategories_type == 1 ) {
			$args['parent'] = 0;
		} else {
			$args['child_of'] = 0;
		}

		return new WP_Term_Query( $args );
	}

	return new WP_Term_Query();
}

function udesly_edd_get_loop_price(){
	if(edd_has_variable_prices(get_the_ID())){
		return udesly_edd_get_variable_price_range(get_the_ID());
	}else{
		return edd_price(get_the_ID());
	}
}

function udesly_edd_get_variable_price_range( $download_id ){

	$prices  = edd_get_variable_prices( $download_id );

	usort($prices, 'udesly_edd_sort_amount');

	$prices_last = count($prices) - 1;

	$lowest_price = floatval($prices[0]['amount']);
	$highest_price = floatval($prices[$prices_last]['amount']);

	$variable_price = edd_currency_filter(edd_format_amount($lowest_price)) . ' - ' .edd_currency_filter(edd_format_amount($highest_price));
	return apply_filters('udesly_edd_variable_price', $variable_price, $download_id);

}

function udesly_edd_sort_amount($item1,$item2)
{
	if ($item1['amount'] == $item2['amount']) return 0;
	return ($item1['amount'] < $item2['amount']) ? -1 : 1;
}

function udesly_get_edd_breadcrumb(){

	$result = array();
	if ( is_tax('download_category') ) {
		$thisCat           = get_term( get_queried_object_id(), 'download_category' );
		if ( $thisCat->parent != 0 ) {
			$parents       = get_ancestors( $thisCat->term_id, 'download_category', 'taxonomy' );
			foreach ( array_reverse( $parents ) as $term_id ) {
				$parent = get_term( $term_id, 'download_category' );
				array_push( $result, array(
					'name' => $parent->name,
					'href' => get_term_link( $parent->term_id, 'download_category' ),
					'type' => 'category'
				) );
				array_push( $result, array(
					'type' => 'separator'
				) );
			}
		}
		$result[] = array( 'name' => $thisCat->name, 'type' => 'current' );
	} elseif ( is_single() && get_post_type() == 'download' ) {
		$parents       = wp_get_post_categories( get_the_ID(), array( 'hide_empty' => 0 ) );
		foreach ( $parents as $term_id ) {
			$parent = get_term( $term_id, 'download_category' );
			array_push( $result, array(
				'name' => $parent->name,
				'href' => get_term_link( $parent->term_id, 'download_category' ),
				'type' => 'category'
			) );
			array_push( $result, array(
				'type' => 'separator'
			) );
		}
		$result[] = array( 'name' => get_the_title(), 'type' => 'current' );

	}

	return $result;
}

function udesly_edd_get_main_category($id){
	if(!$id)
		return;

	$main_edd_category_id = get_post_meta($id, '_udesly_main_edd_category', true);

	$cat = get_term( $main_edd_category_id, 'download_category' );

	if(is_null($cat) || is_wp_error($cat))
		return;

	return array(
		'name' => $cat->name,
		'url' => get_term_link($cat->term_id, 'download_category'),
	);
}

function udesly_edd_get_cart_items(){

	global $post;
	$cart_items = array();

	foreach ( edd_get_cart_contents() as $cart_key => $item ) {

		$id = is_array( $item ) ? $item['id'] : $item;
		$title      = get_the_title( $id );
		$options    = !empty( $item['options'] ) ? $item['options'] : array();
		$quantity   = edd_get_cart_item_quantity( $id, $options );
		$price      = edd_get_cart_item_price( $id, $options );
		$nonce = wp_create_nonce( 'edd-remove-cart-widget-item' );
		$remove_url = edd_add_cache_busting( add_query_arg( array( 'cart_item' => $cart_key, 'edd_action' => 'remove' ), edd_get_current_page_url() ) );
        $remove_url = wp_nonce_url( $remove_url, 'edd-remove-from-cart-' . $cart_key, 'edd_remove_from_cart_nonce' );

		if ( ! empty( $options ) ) {
			$title .= ( edd_has_variable_prices( $item['id'] ) ) ? ' <span class="edd-cart-item-separator">-</span> ' . edd_get_price_name( $id, $item['options'] ) : edd_get_price_name( $id, $item['options'] );
		}

			$current_product = array();
			$current_product['title']      = $title;
			$current_product['image'] = get_the_post_thumbnail_url( $id, 'full' );
			$current_product['permalink'] = get_permalink($id);
			$current_product['remove_url'] = $remove_url;
			$current_product['remove_url_nonce'] = $nonce;
			$current_product['remove_url_cart_item_id'] = absint( $cart_key );
			$current_product['remove_url_item_id'] = absint($id);
			$current_product['quantity'] = sprintf( '%s &times; %s', $quantity, $price );
			$current_product['class'] = '';
			$cart_items[] = $current_product;
	}

	// dummyItem for javascript purposes
	$cart_items[] = array(
		'title' => '{{title}}',
		'image' => '{{image}}',
		'permalink' => '{{permalink}}',
		'quantity' => '{{quantity}}',
		'remove_url' => '{{remove_url}}',
		'remove_url_nonce' => '{{remove_url_nonce}}',
		'remove_url_cart_item_id' => '{{remove_url_cart_item_id}}',
		'remove_url_item_id' => '{{remove_url_item_id}}',
		'class' => 'udesly-edd-mini-cart-dummy-item'
	);
	return $cart_items;
}