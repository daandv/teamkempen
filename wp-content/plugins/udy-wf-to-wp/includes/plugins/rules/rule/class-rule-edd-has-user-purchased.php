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

class Rule_Edd_Has_User_Purchased extends Rule {

	protected $key, $label, $condition, $values;

	public function __construct( $condition = '', $values = array() ) {
		$this->set_condition( $condition );
		$this->set_values( $values );
		$this->key   = 'edd_has_user_purchased';
		$this->label = __('[EDD] Download purchase', i18n::$textdomain);
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
		$params = array(
			'posts_per_page' => 5,
			'post_type' => 'download',
			's' => sanitize_text_field($query),
			'post_status' => 'publish',
			'orderby'     => 'title',
			'order'       => 'ASC'
		);
		$loop = new \WP_Query( $params );
		if ( $loop->have_posts() ) {
			while ( $loop->have_posts() ) : $loop->the_post();
				$data[] = array('id' => $loop->post->ID, 'text' => '#'. $loop->post->ID .' '.$loop->post->post_title);
			endwhile;
		}
		wp_reset_postdata();
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
			'in'    => __('has user purchased', i18n::$textdomain),
			'notin' => __('has not user purchased', i18n::$textdomain),
		);
	}

	public function is_matched_by( $post_id ) {
		$condition = $this->get_condition();

		$value = $this->get_values();
		if(empty($value)) return false;

		switch ( $condition ) {
			case 'in':
				return edd_has_user_purchased(get_current_user_id(), $value);
				break;
			case 'notin':
				return ! edd_has_user_purchased(get_current_user_id(), $value);
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
		parent::get_ui($form, $class);
		$results = array();
		$download = edd_get_download($this->get_values());
		$results[$this->get_values()] = '#' . $download->ID . ' ' . $download->post_title;
		$form->add_select('','rule_group[]','',$results,'','',false,'','rule_group');
	}
}