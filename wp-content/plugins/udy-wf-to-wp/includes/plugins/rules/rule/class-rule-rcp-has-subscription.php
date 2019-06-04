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

class Rule_Rcp_Has_Subscription extends Rule {

	protected $key, $label, $condition, $values;

	public function __construct( $condition = '', $values = array() ) {
		$this->set_condition( $condition );
		$this->set_values( $values );
		$this->key   = 'rcp_has_subscription';
		$this->label = __( '[RCP] Has Subscription', i18n::$textdomain );
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
		$data       = array();
		$levels_db = new \RCP_Levels();
		$levels    = $levels_db->get_levels( array( 'status' => 'active' ) );
		foreach ($levels as $level){
			$data[] = array('id'=> $level->id, 'text' => $level->name);
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
			'in'    => __( 'User has subscription', i18n::$textdomain ),
			'notin' => __( 'User doesn\'t have subscription', i18n::$textdomain ),
		);
	}

	public function is_matched_by( $post_id ) {
		$condition  = $this->get_condition();
		$subscription_id = $this->get_values()[0];
		switch ( $condition ) {
			case 'in':
				return $this->user_has_subscription( $subscription_id );
				break;
			case 'notin':
				return !$this->user_has_subscription( $subscription_id );
				break;
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
		$subscription = $this->get_values()[0];
		$levels = new \RCP_Levels();
		$level  = $levels->get_level( $subscription );
		$results[ $subscription ] = $level->name;
		$form->add_select( '', 'rule_group[]', '', $results, '', '', false, '', 'rule_group' );
	}

	private function user_has_subscription( $subscription_id ) {
		$user_subscription_id = rcp_get_subscription_id( get_current_user_id() );
		if( $user_subscription_id == $subscription_id ){
			return true;
		}else{
			return false;
		}
	}
}