<?php

function udesly_get_acf_image_url( $field_slug ) {
	$image_field = get_field( $field_slug );
	if ( empty($image_field) ) {
		return '';
	}
	if ( is_array( $image_field ) ) {
		return $image_field['url'];
	}
	if ( is_numeric($image_field) ){
		$image_src = wp_get_attachment_image_src( $image_field, 'full' );
	    if($image_src){
	        return $image_src[0];
        }
        return '';
	}
	return $image_field;
}

function udesly_get_acf_subfield_image_url( $field_slug ) {
	$image_field = get_sub_field( $field_slug );
	if ( empty($image_field) ) {
		return '';
	}
	if ( is_array( $image_field ) ) {
		return $image_field['url'];
	}
    if ( is_numeric($image_field) ){
        $image_src = wp_get_attachment_image_src( $image_field, 'full' );
        if($image_src){
            return $image_src[0];
        }
        return '';
    }
	return $image_field;
}

function udesly_get_custom_post_type_archive_link( $cpt_slug ) {
	return get_post_type_archive_link( $cpt_slug );
}

function udesly_get_custom_post_type_terms( $taxonomy ) {

	$saved_settings = get_option( 'udesly_settings' );

	$settings_count = $saved_settings['count_category_child_elements'];;
	$settings_number = $saved_settings['max_category_elements'];

	global $post, $post_type;
	if(!$post_type){
		return array();
	}
	$args = array(
		"number" => $settings_number
	);

	$result = array();

	$posts_term = wp_get_post_terms( $post->ID, $post_type . '_' . $taxonomy, $args );

	foreach ( $posts_term as $term ) {

		if ( $settings_count ) {
			$term->name .= ' (' . $term->count . ')';
		}

		$result[] = array(
			"name"      => $term->name,
			"permalink" => get_term_link( $term->term_id ),
			"description" => $term->description,
			"term_id" => $term->term_id,
		);
	}

	return $result;
}