<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 28/03/2018
 * Time: 17:39
 */

namespace UdyWfToWp\Plugins\CustomTypes;

use UdyWfToWp\Core\Udy_Wf_To_Wp_Loader;
use UdyWfToWp\Interfaces\iPlugin;
use UdyWfToWp\Utils\Utils;

class CustomTypes implements iPlugin {
	public static function define_admin_hooks( Udy_Wf_To_Wp_Loader $loader ) {
		//		CONFIGURATION
		$configuration = CustomTypes_Configuration::getInstance();
		$loader->add_action( 'init', $configuration,'create_custom_type_post_type' );
		$loader->add_action( 'init', $configuration,'init_all_post_types' );
		$loader->add_action( 'init',  $configuration,'change_post_type_labels' );
		$loader->add_action( 'admin_init',  $configuration,'rewrite_custom_taxonomies' );

		$loader->add_filter( 'manage_'.$configuration->post_type_name.'_posts_columns', $configuration, 'change_columns' );
		$loader->add_action( 'manage_'.$configuration->post_type_name.'_posts_custom_column', $configuration, 'custom_columns', 10, 2 );

		$loader->add_action('add_meta_boxes_' . $configuration->post_type_name, $configuration,'add_cpt_meta_box');
		$loader->add_action('save_post_'.$configuration->post_type_name, $configuration, 'save_meta_box', 10, 3);
		$loader->add_filter( 'excerpt_length', $configuration, 'apply_excerpt_length', 100 );
		$loader->add_filter( 'excerpt_more', $configuration, 'apply_excerpt_more', 100 );
		$loader->add_action('pre_get_posts', $configuration, 'custom_posts_per_page', 999);

		$loader->add_action( 'admin_bar_menu', $configuration, 'add_cpt_menu_nodes', 999 );
	}

	public static function define_public_hooks( Udy_Wf_To_Wp_Loader $loader ) {
		$configuration = CustomTypes_Configuration::getInstance();
		$loader->add_filter( 'template_include', $configuration, 'cpt_taxonomy_archive', 98 );
		//$loader->add_filter( 'template_include', $configuration, 'cpt_single_page', 99 );
	}

	public static function activate() {

	}

	public static function deactivate() {

	}

}
