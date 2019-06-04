<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 03/04/2018
 * Time: 15:19
 */

namespace UdyWfToWp\Plugins\ContentManager\Models\Query;

class Query_ContentTaxonomy extends Query {

	private $query_meta;

	public function __construct( $query_meta ) {
		$this->query_meta = $query_meta;
	}

	public function find_matching_items( $search_term ){

		$search_term = explode('#', $search_term);

		$data = array();

		switch($this->query_meta){
			case 'name':
				$taxonomies = get_object_taxonomies($search_term[1]);
				foreach ( $taxonomies as $taxonomy ) {
					if(strpos($taxonomy,$search_term[0]) !== false) {
						$data[] = array( 'id' => $taxonomy, 'text' => $taxonomy );
					}
				}
			break;
		}

		return $data;
	}

	public function get_matched_items($items, $key = null){

		$matched_items = array();

		if(!is_null($key) && isset($items[ $key ])) {
			foreach ( $items[ $key ] as $item ) {
				$matched_items[ $item ] = $item;
			}
		}
		return $matched_items;
	}
}