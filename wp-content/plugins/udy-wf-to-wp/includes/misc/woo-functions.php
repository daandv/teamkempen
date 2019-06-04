<?php

function udesly_get_woocoomerce_loop_add_to_cart_attributes() {
	global $product;
	$args = array();
	if ( $product ) {
		$defaults = array(
			'quantity'   => 1,
			'class'      => implode( ' ', array_filter( array(
				'product_type_' . $product->get_type(),
				$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
				$product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
			) ) ),
			'attributes' => array(
				'data-product_id'  => $product->get_id(),
				'data-product_sku' => $product->get_sku(),
				'aria-label'       => $product->add_to_cart_description(),
				'rel'              => 'nofollow',
			),
		);
		$args     = apply_filters( 'woocommerce_loop_add_to_cart_args', wp_parse_args( $args, $defaults ), $product );
		if ( isset( $args['attributes']['aria-label'] ) ) {
			$args['attributes']['aria-label'] = strip_tags( $args['attributes']['aria-label'] );
		}

		$add_to_cart               = array(
			'href'       => esc_url( $product->add_to_cart_url() ),
			'quantity'   => esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
			'class'      => esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
			'attributes' => isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
			'text'       => esc_html( $product->add_to_cart_text() )
		);
		$add_to_cart['attributes'] .= ' udesly-woo-add-to-cart';

		return $add_to_cart;
	} else {
		return array(
			'href'       => '',
			'quantity'   => 1,
			'class'      => '',
			'attributes' => '',
			'text'       => ''
		);
	}

}

function udesly_woocommerce_breadcrumb( $args = array() ) {
	$args        = wp_parse_args( $args, apply_filters( 'woocommerce_breadcrumb_defaults', array(
		'delimiter'   => '&nbsp;&#47;&nbsp;',
		'wrap_before' => '<nav class="woocommerce-breadcrumb">',
		'wrap_after'  => '</nav>',
		'before'      => '',
		'after'       => '',
		'home'        => _x( 'Shop', 'breadcrumb', 'woocommerce' ),
	) ) );
	$breadcrumbs = new WC_Breadcrumb();
	if ( ! empty( $args['home'] ) && ! is_shop() ) {
		$breadcrumbs->add_crumb( $args['home'], get_permalink( wc_get_page_id( 'shop' ) ) );
	}
	$breadcrumb = $breadcrumbs->generate();
	$result     = array();
	do_action( 'woocommerce_breadcrumb', $breadcrumbs, $args );

	if ( ! empty( $breadcrumb ) ) {
		foreach ( $breadcrumb as $key => $crumb ) {

			if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) {
				array_push( $result, array(
					'name' => esc_html( $crumb[0] ),
					'href' => esc_url( $crumb[1] ),
					'type' => 'category'
				) );
			} else {
				$result[] = array( 'name' => $crumb[0], 'type' => 'current' );
			}

			if ( sizeof( $breadcrumb ) !== $key + 1 ) {
				array_push( $result, array(
					'type' => 'separator'
				) );
			}
		}

	}

	return $result;
}

function udesly_woocommerce_result_count() {

	if ( ! wc_get_loop_prop( 'is_paginated' ) || ! woocommerce_products_will_display() ) {
		return;
	}

	$total    = wc_get_loop_prop( 'total' );
	$per_page = wc_get_loop_prop( 'per_page' );
	$current  = wc_get_loop_prop( 'current_page' );


	if ( $total <= $per_page || - 1 === $per_page ) {
		/* translators: %d: total results */
		printf( _n( 'Showing the single result', 'Showing all %d results', $total, 'woocommerce' ), $total );
	} else {
		$first = ( $per_page * $current ) - $per_page + 1;
		$last  = min( $total, $per_page * $current );
		/* translators: 1: first result 2: last result 3: total results */
		printf( _nx( 'Showing the single result', 'Showing %1$d&ndash;%2$d of %3$d results', $total, 'with first and last result', 'woocommerce' ), $first, $last, $total );
	}
}

function udesly_woocommerce_orderby_options() {
	if ( ! wc_get_loop_prop( 'is_paginated' ) || ! woocommerce_products_will_display() ) {
		return;
	}
	$show_default_orderby    = 'menu_order' === apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
	$catalog_orderby_options = apply_filters( 'woocommerce_catalog_orderby', array(
		'menu_order' => __( 'Default sorting', 'woocommerce' ),
		'popularity' => __( 'Sort by popularity', 'woocommerce' ),
		'rating'     => __( 'Sort by average rating', 'woocommerce' ),
		'date'       => __( 'Sort by newness', 'woocommerce' ),
		'price'      => __( 'Sort by price: low to high', 'woocommerce' ),
		'price-desc' => __( 'Sort by price: high to low', 'woocommerce' ),
	) );
	$default_orderby         = wc_get_loop_prop( 'is_search' ) ? 'relevance' : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby', '' ) );
	$orderby                 = isset( $_GET['orderby'] ) ? wc_clean( wp_unslash( $_GET['orderby'] ) ) : $default_orderby; // WPCS: sanitization ok, input var ok, CSRF ok.
	if ( wc_get_loop_prop( 'is_search' ) ) {
		$catalog_orderby_options = array_merge( array( 'relevance' => __( 'Relevance', 'woocommerce' ) ), $catalog_orderby_options );
		unset( $catalog_orderby_options['menu_order'] );
	}
	if ( ! $show_default_orderby ) {
		unset( $catalog_orderby_options['menu_order'] );
	}
	if ( 'no' === get_option( 'woocommerce_enable_review_rating' ) ) {
		unset( $catalog_orderby_options['rating'] );
	}
	if ( ! array_key_exists( $orderby, $catalog_orderby_options ) ) {
		$orderby = current( array_keys( $catalog_orderby_options ) );
	}
	foreach ( $catalog_orderby_options as $id => $name ) : ?>
        <option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
	<?php endforeach;

}

function udesly_woocommerce_get_archive_categories() {
	$parent_id          = is_product_category() ? get_queried_object_id() : 0;
	$product_categories = woocommerce_get_product_subcategories( $parent_id );

	if ( ! $product_categories ) {
		return array();
	}

	return $product_categories;
}

function udesly_woocommerce_get_category_featured_image( $category ) {
	$thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );

	if ( $thumbnail_id ) {
		$image = wp_get_attachment_image_src( $thumbnail_id, 'full' );
		$image = $image[0];
	} else {
		$image = wc_placeholder_img_src();
	}

	if ( $image ) {
		// Prevent esc_url from breaking spaces in urls for image embeds.
		// Ref: https://core.trac.wordpress.org/ticket/23605.
		$image = str_replace( ' ', '%20', $image );

		return esc_url( $image );

	}

	return '';
}

function udesly_woocommerce_should_archive_categories_be_visible() {
	if ( is_search() ) {
		return false;
	}
	if ( is_shop() && '' === get_option( 'woocommerce_shop_page_display' ) ) {
		return false;
	}

	$term = get_queried_object();

	if ( is_product_category() ) {
		$display_type = get_term_meta( $term->term_id, 'display_type', true );

		switch ( $display_type ) {
			case 'products' :
				return false;
				break;
			case '' :
				if ( '' === get_option( 'woocommerce_category_archive_display' ) ) {
					return false;
				}
				break;
		}
	}

	return true;
}

function udesly_woocommerce_should_products_be_visible() {
	return woocommerce_products_will_display();
}

function udesly_woocommerce_close_single_product() {
	do_action( 'woocommerce_after_single_product_summary' );
    ?>
    </div>
	<?php
	do_action( 'woocommerce_after_single_product' );
}

function udesly_woocommerce_open_single_product() {
	do_action( 'woocommerce_before_single_product' );
	?>
<div id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
}

function udesly_woocommerce_single_product_excerpt() {
	global $post;
	$short_description = apply_filters( 'woocommerce_short_description', $post->post_excerpt );
	if ( ! $short_description ) {
		return '';
	}
	return $short_description;
}

function udesly_woocommerce_get_product_gallery_images() {

    global $product;

    $images = array();

	$post_thumbnail_id = $product->get_image_id();
	$main_caption = wp_get_attachment_caption($post_thumbnail_id);
	$main_caption = $main_caption ?  $main_caption : '';
	$main_image_url = wp_get_attachment_image_url( $post_thumbnail_id, 'full' );
	$main_image_url = $main_image_url ? $main_image_url : esc_url( wc_placeholder_img_src() );
	$main_image = array(
		        'url' => $main_image_url,
                'caption' => $main_caption,
		        'group_name' => 'product-'. $product->get_id(),
        );
    $images[] = $main_image;

	$attachment_ids = $product->get_gallery_image_ids();

	if ( $attachment_ids && has_post_thumbnail() ) {
		foreach ( $attachment_ids as $attachment_id ) {
			$caption = wp_get_attachment_caption($attachment_id);
			$caption = $caption ?  $caption : '';
			$images[] = array(
			        'url' => wp_get_attachment_image_url( $attachment_id, 'full' ),
                    'caption' =>  $caption,
			        'group_name' => 'product-'. $product->get_id(),
            );
		}
	}

	return $images;
}

function udesly_gallery_product_generate_lightbox_json( $image ){
	$filename = basename ( $image['url'] );
    return '{"items":[{"caption":"'. $image['caption'] . '","fileName":"'. $filename . '","origFileName":"'. $filename . '","url":"'. $image['url'] . '","type":"image"}],"group":"'. $image['group_name'] . '"}';
}

function udesly_woocommerce_open_single_tab( $key ) {
    ?>
<div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr( $key ); ?> panel entry-content wc-tab" id="tab-<?php echo esc_attr( $key ); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>">
    <?php
}

function udesly_woocommerce_close_single_tab() {
    ?>
    </div>
    <?php
}

function udesly_woocommerce_get_upsells($limit = '-1', $columns = 4, $orderby = 'rand', $order = 'desc') {
        global $product;

        if ( ! $product ) {
            return;
        }

        // Handle the legacy filter which controlled posts per page etc.
        $args = apply_filters( 'woocommerce_upsell_display_args', array(
            'posts_per_page' => $limit,
            'orderby'        => $orderby,
            'columns'        => $columns,
        ) );

         $orderby = apply_filters( 'woocommerce_upsells_orderby', isset( $args['orderby'] ) ? $args['orderby'] : $orderby );
        $limit   = apply_filters( 'woocommerce_upsells_total', isset( $args['posts_per_page'] ) ? $args['posts_per_page'] : $limit );

        // Get visible upsells then sort them at random, then limit result set.
        $upsells = wc_products_array_orderby( array_filter( array_map( 'wc_get_product', $product->get_upsell_ids() ), 'wc_products_array_filter_visible' ), $orderby, $order );
        $upsells = $limit > 0 ? array_slice( $upsells, 0, $limit ) : $upsells;

        return $upsells;
}


function udesly_woocommerce_get_related( $args = array() ) {
        global $product;

        if ( ! $product ) {
            return;
        }

        $defaults = array(
            'posts_per_page' => 2,
            'columns'        => 2,
            'orderby'        => 'rand', // @codingStandardsIgnoreLine.
            'order'          => 'desc',
        );

        $args = wp_parse_args( $args, $defaults );

        // Get visible related products then sort them at random.
        $args['related_products'] = array_filter( array_map( 'wc_get_product', wc_get_related_products( $product->get_id(), $args['posts_per_page'], $product->get_upsell_ids() ) ), 'wc_products_array_filter_visible' );

        // Handle orderby.
        $args['related_products'] = wc_products_array_orderby( $args['related_products'], $args['orderby'], $args['order'] );

        return $args['related_products'];

}

function udesly_woocommerce_display_sku() {

    global $product;

    do_action( 'woocommerce_product_meta_start' ); ?>

	<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

        <span class="sku_wrapper"><?php esc_html_e( 'SKU:', 'woocommerce' ); ?> <span class="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'woocommerce' ); ?></span></span>

	<?php endif;

	do_action( 'woocommerce_product_meta_end' );
}

function udesly_woocommerce_get_notices() {
    $all_notices  = WC()->session->get( 'wc_notices', array() );
    $notice_types = apply_filters( 'woocommerce_notice_types', array( 'error', 'success', 'notice' ) );

    $notices = array();
    foreach ( $notice_types as $notice_type ) {
        if ( wc_notice_count( $notice_type ) > 0 ) {
             $notices[$notice_type] = array_filter( $all_notices[ $notice_type ] );
            }
    }

    wc_clear_notices();
    return $notices;

}

function udesly_woocommerce_featured_image_url() {
     global $product;
     $main_image_url = wp_get_attachment_image_url( $product->get_image_id(), 'full' );
     $main_image_url = $main_image_url ? $main_image_url : esc_url( wc_placeholder_img_src() );

     return $main_image_url;
}

function udesly_woocommerce_get_cart_items() {

    $cart_items = array();

    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
    $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
    if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
        $current_product = array();
        $current_product['title']      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );

        $main_image_url = wp_get_attachment_image_url( $_product->get_image_id(), 'full' );
	    $main_image_url = $main_image_url ? $main_image_url : esc_url( wc_placeholder_img_src() );
	    $current_product['image'] = $main_image_url;

    $product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
    $current_product['permalink'] = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
    $current_product['remove_url'] = wc_get_cart_remove_url( $cart_item_key );
    $current_product['quantity'] = sprintf( '%s &times; %s', $cart_item['quantity'], $product_price );
    $current_product['class'] = '';
    $cart_items[] = $current_product;
    }
    }
    // dummyItem for javascript purposes
    $cart_items[] = array(
            'title' => '{{title}}',
            'image' => '{{image}}',
            'permalink' => '{{permalink}}',
            'quantity' => '{{quantity}}',
            'remove_url' => '{{remove_url}}',
            'class' => 'udesly-woocommerce-mini-cart-dummy-item'
    );
    return $cart_items;
}

function udesly_get_woo_main_category($id){
	if(!$id)
		return;

	$main_blog_category_id = get_post_meta($id, '_udesly_main_woo_category', true);

	$cat = get_term($main_blog_category_id, 'product_cat');

	if(is_null($cat) || is_wp_error($cat))
		return;

	return array(
		'name' => $cat->name,
		'url' => get_term_link($cat->term_id, 'product_cat'),
	);
}


function udesly_woocommerce_add_to_cart() {
    global $product;
    $type = $product->get_type();

        do_action( 'woocommerce_' . $type . '_add_to_cart' );

    ?>
    <script type="text/javascript" src="<?php echo UDY_WF_TO_WP_PLUGIN_DIRECTORY_URL . 'includes/plugins/woocommerce/assets/js/udesly-woo-add-to-cart.dist.js'; ?>"></script>
    <?php
}



function udesly_woocommerce_webflow_checkout($classes = '{}') {
    define('UDESLY_WOO_WEBFLOW_CHECKOUT', true);

    $classes = wp_parse_args(json_decode($classes), array(
            'h' => '',
            'i' => '',
            'w' => '',
            'c' => '',
            'c_w' => '',
            'l' => '',
            'o' => '',
            'm' => '',
            's' => '',
            'b' => '',
            'header' => 'h4',
            'header_c' => '',
            'l_i' => '',
    ));

    global $udesly_checkout_classes;
    $udesly_checkout_classes = $classes;
     WC()->session->set( 'udesly_checkout_classes', $classes );

    echo do_shortcode('[woocommerce_checkout]');

}

