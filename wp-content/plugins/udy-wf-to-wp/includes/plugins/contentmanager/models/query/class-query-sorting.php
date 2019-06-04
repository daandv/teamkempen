<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 03/04/2018
 * Time: 15:19
 */

namespace UdyWfToWp\Plugins\ContentManager\Models\Query;

class Query_Sorting extends Query {

	private $query_meta;

	public function __construct( $query_meta ) {
		$this->query_meta = $query_meta;
	}

	public function find_matching_items( $search_term ){

		$data = array();

		switch($this->query_meta){
			case 'orderby':
				$status = array(
					"ID",
                    "author",
                    "comment_count",
                    "date" ,
                    "menu_order",
                    "meta_value",
                    "meta_value_num",
                    "modified",
                    "name",
                    "none",
                    "parent",
                    "post__in",
                    "rand",
                    "title",
                    "type",
				);
				foreach ( $status as $key => $value ) {
					$data[] = array( 'id' => $value, 'text' => $value );
				}
			break;
			case 'orderby_term':
				$status = array(
					"id",
					"slug",
					"name",
					"description",
					"term_group",
					"count",
					"none",
				);
				foreach ( $status as $key => $value ) {
					$data[] = array( 'id' => $value, 'text' => $value );
				}
			break;
			case 'order':
				$status = array(
					"desc",
                    "asc",
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