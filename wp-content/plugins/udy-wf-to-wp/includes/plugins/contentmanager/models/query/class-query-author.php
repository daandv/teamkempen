<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 03/04/2018
 * Time: 15:19
 */

namespace UdyWfToWp\Plugins\ContentManager\Models\Query;

class Query_Author extends Query {

	private $query_meta;

	public function __construct( $query_meta ) {
		$this->query_meta = $query_meta;
	}

	public function find_matching_items( $search_term ){

		$data = array();

		switch($this->query_meta){
			case 'name':
				$args      = array(
					'search' => '*' . $search_term . '*',
					'number' => 5,
				);
				$authors = get_users( $args );
				foreach ( $authors as $author ) {
					$data[] = array( 'id' => $author->ID, 'text' => $author->display_name . ' ['. $author->ID .']' );
				}
			break;
		}

		return $data;
	}

	public function get_matched_items($items, $key = null){
		$matched_items = array();
		if(!is_null($key) && isset($items[ $key ])) {
			foreach ( $items[ $key ] as $item ) {
				$current_item                       = get_user_by( 'ID', $item );
				$matched_items[ $current_item->ID ] = $current_item->display_name . ' [' . $current_item->ID . ']';
			}
		}
		return $matched_items;
	}
}