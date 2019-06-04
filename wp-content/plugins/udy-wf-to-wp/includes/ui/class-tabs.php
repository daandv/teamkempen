<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 09/01/2018
 * Time: 14:51
 */

namespace UdyWfToWp\Ui;

class Tabs{

	private $tabs;


	public function __construct($tabs = array()) {
		$this->tabs = $tabs;
	}

	public function add_tab($title, $id, $panel, $icon = '', $order = 0){
		$this->tabs[] = array(
			'title' => $title,
			'id' => $id,
			'panel' => $panel,
			'icon' => $icon,
			'order' => $order
		);
	}

	public function show_tabs(){

		usort($this->tabs, function($a, $b) {
			return $a['order'] - $b['order'];
		});

		echo '<div class="cdg-woo-kit-tabs-component-wrapper">';
		    echo '<div class="cdg-woo-kit-tabs-wrapper">';
                echo '<ul class="cdg-woo-kit-tabs">';
                    foreach ($this->tabs as $tab){
                        echo '<li data-tab-id="' . $tab['id'] . '">'. $tab['icon']  . $tab['title'] . '</li>';
                    }
                echo '</ul>';
            echo '</div>';
            echo '<div class="cdg-woo-kit-panels-wrapper">';
                echo '<div class="cdg-woo-kit-panels">';
                    foreach ($this->tabs as $tab){
                        echo '<div data-panel-id="' . $tab['id'] . '" class="cdg-woo-kit-panel">' . $tab['panel'] . '</div>';
                    }
                echo '</div>';
            echo '</div>';
		echo '</div>';

	}

}