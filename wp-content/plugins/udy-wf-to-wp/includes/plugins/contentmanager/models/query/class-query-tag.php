<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 03/04/2018
 * Time: 15:19
 */

namespace UdyWfToWp\Plugins\ContentManager\Models\Query;

class Query_Tag extends Query {

	private $query_meta;

	public function __construct( $query_meta ) {
		$this->query_meta = $query_meta;
	}

	public function find_matching_items( $search_term ){

		$data = array();

		switch($this->query_meta){
			case 'name':
				$args      = array(
					'search' => $search_term,
					'number' => 5,
				);
				$tags = get_terms( array('post_tag'), $args );
				foreach ( $tags as $tag ) {
					$data[] = array( 'id' => $tag->term_id, 'text' => $tag->name . ' ['. $tag->term_id .']' );
				}
			break;
		}

		return $data;
	}

	public function get_matched_items($items, $key = null){

		$matched_items = array();
		if(!is_null($key) && isset($items[ $key ])) {
			foreach ( $items[ $key ] as $item ) {
				$current_item                       = get_term_by('id', $item, 'post_tag');
				$matched_items[ $current_item->term_id ] = $current_item->name . ' [' . $current_item->term_id . ']';
			}
		}
		return $matched_items;
	}
}