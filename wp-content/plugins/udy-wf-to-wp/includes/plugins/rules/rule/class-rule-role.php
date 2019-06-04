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

class Rule_Role extends Rule {

	protected $key, $label, $condition, $values;

	public function __construct( $condition = '', $values = array() ) {
		$this->set_condition( $condition );
		$this->set_values( $values );
		$this->key   = 'role';
		$this->label = __('User Role', i18n::$textdomain);
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
		$data = array();
		global $wp_roles;
		foreach ( $wp_roles->roles as $key => $value ) {
			$data[] = array( 'id' => $key, 'text' => $value['name'] );
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
			'in'    => __('is',i18n::$textdomain),
			'notin' => __('is not',i18n::$textdomain),
		);
	}

	public function is_matched_by( $post_id ) {
		$user_id = get_current_user_id();

		if( $user_id == 0 ) {
			$user_roles = array();
		}else {
			$user_meta  = get_userdata( $user_id );
			$user_roles = $user_meta->roles;
		}

		$condition = $this->get_condition();
		switch ( $condition ) {
			case 'in':
				return $this->is_in_role( $user_roles );
				break;
			case 'notin':
				return ! $this->is_in_role( $user_roles );
				break;
			default:
				return false;
		}
	}

	public function get_condition() {
		return $this->condition;
	}

	private function is_in_role( $user_roles ) {

		if(empty($user_roles))
			return false;

		$valid_roles = $this->get_values();
		foreach ( $user_roles as $user_role ) {
			if ( in_array( $user_role, $valid_roles ) ) {
				return true;
			}
		}

		return false;
	}

	public function get_values() {
		return $this->values;
	}

	public function get_ui( Form $form, $class ) {
		parent::get_ui( $form, $class );
		global $wp_roles;
		$results = array();
		foreach ($this->get_values() as $key => $value){
			$role = $wp_roles->roles[$value];
			if($role) {
				$results[$value] = $role['name'];
			}
		}
		$form->add_select('','rule_group[]','',$results,'','',false,'','rule_group');
	}
}