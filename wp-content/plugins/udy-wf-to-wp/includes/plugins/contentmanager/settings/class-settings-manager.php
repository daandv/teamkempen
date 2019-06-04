<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 09/04/2018
 * Time: 13:15
 */

namespace UdyWfToWp\Plugins\ContentManager\Settings;

use UdyWfToWp\i18n\i18n;
use UdyWfToWp\Plugins\FrontendEditor\FrontendEditor_Assets;
use UdyWfToWp\Ui\Icon;
use UdyWfToWp\Ui\Icon_Type;
use UdyWfToWp\Ui\Tabs;
use UdyWfToWp\Utils\Utils;
use Valitron\Validator;

class Settings_Manager {

	public static function render_settings_view() {

		$tabs     = new Tabs();
		$settings = self::getISettingsClasses();

		foreach ( $settings as $setting ) {
			$current_tab = new $setting( self::get_saved_settings() );
			if($current_tab->can_be_activated()) {
				$current_tab->get_settings( $tabs );
			}
		}

		//to add tabs create a new "tabs/class-tab-settings-{specific-setting}" class that implements iSettings interfaces
		include_once( 'view/settings-view.php' );
	}

	public static function render_import_view() {

		$tabs     = new Tabs();
		$settings = self::getISettingsWebflowClasses();

		foreach ( $settings as $setting ) {
			$current_tab = new $setting( self::get_saved_settings() );
			$current_tab->get_settings( $tabs );
		}

		include_once( 'view/import-view.php' );
	}

	public static function getISettingsClasses() {

		$return = array();
		$dirs   = array_filter( glob( UDY_WF_TO_WP_PLUGIN_DIRECTORY_PATH . 'includes/plugins/contentmanager/settings/tabs/*' ), 'is_file' );

		foreach ( $dirs as $dir ) {
			$basename = basename( $dir );
			if ( strpos( $basename, 'class-' ) !== false ) {
				$class_name = strtolower( $basename );
				$class_name = str_replace( '-', '_', $class_name );
				$class_name = str_replace( 'class_', '', $class_name );
				$class_name = str_replace( '.php', '', $class_name );
				$classname  = "\\" . __NAMESPACE__ . "\\Tabs\\$class_name";

				if ( in_array( "UdyWfToWp\\Plugins\\ContentManager\\Interfaces\\iSettings", class_implements( $classname ) ) ) {
					$return[] = $classname;
				}
			}
		}

		return $return;
	}

	public static function getISettingsWebflowClasses() {

		$return = array();
		$dirs   = array_filter( glob( UDY_WF_TO_WP_PLUGIN_DIRECTORY_PATH . 'includes/plugins/contentmanager/settings/webflowtabs/*' ), 'is_file' );

		foreach ( $dirs as $dir ) {
			$basename = basename( $dir );
			if ( strpos( $basename, 'class-' ) !== false ) {
				$class_name = strtolower( $basename );
				$class_name = str_replace( '-', '_', $class_name );
				$class_name = str_replace( 'class_', '', $class_name );
				$class_name = str_replace( '.php', '', $class_name );
				$classname  = "\\" . __NAMESPACE__ . "\\Webflowtabs\\$class_name";

				if ( in_array( "UdyWfToWp\\Plugins\\ContentManager\\Interfaces\\iSettings", class_implements( $classname ) ) ) {
					$return[] = $classname;
				}
			}
		}

		return $return;
	}

	public static function save_settings() {
		if ( isset( $_POST['action'] ) && $_POST['action'] == 'udesly_save_settings' ) {

			if ( ! empty( $_POST ) && check_admin_referer( 'save_udesly_settings', 'save_udesly_settings_nonce' ) ) {
				if ( ! isset( $_POST['udesly_settings']['count_category_child_elements'] ) ) {
					$_POST['udesly_settings']['count_category_child_elements'] = 0;
				}

				if ( $_POST['udesly_settings']['max_category_elements'] == '0' ) {
					$_POST['udesly_settings']['max_category_elements'] = '-1';
				}

				if ( ! isset( $_POST['udesly_settings']['temp_mode'] ) ) {
					$_POST['udesly_settings']['temp_mode'] = 0;
				}

				if ( ! isset( $_POST['udesly_settings']['blog_use_template_parent_child'] ) ) {
					$_POST['udesly_settings']['blog_use_template_parent_child'] = 0;
				}

				if ( ! isset( $_POST['udesly_settings']['welcome_email_status'] ) ) {
					$_POST['udesly_settings']['welcome_email_status'] = 0;
				}

				if ( ! isset( $_POST['udesly_settings']['search_one_match_redirect'] ) ) {
					$_POST['udesly_settings']['search_one_match_redirect'] = 0;
				}

				if ( ! isset( $_POST['udesly_settings']['frontend_editor_status'] ) ) {
					$_POST['udesly_settings']['frontend_editor_status'] = 0;
				}

				if ( ! isset( $_POST['udesly_settings']['woo_use_template_parent_child'] ) ) {
					$_POST['udesly_settings']['woo_use_template_parent_child'] = 0;
				}

				if ( isset( $_POST['udesly_settings']['edd_slug'] )) {
				    if(empty($_POST['udesly_settings']['edd_slug'])) {
					    $_POST['udesly_settings']['edd_slug'] = 'downloads';
				    }else{
					    $_POST['udesly_settings']['edd_slug'] = sanitize_title( $_POST['udesly_settings']['edd_slug'] );
                    }
				}

				//sanitize POST
				$udesly_settings = $_POST['udesly_settings'];

				if(is_array($udesly_settings)){
					foreach ($udesly_settings as $key => $value){
						if(!is_array($value)) {
						    if($key == 'welcome_email_message'){
							    $udesly_settings[ $key ] = sanitize_textarea_field($value);
                            }else{
							    is_int($value) ? $udesly_settings[ $key ] = (int)sanitize_text_field( $value ) : $udesly_settings[ $key ] = sanitize_text_field( $value );
                            }
						}else{
							foreach ($value as $sub_key => $sub_value){
								is_int($sub_value) ? $udesly_settings[ $key ][$sub_key] = (int)sanitize_text_field($sub_value) : $udesly_settings[ $key ][$sub_key] = sanitize_text_field($sub_value);
							}
						}
					}
				}

				if(isset($_POST['udesly_settings']['email_recipient'])){
					$v = new Validator(array('email' => $_POST['udesly_settings']['email_recipient']));
					$v->rule('email', 'email');
					if(!$v->validate()) {
					    $errors = $v->errors();
						add_action( 'admin_notices', function()use($errors){
						   self::settings_admin_notice__error($errors);
                        });
						return;
					}
				}

				if(isset($_POST['udesly_settings']['email_cc'])){
					$ccs = explode(',', $_POST['udesly_settings']['email_cc']);
					foreach ($ccs as $cc) {
						$v = new Validator( array( 'email' => trim($cc) ) );
						$v->rule( 'email', 'email' );
						if ( ! $v->validate() ) {
							$errors = $v->errors();
							add_action( 'admin_notices', function () use ( $errors ) {
								self::settings_admin_notice__error( $errors );
							} );
							return;
						}
					}
				}

				update_option( 'udesly_settings', $udesly_settings );

				add_action( 'admin_notices', array( self::class, 'settings_admin_notice__success' ) );
			}
		}
	}

	public static function get_saved_settings() {
		return get_option( 'udesly_settings' );
	}

	public static function settings_admin_notice__success() {
		?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e( 'Setting saved!', i18n::$textdomain ); ?></p>
        </div>
		<?php
	}

	public static function settings_admin_notice__error($errors) {
		?>
        <div class="notice notice-error is-dismissible">
            <p><?php echo Icon::faIcon('exclamation-triangle',true,Icon_Type::SOLID()) . __( ' Email setting errors:', i18n::$textdomain ); ?></p>
            <ul>
                <?php
                foreach ($errors['email'] as $error){
                    ?>
                    <li><?php echo $error; ?></li>
                    <?php
                }
                ?>
            </ul>
        </div>
		<?php
	}

	public static function check_wordpress_importer() {
	    Utils::isWordPressImporterPluginActive();
		if ( ! Utils::isWordPressImporterPluginActive() ) {
			add_action( 'admin_notices', array( self::class, 'check_wordpress_importer_admin_notice__error' ) );
		}
	}

	public static function check_front_page() {
		if ( get_option('show_on_front') == 'page' && is_null(get_post(get_option('page_on_front'))) ) {
			add_action( 'admin_notices', array( self::class, 'check_front_page_admin_notice__error' ) );
		}
	}

	public static function check_front_page_admin_notice__error() {
		?>
        <div class="notice notice-error">
            <p><?php echo Icon::faIcon( 'exclamation-triangle', true, Icon_Type::SOLID() ) . __( 'You need to select the website homepage, ', i18n::$textdomain ) . ' <a href="'.get_admin_url(null, 'options-reading.php').'">'.__( 'go to Settings => reading.', i18n::$textdomain ).'</a> '; ?></p>
        </div>
		<?php
	}

	public static function check_wordpress_importer_admin_notice__error() {
		?>
        <div class="notice notice-error">
            <p><?php echo Icon::faIcon( 'exclamation-triangle', true, Icon_Type::SOLID() ) . __( 'Please install the', i18n::$textdomain ) . ' <a href="https://wordpress.org/plugins/wordpress-importer/" target="_blank">Wordpress Importer plugin</a> ' . __( 'in order to use Udesly.', i18n::$textdomain ); ?></p>
        </div>
		<?php
	}

	public static function enable_temporary_mode() {

		$settings = self::get_saved_settings();

		if ( !$settings['temp_mode'] == '1' )
		    return;

			global $pagenow;

			if ( $pagenow !== 'wp-login.php' && strpos($_SERVER['REQUEST_URI'], 'wp-admin') === false && ! current_user_can( 'administrator' ) ) {
				if ( file_exists( get_template_directory() . '/temporary.php' ) ) {

				    if(isset($settings['temp_mode_type']) && $settings['temp_mode_type'] == 'maintenance'){
                        header( 'HTTP/1.1 503 Service Temporarily Unavailable' );
                        header( 'Content-Type: text/html; charset=utf-8' );
                    }else{
				        //coming soon
					    header( 'HTTP/1.1 307 Temporarily Redirect' );
					    header( 'Content-Type: text/html; charset=utf-8' );
                    }
					require_once( get_template_directory() . '/temporary.php' );
				}else{
					header( 'HTTP/1.1 404 Page Not Found' );
					header( 'Content-Type: text/html; charset=utf-8' );

					if ( file_exists( get_template_directory() . '/404.php' ))

					    require_once( get_template_directory() . '/404.php' );
                }
				die();
			}
	}

	public static function render_toolbar() {

	    if(!current_user_can('administrator'))
	        return;

		global $wp_admin_bar;

		if ( is_admin() ) {
			$icon_span = '<span class="ab-icon" id="udesly-toolbar-menu"></span><span class="ab-label">' . __( 'Udesly', i18n::$textdomain ) . '</span> ';
		}else{
			$icon_span = '<span class="ab-label">' . __( 'Udesly', i18n::$textdomain ) . '</span> ';

		}
		$wp_admin_bar->add_menu( array( 'id' => 'udesly_menu', 'title' => $icon_span, 'href' => false ) );


		$convert_all_form = '<form action="' . admin_url('admin.php') . '" method="get" style="line-height: 26px!important">' .
		                    '<input type="hidden" name="import-pages-data" value="start"><input type="hidden" name="page" value="udesly_import"><input type="submit" value="'.__('Import pages and data', i18n::$textdomain).'" class="udesly_import_data_btn"/> </form>';

        $clean_all_fe_data = '<form action="' . admin_url('admin.php') . '" method="get" style="line-height: 26px!important">' .
            '<input type="hidden" name="clean-fe-transients" value="true"><input type="hidden" name="page" value="udesly_import"><input type="submit" value="'.__('Clean Frontend Editor Transients', i18n::$textdomain).'" class="udesly_import_data_btn udesly_clean_fe_transients"/> </form>';


        if ( is_admin() ) {
			$wp_admin_bar->add_menu( array(
				'parent' => 'udesly_menu',
				'id'     => 'import_data',
				'title'  => $convert_all_form,
				'href'   => false
			) );
            if (FrontendEditor_Assets::frontend_editor_status() == FrontendEditor_Assets::FE2 ) {
                $wp_admin_bar->add_menu( array(
                    'parent' => 'udesly_menu',
                    'id'     => 'clean_fe_data',
                    'title'  => $clean_all_fe_data,
                    'href'   => false
                ) );
            }
		} else {
			$wp_admin_bar->add_menu( array(
				'parent' => 'udesly_menu',
				'id'     => 'import_data_page',
				'title'  => __( 'Go to import page', i18n::$textdomain ),
				'href'   => admin_url( 'admin.php?page=udesly_import' )
			) );
		}

		$wp_admin_bar->add_menu( array(
			'parent' => 'udesly_menu',
			'id'     => 'udesly_settings',
			'title'  => __( 'Settings', i18n::$textdomain ),
			'href'   => admin_url( 'admin.php?page=udesly_settings' )
		) );

	}

}