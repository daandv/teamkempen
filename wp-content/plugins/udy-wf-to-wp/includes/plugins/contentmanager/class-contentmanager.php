<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 28/03/2018
 * Time: 17:39
 */

namespace UdyWfToWp\Plugins\ContentManager;

use UdyWfToWp\Core\Udy_Wf_To_Wp_Loader;
use UdyWfToWp\Interfaces\iPlugin;
use UdyWfToWp\Plugins\ContentManager\Contents\Content_Configuration;
use UdyWfToWp\Plugins\ContentManager\Contents\Content_Manager;
use UdyWfToWp\Plugins\ContentManager\Contents\Content_Ui;
use UdyWfToWp\Plugins\ContentManager\Lists\List_Configuration;
use UdyWfToWp\Plugins\ContentManager\Lists\List_Manager;
use UdyWfToWp\Plugins\ContentManager\Settings\Settings_Blog;
use UdyWfToWp\Plugins\ContentManager\Settings\Settings_Configuration;
use UdyWfToWp\Plugins\ContentManager\Settings\Settings_Manager;
use UdyWfToWp\Plugins\ContentManager\Settings\Settings_Search;
use UdyWfToWp\Plugins\ContentManager\Settings\Settings_Woocommerce;
use UdyWfToWp\Utils\Utils;

class ContentManager implements iPlugin {
	public static function define_admin_hooks( Udy_Wf_To_Wp_Loader $loader ) {

//		GLOBAL ASSETS & AJAX
		$loader->add_action('admin_enqueue_scripts', ContentManager_Assets::class, 'load_scripts');
		$loader->add_action('admin_enqueue_scripts', ContentManager_Assets::class, 'load_styles');
		$loader->add_action('wp_ajax_select2_search',ContentManager_Assets::class,'select2_search');
		$loader->add_action('wp_ajax_pages_sync',ContentManager_Assets::class,'pages_sync');
		$loader->add_action('wp_ajax_delete_all_pages',ContentManager_Assets::class,'delete_all_pages');
		$loader->add_action('wp_ajax_delete_all_fe_elements',ContentManager_Assets::class,'delete_all_fe_elements');
		$loader->add_action('wp_ajax_clean_all_fe_elements',ContentManager_Assets::class,'clean_all_fe_elements');

//		CONTENTS
		$content_configuration = Content_Configuration::getInstance();
		$loader->add_action('init', $content_configuration,'content_post_type');
		$loader->add_action('add_meta_boxes_' . $content_configuration->post_type_name, $content_configuration,'add_content_meta_box');

		$loader->add_action('save_post_'.$content_configuration->get_post_type(), Content_Manager::class, 'save_udesly_content', 10, 3);

		$loader->add_filter( 'manage_'.$content_configuration->get_post_type().'_posts_columns', Content_Manager::class, 'change_columns' );
		$loader->add_action( 'manage_'.$content_configuration->get_post_type().'_posts_custom_column', Content_Manager::class, 'custom_columns', 10, 2 );

		$loader->add_action( 'trashed_post', Content_Manager::class, 'check_udesly_data_on_post_trash' );
		$loader->add_action( 'untrash_post', Content_Manager::class, 'check_udesly_data_on_post_trash' );

		$loader->add_action( 'wp_create_nav_menu', Content_Manager::class, 'refire_check_data' );
		$loader->add_action( 'wp_update_nav_menu', Content_Manager::class, 'refire_check_data' );
		$loader->add_action( 'wp_delete_nav_menu', Content_Manager::class, 'refire_check_data' );

//		LISTS
		$list_configuration = List_Configuration::getInstance();
		$loader->add_action('init', $list_configuration,'list_post_type');
		$loader->add_action('add_meta_boxes_' . $list_configuration->post_type_name, $list_configuration,'add_list_meta_box');

		$loader->add_action('save_post_'.$list_configuration->get_post_type(), List_Manager::class, 'save_udesly_list', 10, 3);

		$loader->add_filter( 'manage_'.$list_configuration->get_post_type().'_posts_columns', List_Manager::class, 'change_columns' );
		$loader->add_action( 'manage_'.$list_configuration->get_post_type().'_posts_custom_column', List_Manager::class, 'custom_columns', 10, 2 );

//		SETTINGS UI
		$settings = Settings_Configuration::getInstance();
		$loader->add_action('admin_menu', $settings, 'create_menu');
		$loader->add_action('admin_init',Settings_Manager::class,'save_settings');
		$loader->add_action('admin_init', Settings_Manager::class, 'check_wordpress_importer');
		$loader->add_action('admin_init', Settings_Manager::class, 'check_front_page');
		$loader->add_action( 'wp_before_admin_bar_render', Settings_Manager::class, 'render_toolbar', 100 );

		$loader->add_action('admin_init', Content_Manager::class, 'check_udesly_data');
		$loader->add_action('admin_notices', Content_Manager::class, 'udesly_data_missing_error');

	}

	public static function define_public_hooks( Udy_Wf_To_Wp_Loader $loader ) {
		$loader->add_action('wp_loaded', Settings_Manager::class, 'enable_temporary_mode');

//		SETTINGS BLOG
		$loader->add_filter( 'excerpt_length', Settings_Blog::class, 'apply_blog_excerpt', 80 );
		$loader->add_filter( 'excerpt_more', Settings_Blog::class, 'apply_blog_excerpt_more', 80 );
		$loader->add_filter('get_the_archive_title', Settings_Blog::class, 'filter_archive_title',90);
		$loader->add_filter( 'category_template', Settings_Blog::class, 'new_subcategory_hierarchy' );

		if(is_plugin_active('woocommerce/woocommerce.php')) {
			$loader->add_filter( 'taxonomy_template', Settings_Woocommerce::class, 'new_subcategory_hierarchy' );
		}

//		SETTINGS SEARCH
		$loader->add_action('pre_get_posts', Settings_Search::class, 'search_results_number', 20, 1);
		$loader->add_filter('template_include', Settings_Search::class, 'search_redirect_page', 21, 1);
		$loader->add_filter( 'excerpt_length', Settings_Search::class, 'apply_search_excerpt', 100 );
		$loader->add_filter( 'excerpt_more', Settings_Search::class, 'apply_search_excerpt_more', 100 );

		$loader->add_action('wp_enqueue_scripts', ContentManager_Assets::class, 'public_load_styles');
	}

	public static function activate() {

	}

	public static function deactivate() {

	}

}
