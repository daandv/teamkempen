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

class Tab_Settings_Edd implements iSettings {

	private $saved_settings;

	public function __construct($saved_settings) {
		$this->saved_settings = $saved_settings;
	}

	public function get_settings(Tabs $tab) {
		$form = new Form();

		$form->add_text('edd_slug','udesly_settings[edd_slug]',__('Edd slug', i18n::$textdomain),'',isset($this->saved_settings['edd_slug']) ? $this->saved_settings['edd_slug'] : 'downloads',__('This constant allows you to change the post type slug of the download post type.', i18n::$textdomain),true);
		$form->add_break_line();
		$form->add_raw('<p>Once you edited the <strong>EDD SLUG</strong> save and go to <a href="options-permalink.php">SETTINGS => PERMALINK</a> then click on "Save Changes"</p>');
		$form->add_break_line_border();
		$form->add_select('edd_archive_categories','udesly_settings[edd_archive_categories]','Edd archive categories',array(
			'0' => __('None', i18n::$textdomain),
			'1' => __('Show direct children', i18n::$textdomain),
			'2' => __('Show all children', i18n::$textdomain),
		),isset($this->saved_settings['edd_archive_categories']) ? $this->saved_settings['edd_archive_categories'] : 0,__('Display edd categories in downloads archive page (Webflow "archive categories" element required)', i18n::$textdomain));
		$form->add_break_line_border();

		$form->add_title('Label','small');
		$form->add_text('edd_category_title','udesly_settings[edd_category_title]',__('Easy digital downloads category title', i18n::$textdomain),'',isset($this->saved_settings['edd_category_title']) ? $this->saved_settings['edd_category_title'] : 'Category: %s','');
		$form->add_break_line_border();
		$form->add_text('edd_tag_title','udesly_settings[edd_tag_title]',__('Easy digital downloads tag title', i18n::$textdomain),'',isset($this->saved_settings['edd_tag_title']) ? $this->saved_settings['edd_tag_title'] : 'Tag: %s','');
		$form->add_break_line_border();
		$form->add_text('edd_author_title','udesly_settings[edd_author_title]',__('Easy digital downloads author title', i18n::$textdomain),'',isset($this->saved_settings['edd_author_title']) ? $this->saved_settings['edd_author_title'] : 'Author: %s','');
		$form->add_break_line_border();
		$form->add_text('edd_archive_title','udesly_settings[edd_archive_title]',__('Easy digital downloads archive title', i18n::$textdomain),'',isset($this->saved_settings['edd_archive_title']) ? $this->saved_settings['edd_archive_title'] : 'Downloads','');
		$form->add_break_line_border();
		$tab->add_tab(__('Easy Digital Downloads', i18n::$textdomain),'edd',$form->get_form(),Icon::faIcon('download',true,Icon_Type::SOLID()));
		return $tab;
	}

	public function can_be_activated(){
		if(is_plugin_active('easy-digital-downloads/easy-digital-downloads.php')) {
			return true;
		}
		return false;
	}
}