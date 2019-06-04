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

class Rule_User extends Rule {

	protected $key, $label, $condition, $values;

	public function __construct( $condition = '', $values = array() ) {
		$this->set_condition( $condition );
		$this->set_values( $values );
		$this->key   = 'user';
		$this->label = __('User', i18n::$textdomain);
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
		$data      = array();
		$args      = array(
			'search' => '*' . sanitize_text_field($query) . '*',
			'number' => 5,
		);
		$customers = get_users( $args );
		foreach ( $customers as $customer ) {
			$data[] = array( 'id' => $customer->ID, 'text' => $customer->display_name );
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
			'in'    => __('is', i18n::$textdomain),
			'notin' => __('is not', i18n::$textdomain),
		);
	}

	public function is_matched_by( $post_id ) {
		$user_id = get_current_user_id();
		$condition = $this->get_condition();
		switch ( $condition ) {
			case 'in':
				return in_array( $user_id, $this->get_values() );
				break;
			case 'notin':
				return ! in_array( $user_id, $this->get_values() );
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
		$results = array();
		foreach ($this->get_values() as $key => $value){
			$user = get_userdata( $value );
			if($user) {
				$results[$value] = $user->display_name;
			}
		}
		$form->add_select('','rule_group[]','',$results,'','',false,'','rule_group');
	}
}