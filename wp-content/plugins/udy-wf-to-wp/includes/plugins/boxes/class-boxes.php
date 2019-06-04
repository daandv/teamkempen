<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 28/03/2018
 * Time: 17:39
 */

namespace UdyWfToWp\Plugins\Boxes;

use UdyWfToWp\Core\Udy_Wf_To_Wp_Loader;
use UdyWfToWp\Interfaces\iPlugin;
use UdyWfToWp\Utils\Utils;

class Boxes implements iPlugin {
	public static function define_admin_hooks( Udy_Wf_To_Wp_Loader $loader ) {
		//		CONFIGURATION
		$configuration = Boxes_Configuration::getInstance();
		$loader->add_action( 'init', $configuration,'create_box_post_type' );
		$loader->add_action( 'init',  $configuration,'change_post_type_labels' );

		$loader->add_action( 'add_meta_boxes', $configuration, 'boxes_add_meta_boxes' );
		$loader->add_action( 'add_meta_boxes', $configuration, 'pages_add_meta_boxes' );
		$loader->add_action( 'save_post_udesly_box', $configuration, 'udesly_boxes_save_meta_boxes_data' );

		$loader->add_filter( 'manage_'.$configuration->post_type_name.'_posts_columns', $configuration, 'change_columns' );
		$loader->add_action( 'manage_'.$configuration->post_type_name.'_posts_custom_column', $configuration, 'custom_columns', 10, 2 );

		$loader->add_shortcode('udesly-boxes',Boxes_Shortcodes::class,'render_box');
		$loader->add_shortcode('udesly_dynamic_box',Boxes_Shortcodes::class,'udesly_dynamic_box');

		$loader->add_action( 'add_meta_boxes', $configuration, 'add_meta_boxes_dynamic_box' );
		$loader->add_action( 'save_post', $configuration, 'udesly_save_dynamic_box' );
	}

	public static function define_public_hooks( Udy_Wf_To_Wp_Loader $loader ) {

	}

	public static function activate() {

	}

	public static function deactivate() {

	}

}
