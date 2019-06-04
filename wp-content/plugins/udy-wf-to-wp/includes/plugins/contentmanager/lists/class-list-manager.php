<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 04/04/2018
 * Time: 11:27
 */

namespace UdyWfToWp\Plugins\ContentManager\Lists;

use UdyWfToWp\i18n\i18n;
use UdyWfToWp\Plugins\ContentManager\Models\Query\Query;

class List_Manager{

	public static function save_udesly_list($post_id, $post, $update){

		if ( ! empty( $_POST ) && check_admin_referer( 'save_udesly_list', 'save_udesly_list_nonce' ) ) {
			//avoid the post autosave
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}

			$query_builder = $_POST['query_builder'];

			if(empty($query_builder['name__like']))
				unset($query_builder['name__like']);

			if(empty($query_builder['orderby_term']))
				unset($query_builder['orderby_term']);

			if(empty($query_builder['order']))
				unset($query_builder['order']);

			List_Model::update($post_id, $query_builder);

			delete_transient('udesly_exported_data');
		}
	}

	private static function array_cast_to_int(&$array, $unset_if_zero){
		foreach ($array as $key => $value){
			$array[$key]    = (int) $array[$key];

			if($unset_if_zero && $array[$key] === 0){
				unset($array[$key]);
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

		$list = new List_Model($post_id);

		switch ( $column ) {
			case "slug":
				echo '<input class="click-to-select" type="text" readonly value="'.$list->slug.'" />';
				break;
		}
	}
}