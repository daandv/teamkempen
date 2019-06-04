<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 04/04/2018
 * Time: 11:27
 */

namespace UdyWfToWp\Plugins\Rules;

use UdyWfToWp\i18n\i18n;
use UdyWfToWp\Plugins\Rules\Rule\Rule_Controller;

class Rules_Manager{

	public static function save_udesly_rules($post_id, $post, $update){

		if ( ! empty( $_POST ) ) {
			//avoid the post autosave
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}

			if(isset($_POST['rule_subject'][0]) && $_POST['rule_subject'][0] == 'always') {
				$udesly_sales_rules = array(
					'rule_subject'              => array('always'),
					'rule_conditions'           => null,
					'rule_group'                => null,
					'rule_group_logic_operator' => null,
				);
			}else{
				unset( $_POST['rule_group_logic_operator'][0] );
				$udesly_sales_rules = array(
					'rule_subject'              => $_POST['rule_subject'],
					'rule_conditions'           => $_POST['rule_conditions'],
					'rule_group'                => $_POST['rule_group'],
					'rule_group_logic_operator' => $_POST['rule_group_logic_operator'],
				);
			}

			Rule_Controller::save_rules($post_id,Rules_Configuration::$post_type_name.'_meta_key',$udesly_sales_rules);

			delete_transient('udesly_exported_data');
		}
	}

	public static function save_udesly_rules_redirect($post_id, $post, $update){
		if ( ! empty( $_POST ) ) {
			//avoid the post autosave
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}

			if(isset($_POST['udesly_rule_redirect']) && isset($_POST['udesly_rule_redirect_url'])){
				update_post_meta($post_id,'udesly_rule_redirect_options',array(
					'udesly_rule_redirect' => sanitize_key($_POST['udesly_rule_redirect']),
					'udesly_rule_redirect_url' => esc_url_raw($_POST['udesly_rule_redirect_url'])
				));
			}

		}
	}

	public static function check_rule_redirect($post_id){
		$saved_redirect = get_post_meta($post_id,'udesly_rule_redirect_options',true);
		if(isset($saved_redirect['udesly_rule_redirect']) && $saved_redirect['udesly_rule_redirect'] != 0 && udesly_eval_rule($saved_redirect['udesly_rule_redirect'],$post_id)){
			if(empty($saved_redirect['udesly_rule_redirect_url'])){
				wp_redirect(get_site_url());
				exit;
			}else {
				wp_redirect( $saved_redirect['udesly_rule_redirect_url'] );
				exit;
			}
		}
	}

	public static function change_columns($cols){
		$cols = array(
			'cb'              => '<input type="checkbox" />',
			'title'           => __( 'Title', i18n::$textdomain ),
			'slug'            => __( 'Slug', i18n::$textdomain ),
		);

		return $cols;
	}

	public static function custom_columns($column, $post_id){

		$rule = get_post($post_id);

		switch ( $column ) {
			case "slug":
				echo '<input class="click-to-select" type="text" readonly value="'.$rule->post_name.'" />';
				break;
		}
	}

	public static function get_udesly_saved_rules(){
		return get_posts(array(
			'posts_per_page'   => -1,
			'post_type'        => Rules_Configuration::$post_type_name
		));
	}

	public static function redirect_on_rule_satisfied($template){
		//TODO: non funziona se mi trovo in una pagina archivio (categorie, archivio articoli, ecc.)
		if(is_page() || is_singular('product') || is_singular('post')) {
			global $post;
			self::check_rule_redirect($post->ID);
		}
	}

}