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

class Tab_Settings_Blog implements iSettings {

	private $saved_settings;

	public function __construct($saved_settings) {
		$this->saved_settings = $saved_settings;
	}

	public function get_settings(Tabs $tab) {

		$form = new Form();
		$form->add_checkbox('count_category_child_elements','udesly_settings[count_category_child_elements]',__('Show the counter of child categories',i18n::$textdomain),'1',isset($this->saved_settings['count_category_child_elements']) ? $this->saved_settings['count_category_child_elements'] : false);
		$form->add_break_line_border();
		$form->add_checkbox('blog_use_template_parent_child','udesly_settings[blog_use_template_parent_child]',__('Use the parent category template for subcategories',i18n::$textdomain),'1',isset($this->saved_settings['blog_use_template_parent_child']) ? $this->saved_settings['blog_use_template_parent_child'] : false);
		$form->add_break_line_border();
		$form->add_number('max_category_elements','udesly_settings[max_category_elements]',__('Category elements max number', i18n::$textdomain),'',isset($this->saved_settings['max_category_elements']) ? $this->saved_settings['max_category_elements'] : 0,-1,1000,__('Set 0 to unlimited',i18n::$textdomain),'','',1);
		$form->add_break_line_border();
		$form->add_number('excerpt_length','udesly_settings[excerpt_length]',__('Excerpt length', i18n::$textdomain),'',isset($this->saved_settings['excerpt_length']) ? $this->saved_settings['excerpt_length'] : 55,0,1000,__('Set 0 to unlimited',i18n::$textdomain),'','',1);
		$form->add_text('excerpt_more','udesly_settings[excerpt_more]',__('Excerpt more', i18n::$textdomain),'',isset($this->saved_settings['excerpt_more']) ? $this->saved_settings['excerpt_more'] : '[...]','');
		$form->add_break_line_border();
		$form->add_select('blog_archive_categories','udesly_settings[blog_archive_categories]','Blog archive categories',array(
			'0' => __('None', i18n::$textdomain),
			'1' => __('Show direct children', i18n::$textdomain),
			'2' => __('Show all children', i18n::$textdomain),
		),isset($this->saved_settings['blog_archive_categories']) ? $this->saved_settings['blog_archive_categories'] : 0,__('Display blog categories in archive page (Webflow "archive categories" element required)', i18n::$textdomain));
		$form->add_break_line_border();

		$form->add_title('Label','small');
		$form->add_text('blog_category_title','udesly_settings[blog_category_title]',__('Blog category title', i18n::$textdomain),'',isset($this->saved_settings['blog_category_title']) ? $this->saved_settings['blog_category_title'] : 'Category: %s','');
		$form->add_break_line_border();
		$form->add_text('blog_tag_title','udesly_settings[blog_tag_title]',__('Blog tag title', i18n::$textdomain),'',isset($this->saved_settings['blog_tag_title']) ? $this->saved_settings['blog_tag_title'] : 'Tag: %s','');
		$form->add_break_line_border();
		$form->add_text('blog_author_title','udesly_settings[blog_author_title]',__('Blog author title', i18n::$textdomain),'',isset($this->saved_settings['blog_author_title']) ? $this->saved_settings['blog_author_title'] : 'Author: %s','');
		$form->add_break_line_border();
		$form->add_text('blog_category_title','udesly_settings[blog_archive_title]',__('Blog archive title', i18n::$textdomain),'',isset($this->saved_settings['blog_archive_title']) ? $this->saved_settings['blog_archive_title'] : 'Archives','');
		$form->add_break_line_border();

		$form->add_wp_nonce( 'save_udesly_settings', 'save_udesly_settings_nonce' );
		$form->add_hidden('udesly_save_settings','action','udesly_save_settings');
		$tab->add_tab(__('Blog', i18n::$textdomain),'blog',$form->get_form(),Icon::faIcon('wordpress',true,Icon_Type::BRANDS()),0);
		return $tab;
	}

	public function can_be_activated(){
		return true;
	}
}