<?php
/**
 * Created by PhpStorm.
 * User: Pietro Falco
 * Date: 30/01/2018
 * Time: 10:40
 */

namespace UdyWfToWp\Plugins\Rules\Rule;


use UdyWfToWp\i18n\i18n;
use UdyWfToWp\Plugins\Rules\Rules_Configuration;
use UdyWfToWp\Ui\Form;

class Rule_Controller {

	private $id;
	private $args;
	private $form;
	private $meta_key;
	private $db_rules;

	public function __construct( $id, $meta_key, Form $form, $args = array() ) {

		$this->id       = $id;
		$this->meta_key = $meta_key;

		$defaults = array(
			'class'    => '',
			'subjects' => array(),
		);

		$this->args = wp_parse_args( $args, $defaults );

		$this->form = $form;

		$this->db_rules = get_post_meta( $id, $meta_key, true );

	}

	public static function save_rules( $post_id, $meta_key, $rules ) {

		if ( ! array_key_exists( 'rule_subject', $rules ) || ! array_key_exists( 'rule_conditions', $rules ) || ! array_key_exists( 'rule_group', $rules ) || ! array_key_exists( 'rule_group_logic_operator', $rules ) ) {
			return new \WP_Error( 'bad_rules_format', __( 'Invalid Rules', i18n::$textdomain ) );
		}

		if(!$rules['rule_subject'][0] == 'always' && ( count( $rules['rule_subject'] ) != count( $rules['rule_group'] ) )){
			return new \WP_Error( 'bad_rules_format', __( 'Invalid Rules', i18n::$textdomain ) );
		}

		$count_rules = count( $rules['rule_subject'] );
		for ( $i = 0; $i < $count_rules; $i ++ ) {
			$rule = Rule::factory( $rules['rule_subject'][ $i ],'','');
			if ( $rule !== false ) {
				$result = $rule::is_valid_rule( $rules['rule_conditions'][ $i ],$rules['rule_group'][ $i ]);
				if(is_wp_error($result)){
					return $result;
				}
				$rules['rule_group'][ $i ] = $rule::format_value_for_save($rules['rule_group'][ $i ]);
			}
		}
		// sanitize is done in $rule::format_value_for_save()
		return update_post_meta($post_id, $meta_key, $rules);

	}

	/**
	 * @param $subject_id post ID checked against the specific rules set
	 * @param $rule_id
	 *
	 * @return bool|mixed
	 */
	public static function is_matched_by( $subject_id, $rule_id ) {

		if(is_numeric($rule_id)){
			$post = get_post($rule_id);
		}else {
			$post = udesly_get_post_by_slug( $rule_id, 'OBJECT', Rules_Configuration::$post_type_name );
		}

		if(is_null($post))
			return false;

		$db_rules = get_post_meta( $post->ID, Rules_Configuration::$post_type_name.'_meta_key', true );

		$count_rules = count( $db_rules['rule_subject'] );

		$results = array();

		for ( $i = 0; $i < $count_rules; $i ++ ) {
			$rule = Rule::factory( $db_rules['rule_subject'][ $i ], $db_rules['rule_conditions'][ $i ], $db_rules['rule_group'][ $i ] );
			if ( $rule !== false ) {
				$results[] = $rule->is_matched_by( $subject_id );
			}
		}

		$condition_logics = $db_rules['rule_group_logic_operator'];

		if(isset($results[0])) {
			$final_result = $results[0];
		}else{
			return false;
		}

		for( $i = 1; $i< count($results); $i++ ){
			switch ($condition_logics[$i]){
				case 'and':
					$final_result = $final_result && $results[$i];
					break;
				case 'or':
					$final_result = $final_result || $results[$i];
					break;
			}


		}

		return $final_result;

	}

	public function create_rules_form() {

		$default_subjects = $this->args['subjects'];

		$default_select = array();
		foreach ( $default_subjects as $subject ) {
			$rule = Rule::factory( $subject );
			if ( $rule !== false ) {
				$default_select[$rule->get_key()] = $rule->get_label();
			}
		}
		if ( empty( $this->db_rules ) ) {
			$this->form->add_title( __( 'Apply this rules:', i18n::$textdomain ), 'small' );
			$this->form->add_select( 'rule_subject', 'rule_subject[]', '', $default_select, '', '', '', true, $this->args['class'] );
			return $this->form->get_form();
		} else {
			$final_form = '';
			$count_rules = count( $this->db_rules['rule_subject'] );
			for ( $i = 0; $i < $count_rules; $i++ ) {
				$form_rule = new Form();

				if ( isset( $this->db_rules['rule_group_logic_operator'][ $i ] ) && $this->db_rules['rule_group_logic_operator'][ $i ] == 'and' ) {
					$form_rule->add_title( __( 'AND', i18n::$textdomain ), 'small' );
				} elseif ( isset( $this->db_rules['rule_group_logic_operator'][ $i ] ) && $this->db_rules['rule_group_logic_operator'][ $i ] == 'or' ) {
					$form_rule->add_title( __( 'OR', i18n::$textdomain ), 'small' );
				}else{
					$form_rule->add_title( __( 'Apply this rules:', i18n::$textdomain ), 'small' );
				}

				$form_rule->add_select( 'rule_subject', 'rule_subject[]', '', $default_select, $this->db_rules['rule_subject'][ $i ], '', '', true, $this->args['class'] );
				$form_rule->add_hidden( 'rule_group_logic_operator', 'rule_group_logic_operator[]', isset( $this->db_rules['rule_group_logic_operator'][ $i ] ) ? $this->db_rules['rule_group_logic_operator'][ $i ] : '', 'rule_group_logic_operator' );

				$rule = Rule::factory( $this->db_rules['rule_subject'][ $i ], $this->db_rules['rule_conditions'][ $i ], $this->db_rules['rule_group'][ $i ] );
				if ( $rule !== false ) {
					$rule->get_ui( $form_rule, $this->args['class'] );
				}

				$form_rule->add_button('','AND','rule_group_btn add_and_rule_group', 'button');
				$form_rule->add_button('','OR','rule_group_btn add_or_rule_group', 'button');
				$form_rule->add_button('','Remove','rule_group_btn remove_rule_group', 'button');

				$final_form .= $form_rule->get_form();
			}
			return $final_form;
		}


	}

	public static function udesly_load_rule_conditions(){

		$rule = Rule::factory($_POST['subject']);

		//verify if rule not exists
		if(!$rule || 'always' == $_POST['subject']) {
			echo '';
			wp_die();
		}

		$select_conditions = new Form( false );
		$select_conditions->add_hidden('','rule_group_logic_operator[]','','rule_group_logic_operator');
		$rule->get_ui($select_conditions,'');
		$select_conditions->add_button('','AND','rule_group_btn add_and_rule_group', 'button');
		$select_conditions->add_button('','OR','rule_group_btn add_or_rule_group', 'button');
		$select_conditions->add_button('','Remove','rule_group_btn remove_rule_group', 'button');
		$select_conditions->get_form(true);
		wp_die();
	}

	public static function udesly_search_in_rule_group(){
		$search_term = $_GET['q'];
		$subject = $_GET['subject'];

		$rule = Rule::factory($subject);

		if(!$rule) {
			echo '';
			wp_die();
		}
		$data = $rule::find_matching_items($search_term);

		echo json_encode($data);
		wp_die();
	}

}
