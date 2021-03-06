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

class Rule_Is_Post_Type_Archive extends Rule {

	protected $key, $label, $condition, $values;

	public function __construct( $condition = '', $values = array() ) {
		$this->set_condition( $condition );
		$this->set_values( $values );
		$this->key   = 'is_post_type_archive';
		$this->label = __( 'Post Type Archive', i18n::$textdomain );
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
		$post_types = get_post_types( array( 'public' => true ) );
		foreach ( $post_types as $post_type ) {
			$type_obj = get_post_type_object( $post_type );
			if ( $type_obj->has_archive && strpos( $type_obj->name, strtolower( sanitize_text_field($query) ) ) !== false ) {
				$data[] = array( 'id' => $post_type, 'text' => $post_type );
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
			'in'    => __( 'is post type archive page', i18n::$textdomain ),
			'notin' => __( 'is not post type  archive page', i18n::$textdomain ),
		);
	}

	public function is_matched_by( $post_id ) {
		$condition  = $this->get_condition();
		$post_types = $this->get_values();
		switch ( $condition ) {
			case 'in':
				return is_post_type_archive( $post_types );
				break;
			case 'notin':
				return ! is_post_type_archive( $post_types );
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
		foreach ($this->get_values() as $value){
			$results[$value] = $value;
		}
		$form->add_select( '', 'rule_group[]', '', $results, '', '', false, '', 'rule_group' );
	}
}