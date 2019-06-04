<?php
/**
 * Created by PhpStorm.
 * User: Pietro Falco
 * Date: 08/01/2018
 * Time: 15:03
 */

namespace UdyWfToWp\Utils;

use UdyWfToWp\i18n\i18n;
use UdyWfToWp\Plugins\FrontendEditor\FrontendEditor_Configuration;

if ( is_admin() && isset( $_POST['udesly_action'] ) && $_POST['udesly_action'] == 'wp_load_importer' ) {
	if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
		define( 'WP_LOAD_IMPORTERS', true );
	}
}

class Utils {

	/**
	 * @return array of iPlugins
	 */
	public static function getIPluginsClasses() {

		$return = array();
		$dirs   = array_filter( glob( UDY_WF_TO_WP_PLUGIN_DIRECTORY_PATH . 'includes/plugins/*' ), 'is_dir' );
		foreach ( $dirs as $dir ) {
			$basename  = ucfirst( basename( $dir ) );
			$classname = "\UdyWfToWp\Plugins\\$basename\\$basename";
			if ( in_array( "UdyWfToWp\\Interfaces\\iPlugin", class_implements( $classname ) ) ) {
				$return[] = $classname;
			}
		}

		return $return;

	}

	public static function getDateTimePickerFormat() {
		return get_option( 'date_format' ) . ' H:i';
	}

	/**
	 * Get the plugin current version, force the use of get_plugin_data() in front-end as well.
	 * @return mixed
	 */
	public static function getPluginVersion() {
		if ( ! function_exists( 'get_plugin_data' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			$plugin_data = get_plugin_data( UDY_WF_TO_WP_PLUGIN_DIRECTORY_PATH . 'udy-wf-to-wp.php', false, false );

			return $plugin_data['Version'];
		}
	}

	public static function checkSyncUdeslyThemeData() {

		$json_data = get_template_directory() . '/udesly_exported_data.json';
		if ( is_file( $json_data ) ) {

			$transient = get_transient( 'udesly_exported_data' );

			$last_mod = filemtime( $json_data );

			if ( $transient == $last_mod ) {
				return;
			}

			$udesly_data = json_decode( file_get_contents( $json_data ) );
			$to_sync     = array();

			if(isset($udesly_data->contents)) {
				foreach ( $udesly_data->contents as $content ) {
					if ( is_null( udesly_get_post_by_slug( $content->slug, OBJECT, 'udesly_content' ) ) ) {
						$to_sync['contents'][] = $content->slug;
					}
				}
			}

			if(isset($udesly_data->lists)) {
				foreach ( $udesly_data->lists as $list ) {
					if ( is_null( udesly_get_post_by_slug( $list->slug, OBJECT, 'udesly_list' ) ) ) {
						$to_sync['list'][] = $list->slug;
					}
				}
			}

			if(isset($udesly_data->rules)) {
				foreach ( $udesly_data->rules as $rule ) {
					if ( is_null( udesly_get_post_by_slug( $rule->slug, OBJECT, 'udesly_rules' ) ) ) {
						$to_sync['rule'][] = $rule->slug;
					}
				}
			}

			if(isset($udesly_data->customPostTypes)) {
				foreach ( $udesly_data->customPostTypes as $cpt ) {
					if ( is_null( udesly_get_post_by_slug( $cpt->slug, OBJECT, 'udesly_cpt' ) ) ) {
						$to_sync['customPostTypes'][] = $cpt->slug;
					}
				}
			}

			if(isset($udesly_data->menus)) {
				foreach ( $udesly_data->menus as $menu ) {
					if ( ! wp_get_nav_menu_object( $menu->slug ) ) {
						$to_sync['menus'][] = $menu->slug;
					}
				}
			}

			if(isset($udesly_data->pages)) {
				$to_sync['pages'] = false;
				foreach ( $udesly_data->pages as $page ) {
					if ( is_null( udesly_get_post_by_slug( $page->slug, OBJECT, 'page' ) ) ) {
						$to_sync['pages'] = true;
						break;
					}
				}
			}

			if(isset($udesly_data->frontendEditorElements)) {
				$to_sync['frontendEditorElements'] = (int)wp_count_posts('udesly-fe')->publish - count($udesly_data->frontendEditorElements);
			}

			foreach ( $udesly_data->customFields as $customField ) {
				$to_sync['customFields'][] = $customField->slug;
			}

			update_option( 'udesly_exported_data_missing', $to_sync );
			set_transient( 'udesly_exported_data', $last_mod );
		}

	}

	public static function syncWebflowToWordpressPages() {
		$xml = get_template_directory() . '/udesly_exported_pages.xml';
		if ( is_file( $xml ) ) {

			$import_file = file_get_contents( $xml );
			$import_file = str_replace( '</channel>', '', $import_file );
			$import_file = str_replace( '</rss>', '', $import_file );
			$import_file .= '</channel></rss>';
			file_put_contents( $xml, $import_file );

			if ( self::isWordPressImporterPluginActive() && class_exists( '\WP_Import' ) ) {
				$importer = new \WP_Import();
				ob_start();
				$importer->import( $xml );
				ob_end_clean();

				$pages = get_pages( array(
					'meta_key' => '_udesly_page'
				) );

				foreach ( $pages as $page ) {
				    delete_transient("udesly_fe_items_".$page->post_name);
					FrontendEditor_Configuration::sync_page_fe_editor( $page->ID, $page->post_name );
				}

				$texts = FrontendEditor_Configuration::getElements( 'text' );

				foreach ( $texts as $text ) {
					FrontendEditor_Configuration::sanitize_udesly_get_permalink_by_slug( $text->post_content, $text->ID );
				}
				$exported_data = get_option( 'udesly_exported_data_missing' );

				if ( isset( $exported_data['customPostTypes'] ) ) {
					foreach ( $exported_data['customPostTypes'] as $slug ) {
						if ( is_null( udesly_get_post_by_slug( $slug, OBJECT, 'udesly_cpt' ) ) ) {
							$id = wp_insert_post( array(
								'post_title' => ucfirst($slug),
								'post_name' => $slug,
								'post_status' => 'publish',
								'post_type' => 'udesly_cpt',
							));
							if(!is_wp_error($id)) {

								update_post_meta( $id, 'udesly_cpt_single_name', ucfirst($slug) );
								update_post_meta( $id, 'udesly_cpt_plural_name', ucfirst($slug) .'s' );
								update_post_meta( $id, 'udesly_cpt_archive_rewrite', $slug );
								update_post_meta( $id, 'udesly_cpt_icon', 	'dashicons-admin-post' );
							}
						}
					}
					set_transient('udesly_should_rewrite', true);
				}

                self::delete_fe_transients();
				delete_transient('udesly_exported_data');
				return 'wp_sync_success';
			} else {
				return new \WP_Error( 'wp_importer_miss', __( 'Install the WordPress importer plugin', i18n::$textdomain ) );
			}
		} else {
			return new \WP_Error( 'xml_file_miss', __( 'The udesly_exported_pages.xml file is missing. Did you activate the exported theme ?', i18n::$textdomain ) );
		}
	}

	public static function delete_fe_transients() {
        global $wpdb;
        $fe_transients = $wpdb->get_results(
            "SELECT option_name AS name FROM $wpdb->options WHERE option_name LIKE '_transient_udesly_fe_items_%'"
        );
        foreach ($fe_transients as $transient) {
           delete_transient(str_replace('_transient_', '', $transient->name));
        }
    }

	public static function deleteAllImportedWordpressPages() {
		global $wpdb;
		//$res = $wpdb->delete( $wpdb->posts, array('post_type' => 'page'));

		$res  = $wpdb->query( "DELETE " . $wpdb->posts . " FROM " . $wpdb->posts . " INNER JOIN " . $wpdb->postmeta . " ON " . $wpdb->postmeta . ".post_id = " . $wpdb->posts . ".ID WHERE (" . $wpdb->postmeta . ".meta_key = '_udesly_page' AND " . $wpdb->postmeta . ".meta_value IS NOT NULL);" );
		$res2 = $wpdb->query( "DELETE from $wpdb->postmeta WHERE meta_key = '_udesly_page'" );


		if ( ! $res && ! $res2 ) {
			return new \WP_Error( 'cant_delete_pages', __( 'Can\'t delete WordPress pages', i18n::$textdomain ) );
		}

		delete_transient('udesly_exported_data');

		return 'wp_delete_pages_success';

	}

	public static function deleteAllFrontendEditorElements() {
		global $wpdb;
		$res = $wpdb->delete( $wpdb->posts, array( 'post_type' => 'udesly-fe' ) );

		if ( ! $res ) {
			return new \WP_Error( 'cant_delete_fe_elements', __( 'Can\'t delete Frontend editor elements', i18n::$textdomain ) );
		}

		delete_transient('udesly_exported_data');

		return 'wp_delete_fe_success';

	}

	public static function cleanAllFrontendEditorElements() {

		$json_data = get_template_directory() . '/udesly_exported_data.json';

		if (! is_file( $json_data ) ) {
			return new \WP_Error( 'json_file_miss', __( 'The udesly_exported_data.json file is missing. Did you activate the exported theme ?', i18n::$textdomain ) );
		}

		$udesly_data = json_decode( file_get_contents( $json_data ) );
		if(isset($udesly_data->frontendEditorElements)){
			global $wpdb;

			$fe_ids = get_posts(array(
				'numberposts' => -1,
				'post_type' => 'udesly-fe',
				'fields' => 'ids',
				'post_name__in' => $udesly_data->frontendEditorElements,
			));

			$deletable_ids = get_posts(array(
				'numberposts' => -1,
				'post_type' => 'udesly-fe',
				'fields' => 'ids',
				'exclude' => $fe_ids,
			));

			$deletable_ids = implode( ',', array_map( 'absint', $deletable_ids ) );
			$wpdb->query( "DELETE FROM $wpdb->posts WHERE ID IN($deletable_ids)" );
		}

		delete_transient('udesly_exported_data');

		return 'wp_clean_fe_success';

	}

	public static function isWordPressImporterPluginActive() {
		if ( is_plugin_active( 'wordpress-importer/wordpress-importer.php' ) ) {
			return true;
		}

		return false;
	}

	public static function flushPermalink() {
		flush_rewrite_rules( true );
	}
}
