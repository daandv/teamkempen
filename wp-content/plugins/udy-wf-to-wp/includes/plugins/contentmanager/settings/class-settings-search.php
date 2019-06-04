<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 26/04/2018
 * Time: 18:03
 */

namespace UdyWfToWp\Plugins\ContentManager\Settings;

class Settings_Search{

	public static function apply_search_excerpt($excerpt_lenght){

		if(!is_search())
			return $excerpt_lenght;

		$settings = Settings_Manager::get_saved_settings();

		if(isset($settings['search_excerpt_length']))
			return $settings['search_excerpt_length'];

		return $excerpt_lenght;
	}

	public static function apply_search_excerpt_more($excerpt_more){

		if(!is_search())
			return $excerpt_more;

		$settings = Settings_Manager::get_saved_settings();

		if(isset($settings['search_excerpt_more']))
			return $settings['search_excerpt_more'];

		return $excerpt_more;
	}



	public static function search_results_number( $query ) {

		if(!is_search())
			return $query;

		$settings = Settings_Manager::get_saved_settings();

		if(!isset($settings['search_results_per_page']))
			return $query;

		if ( $query->is_main_query() && ! is_admin() && $query->is_search() ) {
			if(isset($_GET['post_type']) && $_GET['post_type']=='page'){
				$query->set('post_type',array('page'));
			}
			// Change the query parameters
			$results_number = intval( $settings['search_results_per_page'] );
			$query->set( 'posts_per_page', $results_number );

		}
		return $query;
	}

	public static function search_redirect_page( $template ) {

		if(!is_search())
			return $template;

        $post_type = get_query_var('post_type');
        if (file_exists(get_template_directory(). '/search-' . $post_type . '.php' )) {

            $new_template = locate_template(array('search-' . $post_type . '.php'));
            if (!empty($new_template)) {
                $template = $new_template;
            }
        }
        $settings = Settings_Manager::get_saved_settings();

		if(!isset($settings['search_one_match_redirect']))
			return $template;

		if($settings['search_one_match_redirect'] == true) {
			if (is_search()) {
				global $wp_query;
				if ($wp_query->post_count == 1) {
					wp_redirect( get_permalink( $wp_query->posts['0']->ID ) );
					exit;
				}
			}
		}
		return $template;
	}

}