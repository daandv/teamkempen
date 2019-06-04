<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 09/04/2018
 * Time: 13:06
 */

namespace UdyWfToWp\Plugins\ContentManager\Settings\Webflowtabs;

use UdyWfToWp\i18n\i18n;
use UdyWfToWp\Plugins\ContentManager\Interfaces\iSettings;
use UdyWfToWp\Ui\Form;
use UdyWfToWp\Ui\Icon;
use UdyWfToWp\Ui\Icon_Type;
use UdyWfToWp\Ui\Tabs;

class Webflowtab_Import_Data implements iSettings {

	private $saved_settings;

	public function __construct($saved_settings) {
		$this->saved_settings = $saved_settings;
	}

	public function get_settings(Tabs $tab) {

		$form = new Form();
		if(is_plugin_active('wordpress-importer/wordpress-importer.php')){
			$form->add_raw('<p>' . __('Click to import Webflow pages and frontend editor data into Wordpress', i18n::$textdomain) . '</p>', '');
			$form->add_break_line();
			$form->add_button('udesly-pages-sync-btn',__('Import pages and frontend editor data', i18n::$textdomain),'','button-primary', false);
            $form->add_break_line();
			$form->add_raw('<p style="color:red;">This process can require up to 5-10 minutes according to your server performances, please do not close this tab</p>');
			$form->add_break_line_border();

			$form->add_raw('<p>' . __('Click to delete all the imported Wordpress pages', i18n::$textdomain) . '</p>', '');
			$form->add_break_line();
			$form->add_button('udesly-delete-pages-btn',__('Delete all imported pages', i18n::$textdomain),'','button-primary', false);
			$form->add_break_line_border();

			$form->add_raw('<p>' . __('Click to delete all the frontend editor elements', i18n::$textdomain) . '</p>', '');
			$form->add_break_line();
			$form->add_button('udesly-delete-fe-btn',__('Delete all frontend editor elements', i18n::$textdomain),'','button-primary', false);
			$form->add_break_line_border();

			$to_sync = get_option('udesly_exported_data_missing', array());
			if(isset($to_sync['frontendEditorElements']) && $to_sync['frontendEditorElements'] > 0){
				$form->add_raw('<p>' . __('Click to clean unused frontend editor elements', i18n::$textdomain) . '</p>', '');
				$form->add_break_line();
				$form->add_button('udesly-clean-fe-btn',__('Delete unused frontend editor elements', i18n::$textdomain),'','button-primary', false);
				$form->add_break_line_border();
			}

//			IMPORT DATA AND PAGES ERRORS/SUCCESS MSG
			$form->add_raw('<p>'. Icon::faIcon('check',true,Icon_Type::SOLID()) . __('Pages and data imported succesfully', i18n::$textdomain) .  '</p>', 'udesly-success-msg udesly-hide-msg wp_sync_success');
			$form->add_raw('<p>'. Icon::faIcon('times',true,Icon_Type::SOLID()) . __('Install and activate the WordPress importer plugin', i18n::$textdomain) .  '</p>', 'udesly-error-msg udesly-hide-msg wp_importer_miss');
			$form->add_raw('<p>'. Icon::faIcon('times',true,Icon_Type::SOLID()) . __('The udesly_exported_pages.xml file is missing', i18n::$textdomain) .  '</p>', 'udesly-error-msg udesly-hide-msg xml_file_miss');

//			DELETE PAGES ERRORS/SUCCESS MSG
			$form->add_raw('<p>'. Icon::faIcon('check',true,Icon_Type::SOLID()) . __('Pages deleted succesfully, make sure to import again', i18n::$textdomain) .  '</p>', 'udesly-success-msg udesly-hide-msg wp_delete_pages_success');
			$form->add_raw('<p>'. Icon::faIcon('times',true,Icon_Type::SOLID()) . __('Can\'t delete WordPress pages', i18n::$textdomain) .  '</p>', 'udesly-error-msg udesly-hide-msg cant_delete_pages');

//			FRONTEND EDITOR DELETE ERRORS/SUCCESS MSG
			$form->add_raw('<p>'. Icon::faIcon('check',true,Icon_Type::SOLID()) . __('Frontend editor elements deleted succesfully, make sure to import data again', i18n::$textdomain) .  '</p>', 'udesly-success-msg udesly-hide-msg wp_delete_fe_success');
			$form->add_raw('<p>'. Icon::faIcon('times',true,Icon_Type::SOLID()) . __('Can\'t delete frontend editor elements ', i18n::$textdomain) .  '</p>', 'udesly-error-msg udesly-hide-msg cant_delete_fe_elements');

//			FRONTEND EDITOR CLEAN ERRORS/SUCCESS MSG
			$form->add_raw('<p>'. Icon::faIcon('check',true,Icon_Type::SOLID()) . __('Frontend editor elements cleaned succesfully', i18n::$textdomain) .  '</p>', 'udesly-success-msg udesly-hide-msg wp_clean_fe_success');
			$form->add_raw('<p>'. Icon::faIcon('times',true,Icon_Type::SOLID()) . __('Can\'t clean frontend editor elements ', i18n::$textdomain) .  '</p>', 'udesly-error-msg udesly-hide-msg cant_clean_fe_elements');

		}else{
			$form->add_raw('<p>' . Icon::faIcon('times',true,Icon_Type::SOLID()) . __(' You need to install and activate the', i18n::$textdomain) . ' <a href="https://wordpress.org/plugins/wordpress-importer/" target="_blank">Wordpress Importer plugin</a> ' . __('in order to manage Webflow data.', i18n::$textdomain) . '</p>', 'udesly-error-msg');
		}
		$tab->add_tab(__('Webflow data', i18n::$textdomain),'tools',$form->get_form(),Icon::faIcon('database',true,Icon_Type::SOLID()), 0);
		return $tab;
	}

	public function can_be_activated() {
		return true;
	}
}