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

class Rule_Is_Category extends Rule {

	protected $key, $label, $condition, $values;

	public function __construct( $condition = '', $values = array() ) {
		$this->set_condition( $condition );
		$this->set_values( $values );
		$this->key   = 'is_category';
		$this->label = __( 'Category', i18n::$textdomain );
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
		$categories = get_categories();
		foreach ( $categories as $category ) {
			if ( strpos( strtolower($category->name), strtolower(sanitize_text_field($query)) ) !== false ) {
				$data[] = array( 'id' => $category->term_id, 'text' => $category->name );
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
			'in'    => __( 'is category', i18n::$textdomain ),
			'notin' => __( 'is not category', i18n::$textdomain ),
			'any' => __('Any', i18n::$textdomain ),
			'none' => __('None', i18n::$textdomain )
		);
	}

	public function is_matched_by( $post_id ) {
		$condition  = $this->get_condition();
		$categories = $this->get_values();
		switch ( $condition ) {
			case 'in':
				return is_category( $categories );
				break;
			case 'notin':
				return ! is_category( $categories );
				break;
			case 'any':
				return is_category();
				break;
			case 'none':
				return !is_category();
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
			$cat = get_category($value);
			if($cat) {
				$results[ $value ] = $cat->name;
			}
		}
		$form->add_select( '', 'rule_group[]', '', $results, '', '', false, '', 'rule_group' );
	}
}