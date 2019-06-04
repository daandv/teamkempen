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

class Tab_Settings_Email implements iSettings {

	private $saved_settings;

	public function __construct($saved_settings) {
		$this->saved_settings = $saved_settings;
	}

	public function get_settings(Tabs $tab) {

		$form = new Form();

		$form->add_title(__('General form email settings', i18n::$textdomain),'small');
		$form->add_break_line_border();
		$form->add_text('email_recipient','udesly_settings[email_recipient]',__('Email Recipient', i18n::$textdomain),'e.g. admin@example.com',isset($this->saved_settings['email_recipient']) ? $this->saved_settings['email_recipient'] : '','',false);
		$form->add_break_line();
		$form->add_text('email_cc','udesly_settings[email_cc]',__('Email CC (comma separated)', i18n::$textdomain),'e.g. info@example.com, test@test.it',isset($this->saved_settings['email_cc']) ? $this->saved_settings['email_cc'] : '','',false);
		$form->add_break_line();

		$form->add_title(__('Welcome email', i18n::$textdomain),'small');
		$form->add_break_line_border();
		$form->add_checkbox('welcome_email_status','udesly_settings[welcome_email_status]',__('Enable welcome email', i18n::$textdomain),1,isset($this->saved_settings['welcome_email_status']) ? $this->saved_settings['welcome_email_status'] : false);
		$form->add_break_line_border();
		$form->add_text('welcome_email_subject','udesly_settings[welcome_email_subject]',__('Subject', i18n::$textdomain),'',isset($this->saved_settings['welcome_email_subject']) ? $this->saved_settings['welcome_email_subject'] : '','',false);
		$form->add_break_line();
		$form->add_textarea('udesly_settings[welcome_email_message]',isset($this->saved_settings['welcome_email_message']) ? $this->saved_settings['welcome_email_message'] : '','10','10','',__('Message', i18n::$textdomain));
		$form->add_break_line_border();
		$form->add_title(__('You can use the following placeholders: ', i18n::$textdomain),'small');
		$form->add_raw('<ul>'.
		               '<li><strong>{{username}}</strong> - '.__('username of the registered user', i18n::$textdomain).'</li>'.
		               '<li><strong>{{site_title}}</strong> - '.__('site title as defined in WP general settings', i18n::$textdomain).'</li>'.
		               '<li><strong>{{first_name}}</strong> - '.__('first name entered by user on registration', i18n::$textdomain).'</li>'.
		               '<li><strong>{{last_name}}</strong> - '.__('last name entered by user on registration', i18n::$textdomain).'</li>'.
		               '<li><strong>{{site_link}}</strong> - '.__('home site link', i18n::$textdomain).'</li>'.
		'</ul>','');
		$tab->add_tab(__('Email', i18n::$textdomain),'udesly_email',$form->get_form(),Icon::faIcon('envelope',true,Icon_Type::SOLID()), 1);
		return $tab;
	}

	public function can_be_activated() {
		return true;
	}
}