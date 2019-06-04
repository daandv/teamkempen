<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 10/04/2018
 * Time: 11:10
 */

namespace UdyWfToWp\Plugins\Rules;

use UdyWfToWp\Core\Udy_Wf_To_Wp;
use UdyWfToWp\i18n\i18n;
use UdyWfToWp\Plugins\Rules\Rule\Rule_Controller;
use UdyWfToWp\Ui\Form;
use UdyWfToWp\Ui\Icon;
use UdyWfToWp\Ui\Icon_Type;
use UdyWfToWp\Ui\Tabs;
use WP_Query;

class Rules_Configuration{

	private static $instance;
	public static $post_type_name = 'udesly_rules';

	protected function __construct() {}

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

	public function create_rules_post_type() {

		$args = array(
			'label' => __('Rule', i18n::$textdomain),
			'description' => '',
			'labels' => array(
				'name' => _x('Rules', 'Post Type General Name', i18n::$textdomain),
				'singular_name' => _x('Rule', 'Post Type Singular Name', i18n::$textdomain),
				'menu_name' => __('Rule', i18n::$textdomain),
				'parent_item_colon' => __('Parent Item:', i18n::$textdomain),
				'all_items' => __('Rules', i18n::$textdomain),
				'view_item' => __('View Rules', i18n::$textdomain),
				'add_new_item' => __('Add New Rule', i18n::$textdomain),
				'add_new' => __('Add New Rule', i18n::$textdomain),
				'edit_item' => __('Edit Rule', i18n::$textdomain),
				'update_item' => __('Update Rule', i18n::$textdomain),
				'search_items' => __('Search Rule', i18n::$textdomain),
				'not_found' => __('Not found', i18n::$textdomain),
				'not_found_in_trash' => __('Not found in Trash', i18n::$textdomain),
			),
			'supports' => array('title'),
			'hierarchical' => false,
			'public' => false,
			'show_ui' => true,
			'exclude_from_search' => true,
			'capability_type' => 'post',
			'capabilities'       => array( 'create_posts' => true ),
			'map_meta_cap'       => true,
			'show_in_menu' => Udy_Wf_To_Wp::$menu_slug,
		);

		register_post_type(self::$post_type_name, $args);

	}

	public function rules_add_meta_boxes(){
		add_meta_box( 'box_meta_box', // ID attribute of metabox
			__('Rules',i18n::$textdomain),       // Title of metabox visible to user
			array($this,'udesly_rules_meta_box'), // Function that prints box in wp-admin
			self::$post_type_name,              // Show box for posts, pages, custom, etc.
			'normal',            // Where on the page to show the box
			'high' );

		add_meta_box( 'rules_redirect_meta_box', // ID attribute of metabox
			__('Redirect rules',i18n::$textdomain),       // Title of metabox visible to user
			array($this,'udesly_redirect_rules_meta_box'), // Function that prints box in wp-admin
			array('page', 'post', 'product'),              // Show box for posts, pages, custom, etc.
			'side',            // Where on the page to show the box
			'default' );
    }

    public function udesly_redirect_rules_meta_box($post){

		$rules = Rules_Manager::get_udesly_saved_rules();

		$saved_redirect = get_post_meta($post->ID,'udesly_rule_redirect_options',true);

		$rules_options = array();
		$rules_options[0] = __('No redirect', i18n::$textdomain);
		foreach ($rules as $rule){
			$rules_options[$rule->ID] = $rule->post_title;
		}

		$form = new Form();
		$form->add_select('udesly_rule_redirect','udesly_rule_redirect','Redirect rule',$rules_options, isset($saved_redirect['udesly_rule_redirect']) ?  $saved_redirect['udesly_rule_redirect'] : '',__('Redirect if selected rule is satisfied.', i18n::$textdomain));
		$form->add_break_line_border();
		$form->add_text('udesly_rule_redirect_url','udesly_rule_redirect_url','Redirect to','https://www.example.com/my-page',isset($saved_redirect['udesly_rule_redirect_url']) ?  $saved_redirect['udesly_rule_redirect_url'] : '','Redirect to specific URL');
		$form->get_form(true);
    }

	public function udesly_rules_meta_box($post) {
		$subjects = array(
			'always',
			'user',
			'logged_in',
			'role',
			'is_home',
			'is_archive',
			'is_post_type_archive',
			'is_category',
			'is_tag',
			'has_subcategories',
			'is_subcategory'
		);

		if(is_plugin_active('easy-digital-downloads/easy-digital-downloads.php'))
			$subjects[] = 'edd_has_user_purchased';

		if( is_plugin_active( 'restrict-content-pro/restrict-content-pro.php' ) ){
			$subjects[] = 'rcp_is_active';
			$subjects[] = 'rcp_is_expired';
			$subjects[] = 'rcp_can_access';
			$subjects[] = 'rcp_is_restricted_content';
			$subjects[] = 'rcp_is_paid_content';
			$subjects[] = 'rcp_is_trialing';
			$subjects[] = 'rcp_is_pending_verification';
			$subjects[] = 'rcp_has_used_trial';
			$subjects[] = 'rcp_has_subscription';
		}

		if( is_plugin_active( 'woocommerce/woocommerce.php' ) ){
			$subjects[] = 'woo_products';
			$subjects[] = 'woo_has_user_purchased';
			$subjects[] = 'woo_is_category';
			$subjects[] = 'woo_is_tag';
			$subjects[] = 'woo_has_subcategories';
			$subjects[] = 'woo_is_shop';
		}

		$form_rule = new Form();
		$rule = new Rule_Controller($post->ID,self::$post_type_name . '_meta_key', $form_rule,array('subjects' => $subjects));

		$tab = new Tabs();
		$tab->add_tab( __( 'Rules', i18n::$textdomain ), '1', $rule->create_rules_form(), Icon::faIcon( 'sliders-h', true, Icon_Type::SOLID() ) );

		$tab->show_tabs();
	}

}