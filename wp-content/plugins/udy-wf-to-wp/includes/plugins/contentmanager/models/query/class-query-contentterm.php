<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 03/04/2018
 * Time: 15:19
 */

namespace UdyWfToWp\Plugins\ContentManager\Models\Query;

class Query_ContentTerm extends Query {

	private $query_meta;

	public function __construct( $query_meta ) {
		$this->query_meta = $query_meta;
	}

	public function find_matching_items( $search_term ){

		$search_term = explode('#', $search_term);

		$data = array();

		switch($this->query_meta){
			case 'name':
				$terms = get_terms( array(
					'search' => $search_term[0],
					'taxonomy' => $search_term[1],
				) );
				foreach ( $terms as $term ) {
					$data[] = array( 'id' => $term->term_id, 'text' => $term->name . ' ['. $term->term_id .']' );
				}
			break;
		}

		return $data;
	}

	public function get_matched_items($items, $key = null){

		$matched_items = array();

		if(!is_null($key) && isset($items[ $key ])) {
			foreach ( $items[ $key ] as $item ) {
				$current_item                       = get_term_by( 'id', $item, 'product_cat' );
				$matched_items[ $current_item->term_id ] = $current_item->name . ' [' . $current_item->term_id . ']';
			}
		}
		return $matched_items;
	}

	/**
	 * Get ther without khowing it's taxonomy. Not very nice, though.
	 */
	private function &get_term_by_id($term, $output = OBJECT, $filter = 'raw') {
		global $wpdb;
		$null = null;

		if ( empty($term) ) {
			$error = new WP_Error('invalid_term', __('Empty Term'));
			return $error;
		}

		$_tax = $wpdb->get_row( $wpdb->prepare( "SELECT t.* FROM $wpdb->term_taxonomy AS t WHERE t.term_id = %s LIMIT 1", $term) );
		$taxonomy = $_tax->taxonomy;

		return get_term($term, $taxonomy, $output, $filter);

	}
}