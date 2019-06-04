<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 04/04/2018
 * Time: 12:21
 */

namespace UdyWfToWp\Plugins\ContentManager\Contents;

class Content{

	private $title;
	private $query;
	private $id;
	private $slug;

	public function __construct($id) {
		$this->id = $id;

		$post = get_post($this->id);
		$this->title = $post->post_title;
		$this->slug = $post->post_name;

		$this->query = get_post_meta($this->id,'_udesly_content_query_builder',true);
	}

	public static function update($post_id, $query_builder){

		if(is_array($query_builder)){
			foreach ($query_builder as $key => $value){
				if(!is_array($value)) {
					is_int($value) ? $query_builder[ $key ] = (int)sanitize_text_field( $value ) : $query_builder[ $key ] = sanitize_text_field( $value );
				}else{
					foreach ($value as $sub_key => $sub_value){
						is_int($sub_value) ? $query_builder[ $key ][$sub_key] = (int)sanitize_text_field($sub_value) : $query_builder[ $key ][$sub_key] = sanitize_text_field($sub_value);
					}
				}
			}
		}

		update_post_meta($post_id, '_udesly_content_query_builder', $query_builder);
	}

	public function __get( $name ) {
		return $this->$name;
	}

	public function __set( $name, $value ) {
		$this->$name = $value;
	}
}