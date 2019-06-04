<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 15/05/2018
 * Time: 15:39
 */

function udesly_has_dynamic_box(){
	$post_id = get_the_ID();

	if(!$post_id)
		return false;

	$post_meta = get_post_meta($post_id, '_udesly_dynamic_box', true);

	if(!empty($post_meta)){
		return true;
	}

	return false;
}

function udesly_get_boxes_slider($slug){

	$post_meta = '';

	if($slug == 'dynamic-box'){
		$post_id = get_the_ID();

		if(!$post_id)
			return array();

		$post_meta = get_post_meta($post_id, '_udesly_dynamic_box', true);
	}else{
		$args = array(
			'name'        => $slug,
			'post_type'   => 'udesly_box',
			'post_status' => 'publish',
			'numberposts' => 1
		);
		$my_posts = get_posts($args);
		if( $my_posts ) {
			$post_meta = $my_posts[0]->post_content;
		}else{
			return array();
		}
	}

	$attrs = udesly_get_string_between( '[gallery', ']', $post_meta);
	$attr_ids = udesly_get_string_between( 'ids="', '"', $attrs);
	$images_ids = explode(',',$attr_ids);

	$images = array();

	foreach ($images_ids as $id){
		$image = wp_get_attachment_image_src($id,'full');
		if($image){
			$images[] = $image[0];
		}
	}

	return $images;
}