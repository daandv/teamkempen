<?php

namespace UdyWfToWp\i18n;

class i18n{

	public static $textdomain = 'udy-wf-to-wp';

	/**
	 * Loads plugin textdomain
	 * @since 1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			self::$textdomain,
			false,
			self::$textdomain . '/languages/'
		);

	}

}