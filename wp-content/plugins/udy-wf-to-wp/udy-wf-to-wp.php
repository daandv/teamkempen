<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.udesly.com
 * @since             1.0.0
 * @package           Udy_Wf_To_Wp
 *
 * @wordpress-plugin
 * Plugin Name:       Udesly Adapter WordPress Plugin
 * Plugin URI:        https://www.udesly.com
 * Description:       This is a support plugin for Udesly (Webflow to WordPress converter) that allows you to enable additional features for your theme.
 * Version:           1.6.0
 * Author:            Udesly
 * Author URI:        https://www.udesly.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       udy-wf-to-wp
 * Domain Path:       /languages
 */

// MISC GLOBAL FUNCTIONS
require_once plugin_dir_path(__FILE__) . 'includes/misc/blog-functions.php';
require_once plugin_dir_path(__FILE__) . 'includes/misc/frontend-editor-functions.php';
require_once plugin_dir_path(__FILE__) . 'includes/misc/general-functions.php';
require_once plugin_dir_path(__FILE__) . 'includes/misc/query-builder-functions.php';
require_once plugin_dir_path(__FILE__) . 'includes/misc/login-functions.php';
require_once plugin_dir_path(__FILE__) . 'includes/misc/rule-functions.php';
require_once plugin_dir_path(__FILE__) . 'includes/misc/boxes-functions.php';
require_once plugin_dir_path(__FILE__) . 'includes/misc/social-share-functions.php';
require_once plugin_dir_path(__FILE__) . 'includes/misc/cpt-functions.php';
require_once plugin_dir_path(__FILE__) . 'includes/misc/woo-functions.php';
require_once plugin_dir_path(__FILE__) . 'includes/misc/strings-functions.php';

include_once(ABSPATH.'wp-admin/includes/plugin.php');
if(is_plugin_active('translatepress-multilingual/index.php')) {
	require_once plugin_dir_path( __FILE__ ) . 'includes/misc/translate-press-functions.php';
}

// If this file is called directly, abort.
use UdyWfToWp\Core\Udy_Wf_To_Wp;
use UdyWfToWp\Core\Udy_Wf_To_Wp_Activator;
use UdyWfToWp\Core\Udy_Wf_To_Wp_Deactivator;

if( version_compare(phpversion(), '5.6.0', '<') ){

	function udesly_requirement_error(){
		?>
		<div class="notice notice-error">
			<p><?php echo __( 'Your server not respect the <strong>Udesly minimum requirements</strong>, please use a PHP version at least 5.6.0.', 'udy-wf-to-wp' ) ?></p>
		</div>
		<?php
	}
	add_action('admin_notices', 'udesly_requirement_error');
	return;
}

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'UDESLY_PLUGIN_NAME_VERSION', '1.5.0' );
defined( 'UDY_WF_TO_WP_PLUGIN_DIRECTORY_PATH' ) ? : define( 'UDY_WF_TO_WP_PLUGIN_DIRECTORY_PATH', plugin_dir_path( __FILE__ ) );
defined( 'UDY_WF_TO_WP_PLUGIN_DIRECTORY_URL' ) ? : define( 'UDY_WF_TO_WP_PLUGIN_DIRECTORY_URL', plugin_dir_url( __FILE__ ) );

//Registers autoload function of classes
spl_autoload_register( '\udy_wf_to_wp_autoload' );

function udy_wf_to_wp_autoload( $class_name ) {
	/* Only autoload classes from this namespace */
	if ( false === strpos( $class_name, 'UdyWfToWp\\' ) ) {
		return;
	}

	/* Remove namespace from class name */
	$class_file = str_replace( 'UdyWfToWp' . '\\', '', $class_name );
	/* Convert class name format to file name format */
	$class_file = strtolower( $class_file );
	$class_file = str_replace( '_', '-', $class_file );
	/* Convert sub-namespaces into directories */
	$class_path = explode( '\\', $class_file );
	$class_file = array_pop( $class_path );
	$class_path = implode( '/', $class_path );
	/* Load the class */
	require_once __DIR__ . '/includes/' . $class_path . '/class-' . $class_file . '.php';

}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-udy-wf-to-wp-activator.php
 */
function activate_udy_wf_to_wp() {
	Udy_Wf_To_Wp_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-udy-wf-to-wp-deactivator.php
 */
function deactivate_udy_wf_to_wp() {
	Udy_Wf_To_Wp_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_udy_wf_to_wp' );
register_deactivation_hook( __FILE__, 'deactivate_udy_wf_to_wp' );

function udesly_edd_support(){
	if(is_plugin_active('easy-digital-downloads/easy-digital-downloads.php')) {

		require_once plugin_dir_path(__FILE__) . 'includes/misc/edd-functions.php';

		$saved_settings = get_option( 'udesly_settings' );
		if(isset($saved_settings['edd_slug'])) {
			defined( 'EDD_SLUG' ) ? : define( 'EDD_SLUG', $saved_settings['edd_slug'] );
		}
	}
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_udy_wf_to_wp() {

	$plugin = new Udy_Wf_To_Wp();
	$plugin->run();

	udesly_edd_support();
}
run_udy_wf_to_wp();


function benchmark( $test ) {
	$start_time = microtime(TRUE);

$test();
$end_time = microtime(TRUE);

echo $end_time - $start_time;
echo '<br/>';

}
