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

class Tab_Settings_Pagination implements iSettings {

	private $saved_settings;

	public function __construct($saved_settings) {
		$this->saved_settings = $saved_settings;
	}

	public function get_settings(Tabs $tab) {
		$form = new Form();
		$form->add_number('pagination_mid_size','udesly_settings[pagination_mid_size]',__('Pagination mid size', i18n::$textdomain),'',isset($this->saved_settings['pagination_mid_size']) ? $this->saved_settings['pagination_mid_size'] : 2,0,1000,'','','',1);
		$form->add_break_line_border();
		$form->add_number('pagination_end_size','udesly_settings[pagination_end_size]',__('Pagination end size', i18n::$textdomain),'',isset($this->saved_settings['pagination_end_size']) ? $this->saved_settings['pagination_end_size'] : 1,0,1000,'','','',1);
		$tab->add_tab(__('Pagination', i18n::$textdomain),'pagination',$form->get_form(),Icon::faIcon('ellipsis-h',true,Icon_Type::SOLID()), 3);
		return $tab;
	}

	public function can_be_activated(){
		return true;
	}
}