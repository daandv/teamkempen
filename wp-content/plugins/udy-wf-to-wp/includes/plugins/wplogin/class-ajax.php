<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 28/03/2018
 * Time: 18:25
 */

namespace UdyWfToWp\Plugins\WpLogin;

use UdyWfToWp\Plugins\ContentManager\Settings\Settings_Manager;
use UdyWfToWp\Utils\Utils;

class Ajax {

	public static $assets_folder_url = UDY_WF_TO_WP_PLUGIN_DIRECTORY_URL . 'includes/plugins/wplogin/assets';

	/**
	 * Enqueue wplogin plugin scripts and styles.
	 */
	public static function ajax_login_scripts() {
		wp_enqueue_script( 'ajax-login', self::$assets_folder_url . '/js/ajax-login.js', array(), Utils::getPluginVersion(), true );
		wp_localize_script( 'ajax-login', 'ajax_login_object', array(
			'ajaxurl'     => admin_url( 'admin-ajax.php' ),
			'redirecturl' => home_url(),
		) );
	}

	public static function ajax_login_style() {
		wp_enqueue_style( 'udesly-wplogin-css', self::$assets_folder_url . '/css/udesly-wplogin.css', '', Utils::getPluginVersion() );
	}

	public static function ajaxlogin() {
		// First check the nonce, if it fails the function will break
		check_ajax_referer( 'ajax-login-nonce', 'security' );

		// Nonce is checked, get the POST data and sign user on
		$info                  = array();
		$info['user_login']    = sanitize_text_field($_POST['username']);
		$info['user_password'] = sanitize_text_field($_POST['password']);
		$info['remember']      = $_POST['rememberme'] ? true : false;

		$user_signon = wp_signon( $info, false );
		if ( is_wp_error( $user_signon ) ) {
			echo json_encode( array( 'loggedin' => false, 'message' => $user_signon->get_error_message() ) );
		} else {
			echo json_encode( array( 'loggedin' => true ) );
		}

		wp_die();
	}

	public static function lost_password() {
		global $wpdb, $wp_hasher;

		check_ajax_referer( 'ajax-lost-password-nonce', 'security' );

		$user_login = sanitize_text_field( $_POST['user_login'] );

		$errors = new \WP_Error();

		if ( empty( $user_login ) ) {
			$errors->add( 'empty_username', __( 'Enter a username or e-mail address.' ) );
		} else if ( strpos( $user_login, '@' ) ) {
			$user_data = get_user_by( 'email', trim( $user_login ) );
			if ( empty( $user_data ) ) {
				$errors->add( 'invalid_email', __( 'There is no user registered with that email address.' ) );
			}
		} else {
			$login     = trim( $user_login );
			$user_data = get_user_by( 'login', $login );
		}

		do_action( 'lostpassword_post', $errors );

		if ( $errors->get_error_code() ) {
			echo json_encode( array( 'error' => true, 'errormessage' => $errors->get_error_message() ) );
			wp_die();
		}

		if ( ! $user_data ) {
			$errors->add( 'invalidcombo', __( 'Invalid username or email.' ) );
			echo json_encode( array( 'error' => true, 'errormessage' => $errors->get_error_message() ) );
			wp_die();
		}

		// Redefining user_login ensures we return the right case in the email.
		$user_login = $user_data->user_login;
		$user_email = $user_data->user_email;
		$key        = get_password_reset_key( $user_data );

		if ( is_wp_error( $key ) ) {
			echo json_encode( array( 'error' => true, 'errormessage' => $key->get_error_message() ) );
			wp_die();
		}

		$message = __( 'Someone requested that the password be reset for the following account:' ) . "\r\n\r\n";
		$message .= network_home_url( '/' ) . "\r\n\r\n";
		$message .= sprintf( __( 'Username: %s' ), $user_login ) . "\r\n\r\n";
		$message .= __( 'If this was a mistake, just ignore this email and nothing will happen.' ) . "\r\n\r\n";
		$message .= __( 'To reset your password, visit the following address:' ) . "\r\n\r\n";

		$message .= esc_url_raw( udesly_get_permalink_by_slug( $_POST['page_slug'] ) . "?action=rp&key=$key&login=" . urlencode( $user_login ) ) . "\r\n";

		if ( is_multisite() ) {
			$blogname = $GLOBALS['current_site']->site_name;
		} else /*
			 * The blogname option is escaped with esc_html on the way into the database
			 * in sanitize_option we want to reverse this for the plain text arena of emails.
			 */ {
			$blogname = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
		}

		$title = sprintf( __( '%s - Password Reset' ), $blogname );
		$title = apply_filters( 'retrieve_password_title', $title, $user_login, $user_data );

		$message = apply_filters( 'retrieve_password_message', $message, $key, $user_login, $user_data );

		if ( wp_mail( $user_email, wp_specialchars_decode( $title ), $message ) ) {
			echo json_encode( array( 'error' => false ) );
			wp_die();
		} else {
			$errors->add( 'could_not_sent', __( 'The e-mail could not be sent.' ), 'message' );
		}


		// display error message
		if ( $errors->get_error_code() ) {
			echo json_encode( array( 'error' => true, 'errormessage' => $errors->get_error_message() ) );
			wp_die();
		}

		// return proper result
		wp_die();
	}

public static function reset_password() {

		$errors = new \WP_Error();


		check_ajax_referer( 'ajax-reset-password-nonce', 'security' );

		$pass1 	= sanitize_text_field($_POST['password']);
		$pass2 	= sanitize_text_field($_POST['password_repeat']);
		$key 	= sanitize_text_field($_POST['user_key']);
		$login 	= sanitize_text_field($_POST['user_login']);

		$user = check_password_reset_key( $key, $login );

		// check to see if user added some string
		if( empty( $pass1 ) || empty( $pass2 ) )
			$errors->add( 'password_required', __( 'Password is required field' ) );

		// is pass1 and pass2 match?
		if ( isset( $pass1 ) && $pass1 != $pass2 )
			$errors->add( 'password_reset_mismatch', __( 'The passwords do not match.' ) );

		// is pass too short?
		if ( isset( $pass1 ) && $pass1 == $pass2 && strlen($pass1) < 6)
			$errors->add( 'password_too_short', __( 'The passwords is too short, min. 6 characters.' ) );

		do_action( 'validate_password_reset', $errors, $user );

		if ( ( ! $errors->get_error_code() ) && isset( $pass1 ) && !empty( $pass1 ) ) {
			reset_password($user, $pass1);
			echo json_encode( array( 'error' => false ) );
			wp_die();
		}

		// display error message
		if ( $errors->get_error_code() )  {
			echo json_encode( array( 'error' => true, 'errormessage' => $errors->get_error_message() ) );
			wp_die();
		}
		echo json_encode( array( 'error' => false ) );
		wp_die();
	}

	public static function register_user() {

		// Verify nonce
		check_ajax_referer( 'ajax-register-nonce', 'security' );

		if ( !get_option( 'users_can_register' ) ) {
			echo json_encode( array( 'status' => false, 'message' => __( 'Sorry, registration is not currently allowed' ) ) );
			wp_die();
		}

		if ( ! isset( $_POST['mail'] ) ) {
			echo json_encode( array( 'status' => false, 'message' => 'Mail not set' ) );
			wp_die();
		}
		// Post values
		$username  = sanitize_text_field($_POST['username']);
		$password  = sanitize_text_field($_POST['password']);
		$password_confirm  = sanitize_text_field($_POST['password_repeat']);
		$email     = sanitize_email($_POST['mail']);
		$name      = sanitize_text_field($_POST['first_name']);
		$last_name = sanitize_text_field($_POST['last_name']);


		$userdata = array(
			'user_login' => $username,
			'user_pass'  => $password,
			'user_email' => $email,
			'first_name' => $name,
			'last_name'  => $last_name,
		);


		// check to see if user added some string
		if( empty( $password ) || empty( $password_confirm ) ) {
			echo json_encode( array( 'status' => false, 'message' => __( 'Password is required field' ) ) );
			wp_die();
		}

		// is pass1 and pass2 match?
		if ( isset( $password ) && $password != $password_confirm ) {
			echo json_encode( array( 'status' => false, 'message' => __( 'The passwords do not match.' ) ) );
			wp_die();
		}

		// is pass too short?
		if ( isset( $password ) && $password == $password_confirm && strlen($password) < 6) {
			echo json_encode( array( 'status' => false, 'message' => __( 'The passwords is too short, min. 6 characters.' ) ) );
			wp_die();
		}

		$user_id = wp_insert_user( $userdata );

		// Return
		if ( ! is_wp_error( $user_id ) ) {
			echo json_encode( array( 'status' => true ) );

			$info                  = array();
			$info['user_login']    = $username;
			$info['user_password'] = $password;
			$info['remember']      = true;

			wp_signon( $info, false );

			do_action('udesly_wp_registration_success', $user_id);

		} else {
			echo json_encode( array( 'status' => false, 'message' => $user_id->get_error_message() ) );
		}
		wp_die();

	}

	public function send_register_email($user_id){
		$settings = Settings_Manager::get_saved_settings();

		if(!isset($settings['welcome_email_status']))
			return;

		if(isset($settings['welcome_email_status']) && $settings['welcome_email_status'] == 0)
			return;

		$user = get_user_by('ID', $user_id);

		$settings['welcome_email_subject'] = str_replace('{{username}}', $user->user_nicename, $settings['welcome_email_subject']);
		$settings['welcome_email_subject'] = str_replace('{{site_title}}', get_option('blogname'), $settings['welcome_email_subject']);
		$settings['welcome_email_subject'] = str_replace('{{first_name}}', $user->first_name, $settings['welcome_email_subject']);
		$settings['welcome_email_subject'] = str_replace('{{last_name}}', $user->last_name, $settings['welcome_email_subject']);
		$settings['welcome_email_subject'] = str_replace('{{site_link}}', '<a href="'.get_option('siteurl').'">'.get_option('blogname').'</a>', $settings['welcome_email_subject']);

		$settings['welcome_email_message'] = str_replace('{{username}}', $user->user_nicename, $settings['welcome_email_message']);
		$settings['welcome_email_message'] = str_replace('{{site_title}}', get_option('blogname'), $settings['welcome_email_message']);
		$settings['welcome_email_message'] = str_replace('{{first_name}}', $user->first_name, $settings['welcome_email_message']);
		$settings['welcome_email_message'] = str_replace('{{last_name}}', $user->last_name, $settings['welcome_email_message']);
		$settings['welcome_email_message'] = str_replace('{{site_link}}', '<a href="'.get_option('siteurl').'">'.get_option('blogname').'</a>', $settings['welcome_email_message']);

		wp_mail($user->user_email, $settings['welcome_email_subject'], $settings['welcome_email_message']);
	}

}