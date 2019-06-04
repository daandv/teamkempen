<?php

namespace UdyWfToWp\Plugins\ContentManager\Contents;

use UdyWfToWp\Core\Udy_Wf_To_Wp;
use UdyWfToWp\i18n\i18n;

class Content_Configuration{

	private static $instance;
	private $post_type_name;

	protected function __construct() {
		$this->post_type_name = 'udesly_content';
	}

	public function __get( $name ) {
		return $this->$name;
	}

	public static function getInstance()
	{
		if (!isset(self::$instance)) {
			self::$instance = new self;
		}
		return self::$instance;
	}


	public function content_post_type(){

		$args = array(
			'label' => __('Content', i18n::$textdomain),
			'description' => '',
			'labels' => array(
				'name' => _x('Contents', 'Post Type General Name', i18n::$textdomain),
				'singular_name' => _x('Content', 'Post Type Singular Name', i18n::$textdomain),
				'menu_name' => __('Content', i18n::$textdomain),
				'parent_item_colon' => __('Parent Item:', i18n::$textdomain),
				'all_items' => __('Contents', i18n::$textdomain),
				'view_item' => __('View Contents', i18n::$textdomain),
				'add_new_item' => __('Add New Content', i18n::$textdomain),
				'add_new' => __('Add New Content', i18n::$textdomain),
				'edit_item' => __('Edit Content', i18n::$textdomain),
				'update_item' => __('Update Content', i18n::$textdomain),
				'search_items' => __('Search Content', i18n::$textdomain),
				'not_found' => __('Not found', i18n::$textdomain),
				'not_found_in_trash' => __('Not found in Trash', i18n::$textdomain),
			),
			'supports' => array('title'),
			'hierarchical' => false,
			'public' => false,
			'show_ui' => true,
			'exclude_from_search' => true,
			'capability_type' => 'post',
			'capabilities'       => array( 'create_posts' => true ),
			'map_meta_cap'       => true,
			'show_in_menu' => Udy_Wf_To_Wp::$menu_slug,
		);

		register_post_type($this->post_type_name, $args);
	}

	public function add_content_meta_box($post){
		add_meta_box(
			'add_content_meta_box',
			__( 'Content', i18n::$textdomain ),
			array(Content_Ui::class, 'add_content_meta_box_component'),
			$this->post_type_name,
			'normal',
			'default',
			array(
				'post' => $post
			)
		);
	}

	public function get_post_type(){
		return $this->post_type_name;
	}

}