<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 03/04/2018
 * Time: 15:19
 */

namespace UdyWfToWp\Plugins\ContentManager\Models\Query;

class Query_Post_Meta extends Query {

	private $query_meta;

	public function __construct( $query_meta ) {
		$this->query_meta = $query_meta;
	}

	public function find_matching_items( $search_term ){

		$data = array();

		switch($this->query_meta){
			case 'compare':
				$status = array(
					"=",
                    "!=",
                    ">",
                    ">=",
                    "<",
                    "<=",
                    "LIKE",
                    "NOT LIKE",
                    "IN",
                    "NOT IN",
                    "BETWEEN",
                    "NOT BETWEEN",
                    "NOT EXISTS",
                    "REGEXP",
                    "NOT REGEXP",
                    "RLIKE",
				);
				foreach ( $status as $key => $value ) {
					$data[] = array( 'id' => $value, 'text' => $value );
				}
			break;
		}

		return $data;
	}

	public function get_matched_items($items, $key = null){
		return array();
	}
}