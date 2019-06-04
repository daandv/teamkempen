<?php

namespace UdyWfToWp\Plugins\ContentManager\Settings;

use UdyWfToWp\Core\Udy_Wf_To_Wp;
use UdyWfToWp\i18n\i18n;

class Settings_Configuration{

	private static $instance;

	protected function __construct() {

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

	public function create_menu(){
		add_submenu_page( Udy_Wf_To_Wp::$menu_slug, __('Settings', i18n::$textdomain), __('Settings', i18n::$textdomain), 'manage_options', 'udesly_settings', array(
			Settings_Manager::class,
			'render_settings_view'
		));
		add_submenu_page( Udy_Wf_To_Wp::$menu_slug, __('Import from webflow', i18n::$textdomain), __('Import from Webflow', i18n::$textdomain), 'manage_options', 'udesly_import', array(
			Settings_Manager::class,
			'render_import_view'
		));
	}
}