<?php

namespace UdyWfToWp\Plugins\ContentManager\Lists;

use UdyWfToWp\Core\Udy_Wf_To_Wp;
use UdyWfToWp\i18n\i18n;

class List_Configuration{

	private static $instance;
	private $post_type_name;

	protected function __construct() {
		$this->post_type_name = 'udesly_list';
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


	public function list_post_type(){

		$args = array(
			'label' => __('List', i18n::$textdomain),
			'description' => '',
			'labels' => array(
				'name' => _x('Lists', 'Post Type General Name', i18n::$textdomain),
				'singular_name' => _x('List', 'Post Type Singular Name', i18n::$textdomain),
				'menu_name' => __('List', i18n::$textdomain),
				'parent_item_colon' => __('Parent Item:', i18n::$textdomain),
				'all_items' => __('Lists', i18n::$textdomain),
				'view_item' => __('View Lists', i18n::$textdomain),
				'add_new_item' => __('Add New List', i18n::$textdomain),
				'add_new' => __('Add New List', i18n::$textdomain),
				'edit_item' => __('Edit List', i18n::$textdomain),
				'update_item' => __('Update List', i18n::$textdomain),
				'search_items' => __('Search List', i18n::$textdomain),
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

	public function add_list_meta_box($post){
		add_meta_box(
			'add_list_meta_box',
			__( 'List', i18n::$textdomain ),
			array(List_Ui::class, 'add_list_meta_box_component'),
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