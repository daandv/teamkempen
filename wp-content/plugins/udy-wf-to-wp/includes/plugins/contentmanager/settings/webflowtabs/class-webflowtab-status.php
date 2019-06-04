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

class Webflowtab_Status implements iSettings {

	private $saved_settings;

	public function __construct($saved_settings) {
		$this->saved_settings = $saved_settings;
	}

	public function get_settings(Tabs $tab) {

		$exported_data = get_option('udesly_exported_data_missing');

		$form = new Form();

		if(!isset($exported_data['contents']) && !isset($exported_data['rules']) && !isset($exported_data['menus']) && !isset($exported_data['lists']) && !isset($exported_data['customPostTypes'])){
			$form->add_raw('<p>' . __('No missing elements found!', i18n::$textdomain) . '</p>');
		} else {


			$form->add_raw( '<p>' . __( 'The table below lists the missing elements used in your Webflow project that you need to create in WordPress through the Udesly plugin in order to have the converted theme working perfectly!', i18n::$textdomain ) . '</p>' );
			$form->add_break_line_border();

			$table = '<table style="margin-top: 15px;" class="widefat">' .
			         '<thead>' .
			         '<th>Elements</th>' .
			         '<th>Slug</th>' .
			         '</thead>' .
			         '<tbody>';

			if ( isset( $exported_data['contents'] ) ) {
				foreach ( $exported_data['contents'] as $slug ) {
					$table .= '<tr>' .
					          '<td><a href="' . get_admin_url( null, 'edit.php?post_type=udesly_content' ) . '">' . __( 'Content', i18n::$textdomain ) . '</a></td>' .
					          '<td>' . $slug . '</td>' .
					          '</tr>';
				}
			}

			if ( isset( $exported_data['rules'] ) ) {
				foreach ( $exported_data['rules'] as $slug ) {
					$table .= '<tr>' .
					          '<td>' . __( 'Rule', i18n::$textdomain ) . '</td>' .
					          '<td>' . $slug . '</td>' .
					          '</tr>';
				}
			}

			if ( isset( $exported_data['lists'] ) ) {
				foreach ( $exported_data['lists'] as $slug ) {
					$table .= '<tr>' .
					          '<td>' . __( 'List', i18n::$textdomain ) . '</td>' .
					          '<td>' . $slug . '</td>' .
					          '</tr>';
				}
			}

			if ( isset( $exported_data['customPostTypes'] ) ) {
				foreach ( $exported_data['customPostTypes'] as $slug ) {
					$table .= '<tr>' .
					          '<td>' . __( 'Custom Type', i18n::$textdomain ) . '</td>' .
					          '<td>' . $slug . '</td>' .
					          '</tr>';
				}
			}
			if ( isset( $exported_data['menus'] ) ) {
				foreach ( $exported_data['menus'] as $slug ) {
					$table .= '<tr>' .
					          '<td>' . __( 'Menu', i18n::$textdomain ) . '</td>' .
					          '<td>' . $slug . '</td>' .
					          '</tr>';
				}
			}

			$table .= '</tbody>' .
			          '</table>';

			$form->add_raw( $table );
		}

		$tab->add_tab(__('Missing elements', i18n::$textdomain),'status', $form->get_form(),Icon::faIcon('exclamation-triangle',true,Icon_Type::SOLID()), 1);

		return $tab;
	}
	public function can_be_activated() {
		return true;
	}
}