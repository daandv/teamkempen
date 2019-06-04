<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 28/03/2018
 * Time: 17:39
 */

namespace UdyWfToWp\Plugins\Form;

use UdyWfToWp\Core\Udy_Wf_To_Wp_Loader;
use UdyWfToWp\Interfaces\iPlugin;

class Form implements iPlugin {
	public static function define_admin_hooks( Udy_Wf_To_Wp_Loader $loader ) {

	}

	public static function define_public_hooks( Udy_Wf_To_Wp_Loader $loader ) {
		$loader->add_action('wp_enqueue_scripts', Ajax::class, 'ajax_login_scripts');
		$loader->add_action('wp_ajax_nopriv_send_form', Ajax::class, 'send_form');
		$loader->add_action('wp_ajax_send_form', Ajax::class, 'send_form');
	}

	public static function activate() {

	}

	public static function deactivate() {

	}

}
