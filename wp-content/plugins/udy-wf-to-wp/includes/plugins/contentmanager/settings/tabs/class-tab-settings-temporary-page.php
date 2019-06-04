<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 09/04/2018
 * Time: 13:06
 */

namespace UdyWfToWp\Plugins\ContentManager\Settings\Tabs;

use UdyWfToWp\i18n\i18n;
use UdyWfToWp\Plugins\ContentManager\Interfaces\iSettings;
use UdyWfToWp\Ui\Form;
use UdyWfToWp\Ui\Icon;
use UdyWfToWp\Ui\Icon_Type;
use UdyWfToWp\Ui\Tabs;

class Tab_Settings_Temporary_Page implements iSettings {

	private $saved_settings;

	public function __construct($saved_settings) {
		$this->saved_settings = $saved_settings;
	}

	public function get_settings(Tabs $tab) {

		$form = new Form();

		$form->add_checkbox('temp_mode','udesly_settings[temp_mode]',__('Enable temporary page', i18n::$textdomain),1,isset($this->saved_settings['temp_mode']) ? $this->saved_settings['temp_mode'] : false);
		$form->add_break_line_border();
		$form->add_select('temp_mode_type','udesly_settings[temp_mode_type]','Type',array(
			'coming_soon' => 'Coming soon',
			'maintenance' => 'Maintenance',
		),isset($this->saved_settings['temp_mode_type']) ? $this->saved_settings['temp_mode_type'] : 'coming_soon');

		$tab->add_tab(__('Temporary page', i18n::$textdomain),'temporary_page',$form->get_form(),Icon::faIcon('hourglass-half',true,Icon_Type::SOLID()), 5);
		return $tab;
	}

	public function can_be_activated(){
		return true;
	}
}