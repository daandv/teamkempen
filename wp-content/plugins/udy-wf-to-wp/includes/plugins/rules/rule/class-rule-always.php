<?php
/**
 * Created by PhpStorm.
 * User: Pietro Falco
 * Date: 25/01/2018
 * Time: 10:40
 */

namespace UdyWfToWp\Plugins\Rules\Rule;

use UdyWfToWp\i18n\i18n;
use UdyWfToWp\Ui\Form;

class Rule_Always extends Rule{

	protected $key, $label, $condition, $values;

	public function get_valid_conditions() {
		return array();
	}

	public function get_values() {
		return array();
	}

	public function is_matched_by( $post_id ) {
		return true;
	}

	static function find_matching_items( $query ) {
		return array();
	}

	public function __construct( $condition = '', $values = array() ) {
		$this->set_condition($condition);
		$this->set_values($values);
		$this->key = 'always';
		$this->label = __('Always', i18n::$textdomain);
	}

	public function get_key() {
		return $this->key;
	}

	public function get_label() {
		return $this->label;
	}

	public function get_condition() {
		return $this->condition;
	}

	public function set_condition( $condition ) {
		$this->condition = $condition;
	}

	public function set_values( $values ) {

		if(empty($values)){
			$this->values = array();
		}else {
			$this->values = $values;
		}
	}

	public function is_valid_condition( $condition ) {
		return true;
	}

	public function get_ui( Form $form, $class ) {
		parent::get_ui($form, $class);
	}

}