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

class Rule_Rcp_Has_Used_Trial extends Rule {

	protected $key, $label, $condition, $values;

	public function __construct( $condition = '', $values = array() ) {
		$this->set_condition( $condition );
		$this->set_values( $values );
		$this->key   = 'rcp_has_used_trial';
		$this->label = __('[RCP] Trial Usage', i18n::$textdomain);
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
			'in'    => __('User used trial', i18n::$textdomain),
			'notin' => __('User has not used trial', i18n::$textdomain),
		);
	}

	public function is_matched_by( $post_id ) {
		$condition = $this->get_condition();
		switch ( $condition ) {
			case 'in':
				return rcp_has_used_trial();
				break;
			case 'notin':
				return ! rcp_has_used_trial();
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
}