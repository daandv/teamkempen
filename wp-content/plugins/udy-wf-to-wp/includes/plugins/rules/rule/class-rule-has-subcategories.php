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

class Rule_Has_Subcategories extends Rule {

	protected $key, $label, $condition, $values;

	public function __construct( $condition = '', $values = array() ) {
		$this->set_condition( $condition );
		$this->set_values( $values );
		$this->key   = 'has_subcategories';
		$this->label = __('Has Subcategories', i18n::$textdomain);
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
		}else {
			$this->values = $values;
		}
	}

	static function find_matching_items( $query ) {
		return array();
	}

	public function get_key() {
		return $this->key;
	}

	public function get_label() {
		return $this->label;
	}

	public function get_valid_conditions() {
		return array(
			'in'    => __('has subcategories', i18n::$textdomain),
			'notin' => __('doesn\'t have subcategories', i18n::$textdomain),
		);
	}
	public function is_matched_by( $post_id ) {
		$condition = $this->get_condition();
		switch ( $condition ) {
			case 'in':
				return $this->has_subcategories();
				break;
			case 'notin':
				return ! $this->has_subcategories();
				break;
			default:
				return false;
		}
	}

	public function get_condition() {
		return $this->condition;
	}

	public function get_values() {
		return $this->values;
	}

	public function get_ui( Form $form, $class ) {
		parent::get_ui( $form, $class );
	}

	private function has_subcategories(){
		if (is_category()) {

			$childs = get_term_children(get_queried_object_id(), 'category');
			if ( empty($childs) ){
				return false;
			}else{
				return true;
			}
		}
		return false;
	}

}