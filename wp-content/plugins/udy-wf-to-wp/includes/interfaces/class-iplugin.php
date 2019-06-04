<?php

namespace UdyWfToWp\Interfaces;

use UdyWfToWp\Core\Udy_Wf_To_Wp_Loader;

interface iPlugin{

	public static function define_admin_hooks( Udy_Wf_To_Wp_Loader $loader );

	public static function define_public_hooks( Udy_Wf_To_Wp_Loader $loader );

	public static function activate();

	public static function deactivate();

}