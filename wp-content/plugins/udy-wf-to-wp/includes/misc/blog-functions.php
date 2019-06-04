<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 29/03/2018
 * Time: 17:06
 */

function udesly_next_posts_link() {
	global $paged, $wp_query;

	$max_page = $wp_query->max_num_pages;

	if ( ! $paged ) {
		$paged = 1;
	}

	$nextpage = intval( $paged ) + 1;


	if ( ! is_single() && ( $nextpage <= $max_page ) ) {

		return next_posts( $max_page, false );
	}
}

function udesly_previous_posts_link() {
	global $paged;

	if ( ! is_single() && $paged > 1 ) {
		return previous_posts( false );
	}
}


function udesly_get_category_link_by_slug( $slug ) {

	$category = get_category_by_slug( $slug );

	if ( $category ) {
		$category_id = $category->term_id;

		return get_category_link( $category_id );
	}

	return '#';

}

function udesly_get_tag_link_by_slug( $slug ) {

	return get_term_link( $slug, 'post_tag' );

}

function udesly_get_lightbox_video_json( $post_field_key, $width, $height ) {
	$youtube_code = get_post_meta( get_the_ID(), $post_field_key, true );
	$width        = intval( $width );
	$height       = intval( $height );
	$url          = "https://www.youtube.com/watch?v=" . $youtube_code;
	$embed_url    = "https://www.youtube.com/embed/" . $youtube_code;
	$items        = array(
		"type"        => "video",
		"originalUrl" => $url . '&',
		"url"         => $url . '&',
		"html"        => "<iframe class=\"embedly-embed\" src=\"$embed_url\" width=\"$width\" height=\"$height\" scrolling=\"no\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen></iframe>",
		"width"       => $width,
		"height"      => $height,
	);

	return '{"items": [' . json_encode( $items ) . "] }";
}

function udesly_get_archive_categories() {

	$settings = \UdyWfToWp\Plugins\ContentManager\Settings\Settings_Manager::get_saved_settings();

	$subcategories_type = isset($settings['blog_archive_categories']) ? $settings['blog_archive_categories'] : 0;

	if ( $subcategories_type == 0 ) {
		return new WP_Term_Query();
	}
	$args = array(
		'taxonomy' => 'category'
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

function udesly_get_blog_breadcrumb() {
	$result = array();
	if ( is_category() ) {
		$thisCat           = get_category( get_query_var( 'cat' ), false );
		if ( $thisCat->parent != 0 ) {
			$parents       = get_ancestors( $thisCat->term_id, 'category', 'taxonomy' );
			foreach ( array_reverse( $parents ) as $term_id ) {
				$parent = get_term( $term_id, 'category' );
				array_push( $result, array(
					'name' => $parent->name,
					'href' => get_term_link( $parent->term_id, 'category' ),
					'type' => 'category'
				) );
				array_push( $result, array(
					'type' => 'separator'
				) );
			}
		}
		$result[] = array( 'name' => $thisCat->name, 'type' => 'current' );
	} elseif ( is_single() && get_post_type() == 'post' ) {
		$parents       = wp_get_post_categories( get_the_ID(), array( 'hide_empty' => 0 ) );
		foreach ( $parents as $term_id ) {
			$parent = get_term( $term_id, 'category' );
			array_push( $result, array(
				'name' => $parent->name,
				'href' => get_term_link( $parent->term_id, 'category' ),
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

function udesly_get_term_featured_image($term_id){
	$img = get_term_meta($term_id, '_featured_image', true);
	if($img)
	return wp_get_attachment_image_src($img, 'full')[0];
}

function udesly_get_main_category($id){
	if(!$id)
		return;

	$main_blog_category_id = get_post_meta($id, '_udesly_main_blog_category', true);

	$cat = get_category($main_blog_category_id);

	if(is_null($cat) || is_wp_error($cat))
		return;

	return array(
		'name' => $cat->name,
		'url' => get_term_link($cat->term_id, 'category'),
	);
}

function udesly_get_latest_index_global_query(){
	global $wp_query;
	$page  = max( 1, get_query_var( 'paged' ) );
	$ppp   = get_query_var('posts_per_page');
	$start = $ppp * ( $page - 1 ) + 1;
	$end   = $start + $wp_query->post_count - 1;
	return abs($start-$end);
}

function udesly_wp_link_page( $i ) {
        global $wp_rewrite;
        $post = get_post();

        if ( 1 == $i ) {
                $url = get_permalink();
        } else {
                if ( '' == get_option('permalink_structure') || in_array($post->post_status, array('draft', 'pending')) )
                        $url = add_query_arg( 'page', $i, get_permalink() );
                elseif ( 'page' == get_option('show_on_front') && get_option('page_on_front') == $post->ID )
                        $url = trailingslashit(get_permalink()) . user_trailingslashit("$wp_rewrite->pagination_base/" . $i, 'single_paged');
                else
                        $url = trailingslashit(get_permalink()) . user_trailingslashit($i, 'single_paged');
        }

        return esc_url( $url );
}