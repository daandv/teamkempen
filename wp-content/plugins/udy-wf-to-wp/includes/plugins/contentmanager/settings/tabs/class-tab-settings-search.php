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

class Tab_Settings_Search implements iSettings {

	private $saved_settings;

	public function __construct($saved_settings) {
		$this->saved_settings = $saved_settings;
	}

	public function get_settings(Tabs $tab) {

		$form = new Form();
		$form->add_checkbox('search_one_match_redirect','udesly_settings[search_one_match_redirect]',__('If there is only one match, directly redirect to the result',i18n::$textdomain),'1',isset($this->saved_settings['search_one_match_redirect']) ? $this->saved_settings['search_one_match_redirect'] : false);
		$form->add_break_line_border();
		$form->add_number('search_results_per_page','udesly_settings[search_results_per_page]',__('Search results per page', i18n::$textdomain),'',isset($this->saved_settings['search_results_per_page']) ? $this->saved_settings['search_results_per_page'] : 10,1,1000,'','','',1);
		$form->add_break_line_border();
		$form->add_number('search_excerpt_length','udesly_settings[search_excerpt_length]',__('Excerpt length', i18n::$textdomain),'',isset($this->saved_settings['search_excerpt_length']) ? $this->saved_settings['search_excerpt_length'] : 50,0,1000,__('Set 0 to unlimited',i18n::$textdomain),'','',1);
		$form->add_text('search_excerpt_more','udesly_settings[search_excerpt_more]',__('Excerpt more', i18n::$textdomain),'',isset($this->saved_settings['search_excerpt_more']) ? $this->saved_settings['search_excerpt_more'] : '[...]','');

		$tab->add_tab(__('Search', i18n::$textdomain),'search',$form->get_form(),Icon::faIcon('search',true,Icon_Type::SOLID()), 4);
		return $tab;
	}

	public function can_be_activated(){
		return true;
	}
}