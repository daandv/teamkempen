<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 04/04/2018
 * Time: 11:27
 */

namespace UdyWfToWp\Plugins\ContentManager\Contents;

use UdyWfToWp\i18n\i18n;
use UdyWfToWp\Plugins\ContentManager\Models\Query\Query;
use UdyWfToWp\Ui\Icon;
use UdyWfToWp\Ui\Icon_Type;
use UdyWfToWp\Utils\Utils;

class Content_Manager{

	public static function select2_search(){
		$search_term = $_GET['q'];
		$subject = $_GET['subject'];
		$query_meta = $_GET['query_meta'];

		$query = Query::factory($subject, $query_meta);

		if(!$query) {
			echo '';
			wp_die();
		}

		$data = $query->find_matching_items($search_term);

		echo json_encode($data);
		wp_die();
	}

	public static function save_udesly_content($post_id, $post, $update){

		if ( ! empty( $_POST ) && check_admin_referer( 'save_udesly_content', 'save_udesly_content_nonce' ) ) {
			//avoid the post autosave
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}

			$query_builder = $_POST['query_builder'];

			if(!isset($query_builder['post_type']) || $query_builder['post_type'][0] == 'post'){
			    unset($query_builder['contenttaxonomy']);
			    unset($query_builder['contentterm']);
            }else{
				unset($query_builder['category__in']);
				unset($query_builder['category__not_in']);
				unset($query_builder['tag__in']);
				unset($query_builder['tag__not_in']);
            }

			self::cast_to_int($query_builder['date_query'], true);
			if(empty($query_builder['date_query']))
				unset($query_builder['date_query']);

			if(empty($query_builder['meta_query']['value']))
				unset($query_builder['meta_query']);

			self::cast_to_int($query_builder['posts_per_page'],true);
			if(empty($query_builder['posts_per_page']))
				unset($query_builder['posts_per_page']);

			if(empty((int)$query_builder['offset']))
				unset($query_builder['offset']);

			$query_builder['ignore_sticky_posts'] = true;

			Content::update($post_id, $query_builder);

			delete_transient('udesly_exported_data');

		}
	}

	private static function cast_to_int(&$array, $unset_if_zero){
		if(!is_array($array)) {
			$array = (int) $array;
			return;
		}

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

		$content = new Content($post_id);

		switch ( $column ) {
			case "slug":
				echo '<input class="click-to-select" type="text" readonly value="'.$content->slug.'" />';
				break;
		}
	}

	public static function check_udesly_data(){
		Utils::checkSyncUdeslyThemeData();
	}

	public static function udesly_data_missing_error(){

		$to_sync = get_option('udesly_exported_data_missing', array());

		if(isset($to_sync['contents']) || isset($to_sync['rules']) || isset($to_sync['lists']) || isset($to_sync['customPostTypes']) || isset($to_sync['menus'])){
			?>
			<div class="notice notice-error">
				<p><?php echo Icon::faIcon( 'exclamation-triangle', true, Icon_Type::SOLID() ) . __( 'You need to create the missing data that your theme requires', i18n::$textdomain ) . ' <a href="'.get_admin_url(null,'admin.php?page=udesly_import#status').'">'.__( 'go to Udesly => Import from Webflow => Missing elements.', i18n::$textdomain ).'</a> '; ?></p>
			</div>
			<?php
		}

		if(isset($to_sync['pages']) && $to_sync['pages'] == true){
            ?>
            <div class="notice notice-error">
                <p><?php echo Icon::faIcon( 'exclamation-triangle', true, Icon_Type::SOLID() ) . __( 'You need to import the pages', i18n::$textdomain ) . ' <a href="'.get_admin_url(null,'admin.php?page=udesly_import#tools').'">'.__( 'go to Udesly => Import from Webflow => Webflow data.', i18n::$textdomain ).'</a> '; ?></p>
            </div>
            <?php
        }

        if(isset($to_sync['frontendEditorElements']) && $to_sync['frontendEditorElements'] > 0){
            ?>
            <div class="notice notice-info is-dismissible">
                <p><?php echo Icon::faIcon( 'info', true, Icon_Type::SOLID() ) . __( 'Did you convert and used more then one udesly theme? Maybe you need to clean the database from old frontend editor data', i18n::$textdomain ) . ' <a href="'.get_admin_url(null,'admin.php?page=udesly_import#tools').'">'.__( 'go to Udesly => Import from Webflow => Webflow data.', i18n::$textdomain ).'</a> '; ?></p>
            </div>
            <?php
        }

        if(isset($to_sync['frontendEditorElements']) && $to_sync['frontendEditorElements'] < 0){
            ?>
            <div class="notice notice-error">
                <p><?php echo Icon::faIcon( 'exclamation-triangle', true, Icon_Type::SOLID() ) . __( 'You need to import the frontend editor data', i18n::$textdomain ) . ' <a href="'.get_admin_url(null,'admin.php?page=udesly_import#tools').'">'.__( 'go to Udesly => Import from Webflow => Webflow data.', i18n::$textdomain ).'</a> '; ?></p>
            </div>
            <?php
        }
	}

	public static function check_udesly_data_on_post_trash( $post_id ) {
		if (in_array(get_post_type( $post_id ), array('udesly_content', 'udesly_list', 'udesly_rules', 'udesly_cpt'))){
			delete_transient('udesly_exported_data');
        }
	}

	public static function refire_check_data( $menu_id ) {
		delete_transient('udesly_exported_data');
    }
}