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

class Rule_Is_Tag extends Rule {

	protected $key, $label, $condition, $values;

	public function __construct( $condition = '', $values = array() ) {
		$this->set_condition( $condition );
		$this->set_values( $values );
		$this->key   = 'is_tag';
		$this->label = __( 'Tag', i18n::$textdomain );
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
		$tags = get_tags();
		foreach ( $tags as $tag ) {
			if ( strpos( strtolower($tag->name), strtolower(sanitize_text_field($query)) ) !== false ) {
				$data[] = array( 'id' => $tag->term_id, 'text' => $tag->name );
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
			'in'    => __( 'is tag', i18n::$textdomain ),
			'notin' => __( 'is not tag', i18n::$textdomain ),
			'any' => __('Any', i18n::$textdomain ),
			'none' => __('None', i18n::$textdomain )
		);
	}

	public function is_matched_by( $post_id ) {
		$condition  = $this->get_condition();
		$tags = $this->get_values();
		switch ( $condition ) {
			case 'in':
				return is_tag( $tags );
				break;
			case 'notin':
				return ! is_tag( $tags );
				break;
			case 'any':
				return is_tag();
				break;
			case 'none':
				return !is_tag();
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
			$tag = get_tag($value);
			if($tag){
				$results[$value] = $tag->name;
			}

		}
		$form->add_select( '', 'rule_group[]', '', $results, '', '', false, '', 'rule_group' );
	}
}