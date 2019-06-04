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

class Webflowtab_Custom_Fields implements iSettings {

	private $saved_settings;

	public function __construct($saved_settings) {
		$this->saved_settings = $saved_settings;
	}

	public function get_settings(Tabs $tab) {

		$exported_data = get_option('udesly_exported_data_missing');

		$form = new Form();

		if(!isset($exported_data['customFields'])){
			$form->add_raw('<p>' . __('No custom fields found!', i18n::$textdomain) . '</p>');
		} else {


			$form->add_raw( '<p>' . __( 'The list below shows the custom fields added in your Webflow project that you can use in WordPress.', i18n::$textdomain ) . '</p>' );
			$form->add_break_line_border();

			$list = '<ul style="padding-left: 20px; list-style: disc;">';

			if ( isset( $exported_data['customFields'] ) ) {
				foreach ( $exported_data['customFields'] as $slug ) {
					$list .= '<li>' . $slug . '</li>';
				}
			}

			$list .= '</ul>';

			$form->add_raw( $list );
		}

		$tab->add_tab(__('Custom fields', i18n::$textdomain),'custom_fields', $form->get_form(),Icon::faIcon('edit',true,Icon_Type::SOLID()), 2);

		return $tab;
	}

	public function can_be_activated() {
		return true;
	}
}