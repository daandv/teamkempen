<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 12/04/2018
 * Time: 10:59
 */

namespace UdyWfToWp\Plugins\FrontendEditor;

use UdyWfToWp\Core\Udy_Wf_To_Wp;
use UdyWfToWp\i18n\i18n;
use UdyWfToWp\Plugins\ContentManager\Settings\Settings_Manager;
use UdyWfToWp\Utils\Utils;

class FrontendEditor_Configuration{

	public static $plugin_name = 'udesly-frontend-editor';

	public static function register_frontend_editor_post_type(){

		$args = array(
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => false,
			'show_in_menu'       => false,
			'query_var'          => false,
			'has_archive'        => false,
			'hierarchical'       => false,
			'labels' => array(
		        'name' => __( 'Frontend Editor', 'boxes-plugin' ),
		        'singular_name' => __( 'Frontend Editor', 'boxes-plugin' )
	        ),
		);

		register_post_type( 'udesly-fe', $args );
	}

/*	public static function frontend_editor_add_meta_box(){

	    if(FrontendEditor_Configuration::current_user_can_use_frontend_editor())
		    add_meta_box( 'frontend_editor_meta_box', __( 'Frontend Editor', 'udesly-frontend-editor' ), array(self::class,'frontend_editor_meta_box'), 'page', 'normal', 'high' );

	}*/

// @deprecated
	public static function frontend_editor_meta_box($post){

        $text_elements  = self::getElementForPage( $post->post_name, 'text' );
        $image_elements = self::getElementForPage( $post->post_name, 'image' );
        $video_elements = self::getElementForPage( $post->post_name, 'video' );
		?>
		<p>These are the frontend elements present in this page</p>
        <div class="cdg-woo-kit-form-field udesly-success-msg udesly-hide-msg delete_all_page_elements_msg">
            <p><i class="fas fa-fw fa-check cdg-icon "></i><?php _e("Frontend editor elements succesfully deleted", i18n::$textdomain); ?></p>
        </div>
		<table class="widefat">
			<tbody>
			<thead>
			<th>Texts</th>
			<th>Images</th>
			<th>Videos</th>
			<th></th>
			<th></th>
			</thead>
			<tr>
				<td class="udesly-fe-el-count"><?php echo count($text_elements); ?></td>
				<td class="udesly-fe-el-count"><?php echo count($image_elements); ?></td>
				<td class="udesly-fe-el-count"><?php echo count($video_elements); ?></td>
                <?php if(isset($_GET['post'])) : ?>
                    <td style="width: 100px;"><a class="button button-primary button-large" href="<?php echo get_permalink($_GET['post']); ?>" target="_blank">Edit with frontend editor</a></td>
                    <td style="width: 100px;"><a id="delete-frontend-editor-elements" data-post-id="<?php echo $post->ID; ?>" class="button udesly-button-danger button-large">Delete elements in this page</a></td>
                <?php endif;?>
			</tr>
			</tbody>
		</table>
		<?php

	}

	public static function getElementForPage($page_name, $media_type){
		global $wpdb;
		$results = array();
		if(!empty($page_name)) {
			$results = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->posts . ' WHERE `post_title` LIKE \'%' . $page_name . '_udesly_frontend_editor_' . $media_type . '%\' AND `post_type` LIKE \'udesly-fe\'', OBJECT );
		}
		return $results;
	}

	public static function getElements($media_type){
		global $wpdb;
		$results = array();
		if(!empty($media_type)) {
			$results = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->posts . ' WHERE `post_title` LIKE \'%' . '_udesly_frontend_editor_' . $media_type . '%\' AND `post_type` LIKE \'udesly-fe\'', OBJECT );
		}
		return $results;
	}

	public static function frontendeditor_search_query( $query ) {
		if ( $query->is_search && (isset($query->query['post_type']) && ($query->query['post_type'] == 'page')) || !isset($query->query['post_type'])) {
			self::add_meta_field_to_search_query('_udesly_fe_content');
		};
	}

	public static function sync_page_fe_editor($page_id, $page_name){
        $page_fe_elements = self::getElementForPage($page_name, 'text');

        $text = '';
        foreach ($page_fe_elements as $page_fe_element){

            $text .= wp_strip_all_tags($page_fe_element->post_content) . ' ';

        }

        update_post_meta($page_id,'_udesly_fe_content',sanitize_text_field($text));
    }

    public static function sanitize_udesly_get_permalink_by_slug($string, $text_id){

	    $string = html_entity_decode($string, ENT_QUOTES | ENT_HTML5);

	    $matches = array();
	    $delimiter = '#';
	    $startTag = "START-UDESLY-PHPecho udesly_get_permalink_by_slug('";
	    $endTag = "');END-UDESLY-PHP";
	    $regex = $delimiter . preg_quote($startTag, $delimiter)
	             . '(.*?)'
	             . preg_quote($endTag, $delimiter)
	             . $delimiter
	             . 's';
	    preg_match_all($regex,$string,$matches);

	    foreach ($matches[1] as $key => $permalink_slug){
	        $result = udesly_get_guid_by_slug($permalink_slug);
	        $string = str_replace($matches[0][$key],$result,$string);
        }

        if(!empty($matches[1])){
	        wp_update_post(array(
		        'ID'           => $text_id,
		        'post_content' => $string
	        ));
        }

        return $string;
    }

	public static function add_meta_field_to_search_query($field){
		if(isset($GLOBALS['added_meta_field_to_search_query'])){
			$GLOBALS['added_meta_field_to_search_query'][] = '\'' . $field . '\'';

			return;
		}

		$GLOBALS['added_meta_field_to_search_query'] = array();
		$GLOBALS['added_meta_field_to_search_query'][] = '\'' . $field . '\'';

		add_filter('posts_join', function($join){
			global $wpdb;

			if (is_search()){
				$join .= " LEFT JOIN $wpdb->postmeta ON $wpdb->posts.ID = $wpdb->postmeta.post_id ";
			}

			return $join;
		});

		add_filter('posts_groupby', function($groupby){
			global $wpdb;

			if (is_search()) {
				$groupby = "$wpdb->posts.ID";
			}

			return $groupby;
		});

		add_filter('posts_search', function($search_sql){
			global $wpdb;

			$search_terms = get_query_var('search_terms');

			if(!empty($search_terms)){
				foreach ($search_terms as $search_term){
					$old_or = "OR ({$wpdb->posts}.post_content LIKE '{$wpdb->placeholder_escape()}{$search_term}{$wpdb->placeholder_escape()}')";
					$new_or = $old_or . " OR ({$wpdb->postmeta}.meta_value LIKE '{$wpdb->placeholder_escape()}{$search_term}{$wpdb->placeholder_escape()}' AND {$wpdb->postmeta}.meta_key IN (" . implode(', ', $GLOBALS['added_meta_field_to_search_query']) . "))";
					$search_sql = str_replace($old_or, $new_or, $search_sql);
				}
			}

			$search_sql = str_replace( " ORDER BY ", " GROUP BY $wpdb->posts.ID ORDER BY ", $search_sql );

			return $search_sql;
		});
	}

	public static function get_current_user_role() {
		if( is_user_logged_in() ) {
			$user = wp_get_current_user();
			$role = ( array ) $user->roles;
			return $role[0];
		} else {
			return false;
		}
	}

	public static function current_user_can_use_frontend_editor() {
		$settings = Settings_Manager::get_saved_settings();
		if(!isset($settings['frontend_editor_status'])){
			$settings['frontend_editor_status'] = '1';
			$settings['frontend_editor_roles'] = 'none';
		}

		if ( $settings['frontend_editor_status'] == '1' && (current_user_can( 'administrator' ) || $settings['frontend_editor_roles'] == self::get_current_user_role()) ) {
		    return true;
        }else{
		    return false;
        }
    }
}