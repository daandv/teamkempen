<?php
/**
 * Created by PhpStorm.
 * User: Pietro Falco
 * Date: 25/01/2018
 * Time: 10:00
 */

namespace UdyWfToWp\Plugins\Rules\Rule;

use UdyWfToWp\Ui\Form;

abstract class Rule implements IRule {

	abstract public function __construct( $condition = '', $values = array() );

	/**
	 * @param $subject
	 * @param $condition
	 * @param $values
	 *
	 * @return Rule | false
	 */
	public static final function factory( $subject, $condition = '', $values = array() ) {

		$class = "\\" . __NAMESPACE__ . "\Rule_" . $subject;

		$class_file = str_replace( '_', '-', $subject );

		if ( ! file_exists( plugin_dir_path( __FILE__ ) . "/class-rule-$class_file.php" ) ) {
			return false;
		}

		return new $class( $condition, $values );

	}

	abstract public function get_key();

	abstract public function get_label();

	abstract public function get_condition();

	abstract public function set_condition( $condition );

	abstract public function set_values( $values );

	public function is_valid_condition( $condition ) {
		return array_key_exists( $condition, $this->get_valid_conditions());
	}

	public static function format_value_for_save( $value ) {
		if(is_array($value)){
			foreach ($value as $key => $arr_value){
				if(!is_int($arr_value)){
					$value[$key] = sanitize_text_field($arr_value);
				}
			}
		}else{
			$value = sanitize_text_field($value);
		}

		return $value;
	}

	abstract public function get_valid_conditions();

	abstract public function get_values();

	public function get_ui( Form $form, $class ) {
		if ( ! empty( $this->get_valid_conditions() ) ) {
			$form->add_select( '', 'rule_conditions[]', '', $this->get_valid_conditions(), $this->get_condition(), '', '', '', $class );
		}
	}

	abstract public function is_matched_by( $post_id );

	public static function is_valid_rule( $condition, $value ){
		return true;
	}

}

interface IRule {
	static function factory( $subject, $condition, $values );

	static function find_matching_items( $query );
}