<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 23/04/2018
 * Time: 17:45
 */

namespace UdyWfToWp\Plugins\Form;

use UdyWfToWp\i18n\i18n;
use UdyWfToWp\Plugins\ContentManager\Settings\Settings_Manager;
use UdyWfToWp\Utils\Utils;

class Ajax {

	public static $assets_folder_url = UDY_WF_TO_WP_PLUGIN_DIRECTORY_URL . 'includes/plugins/form/assets';

	/**
	 * Enqueue wplogin plugin scripts and styles.
	 */
	public static function ajax_login_scripts() {
		wp_enqueue_script( 'ajax-udesly-form', self::$assets_folder_url . '/js/ajax-udesly-form.js', array(), Utils::getPluginVersion(), true );
		wp_localize_script( 'ajax-udesly-form', 'ajax_form_object', array(
			'ajaxurl'     => admin_url( 'admin-ajax.php' ),
			'redirecturl' => home_url(),
		) );
	}

	public static function send_form() {

		if ( ! isset( $_POST['form_data'] ) ) {
			echo json_encode( array( 'form_sent' => false ) );
			wp_die();
		}

		$message = __( 'Someone sent a message from ', i18n::$textdomain )  . get_bloginfo( 'name' ) .  __( ':', i18n::$textdomain ) . "\r\n\r\n";

		$form_data = $_POST['form_data'];

		foreach ($form_data as $data){
			$message .= $data['name'] . ": " . $data['value'] . "\r\n";
		}

		$settings = Settings_Manager::get_saved_settings();
		if(isset($settings['email_recipient'])){
			$to = $settings['email_recipient'];
		}else{
			$to = get_bloginfo( "admin_email" );
		}

		if(isset($settings['email_cc'])){
			$headers = array();
			$headers[] = 'From: ' . get_bloginfo( "admin_email" );
			foreach (explode(',', $settings['email_cc']) as $email_cc) {
				$email_cc = trim($email_cc);
				$headers[] = 'Cc: ' . $email_cc;
			}
		}else{
			$headers = '';
		}

		if ( wp_mail( $to, __( "New message from ", i18n::$textdomain ) . get_bloginfo( 'name' ), $message, $headers ) ) {
			echo json_encode( array( 'form_sent' => true ) );
			wp_die();
		}

		echo json_encode( array( 'form_sent' => false ) );

		wp_die();
	}
}