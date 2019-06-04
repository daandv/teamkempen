<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 16/04/2018
 * Time: 11:00
 */

function udesly_get_content_query( $slug ) {
	if ( $query_post = get_page_by_path( $slug, OBJECT, 'udesly_content' ) ) {
		$id = $query_post->ID;
	} else {
		return new WP_Query();
	}

	$content = new \UdyWfToWp\Plugins\ContentManager\Contents\Content( $id );
	$args    = $content->query;

	if ( isset( $content->query['related'] ) && $content->query['related'] == 'contents' && is_single() ) {
		global $post;

		if ( $post->post_type != 'post' ) {
			switch ( $post->post_type ) {
				case 'download' :
					$args = _udesly_get_tax_args( $post->ID, 'download_tag' );
					break;
			}
		} else {

			$tags = wp_get_post_tags( $post->ID );
			if ( $tags ) {
				$tag_ids = array();
				foreach ( $tags as $individual_tag ) {
					$tag_ids[] = $individual_tag->term_id;
				}
				$args = array(
					'tag__in'             => $tag_ids,
					'post__not_in'        => array( $post->ID ),
					'ignore_sticky_posts' => 1
				);
			}

		}

		if ( isset( $content->query['orderby'] ) ) {
			$args['orderby'] = $content->query['orderby'];
		}

		if ( isset( $content->query['order'] ) ) {
			$args['order'] = $content->query['order'];
		}

		if ( isset( $content->query['posts_per_page'] ) ) {
			$args['posts_per_page'] = $content->query['posts_per_page'];
		}

		if ( isset( $content->query['tag__not_in'] ) ) {
			$args['tag__not_in'] = $content->query['tag__not_in'];
		}

	}

	if ( isset( $content->query['related'] ) && $content->query['related'] == 'categories' && is_single() ) {
		global $post;

		if ( $post->post_type != 'post' ) {
			switch ( $post->post_type ) {
				case 'download' :
					$args = _udesly_get_tax_args( $post->ID, 'download_category' );
					break;
			}
		} else {
			$categories = get_the_category( $post->ID );
			if ( $categories ) {
				$category_ids = array();
				foreach ( $categories as $individual_category ) {
					$category_ids[] = $individual_category->term_id;
				}
				$args = array(
					'category__in'        => $category_ids,
					'post__not_in'        => array( $post->ID ),
					'ignore_sticky_posts' => 1
				);

			}
		}

		if ( isset( $content->query['orderby'] ) ) {
			$args['orderby'] = $content->query['orderby'];
		}

		if ( isset( $content->query['order'] ) ) {
			$args['order'] = $content->query['order'];
		}

		if ( isset( $content->query['posts_per_page'] ) ) {
			$args['posts_per_page'] = $content->query['posts_per_page'];
		}

		if ( isset( $content->query['category__not_in'] ) ) {
			$args['category__not_in'] = $content->query['category__not_in'];
		}
	}

	if ( isset( $content->query['related'] ) ) {
		unset( $content->query['related'] );
	}

	if(isset( $content->query['contenttaxonomy'][0] ) && isset( $content->query['contentterm'] )){
		$args['tax_query'] = array(array(
			'taxonomy' => $content->query['contenttaxonomy'][0],
			'terms'    => $content->query['contentterm'],
		));
		unset($args['contenttaxonomy']);
		unset($args['contentterm']);
	}

	return new WP_Query( $args );
}

function _udesly_get_tax_args( $post_id, $taxonomy ) {
	$terms = get_the_terms( $post_id, $taxonomy, 'string' );
	//Pluck out the IDs to get an array of IDS
	$term_ids = wp_list_pluck( $terms, 'term_id' );

	$args = array(
		'post__not_in' => array( $post_id ),
		'tax_query'    => array(
			array(
				'taxonomy' => $taxonomy,
				'field'    => 'id',
				'terms'    => $term_ids,
				'operator' => 'IN' //Or 'AND' or 'NOT IN'
			)
		)
	);

	return $args;
}

function udesly_get_list_query( $slug ) {
	if ( $post = get_page_by_path( $slug, OBJECT, 'udesly_list' ) ) {
		$id = $post->ID;
	} else {
		return new WP_Term_Query();
	}

	$list = new \UdyWfToWp\Plugins\ContentManager\Lists\List_Model( $id );

	return new WP_Term_Query( $list->query );
}


/**
 * Callable only in post loop otherwise global $post initialization needed before function call
 *
 * @param $taxonomy
 *
 * @return array|WP_Error
 */
function udesly_get_terms( $taxonomy ) {

	$saved_settings = get_option( 'udesly_settings' );

	$settings_count = $saved_settings['count_category_child_elements'];;
	$settings_number = $saved_settings['max_category_elements'];

	global $post;

	$args = array(
		"number" => $settings_number
	);

	$result = array();

	$posts_term = wp_get_post_terms( $post->ID, $taxonomy, $args );

	foreach ( $posts_term as $term ) {

		if ( $settings_count ) {
			$term->name .= ' (' . $term->count . ')';
		}

		$result[] = array(
			"name"        => $term->name,
			"permalink"   => get_term_link( $term->term_id ),
			"description" => $term->description,
			"term_id"     => $term->term_id,
		);
	}

	return $result;
}