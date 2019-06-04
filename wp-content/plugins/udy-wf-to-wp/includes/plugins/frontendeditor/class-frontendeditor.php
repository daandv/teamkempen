<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 28/03/2018
 * Time: 17:39
 */

namespace UdyWfToWp\Plugins\FrontendEditor;

use UdyWfToWp\Core\Udy_Wf_To_Wp_Loader;
use UdyWfToWp\Interfaces\iPlugin;

class FrontendEditor implements iPlugin {
	public static function define_admin_hooks( Udy_Wf_To_Wp_Loader $loader ) {

		$loader->add_action( 'init', FrontendEditor_Configuration::class, 'register_frontend_editor_post_type' );
		$loader->add_action( 'admin_enqueue_scripts', FrontendEditor_Assets::class, 'enqueue_admin_styles' );
		$loader->add_action( 'admin_enqueue_scripts', FrontendEditor_Assets::class, 'enqueue_admin_scripts' );

		$loader->add_action('wp_ajax_delete_frontend_editor_page_elements', FrontendEditor_Assets::class, 'delete_frontend_editor_page_elements');

	}

	public static function define_public_hooks( Udy_Wf_To_Wp_Loader $loader ) {

		$loader->add_action( 'wp_enqueue_scripts', FrontendEditor_Assets::class, 'enqueue_styles' );
		$loader->add_action( 'wp_enqueue_scripts', FrontendEditor_Assets::class, 'enqueue_scripts' );

		$loader->add_action( 'wp_ajax_save_frontend_editor_content_editable', FrontendEditor_Assets::class, 'save_frontend_editor_content_editable'  );
        $loader->add_action( 'wp_ajax_save_content_editable', FrontendEditor_Assets::class, 'save_content_editable');

		$loader->add_action( 'init', FrontendEditor_Shortcodes::class, 'fee_image_shortcode' );

		$loader->add_filter( 'pre_get_posts', FrontendEditor_Configuration::class, 'frontendeditor_search_query');

		$loader->add_action('wp_footer', FrontendEditor_Assets::class, 'enqueue_frontend_editor_scripts');
	}

	public static function activate() {

	}

	public static function deactivate() {

	}

}
