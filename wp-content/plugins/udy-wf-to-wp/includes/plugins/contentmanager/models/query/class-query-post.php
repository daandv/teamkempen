<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 03/04/2018
 * Time: 15:19
 */

namespace UdyWfToWp\Plugins\ContentManager\Models\Query;

class Query_Post extends Query {

	private $query_meta;

	public function __construct( $query_meta ) {
		$this->query_meta = $query_meta;
	}

	public function find_matching_items( $search_term ){

		$data = array();

		switch($this->query_meta){
			case 'status':
				$status = array('any','publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash');
				foreach ( $status as $key => $value ) {
					$data[] = array( 'id' => $value, 'text' => $value );
				}
			break;
			case 'type':
				$types = get_post_types(array(
					'publicly_queryable' => true,
					'public'             => true
				));
				foreach ( $types as $key => $value ) {
					$data[] = array( 'id' => $value, 'text' => $value );
				}
			break;
			case 'name':
				$data = array();
				$params = array(
					'posts_per_page' => 5,
					's' => $search_term,
					'orderby'     => 'title',
					'order'       => 'ASC'
				);
				$loop = new \WP_Query( $params );
				if ( $loop->have_posts() ) {
					while ( $loop->have_posts() ) : $loop->the_post();
						$data[] = array('id' => $loop->post->ID, 'text' => '#'. $loop->post->ID .' '.$loop->post->post_title);
					endwhile;
				}
				wp_reset_postdata();
				return $data;
			break;
		}

		return $data;
	}

	public function get_matched_items($items, $key = null){

		$matched_items = array();

		if(!is_null($key) && isset($items[ $key ])) {
			foreach ( $items[ $key ] as $item ) {
				switch($this->query_meta){
					case 'status':
					case 'type':
						$matched_items[ $item ] = $item;
						break;
					case 'name':
						$current_item = get_post( $item );
						$matched_items[ $current_item->ID ] = '#' . $current_item->ID .' '. $current_item->post_title;
						break;
				}
			}
		}
		return $matched_items;
	}
}