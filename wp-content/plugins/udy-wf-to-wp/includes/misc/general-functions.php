<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 16/04/2018
 * Time: 11:05
 */

function udesly_get_post_by_slug($page_slug, $output = OBJECT, $post_type = 'page' ){
	global $wpdb;
	$page_slug = sanitize_title($page_slug);
	if ( is_array( $post_type ) ) {
		$post_type = esc_sql( $post_type );
		$post_type_in_string = "'" . implode( "','", $post_type ) . "'";
		$sql = $wpdb->prepare( "
			SELECT ID
			FROM $wpdb->posts
			WHERE post_name = %s
			AND post_type IN ($post_type_in_string)
		", $page_slug );
	} else {
		$sql = $wpdb->prepare( "
			SELECT ID
			FROM $wpdb->posts
			WHERE post_name = %s
			AND post_type = %s
		", $page_slug, $post_type );
	}
	$page = $wpdb->get_var( $sql );
	if ( $page )
		return get_post( $page, $output );
	return null;
}

function udesly_get_permalink_by_slug($page_slug, $output = OBJECT, $post_type = 'page' ){

    if(strpos($page_slug, '#') === 0){
        return $page_slug;
    }

	$post = udesly_get_post_by_slug($page_slug, $output, $post_type);

	if(!is_null($post) || is_wp_error($post))
		return get_permalink($post);

	return '#';
}

function udesly_get_guid_by_slug($page_slug, $output = OBJECT, $post_type = 'page' ){
	$post = udesly_get_post_by_slug($page_slug, $output, $post_type);

	if(!is_null($post) || is_wp_error($post))
		return $post->guid;

	return '#';
}

function udesly_get_numbers_links(){

	$saved_settings = \UdyWfToWp\Plugins\ContentManager\Settings\Settings_Manager::get_saved_settings();

	global $wp_query, $wp_rewrite;
	$args = array();
 // Setting up default values based on the current URL.
 $pagenum_link = html_entity_decode( get_pagenum_link() );
 $url_parts    = explode( '?', $pagenum_link );

 // Get max pages and current page out of the current query, if available.
 $total   = isset( $wp_query->max_num_pages ) ? $wp_query->max_num_pages : 1;
 $current = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;

 // Append the format placeholder to the base URL.
 $pagenum_link = trailingslashit( $url_parts[0] ) . '%_%';

 // URL base depends on permalink settings.
 $format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
 $format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

 $defaults = array(
     'base'               => $pagenum_link, 
     'format'             => $format, 
     'total'              => $total,
     'current'            => $current,
     'aria_current'       => 'page',
     'show_all'           => false,
     'prev_text'          => __( '&laquo; Previous' ),
     'next_text'          => __( 'Next &raquo;' ),
     'end_size'           => isset($saved_settings['pagination_end_size']) ? $saved_settings['pagination_end_size'] : 1,
     'mid_size'           => isset($saved_settings['pagination_mid_size']) ? $saved_settings['pagination_mid_size'] : 2,
     'type'               => 'plain',
     'add_args'           => array(), 
     'add_fragment'       => '',
     'before_page_number' => '',
     'after_page_number'  => '',
 );

 $args = wp_parse_args( $args, $defaults );

 if ( ! is_array( $args['add_args'] ) ) {
     $args['add_args'] = array();
 }

 if ( isset( $url_parts[1] ) ) {
     $format = explode( '?', str_replace( '%_%', $args['format'], $args['base'] ) );
     $format_query = isset( $format[1] ) ? $format[1] : '';
     wp_parse_str( $format_query, $format_args );

     // Find the query args of the requested URL.
     wp_parse_str( $url_parts[1], $url_query_args );

     // Remove the format argument from the array of query arguments, to avoid overwriting custom format.
     foreach ( $format_args as $format_arg => $format_arg_value ) {
         unset( $url_query_args[ $format_arg ] );
     }

     $args['add_args'] = array_merge( $args['add_args'], urlencode_deep( $url_query_args ) );
 }

 // Who knows what else people pass in $args
 $total = (int) $args['total'];
 if ( $total < 2 ) {
     return;
 }
 $current  = (int) $args['current'];
 $end_size = (int) $args['end_size']; // Out of bounds?  Make it the default.
 if ( $end_size < 1 ) {
     $end_size = 1;
 }
 $mid_size = (int) $args['mid_size'];
 if ( $mid_size < 0 ) {
     $mid_size = 2;
 }
 $add_args = $args['add_args'];
 $page_links = array();
 $dots = false;

 for ( $n = 1; $n <= $total; $n++ ) :
     if ( $n == $current ) :
         $page_links[] = array( 'url' => $current , 'type' => 'current' );
         $dots = true;
     else :
         if ( $args['show_all'] || ( $n <= $end_size || ( $current && $n >= $current - $mid_size && $n <= $current + $mid_size ) || $n > $total - $end_size ) ) :
             $link = str_replace( '%_%', 1 == $n ? '' : $args['format'], $args['base'] );
             $link = str_replace( '%#%', $n, $link );
             if ( $add_args )
                 $link = add_query_arg( $add_args, $link );
             $link .= $args['add_fragment'];

             $page_links[] = array( 'url' => esc_url( apply_filters( 'paginate_links', $link ) ) , 'type' => 'number' , 'number' => $n );
             $dots = true;
         elseif ( $dots && ! $args['show_all'] ) :
             $page_links[] = array( 'url' => '#' , 'type' => 'dots' );
             $dots = false;
         endif;
     endif;
 endfor;
return $page_links;
}

function udesly_get_term_link_by_slug($slug, $type){

	$term_link = get_term_link( $slug, $type );

	if(is_null($term_link) || is_wp_error($term_link))
		return '#';

	return $term_link;
}

function udesly_get_term_list( $separator, $taxonomy ) {
	$terms = get_the_terms(get_the_ID(), $taxonomy);

	if(is_null($terms) || is_wp_error($terms))
		return '';

	$result = '';

	if($terms){
		$terms_count = count($terms) - 1;
		foreach ($terms as $index => $term){
			$link = get_term_link($term->term_id, $taxonomy);

			if(is_null($link) || is_wp_error($link))
				continue;

			$name = $term->name;
			$result .= "<a href='$link'>$name</a>";

			if($index !== $terms_count){
				$result .= $separator;
			}
		}
	}

	return $result;
}

function udesly_get_string_between( $start, $end, $string ) {
	$string = ' ' . $string;
	$ini    = strpos( $string, $start );
	if ( $ini == 0 ) {
		return '';
	}
	$ini += strlen( $start );
	$len = strpos( $string, $end, $ini ) - $ini;

	return substr( $string, $ini, $len );
}

function udesly_get_identifier( $identifier_template ) {
    global $post;
    if (!$post) {
        return '';
    }
    $identifier = str_replace('{id}', $post->ID, $identifier_template);
    $identifier = str_replace('{slug}', $post->post_name, $identifier);
    return $identifier;
}