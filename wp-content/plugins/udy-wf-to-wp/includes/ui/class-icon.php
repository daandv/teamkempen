<?php
/**
 * Created by PhpStorm.
 * User: Pietro Falco
 * Date: 10/01/2018
 * Time: 15:23
 */

namespace UdyWfToWp\Ui;


class Icon {

	public static function faIconTooltip($message, $echo = false ){
		$icon = '<a class="cdg-woo-kit-tooltip">';
		$icon .= Icon::faIcon( 'info-circle', true, Icon_Type::SOLID(), '',false );
		$icon .= "<div class='tooltip'>$message</div>";
		$icon .= '</a>';

		if($echo){
			echo $icon;
		}else{
			return $icon;
		}
	}

	public static function faIconLayered( $icon_name, $status, $counter = 0, Icon_Type $type, $class = '', $echo = false ) {

		$icon = "<span class='fa-layers fa-fw'>";
		$icon .= Icon::faIcon( $icon_name, true, $type, $class,false );
		$icon .= "<span class='fa-layers-counter cdg-icon-label-$status'>$counter</span>";
		$icon .= "</span>";

		if ( $echo ) {
			echo $icon;
		} else {
			return $icon;
		}

	}

	public static function faIcon( $icon_name, $fixed_width, Icon_Type $type, $class = '',  $echo = false ) {

		$fixed_width = $fixed_width ? 'fa-fw' : '';
		$icon = "<i class='$type $fixed_width fa-$icon_name cdg-icon $class'></i>";
		if ( $echo ) {
			echo $icon;
		} else {
			return $icon;
		}
	}


}