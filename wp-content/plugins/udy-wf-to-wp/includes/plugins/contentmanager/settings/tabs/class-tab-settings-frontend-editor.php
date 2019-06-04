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
use UdyWfToWp\Plugins\FrontendEditor\FrontendEditor_Assets;
use UdyWfToWp\Ui\Form;
use UdyWfToWp\Ui\Icon;
use UdyWfToWp\Ui\Icon_Type;
use UdyWfToWp\Ui\Tabs;

class Tab_Settings_Frontend_Editor implements iSettings {

	private $saved_settings;

	public function __construct($saved_settings) {
		$this->saved_settings = $saved_settings;
	}

	public function get_settings(Tabs $tab) {

		global $wp_roles;
		$results = array();

		foreach ($wp_roles->role_names as $key => $value){
			$results[$key] = $value;
		}

		unset($results['administrator']);
		$results = array('none' => __('No additional role', i18n::$textdomain)) + $results;


		$form = new Form();
		$form->add_checkbox('frontend_editor_status','udesly_settings[frontend_editor_status]',__('Enable Frontend Editor'),'1',isset($this->saved_settings['frontend_editor_status']) ? $this->saved_settings['frontend_editor_status'] : true);
		$form->add_break_line_border();
		$form->add_select('frontend_editor_roles','udesly_settings[frontend_editor_roles]',__('Additional user role', i18n::$textdomain),$results,isset($this->saved_settings['frontend_editor_roles']) ? $this->saved_settings['frontend_editor_roles'] : 'none',__('Allow user with this specific role to use frontend editor along with administrator', i18n::$textdomain),false);
		$tab->add_tab(__('Frontend Editor', i18n::$textdomain),'frontend-editor',$form->get_form(),Icon::faIcon('edit',true,Icon_Type::SOLID()), 2);
		return $tab;
	}

	public function can_be_activated(){
        return FrontendEditor_Assets::frontend_editor_status() !== FrontendEditor_Assets::FED;
	}
}