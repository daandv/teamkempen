<?php
/**
 * Created by PhpStorm.
 * User: Pietro Falco
 * Date: 25/01/2018
 * Time: 12:31
 */

namespace UdyWfToWp\Plugins\Rules\Rule;

use UdyWfToWp\i18n\i18n;
use UdyWfToWp\Ui\Form;

class Rule_Woo_Products extends Rule {

	protected $key, $label, $condition, $values;

	public function __construct( $condition = '', $values = array() ) {
		$this->set_condition( $condition );
		$this->set_values( $values );
		$this->key   = 'woo_products';
		$this->label = __( '[WOO] Products', i18n::$textdomain );
	}

	public function set_condition( $condition ) {
		if ( empty( $condition ) || ! $this->is_valid_condition( $condition ) ) {
			$this->condition = 'in';
		} else {
			$this->condition = $condition;
		}
	}

	public function set_values( $values ) {
		if ( empty( $values ) ) {
			$this->values = array();
		} else {
			$this->values = $values;
		}
	}

	static function find_matching_items( $query ) {
		$data = array();

		global $wpdb;
		$loop = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type = 'product' AND post_title LIKE '%s'", '%'. $wpdb->esc_like( $query ) .'%') );

		if ( !empty($loop) ) {
			foreach ($loop as $product) {
				$data[] = array('id' => $product->ID, 'text' => '#'. $product->ID .' '.$product->post_title);
			}
		}
		return $data;
	}

	public function get_key() {
		return $this->key;
	}

	public function get_label() {
		return $this->label;
	}

	public function get_valid_conditions() {
		return array(
			'in'    => __( 'is', i18n::$textdomain ),
			'notin' => __( 'is not', i18n::$textdomain ),
		);
	}

	public function is_matched_by( $product_id ) {
		
		$product = wc_get_product ( $product_id );
		if( null == $product ) return false;

		$condition = $this->get_condition();
		$values = $this->get_values();
		if(empty($values)) return false;
		switch ($condition){
			case 'in':
				return $this->is_in_values( $product_id, $values );
				break;
			case 'notin':
				return !$this->is_in_values( $product_id, $values );
				break;
			default:
				return false;
		}
	}

	private function is_in_values($id, $values){
		return in_array($id, $values);
	}

	public function get_condition() {
		return $this->condition;
	}

	public function get_values() {
		return $this->values;
	}

	public function get_ui( Form $form, $class ) {
		parent::get_ui( $form, $class );
		$results = array();
		foreach ($this->get_values() as $key => $value){
			$product = wc_get_product( $value );
			if($product) {
				$results[$value] = '#'. $value .' '.$product->get_title();
			}
		}
		$form->add_select( '', 'rule_group[]', '', $results, '', '', false, '', 'rule_group' );
	}
}