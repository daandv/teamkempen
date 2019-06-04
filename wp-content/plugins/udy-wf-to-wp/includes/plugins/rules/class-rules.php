<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 28/03/2018
 * Time: 17:39
 */

namespace UdyWfToWp\Plugins\Rules;

use UdyWfToWp\Core\Udy_Wf_To_Wp_Loader;
use UdyWfToWp\Interfaces\iPlugin;
use UdyWfToWp\Plugins\Rules\Rule\Rule_Controller;

class Rules implements iPlugin {
	public static function define_admin_hooks( Udy_Wf_To_Wp_Loader $loader ) {
		//		CONFIGURATION
		$configuration = Rules_Configuration::getInstance();
		$loader->add_action( 'init', $configuration,'create_rules_post_type' );
		$loader->add_action( 'add_meta_boxes', $configuration, 'rules_add_meta_boxes' );

		$loader->add_action('wp_ajax_udesly_load_rule_conditions', Rule_Controller::class, 'udesly_load_rule_conditions');
		$loader->add_action('wp_ajax_udesly_search_in_rule_group', Rule_Controller::class, 'udesly_search_in_rule_group');

		$loader->add_action('save_post_'.$configuration::$post_type_name, Rules_Manager::class, 'save_udesly_rules', 10, 3);
		$loader->add_action('save_post', Rules_Manager::class, 'save_udesly_rules_redirect', 10, 3);
		$loader->add_filter( 'manage_'.$configuration::$post_type_name.'_posts_columns', Rules_Manager::class, 'change_columns' );
		$loader->add_action( 'manage_'.$configuration::$post_type_name.'_posts_custom_column', Rules_Manager::class, 'custom_columns', 10, 2 );
	}

	public static function define_public_hooks( Udy_Wf_To_Wp_Loader $loader ) {
		$loader->add_action('template_redirect', Rules_Manager::class, 'redirect_on_rule_satisfied', 99);
	}

	public static function activate() {

	}

	public static function deactivate() {

	}

}
