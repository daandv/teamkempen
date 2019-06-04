<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 28/03/2018
 * Time: 17:39
 */

namespace UdyWfToWp\Plugins\Blog;

use UdyWfToWp\Core\Udy_Wf_To_Wp_Loader;
use UdyWfToWp\Interfaces\iPlugin;


class Blog implements iPlugin {
	public static function define_admin_hooks( Udy_Wf_To_Wp_Loader $loader ) {
		$loader->add_action ( 'edit_category_form_fields',  Blog_Terms::class,'extra_category_fields');
		$loader->add_action ( 'edited_category', Blog_Terms::class, 'save_extra_category_fields');

		$loader->add_action ( 'edit_tag_form_fields',  Blog_Terms::class,'extra_category_fields');
		$loader->add_action ( 'edited_tag', Blog_Terms::class, 'save_extra_category_fields');

		$loader->add_action('add_meta_boxes_post',Blog_Configuration::class,'main_blog_category_add_meta_box');

		$loader->add_action( 'save_post', Blog_Configuration::class,'main_blog_category_save_meta_boxes_data', 10, 2 );
	}

	public static function define_public_hooks( Udy_Wf_To_Wp_Loader $loader ) {

		$loader->add_filter('template_include', Blog_Configuration::class, 'home_redirect');

	}

	public static function activate() {

	}

	public static function deactivate() {

	}

}
