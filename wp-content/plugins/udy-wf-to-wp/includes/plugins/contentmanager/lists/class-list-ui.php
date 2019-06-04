<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 03/04/2018
 * Time: 14:19
 */

namespace UdyWfToWp\Plugins\ContentManager\Lists;

use UdyWfToWp\i18n\i18n;
use UdyWfToWp\Plugins\ContentManager\Models\Query\Query;
use UdyWfToWp\Ui\Form;
use UdyWfToWp\Ui\Icon;
use UdyWfToWp\Ui\Icon_Type;
use UdyWfToWp\Ui\Tabs;
use UdyWfToWp\Utils\Utils;
use \WP_Query;

class List_Ui{

	public static function add_list_meta_box_component($post){

		$list = new List_Model($post->ID);

		$tabs = new Tabs();
		$tabs->add_tab(__('Taxonomy', i18n::$textdomain),'taxonomy',self::get_taxonomy_form($list->query),Icon::faIcon('filter',true,Icon_Type::SOLID()),1);
		$tabs->add_tab(__('Term', i18n::$textdomain),'term',self::get_term_form($list->query),Icon::faIcon('quote-left',true,Icon_Type::SOLID()),2);
		$tabs->add_tab(__('Search', i18n::$textdomain),'search',self::get_search_form($list->query),Icon::faIcon('search',true,Icon_Type::SOLID()),3);
		$tabs->add_tab(__('Sorting', i18n::$textdomain),'sorting',self::get_sorting_form($list->query),Icon::faIcon('sort-alpha-up',true,Icon_Type::SOLID()),4);
		$tabs->add_tab(__('Pagination', i18n::$textdomain),'pagination',self::get_pagination_form($list->query),Icon::faIcon('copy',true,Icon_Type::SOLID()),5);
		$tabs->show_tabs();
	}

	private static function get_taxonomy_form($query){

		$query_builder = Query::factory('taxonomy', 'name');

		$form = new Form();
		$form->add_wp_nonce( 'save_udesly_list', 'save_udesly_list_nonce' );
		$form->add_select('taxonomy','query_builder[taxonomy][]',__('Taxonomy',i18n::$textdomain),$query_builder->get_matched_items($query, 'taxonomy'),'[*]',__('A single taxonomy name, or a list of taxonomies.', i18n::$textdomain),true,'','select2-wf-to-wp', array(
			'subject' => 'taxonomy',
			'query_meta' => 'name',
			'minimum_input_length' => 0,
			'minimum_results_for_search' => -1, //display all available options without search input
		));

		return $form->get_form();
	}

	private static function get_term_form($query){

		$query_builder = Query::factory('term', 'name');

		$form = new Form();
		$form->add_select('term','query_builder[name][]',__('Term Name',i18n::$textdomain),$query_builder->get_matched_items($query, 'name'),'[*]',__('Return term by names.', i18n::$textdomain),true,'','select2-wf-to-wp', array(
			'subject' => 'term',
			'query_meta' => 'name',
			'minimum_input_length' => 2,
			'minimum_results_for_search' => 0,
		));

		return $form->get_form();
	}

	private static function get_search_form($query){
		$form = new Form();

		$form->add_text('name__like','query_builder[name__like]',__('Term Name Like', i18n::$textdomain),'',isset($query['name__like']) ? $query['name__like'] : '',__('Return terms with names like the criteria.', i18n::$textdomain),'','');

		return$form->get_form();
	}

	private static function get_sorting_form($query){
		$form = new Form();

		$form->add_select('orderby_term','query_builder[orderby_term]',__('Sort By', i18n::$textdomain),array(
			isset($query['orderby_term']) ?  $query['orderby_term'] : ''=> isset($query['orderby_term']) ? $query['orderby_term'] : ''
		),isset($query['orderby_term']) ? $query['orderby_term'] : '','',false,'','select2-wf-to-wp', array(
			'subject' => 'sorting',
			'query_meta' => 'orderby_term',
			'minimum_input_length' => 0,
			'minimum_results_for_search' => -1, //display all available options without search input
		));
		$form->add_select('order','query_builder[order]',__('Sorting Direction', i18n::$textdomain),array(
			isset($query['order']) ?  $query['order'] : ''=> isset($query['order']) ? $query['order'] : ''
		),isset($query['order']) ? $query['order'] : '','',false,'','select2-wf-to-wp', array(
			'subject' => 'sorting',
			'query_meta' => 'order',
			'minimum_input_length' => 0,
			'minimum_results_for_search' => -1, //display all available options without search input
		));

		return$form->get_form();
	}

	private static function get_pagination_form($query){
		$form = new Form();
		$form->add_number('number','query_builder[number]',__('Number of elements',i18n::$textdomain),'',isset($query['number']) ? $query['number'] : '',0,1000,'','','',1);
		$form->add_number('parent','query_builder[parent]',__('Parent',i18n::$textdomain),'',isset($query['parent']) ? $query['parent'] : '',0,1000000,'','','',1);
		return $form->get_form();
	}

	private static function get_related_form($query){
		$form = new Form();
		$form->add_checkbox('related_tag','query_builder[related_tag]','Only related contents', 1,isset($query['related_tag']) ? $query['related_tag'] : false);
		return $form->get_form();
	}

}