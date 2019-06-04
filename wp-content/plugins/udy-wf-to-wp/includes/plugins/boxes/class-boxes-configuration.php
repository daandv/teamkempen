<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 10/04/2018
 * Time: 11:10
 */

namespace UdyWfToWp\Plugins\Boxes;

use UdyWfToWp\Core\Udy_Wf_To_Wp;
use UdyWfToWp\i18n\i18n;
use WP_Query;

class Boxes_Configuration{

	private static $instance;
	private $post_type_name;

	protected function __construct() {
		$this->post_type_name = 'udesly_box';
	}

	public function __get( $name ) {
		return $this->$name;
	}

	public static function getInstance()
	{
		if (!isset(self::$instance)) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	public function create_box_post_type() {

		register_post_type( $this->post_type_name,
			array(
				'labels' => array(
					'name' => __( 'Boxes', i18n::$textdomain ),
					'singular_name' => __( 'Box', i18n::$textdomain )
				),
				'public' => true,
				'has_archive' => false,
				'menu_icon'   => '',
				'exclude_from_search' => true,
				'show_in_nav_menus' => false,
				'show_in_menu' => Udy_Wf_To_Wp::$menu_slug,
			)
		);

	}

	public function change_post_type_labels() {
		global $wp_post_types;

		// Get the post labels
		$postLabels = $wp_post_types['udesly_box']->labels;
		$postLabels->name = __('Boxes', i18n::$textdomain);
		$postLabels->singular_name = __('Box', i18n::$textdomain);
		$postLabels->add_new = __('Add New Box', i18n::$textdomain);
		$postLabels->add_new_item = __('Add Box', i18n::$textdomain);
		$postLabels->edit_item = __('Edit Boxes', i18n::$textdomain);
		$postLabels->new_item = __('Boxes', i18n::$textdomain);
		$postLabels->view_item = __('View Box', i18n::$textdomain);
		$postLabels->search_items = __('Search Boxes', i18n::$textdomain);
		$postLabels->not_found = __('No Boxes found', i18n::$textdomain);
		$postLabels->not_found_in_trash = __('No Boxes found in Trash', i18n::$textdomain);

	}

	public function add_meta_boxes_dynamic_box($post){

		if(in_array($post, array('udesly_box','udesly_content','udesly_list','udesly_rules','acf-field-group','udesly_cpt')))
			    return;

		add_meta_box( 'box_meta_box_dynamic', // ID attribute of metabox
			__('Dynamic Box',i18n::$textdomain),       // Title of metabox visible to user
			array($this,'udesly_boxes_meta_box_dynamic'), // Function that prints box in wp-admin
			$post,              // Show box for posts, pages, custom, etc.
			'normal',            // Where on the page to show the box
			'high' );

	}

	public function udesly_boxes_meta_box_dynamic($post){
		$init = get_post_meta($post->ID, '_udesly_dynamic_box', true);
		wp_editor($init,'udesly_dynamic_box');
	}

	public function udesly_save_dynamic_box($post_id){
		if(isset($_POST['udesly_dynamic_box'])){
			$dynamic_box = wp_kses_post($_POST['udesly_dynamic_box']);
			update_post_meta($post_id, '_udesly_dynamic_box', $dynamic_box);
		}
	}

	public function boxes_add_meta_boxes(){

		add_meta_box( 'box_meta_box', // ID attribute of metabox
			__('Related Page',i18n::$textdomain),       // Title of metabox visible to user
			array($this,'udesly_boxes_meta_box'), // Function that prints box in wp-admin
			'udesly_box',              // Show box for posts, pages, custom, etc.
			'side',            // Where on the page to show the box
			'high' );

	}

	public function udesly_boxes_meta_box($post) {
		wp_nonce_field( basename( __FILE__ ), 'udesly_boxes_meta_box_nonce' );
		$selected = get_post_meta($post->ID,'_udesly_box_related_page',true);
		wp_dropdown_pages(array(
			'name' => 'udesly_box_related_page',
			'selected' => $selected,
			'show_option_none' => __('No Page Selected',i18n::$textdomain)
		));
		if(!empty($selected)): ?>

			<a class="button button-primary button-large" href="<?php echo get_edit_post_link( $selected ); ?>"><?php _e('Go To Page',i18n::$textdomain); ?></a>

		<?php endif;
	}

	public function pages_add_meta_boxes(){

		global $post;

		$boxes_query = new WP_Query( array(
			'post_type' => 'udesly_box',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'meta_query' => array(
				array(
					'key' => '_udesly_box_related_page',
					'value' => intval($post->ID),
				),
			)
		));


		if($boxes_query->have_posts()) {

			$GLOBALS['boxes_query'] = $boxes_query;


			add_meta_box( 'related_boxes_meta_box', // ID attribute of metabox
				__( 'Related Boxes', i18n::$textdomain ),       // Title of metabox visible to user
				array( $this, 'related_boxes_meta_box' ), // Function that prints box in wp-admin
				'page',              // Show box for posts, pages, custom, etc.
				'normal',            // Where on the page to show the box
				'high' );

		}

	}

	public function related_boxes_meta_box($post) {

		global $boxes_query;

		?>
		<p><?php _e('This Page use these Boxes',i18n::$textdomain); ?></p>
		<table class="widefat">
			<thead>
			<tr><th><strong>Box Name</strong></th><th><strong>Action</strong></th></tr>
			</thead>

			<?php
			foreach ($boxes_query->posts as $box): ?>
				<tr><td><?php echo ucfirst($box->post_title); ?></td><td>
						<a class="button button-primary button-large" href="<?php echo get_edit_post_link( $box->ID ); ?>"><?php _e('Edit Box',i18n::$textdomain); ?></a></td></tr>
			<?php endforeach;

			?>
		</table>
		<?php

	}

	public function udesly_boxes_save_meta_boxes_data( $post_id ){

		if ( !isset( $_POST['udesly_boxes_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['udesly_boxes_meta_box_nonce'], basename( __FILE__ ) ) ){
			return;
		}

		if(isset($_POST['udesly_box_related_page'])){
			update_post_meta( $post_id, '_udesly_box_related_page', sanitize_key($_POST['udesly_box_related_page']));
		}

	}

	public static function change_columns($cols){
		$cols = array(
			'cb'              => '<input type="checkbox" />',
			'title'           => __( 'Title', i18n::$textdomain ),
			'shortcode'            => __( 'Shortcode', i18n::$textdomain ),
		);

		return $cols;
	}

	public static function custom_columns($column, $post_id){

		$boxes = get_post($post_id);

		switch ( $column ) {
			case "shortcode":
				echo '<input style="width: 300px;" class="click-to-select" type="text" readonly value="[udesly-boxes slug=&quot;'.$boxes->post_name.'&quot;]" />';
				break;
		}
	}
}