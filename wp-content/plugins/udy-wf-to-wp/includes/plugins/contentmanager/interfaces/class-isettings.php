<?php

namespace UdyWfToWp\Plugins\ContentManager\Interfaces;

use UdyWfToWp\Ui\Tabs;

interface iSettings{

	public function __construct($saved_settings);

	public function get_settings(Tabs $tab);

	public function can_be_activated();

}