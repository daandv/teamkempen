<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 28/03/2018
 * Time: 17:39
 */

namespace UdyWfToWp\Plugins\WpLogin;

use UdyWfToWp\Core\Udy_Wf_To_Wp_Loader;
use UdyWfToWp\Interfaces\iPlugin;

class WpLogin implements iPlugin {
	public static function define_admin_hooks( Udy_Wf_To_Wp_Loader $loader ) {

	}

	public static function define_public_hooks( Udy_Wf_To_Wp_Loader $loader ) {
		$loader->add_action('wp_enqueue_scripts', Ajax::class, 'ajax_login_scripts');
		$loader->add_action('wp_enqueue_scripts', Ajax::class, 'ajax_login_style');
		$loader->add_action('wp_ajax_nopriv_ajaxlogin', Ajax::class, 'ajaxlogin');
		$loader->add_action('wp_ajax_ajaxlogin', Ajax::class, 'ajax_login_scripts');

		$loader->add_action('wp_ajax_register_user', Ajax::class, 'register_user');
		$loader->add_action('wp_ajax_nopriv_register_user', Ajax::class, 'register_user');
		$loader->add_action('wp_ajax_lost_password', Ajax::class, 'lost_password');
		$loader->add_action('wp_ajax_nopriv_lost_password', Ajax::class, 'lost_password');

		$loader->add_action('wp_ajax_reset_password', Ajax::class, 'reset_password');
		$loader->add_action('wp_ajax_nopriv_reset_password', Ajax::class, 'reset_password');

		$loader->add_action('udesly_wp_registration_success', Ajax::class, 'send_register_email');
	}

	public static function activate() {

	}

	public static function deactivate() {

	}

}
