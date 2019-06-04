<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 02/05/2018
 * Time: 15:04
 */

function udesly_eval_rule($rule_slug, $subject_id = 0){
	if( $subject_id == 0 ) {
		global $post;
		$subject_id = $post->ID;
	}

	return \UdyWfToWp\Plugins\Rules\Rule\Rule_Controller::is_matched_by($subject_id, $rule_slug);
}