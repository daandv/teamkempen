<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 05/04/2018
 * Time: 14:58
 */

namespace UdyWfToWp\Plugins\ContentManager;

use UdyWfToWp\Plugins\ContentManager\Models\Query\Query;
use UdyWfToWp\Utils\Utils;

class ContentManager_Assets{
	public static $assets_folder_url = UDY_WF_TO_WP_PLUGIN_DIRECTORY_URL . 'includes/plugins/contentmanager/assets';

	public static function load_scripts(){
		wp_enqueue_script( 'select2-query-builder', self::$assets_folder_url . '/js/select2-query-builder.js', array(), Utils::getPluginVersion(), true );
		wp_enqueue_script( 'udesly-pages-sync', self::$assets_folder_url . '/js/udesly-pages-sync.js', array(), Utils::getPluginVersion(), true );

		wp_localize_script( 'select2-query-builder', 'ajax_login_object', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'pages_sync_nonce' => wp_create_nonce( "pages_sync" ),
			'delete_all_pages_nonce' => wp_create_nonce( "delete_all_pages" ),
			'delete_all_fe_elements_nonce' => wp_create_nonce( "delete_all_fe_elements" ),
			'clean_all_fe_elements_nonce' => wp_create_nonce( "clean_all_fe_elements" ),
		));
	}

	public static function load_styles(){
		wp_enqueue_style('contentmanager-style',self::$assets_folder_url . '/css/contentmanager.css','',Utils::getPluginVersion());
	}

	public static function public_load_styles(){
		wp_enqueue_style('contentmanager-wp-editor',self::$assets_folder_url . '/css/wpeditor.css','',Utils::getPluginVersion());
	}

	public static function select2_search(){
		$search_term = $_GET['q'];
		$subject = $_GET['subject'];
		$query_meta = $_GET['query_meta'];

		$query = Query::factory($subject, $query_meta);

		if(!$query) {
			echo '';
			wp_die();
		}

		$data = $query->find_matching_items($search_term);

		echo json_encode($data);
		wp_die();
	}

	public static function pages_sync(){
		check_ajax_referer( 'pages_sync', 'pages_sync_nonce' );

		$result = Utils::syncWebflowToWordpressPages();
		if(is_wp_error($result)){
			echo wp_json_encode($result->get_error_code());
		}else{
			Utils::flushPermalink();
			echo wp_json_encode($result);
		}
		wp_die(); // this is required to terminate immediately and return a proper response
	}

	public static function delete_all_pages(){

		check_ajax_referer( 'delete_all_pages', 'delete_all_pages_nonce' );

		$result = Utils::deleteAllImportedWordpressPages();
		if(is_wp_error($result)){
			echo wp_json_encode($result->get_error_code());
		}else{
			echo wp_json_encode($result);
		}
		wp_die(); // this is required to terminate immediately and return a proper response
	}

	public static function delete_all_fe_elements(){

		check_ajax_referer( 'delete_all_fe_elements', 'delete_all_fe_elements_nonce' );

		$result = Utils::deleteAllFrontendEditorElements();
		if(is_wp_error($result)){
			echo wp_json_encode($result->get_error_code());
		}else{
			echo wp_json_encode($result);
		}
		wp_die(); // this is required to terminate immediately and return a proper response
	}

	public static function clean_all_fe_elements(){

		check_ajax_referer( 'clean_all_fe_elements', 'clean_all_fe_elements_nonce' );

		$result = Utils::cleanAllFrontendEditorElements();
		if(is_wp_error($result)){
			echo wp_json_encode($result->get_error_code());
		}else{
			echo wp_json_encode($result);
		}
		wp_die(); // this is required to terminate immediately and return a proper response
	}
}