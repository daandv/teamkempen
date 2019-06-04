<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 18/05/2018
 * Time: 11:37
 */

function udesly_get_url_for_language($language_code){

	$trp = TRP_Translate_Press::get_trp_instance();
	$url_converter = $trp->get_component('url_converter');
	$url = $url_converter->get_url_for_language($language_code);

	return $url;
}