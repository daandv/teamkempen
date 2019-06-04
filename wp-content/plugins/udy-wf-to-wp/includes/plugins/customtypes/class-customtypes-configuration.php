<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 10/04/2018
 * Time: 11:10
 */

namespace UdyWfToWp\Plugins\CustomTypes;

use UdyWfToWp\Core\Udy_Wf_To_Wp;
use UdyWfToWp\i18n\i18n;
use UdyWfToWp\Ui\Form;
use UdyWfToWp\Ui\Icon;
use UdyWfToWp\Ui\Icon_Type;
use UdyWfToWp\Ui\Tabs;
use WP_Query;

class CustomTypes_Configuration {

	private static $instance;
	private $post_type_name;

	protected function __construct() {
		$this->post_type_name = 'udesly_cpt';
	}

	public function __get( $name ) {
		return $this->$name;
	}

	public static function getInstance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function init_all_post_types() {
		$post_types_query = new \WP_Query( array(
			'post_type'      => 'udesly_cpt',
			'posts_per_page' => - 1
		) );

		foreach ( $post_types_query->posts as $post_type ) {

		    if(!$post_type->post_name){
		        return;
            }

			$singular_name = get_post_meta( $post_type->ID, 'udesly_cpt_single_name', true );
			$plural_name   = get_post_meta( $post_type->ID, 'udesly_cpt_plural_name', true );
			$rewrite       = get_post_meta( $post_type->ID, 'udesly_cpt_archive_rewrite', true );
			$icon          = get_post_meta( $post_type->ID, 'udesly_cpt_icon', true );
			$taxonomies    = get_post_meta( $post_type->ID, 'udesly_cpt_taxonomies', true );
			if ( empty( $taxonomies ) ) {
				$taxonomies = array();
			} else {
				$taxonomies = explode( ',', $taxonomies );
			}

			$labels = array(
				'name'                  => $plural_name,
				'singular_name'         => $singular_name,
				'menu_name'             => $plural_name,
				'name_admin_bar'        => $singular_name,
				'archives'              => $singular_name . __(  'Archives', i18n::$textdomain ),
				'attributes'            => $singular_name . __( 'Attributes', i18n::$textdomain ),
				'parent_item_colon'     => __( 'Parent Item:', i18n::$textdomain ),
				'all_items'             => __( 'All ', i18n::$textdomain ) . $plural_name,
				'add_new_item'          => __( 'Add New ', i18n::$textdomain ) . $singular_name,
				'add_new'               => __( 'Add New', i18n::$textdomain ),
				'new_item'              => __( 'New ', i18n::$textdomain ) . $singular_name,
				'edit_item'             => __( 'Edit ', i18n::$textdomain ) . $singular_name,
				'update_item'           => __( 'Update ', i18n::$textdomain ) . $singular_name,
				'view_item'             => __( 'View ', i18n::$textdomain ) . $singular_name,
				'view_items'            => __( 'View ', i18n::$textdomain ) . $plural_name,
				'search_items'          => __( 'Search ', i18n::$textdomain ) . $singular_name,
				'not_found'             => __( 'Not found', i18n::$textdomain ),
				'not_found_in_trash'    => __( 'Not found in Trash', i18n::$textdomain ),
				'featured_image'        => __( 'Featured Image', i18n::$textdomain ),
				'set_featured_image'    => __( 'Set featured image', i18n::$textdomain ),
				'remove_featured_image' => __( 'Remove featured image', i18n::$textdomain ),
				'use_featured_image'    => __( 'Use as featured image', i18n::$textdomain ),
				'insert_into_item'      => __( 'Insert into item', i18n::$textdomain ),
				'uploaded_to_this_item' => __( 'Uploaded to this item', i18n::$textdomain ),
				'items_list'            => __( 'Items list', i18n::$textdomain ),
				'items_list_navigation' => __( 'Items list navigation', i18n::$textdomain ),
				'filter_items_list'     => __( 'Filter items list', i18n::$textdomain ),
			);
			$args   = array(
				'label'               => $singular_name,
				'description'         => $singular_name . __( ' Description', i18n::$textdomain ),
				'labels'              => $labels,
				'supports'            => array( 'title', 'author', 'editor', 'thumbnail', 'custom-fields', 'excerpt' ),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_position'       => 5,
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => true,
				'can_export'          => true,
				'has_archive'         => true,
				'rewrite'             => array(
					'slug'       => $rewrite,
					'with_front' => true,
					'pages'      => true,
					'feeds'      => true
				),
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'page',
				'menu_icon'           => $icon
			);
			register_post_type( $post_type->post_name, $args );

			foreach ( $taxonomies as $taxonomy ) {
				$taxonomy = sanitize_title( trim( $taxonomy ) );
				$taxonomy = str_replace( '-', '_', $taxonomy );
				$tax_name = str_replace( '_', ' ', ucfirst( $taxonomy ) );
				$slug = get_option('udesly_cpt_rewrite_' . $post_type->post_name . '_' . $taxonomy . '_field_id', $post_type->post_name . '_' . $taxonomy);
				register_taxonomy( $post_type->post_name . '_' . $taxonomy, $post_type->post_name, array(
					'labels' => array(
						'name'                       => $tax_name,
						'singular_name'              => $tax_name,
						'menu_name'                  => __( 'All ', i18n::$textdomain ) . $tax_name,
						'all_items'                  => __( 'All ', i18n::$textdomain ) . $tax_name,
						'edit_item'                  => __( 'Edit ', i18n::$textdomain ) . $tax_name,
						'view_item'                  => __( 'View ', i18n::$textdomain ) . $tax_name,
						'update_item'                => __( 'Update ', i18n::$textdomain ) . $tax_name,
						'add_new_item'               => __( 'Add new ', i18n::$textdomain ) . $tax_name,
						'new_item_name'              => __( 'New ', i18n::$textdomain )  . $tax_name .  __( ' name', i18n::$textdomain ),
						'search_items'               => __( 'Search ', i18n::$textdomain ) . $tax_name,
						'popular_items'              => __( 'Popular ', i18n::$textdomain ) . $tax_name,
						'separate_items_with_commas' => __( 'Separate ', i18n::$textdomain ) . $tax_name . __( ' with commas', i18n::$textdomain ),
						'add_or_remove_items'        => __( 'Add or remove ', i18n::$textdomain ) . $tax_name,
						'choose_from_most_used'      => __( 'Choose most used ', i18n::$textdomain ) . $tax_name,
						'not_found'                  => __( 'No ', i18n::$textdomain )  . $tax_name . __( ' found', i18n::$textdomain ),
					),
					'rewrite'                    => array(
						'slug' => $slug
					)
				) );
			}
		}

		if ( get_transient( 'udesly_should_rewrite' ) ) {
			flush_rewrite_rules( true );
			delete_transient( 'udesly_should_rewrite' );
		}
	}

	public function rewrite_custom_taxonomies(){

		$post_types_query = new \WP_Query( array(
			'post_type'      => 'udesly_cpt',
			'posts_per_page' => - 1
		) );

		foreach ( $post_types_query->posts as $post_type ) {
			$taxonomies    = get_post_meta( $post_type->ID, 'udesly_cpt_taxonomies', true );
			if ( empty( $taxonomies ) ) {
				$taxonomies = array();
			} else {
				$taxonomies = explode( ',', $taxonomies );
			}

			/* Create settings section */
			add_settings_section(
				'udesly_cpt_rewrite_' . $post_type->ID . '_section_id',                   // Section ID
				$post_type->post_title . ' permalinks',  // Section title
				array(self::class, 'taxonomy_rewrite_slug'), // Section callback function
				'permalink'                          // Settings page slug
			);
			
			foreach ($taxonomies as $taxonomy){

				$option_name = 'udesly_cpt_rewrite_' . $post_type->post_name . '_' . $taxonomy . '_field_id';

				$taxonomy = trim($taxonomy);
				/* Register Settings */
				register_setting(
					'permalink', // Options group
					$option_name              // Option name/database
				);

				/* Create settings field */
				add_settings_field(
					'udesly_cpt_rewrite_' . $post_type->post_name . '_' . $taxonomy . '_field_id',       // Field ID
					'Archive base ' . $taxonomy,       // Field title
					array(self::class, 'taxonomy_rewrite_slug_field'),
					'permalink',                    // Settings page slug
					'udesly_cpt_rewrite_' . $post_type->ID . '_section_id',               // Section ID
					array($option_name, $post_type->post_name . '_' . $taxonomy)
				);

				//Register settings in DB (is not possible to do with Settings API in permalink page, WP BUG)
				if(isset($_POST[$option_name])){
					update_option($option_name,sanitize_title($_POST[$option_name]));
				}
			}
		}
	}

	/* Setting Section Description */
	public static function taxonomy_rewrite_slug(){
		echo wpautop( "Change the permalink structure" );
	}

	/* Settings Field Callback */
	public static function taxonomy_rewrite_slug_field($args){
		?>
		<input id="<?php echo $args[0]; ?>" type="text" value="<?php echo get_option($args[0], $args[1]); ?>" name="<?php echo $args[0]; ?>" />
		<?php
	}

	public function add_cpt_menu_nodes( $wp_admin_bar ) {

		$post_types_query = new \WP_Query( array(
			'post_type'      => 'udesly_cpt',
			'posts_per_page' => - 1
		) );

		if ( ! count( $post_types_query->posts ) ) {
			return;
		}

		$args = array(
			'id'     => 'cpt-menus',     // id of the existing child node (New > Post)
			'title'  => __( 'View Custom Types' ), // alter the title of existing node
			'parent' => 'site-name',          // set parent to false to make it a top level (parent) node
		);
		$wp_admin_bar->add_node( $args );

		foreach ( $post_types_query->posts as $cpt ) {
			$args = array(
				'id'     => 'cpt-menu-' . $cpt->post_name,     // id of the existing child node (New > Post)
				'title'  => __( 'View all' ) . ' ' . $cpt->post_title, // alter the title of existing node
				'parent' => 'cpt-menus',          // set parent to false to make it a top level (parent) node
				'href'   => udesly_get_custom_post_type_archive_link( $cpt->post_name ),
			);
			$wp_admin_bar->add_node( $args );
		}
	}

	public function custom_posts_per_page( $query ) {

		if ( is_admin() ) {
			return;
		} else if ( $query->is_main_query() && isset(get_queried_object()->name)) {
			$post_type = get_queried_object()->name;
			if( !is_post_type_archive( $post_type ) ) {
				return;
			}
			$cpt            = udesly_get_post_by_slug( $post_type, OBJECT, 'udesly_cpt' );

			if(is_null($cpt))
				return;

			$posts_per_page = get_post_meta( $cpt->ID, 'udesly_cpt_posts_per_page', true );
			if ( ! empty( $posts_per_page ) ) {
				$query->set( 'posts_per_page', intval( $posts_per_page ) );
			}
		}
	}

	public function apply_excerpt_length( $length ) {
		global $post_type;

		$cpt = udesly_get_post_by_slug( $post_type, OBJECT, 'udesly_cpt' );
		if ( is_null( $cpt ) ) {
			return $length;
		}
		$excerpt_length = get_post_meta( $cpt->ID, 'udesly_cpt_excerpt_length', true );
		if ( empty( $excerpt_length ) ) {
			$excerpt_length = 20;
		}

		return $excerpt_length;
	}

	public function apply_excerpt_more( $more ) {
		global $post_type;

		$cpt = udesly_get_post_by_slug( $post_type, OBJECT, 'udesly_cpt' );
		if ( is_null( $cpt ) ) {
			return $more;
		}
		$excerpt_more = get_post_meta( $cpt->ID, 'udesly_cpt_excerpt_more', true );
		if ( empty( $excerpt_more ) ) {
			$excerpt_more = '...';
		}

		return $excerpt_more;
	}

	public function create_custom_type_post_type() {

		register_post_type( $this->post_type_name,
			array(
				'labels'              => array(
					'name'          => __( 'Custom Types', i18n::$textdomain ),
					'singular_name' => __( 'Custom Type', i18n::$textdomain )
				),
				'public'              => false,
				'show_ui'             => true, // it's not public, it shouldn't have it's own permalink, and so on
				'publicly_queryable'  => false,
				'has_archive'         => false,
				'menu_icon'           => '',
				'exclude_from_search' => true,
				'show_in_nav_menus'   => false,
				'supports'            => array( 'title' ),
				'show_in_menu'        => Udy_Wf_To_Wp::$menu_slug,
				'rewrite'             => false,
			)
		);

	}

	public function save_meta_box( $post_id ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( isset( $_POST['udesly_cpt_single_name'] ) ) {
			update_post_meta( $post_id, 'udesly_cpt_single_name', sanitize_text_field( $_POST['udesly_cpt_single_name'] ) );
		}
		if ( isset( $_POST['udesly_cpt_plural_name'] ) ) {
			update_post_meta( $post_id, 'udesly_cpt_plural_name', sanitize_text_field( $_POST['udesly_cpt_plural_name'] ) );
		}
		if ( isset( $_POST['udesly_cpt_archive_rewrite'] ) ) {
			update_post_meta( $post_id, 'udesly_cpt_archive_rewrite', sanitize_title( $_POST['udesly_cpt_archive_rewrite'] ) );
		}
		if ( isset( $_POST['udesly_cpt_icon'] ) ) {
			update_post_meta( $post_id, 'udesly_cpt_icon', sanitize_text_field( $_POST['udesly_cpt_icon'] ) );
		}
		if ( isset( $_POST['udesly_cpt_excerpt_length'] ) ) {
			update_post_meta( $post_id, 'udesly_cpt_excerpt_length', (int) sanitize_text_field( $_POST['udesly_cpt_excerpt_length'] ) );
		}
		if ( isset( $_POST['udesly_cpt_excerpt_more'] ) ) {
			update_post_meta( $post_id, 'udesly_cpt_excerpt_more', sanitize_text_field( $_POST['udesly_cpt_excerpt_more'] ) );
		}
		if ( isset( $_POST['udesly_cpt_taxonomies'] ) ) {
			update_post_meta( $post_id, 'udesly_cpt_taxonomies', strtolower( sanitize_text_field( $_POST['udesly_cpt_taxonomies'] ) ) );
		}
		if ( isset( $_POST['udesly_cpt_posts_per_page'] ) ) {
			update_post_meta( $post_id, 'udesly_cpt_posts_per_page', (int) sanitize_text_field( $_POST['udesly_cpt_posts_per_page'] ) );
		}


		set_transient( 'udesly_should_rewrite', true );
	}

	public function add_cpt_meta_box( $post ) {

		add_meta_box(
			'add_cpt_meta_box',
			__( 'Settings', i18n::$textdomain ),
			array( self::class, 'create_meta_box' ),
			$this->post_type_name,
			'normal',
			'default',
			array(
				'post' => $post
			)
		);

	}

	public static function create_meta_box( $post ) {
		$form = new Form();
		$form->add_text( 'udesly_cpt_single_name', 'udesly_cpt_single_name', 'Single Type Name', '', get_post_meta( $post->ID, 'udesly_cpt_single_name', true ), '', true );
		$form->add_break_line();
		$form->add_text( 'udesly_cpt_plural_name', 'udesly_cpt_plural_name', 'Plural Type Name', '', get_post_meta( $post->ID, 'udesly_cpt_plural_name', true ), '', true );
		$form->add_break_line();
		$form->add_text( 'udesly_cpt_archive_rewrite', 'udesly_cpt_archive_rewrite', 'Archive Rewrite Permalink', '', get_post_meta( $post->ID, 'udesly_cpt_archive_rewrite', true ), '', true );
		$form->add_break_line();

		$options = array(
			'dashicons-menu'                    => 'menu',
			'dashicons-admin-site'              => 'site',
			'dashicons-dashboard'               => 'dashboard',
			'dashicons-admin-post'              => 'post',
			'dashicons-admin-media'             => 'media',
			'dashicons-admin-links'             => 'links',
			'dashicons-admin-page'              => 'page',
			'dashicons-admin-comments'          => 'comments',
			'dashicons-admin-appearance'        => 'appearance',
			'dashicons-admin-plugins'           => 'plugins',
			'dashicons-admin-users'             => 'users',
			'dashicons-admin-tools'             => 'tools',
			'dashicons-admin-settings'          => 'settings',
			'dashicons-admin-network'           => 'network',
			'dashicons-admin-home'              => 'home',
			'dashicons-admin-generic'           => 'generic',
			'dashicons-admin-collapse'          => 'collapse',
			'dashicons-filter'                  => 'filter',
			'dashicons-admin-customizer'        => 'customizer',
			'dashicons-admin-multisite'         => 'multisite',
			'dashicons-welcome-write-blog'      => 'write blog',
			'dashicons-welcome-add-page'        => 'add page',
			'dashicons-welcome-view-site'       => 'view site',
			'dashicons-welcome-widgets-menus'   => 'widgets and menus',
			'dashicons-welcome-comments'        => 'comments',
			'dashicons-welcome-learn-more'      => 'learn more',
			'dashicons-format-aside'            => 'aside',
			'dashicons-format-image'            => 'image',
			'dashicons-format-gallery'          => 'gallery',
			'dashicons-format-video'            => 'video',
			'dashicons-format-status'           => 'status',
			'dashicons-format-quote'            => 'quote',
			'dashicons-format-chat'             => 'chat',
			'dashicons-format-audio'            => 'audio',
			'dashicons-camera'                  => 'camera',
			'dashicons-images-alt'              => 'images (alt)',
			'dashicons-images-alt2'             => 'images (alt 2)',
			'dashicons-video-alt'               => 'video (alt)',
			'dashicons-video-alt2'              => 'video (alt 2)',
			'dashicons-video-alt3'              => 'video (alt 3)',
			'dashicons-media-archive'           => 'archive',
			'dashicons-media-audio'             => 'audio',
			'dashicons-media-code'              => 'code',
			'dashicons-media-default'           => 'default',
			'dashicons-media-document'          => 'document',
			'dashicons-media-interactive'       => 'interactive',
			'dashicons-media-spreadsheet'       => 'spreadsheet',
			'dashicons-media-text'              => 'text',
			'dashicons-media-video'             => 'video',
			'dashicons-playlist-audio'          => 'audio playlist',
			'dashicons-playlist-video'          => 'video playlist',
			'dashicons-controls-play'           => 'play player',
			'dashicons-controls-pause'          => 'player pause',
			'dashicons-controls-forward'        => 'player forward',
			'dashicons-controls-skipforward'    => 'player skip forward',
			'dashicons-controls-back'           => 'player back',
			'dashicons-controls-skipback'       => 'player skip back',
			'dashicons-controls-repeat'         => 'player repeat',
			'dashicons-controls-volumeon'       => 'player volume on',
			'dashicons-controls-volumeoff'      => 'player volume off',
			'dashicons-image-crop'              => 'crop',
			'dashicons-image-rotate'            => 'rotate',
			'dashicons-image-rotate-left'       => 'rotate left',
			'dashicons-image-rotate-right'      => 'rotate right',
			'dashicons-image-flip-vertical'     => 'flip vertical',
			'dashicons-image-flip-horizontal'   => 'flip horizontal',
			'dashicons-image-filter'            => 'filter',
			'dashicons-undo'                    => 'undo',
			'dashicons-redo'                    => 'redo',
			'dashicons-editor-bold'             => 'bold',
			'dashicons-editor-italic'           => 'italic',
			'dashicons-editor-ul'               => 'ul',
			'dashicons-editor-ol'               => 'ol',
			'dashicons-editor-quote'            => 'quote',
			'dashicons-editor-alignleft'        => 'alignleft',
			'dashicons-editor-aligncenter'      => 'aligncenter',
			'dashicons-editor-alignright'       => 'alignright',
			'dashicons-editor-insertmore'       => 'insertmore',
			'dashicons-editor-spellcheck'       => 'spellcheck',
			'dashicons-editor-expand'           => 'expand',
			'dashicons-editor-contract'         => 'contract',
			'dashicons-editor-kitchensink'      => 'kitchen sink',
			'dashicons-editor-underline'        => 'underline',
			'dashicons-editor-justify'          => 'justify',
			'dashicons-editor-textcolor'        => 'textcolor',
			'dashicons-editor-paste-word'       => 'paste',
			'dashicons-editor-paste-text'       => 'paste',
			'dashicons-editor-removeformatting' => 'remove formatting',
			'dashicons-editor-video'            => 'video',
			'dashicons-editor-customchar'       => 'custom character',
			'dashicons-editor-outdent'          => 'outdent',
			'dashicons-editor-indent'           => 'indent',
			'dashicons-editor-help'             => 'help',
			'dashicons-editor-strikethrough'    => 'strikethrough',
			'dashicons-editor-unlink'           => 'unlink',
			'dashicons-editor-rtl'              => 'rtl',
			'dashicons-editor-break'            => 'break',
			'dashicons-editor-code'             => 'code',
			'dashicons-editor-paragraph'        => 'paragraph',
			'dashicons-editor-table'            => 'table',
			'dashicons-align-left'              => 'align left',
			'dashicons-align-right'             => 'align right',
			'dashicons-align-center'            => 'align center',
			'dashicons-align-none'              => 'align none',
			'dashicons-lock'                    => 'lock',
			'dashicons-unlock'                  => 'unlock',
			'dashicons-calendar'                => 'calendar',
			'dashicons-calendar-alt'            => 'calendar',
			'dashicons-visibility'              => 'visibility',
			'dashicons-hidden'                  => 'hidden',
			'dashicons-post-status'             => 'post status',
			'dashicons-edit'                    => 'edit pencil',
			'dashicons-trash'                   => 'trash remove delete',
			'dashicons-sticky'                  => 'sticky',
			'dashicons-external'                => 'external',
			'dashicons-arrow-up'                => 'arrow-up',
			'dashicons-arrow-down'              => 'arrow-down',
			'dashicons-arrow-right'             => 'arrow-right',
			'dashicons-arrow-left'              => 'arrow-left',
			'dashicons-arrow-up-alt'            => 'arrow-up',
			'dashicons-arrow-down-alt'          => 'arrow-down',
			'dashicons-arrow-right-alt'         => 'arrow-right',
			'dashicons-arrow-left-alt'          => 'arrow-left',
			'dashicons-arrow-up-alt2'           => 'arrow-up',
			'dashicons-arrow-down-alt2'         => 'arrow-down',
			'dashicons-arrow-right-alt2'        => 'arrow-right',
			'dashicons-arrow-left-alt2'         => 'arrow-left',
			'dashicons-sort'                    => 'sort',
			'dashicons-leftright'               => 'left right',
			'dashicons-randomize'               => 'randomize shuffle',
			'dashicons-list-view'               => 'list view',
			'dashicons-exerpt-view'             => 'exerpt view',
			'dashicons-grid-view'               => 'grid view',
			'dashicons-move'                    => 'move',
			'dashicons-share'                   => 'share',
			'dashicons-share-alt'               => 'share',
			'dashicons-share-alt2'              => 'share',
			'dashicons-twitter'                 => 'twitter social',
			'dashicons-rss'                     => 'rss',
			'dashicons-email'                   => 'email',
			'dashicons-email-alt'               => 'email',
			'dashicons-facebook'                => 'facebook social',
			'dashicons-facebook-alt'            => 'facebook social',
			'dashicons-googleplus'              => 'googleplus social',
			'dashicons-networking'              => 'networking social',
			'dashicons-hammer'                  => 'hammer development',
			'dashicons-art'                     => 'art design',
			'dashicons-migrate'                 => 'migrate migration',
			'dashicons-performance'             => 'performance',
			'dashicons-universal-access'        => 'universal access accessibility',
			'dashicons-universal-access-alt'    => 'universal access accessibility',
			'dashicons-tickets'                 => 'tickets',
			'dashicons-nametag'                 => 'nametag',
			'dashicons-clipboard'               => 'clipboard',
			'dashicons-heart'                   => 'heart',
			'dashicons-megaphone'               => 'megaphone',
			'dashicons-schedule'                => 'schedule',
			'dashicons-wordpress'               => 'wordpress',
			'dashicons-wordpress-alt'           => 'wordpress',
			'dashicons-pressthis'               => 'press this',
			'dashicons-update'                  => 'update',
			'dashicons-screenoptions'           => 'screenoptions',
			'dashicons-info'                    => 'info',
			'dashicons-cart'                    => 'cart shopping',
			'dashicons-feedback'                => 'feedback form',
			'dashicons-cloud'                   => 'cloud',
			'dashicons-translation'             => 'translation language',
			'dashicons-tag'                     => 'tag',
			'dashicons-category'                => 'category',
			'dashicons-archive'                 => 'archive',
			'dashicons-tagcloud'                => 'tagcloud',
			'dashicons-text'                    => 'text',
			'dashicons-yes'                     => 'yes check checkmark',
			'dashicons-no'                      => 'no x',
			'dashicons-no-alt'                  => 'no x',
			'dashicons-plus'                    => 'plus add increase',
			'dashicons-plus-alt'                => 'plus add increase',
			'dashicons-minus'                   => 'minus decrease',
			'dashicons-dismiss'                 => 'dismiss',
			'dashicons-marker'                  => 'marker',
			'dashicons-star-filled'             => 'filled star',
			'dashicons-star-half'               => 'half star',
			'dashicons-star-empty'              => 'empty star',
			'dashicons-flag'                    => 'flag',
			'dashicons-warning'                 => 'warning',
			'dashicons-location'                => 'location pin',
			'dashicons-location-alt'            => 'location',
			'dashicons-vault'                   => 'vault safe',
			'dashicons-shield'                  => 'shield',
			'dashicons-shield-alt'              => 'shield',
			'dashicons-sos'                     => 'sos help',
			'dashicons-search'                  => 'search',
			'dashicons-slides'                  => 'slides',
			'dashicons-analytics'               => 'analytics',
			'dashicons-chart-pie'               => 'pie chart',
			'dashicons-chart-bar'               => 'bar chart',
			'dashicons-chart-line'              => 'line chart',
			'dashicons-chart-area'              => 'area chart',
			'dashicons-groups'                  => 'groups',
			'dashicons-businessman'             => 'businessman',
			'dashicons-id'                      => 'id',
			'dashicons-id-alt'                  => 'id',
			'dashicons-products'                => 'products',
			'dashicons-awards'                  => 'awards',
			'dashicons-forms'                   => 'forms',
			'dashicons-testimonial'             => 'testimonial',
			'dashicons-portfolio'               => 'portfolio',
			'dashicons-book'                    => 'book',
			'dashicons-book-alt'                => 'book',
			'dashicons-download'                => 'download',
			'dashicons-upload'                  => 'upload',
			'dashicons-backup'                  => 'backup',
			'dashicons-clock'                   => 'clock',
			'dashicons-lightbulb'               => 'lightbulb',
			'dashicons-microphone'              => 'microphone mic',
			'dashicons-desktop'                 => 'desktop monitor',
			'dashicons-laptop'                  => 'laptop',
			'dashicons-tablet'                  => 'tablet ipad',
			'dashicons-smartphone'              => 'smartphone iphone',
			'dashicons-phone'                   => 'phone',
			'dashicons-index-card'              => 'index card',
			'dashicons-carrot'                  => 'carrot food vendor',
			'dashicons-building'                => 'building',
			'dashicons-store'                   => 'store',
			'dashicons-album'                   => 'album',
			'dashicons-palmtree'                => 'palm tree',
			'dashicons-tickets-alt'             => 'tickets (alt)',
			'dashicons-money'                   => 'money',
			'dashicons-smiley'                  => 'smiley smile',
			'dashicons-thumbs-up'               => 'thumbs up',
			'dashicons-thumbs-down'             => 'thumbs down',
			'dashicons-layout'                  => 'layout',
			'dashicons-paperclip'               => 'paperclip',
		);
		$form->add_select( 'udesly_cpt_icon', 'udesly_cpt_icon', 'Icon', $options, get_post_meta( $post->ID, 'udesly_cpt_icon', true ) );
		$form->add_break_line();

		$excerpt_length = get_post_meta( $post->ID, 'udesly_cpt_excerpt_length', true );
		if ( empty( $excerpt_length ) ) {
			$excerpt_length = 20;
		}
		$excerpt_more = get_post_meta( $post->ID, 'udesly_cpt_excerpt_more', true );
		if ( empty( $excerpt_more ) ) {
			$excerpt_more = '...';
		}
		$form->add_title( 'Excerpt Settings' );
		$form->add_number( 'udesly_cpt_excerpt_length', 'udesly_cpt_excerpt_length', 'Excerpt Length', '', $excerpt_length, 0, 100 );
		$form->add_text( 'udesly_cpt_excerpt_more', 'udesly_cpt_excerpt_more', 'Excerpt More', '', $excerpt_more, '', true );
		$form->add_break_line();

		$form->add_title( 'Taxonomies' );
		$form->add_text( 'udesly_cpt_taxonomies', 'udesly_cpt_taxonomies', 'Taxonomies', '', get_post_meta( $post->ID, 'udesly_cpt_taxonomies', true ), 'Separate taxonomies by comma', false );
		$form->add_break_line();

		$form->add_title( 'Archive Settings' );
		$form->add_number( 'udesly_cpt_posts_per_page', 'udesly_cpt_posts_per_page', 'Posts per page', '', get_post_meta( $post->ID, 'udesly_cpt_posts_per_page', true ), 1, 100 );


		$tabs = new Tabs();
		$tabs->add_tab( __( 'Settings', i18n::$textdomain ), 'settings', $form->get_form( false ), Icon::faIcon( 'cog', true, Icon_Type::SOLID() ), 1 );
		$tabs->show_tabs();
	}

	public function change_post_type_labels() {
		global $wp_post_types;

		// Get the post labels
		$postLabels                     = $wp_post_types['udesly_cpt']->labels;
		$postLabels->name               = __( 'Custom Types', i18n::$textdomain );
		$postLabels->singular_name      = __( 'Custom Type', i18n::$textdomain );
		$postLabels->add_new            = __( 'Add New Custom Type', i18n::$textdomain );
		$postLabels->add_new_item       = __( 'Add Custom Type', i18n::$textdomain );
		$postLabels->edit_item          = __( 'Edit Custom Types', i18n::$textdomain );
		$postLabels->new_item           = __( 'Custom Types', i18n::$textdomain );
		$postLabels->view_item          = __( 'View Custom Type', i18n::$textdomain );
		$postLabels->search_items       = __( 'Search Custom Types', i18n::$textdomain );
		$postLabels->not_found          = __( 'No Custom Types found', i18n::$textdomain );
		$postLabels->not_found_in_trash = __( 'No Custom Types found in Trash', i18n::$textdomain );

	}

	public static function change_columns( $cols ) {
		$cols = array(
			'cb'    => '<input type="checkbox" />',
			'title' => __( 'Title', i18n::$textdomain ),
			'slug'  => __( 'Slug', i18n::$textdomain ),
		);

		return $cols;
	}

	public static function custom_columns( $column, $post_id ) {

		$post_type = get_post( $post_id );

		switch ( $column ) {
			case "slug":
				echo $post_type->post_name;
				break;
		}
	}

	private function get_registered_cpts(){

		$cpts = array();

		$post_types_query = new \WP_Query( array(
			'post_type'      => 'udesly_cpt',
			'posts_per_page' => - 1
		) );

		foreach ( $post_types_query->posts as $post ) {
			$cpts[] = $post->post_name;
		}

		return $cpts;
	}

	public function cpt_taxonomy_archive($template){
		global $post;

		if(!$post){
			return $template;
		}

		$current_post_type = $post->post_type;
		$registered_cpts = $this->get_registered_cpts();

		if(in_array($current_post_type, $registered_cpts) &&
		   isset(get_queried_object()->taxonomy) &&
		   taxonomy_exists(get_queried_object()->taxonomy) &&
		   file_exists(get_template_directory(). '/archive-' . $current_post_type . '.php' )){

			$new_template = locate_template( array( 'archive-' . $current_post_type . '.php' ) );
			if ( !empty( $new_template ) ) {
				return $new_template;
			}
		}

		return $template;

	}

//	public function cpt_single_page($template){
//		global $post;
//
//		$current_post_type = $post->post_type;
//		$registered_cpts = $this->get_registered_cpts();
//
//		if(in_array($current_post_type, $registered_cpts) &&
//		   is_single($post->ID) &&
//		   file_exists(get_template_directory(). '/single-' . $current_post_type . '.php' )){
//
//			$new_template = locate_template( array( 'single-' . $current_post_type . '.php' ) );
//			if ( !empty( $new_template ) ) {
//				return $new_template;
//			}
//		}
//
//		return $template;
//
//	}

}