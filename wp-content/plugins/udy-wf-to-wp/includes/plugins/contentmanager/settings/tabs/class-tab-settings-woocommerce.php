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

class Tab_Settings_Woocommerce implements iSettings {

	private $saved_settings;

	public function __construct($saved_settings) {
		$this->saved_settings = $saved_settings;
	}

	public function get_settings(Tabs $tab) {

		$form = new Form();
		$form->add_checkbox('woo_use_template_parent_child','udesly_settings[woo_use_template_parent_child]',__('Use the parent category template for shop subcategories',i18n::$textdomain),'1',isset($this->saved_settings['woo_use_template_parent_child']) ? $this->saved_settings['woo_use_template_parent_child'] : false);
		$form->add_break_line_border();

        $form->add_checkbox('woo_disable_select2','udesly_settings[woo_disable_select2]',__('Disable Select 2',i18n::$textdomain),'1',isset($this->saved_settings['woo_disable_select2']) ? $this->saved_settings['woo_disable_select2'] : false);
        $form->add_break_line_border();
		$form->add_title('Label','small');
		$form->add_text('woo_shop_page_title','udesly_settings[woo_shop_page_title]',__('Shop Page Title', i18n::$textdomain),'',isset($this->saved_settings['woo_shop_page_title']) ? $this->saved_settings['woo_shop_page_title'] : 'Shop','');
		$form->add_break_line_border();
		$form->add_text('woo_tag_title','udesly_settings[woo_tag_title]',__('Tag Pre-Title', i18n::$textdomain),'',isset($this->saved_settings['woo_tag_title']) ? $this->saved_settings['woo_tag_title'] : 'Tag: %s','');
		$form->add_break_line_border();
		$form->add_text('woo_category_title','udesly_settings[woo_category_title]',__('Category Pre-Title', i18n::$textdomain),'',isset($this->saved_settings['woo_category_title']) ? $this->saved_settings['woo_category_title'] : 'Category: %s','');
		$form->add_break_line_border();

		$tab->add_tab(__('Woocommerce', i18n::$textdomain),'woocommerce',$form->get_form(),Icon::faIcon('shopping-cart',true,Icon_Type::SOLID()),6);
		return $tab;
	}

	public function can_be_activated() {
		if(is_plugin_active('woocommerce/woocommerce.php')) {
			return true;
		}
		return false;
	}
}