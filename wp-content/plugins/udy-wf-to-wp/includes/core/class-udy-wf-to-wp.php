<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.udesly.com
 * @since      1.0.0
 *
 * @package    Udy_Wf_To_Wp
 * @subpackage Udy_Wf_To_Wp/includes
 */

namespace UdyWfToWp\Core;

use UdyWfToWp\i18n\i18n;
use UdyWfToWp\Ui\Ui_Assets;
use UdyWfToWp\Utils\Utils;
use UdyWfToWp\Core\Udy_Wf_To_Wp_Loader;
use UdyWfToWp\Core\Udy_Wf_To_Wp_i18n;

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Udy_Wf_To_Wp
 * @subpackage Udy_Wf_To_Wp/includes
 * @author     Udesly <info@udesly.com>
 */
class Udy_Wf_To_Wp {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Udy_Wf_To_Wp_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */

	public static $menu_slug = 'udesly_main_menu';

	public function __construct() {
		if ( defined( 'UDESLY_PLUGIN_NAME_VERSION' ) ) {
			$this->version = UDESLY_PLUGIN_NAME_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'udy-wf-to-wp';

		$this->load_dependencies();
		$this->set_locale();
		$this->create_plugin_menu();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Udy_Wf_To_Wp_Loader. Orchestrates the hooks of the plugin.
	 * - Udy_Wf_To_Wp_i18n. Defines internationalization functionality.
	 * - Udy_Wf_To_Wp_Admin. Defines all hooks for the admin area.
	 * - Udy_Wf_To_Wp_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		//require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-udy-wf-to-wp-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		//require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-udy-wf-to-wp-i18n.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . '../vendor/autoload.php';

		$this->loader = new Udy_Wf_To_Wp_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Udy_Wf_To_Wp_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		foreach ( Utils::getIPluginsClasses() as $class ) {
			$class::define_admin_hooks( $this->loader );
		}

		$this->loader->add_action('admin_enqueue_scripts', Ui_Assets::class, 'add_ui_styles');
		$this->loader->add_action('admin_enqueue_scripts', Ui_Assets::class, 'add_ui_scripts');

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$this->loader->add_action('wp_enqueue_scripts', Ui_Assets::class, 'add_frontend_ui_styles');

		foreach ( Utils::getIPluginsClasses() as $class ) {
			$class::define_public_hooks( $this->loader );
		}

	}

	private function create_plugin_menu(){

		$this->loader->add_action('admin_menu', $this, 'add_plugin_menu');

	}

	public function add_plugin_menu(){
		if(current_user_can('manage_options')) {
			add_menu_page( __( 'Udesly', i18n::$textdomain ), __( 'Udesly', i18n::$textdomain ), 'manage_options', self::$menu_slug, '', '', '66' );
		}
	}


	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Udy_Wf_To_Wp_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
