<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 03/04/2018
 * Time: 14:19
 */

namespace UdyWfToWp\Plugins\ContentManager\Contents;

use UdyWfToWp\i18n\i18n;
use UdyWfToWp\Plugins\ContentManager\Models\Query\Query;
use UdyWfToWp\Ui\Form;
use UdyWfToWp\Ui\Icon;
use UdyWfToWp\Ui\Icon_Type;
use UdyWfToWp\Ui\Tabs;
use UdyWfToWp\Utils\Utils;
use \WP_Query;

class Content_Ui{

	public static function add_content_meta_box_component($post){

		$content = new Content($post->ID);

		$tabs = new Tabs();
		$tabs->add_tab(__('Author', i18n::$textdomain),'author',self::get_author_form($content->query),Icon::faIcon('user',true,Icon_Type::SOLID()), 1);
		$tabs->add_tab(__('Taxonomy', i18n::$textdomain),'taxonomy',self::get_taxonomy_form($content->query),Icon::faIcon('filter',true,Icon_Type::SOLID()),2);
		$tabs->add_tab(__('Category', i18n::$textdomain),'category',self::get_category_form($content->query),Icon::faIcon('list-ul',true,Icon_Type::SOLID()), 3);
		$tabs->add_tab(__('Tag', i18n::$textdomain),'tag',self::get_tag_form($content->query),Icon::faIcon('tag',true,Icon_Type::SOLID()),4);
		$tabs->add_tab(__('Objects (Posts, Products, etc.)', i18n::$textdomain),'post',self::get_post_form($content->query),Icon::faIcon('file',true,Icon_Type::SOLID()),5);
		$tabs->add_tab(__('Date', i18n::$textdomain),'date',self::get_date_form($content->query),Icon::faIcon('calendar-alt',true,Icon_Type::SOLID()),6);
		$tabs->add_tab(__('Meta/Custom Field', i18n::$textdomain),'meta_custom_field',self::get_meta_custom_field_form($content->query),Icon::faIcon('i-cursor',true,Icon_Type::SOLID()),7);
		$tabs->add_tab(__('Sorting', i18n::$textdomain),'sorting',self::get_sorting_form($content->query),Icon::faIcon('sort-alpha-up',true,Icon_Type::SOLID()),8);
		$tabs->add_tab(__('Pagination', i18n::$textdomain),'pagination',self::get_pagination_form($content->query),Icon::faIcon('copy',true,Icon_Type::SOLID()),9);
		$tabs->add_tab(__('Related elements', i18n::$textdomain),'related',self::get_related_form($content->query),Icon::faIcon('link',true,Icon_Type::SOLID()),10);
		$tabs->show_tabs();
	}

	private static function get_author_form($query){

		$query_builder = Query::factory('author', 'name');

		$form = new Form();
		$form->add_wp_nonce( 'save_udesly_content', 'save_udesly_content_nonce' );
		$form->add_select('author__in','query_builder[author__in][]',__('Authors List',i18n::$textdomain),$query_builder->get_matched_items($query, 'author__in'),'[*]',__('Get entries by selected authors (using user_nicename)', i18n::$textdomain),true,'','select2-wf-to-wp', array(
			'subject' => 'author',
			'query_meta' => 'name',
			'minimum_input_length' => 2,
			'minimum_results_for_search' => 0,
		));
		$form->add_break_line();
		$form->add_select('author__not_in','query_builder[author__not_in][]',__('Authors Exclude List',i18n::$textdomain),$query_builder->get_matched_items($query, 'author__not_in'),'[*]',__('Exclude posts from selected authors', i18n::$textdomain),true,'','select2-wf-to-wp', array(
			'subject' => 'author',
			'query_meta' => 'name',
			'minimum_input_length' => 2,
			'minimum_results_for_search' => 0,
		));

		return $form->get_form();
	}

	private static function get_taxonomy_form($query){

		$query_builder = Query::factory('contenttaxonomy', 'name');

		$form = new Form();
		$form->add_select('contenttaxonomy','query_builder[contenttaxonomy][]',__('Taxonomy',i18n::$textdomain),$query_builder->get_matched_items($query, 'contenttaxonomy'),'[*]',__('A single taxonomy name, or a list of taxonomies.', i18n::$textdomain),false,'','select2-wf-to-wp', array(
			'subject' => 'contenttaxonomy',
			'query_meta' => 'name',
			'minimum_input_length' => 0,
			'minimum_results_for_search' => -1, //display all available options without search input
		));

		$query_builder = Query::factory('contentterm', 'name');

		$form->add_select('contentterm','query_builder[contentterm][]',__('Term Name',i18n::$textdomain),$query_builder->get_matched_items($query, 'contentterm'),'[*]',__('Return term by names.', i18n::$textdomain),true,'','select2-wf-to-wp', array(
			'subject' => 'contentterm',
			'query_meta' => 'name',
			'minimum_input_length' => 2,
			'minimum_results_for_search' => 0,
		));

		return $form->get_form();
	}

	private static function get_category_form($query){

		$query_builder = Query::factory('category', 'name');

		$form = new Form();
		$form->add_select('category__in','query_builder[category__in][]',__('Categories List', i18n::$textdomain),$query_builder->get_matched_items($query, 'category__in'),'[*]',__('Get entries associated with ANY of the selected category ids', i18n::$textdomain),true,'','select2-wf-to-wp', array(
			'subject' => 'category',
			'query_meta' => 'name',
			'minimum_input_length' => 2,
			'minimum_results_for_search' => 0,
		));
		$form->add_break_line();
		$form->add_select('category__not_in','query_builder[category__not_in][]',__('Categories Exclude List',i18n::$textdomain),$query_builder->get_matched_items($query, 'category__not_in'),'[*]',__('Get entries NOT associated with any of the selected category ids', i18n::$textdomain),true,'','select2-wf-to-wp', array(
			'subject' => 'category',
			'query_meta' => 'name',
			'minimum_input_length' => 2,
			'minimum_results_for_search' => 0,
		));

		return $form->get_form();
	}

	private static function get_tag_form($query){

		$query_builder = Query::factory('tag', 'name');

		$form = new Form();
		$form->add_select('tag__in','query_builder[tag__in][]',__('Tags List',i18n::$textdomain),$query_builder->get_matched_items($query, 'tag__in'),'[*]',__('Get entries having any of the selected tag ids', i18n::$textdomain),true,'','select2-wf-to-wp', array(
			'subject' => 'tag',
			'query_meta' => 'name',
			'minimum_input_length' => 2,
			'minimum_results_for_search' => 0,
		));
		$form->add_break_line();
		$form->add_select('tag__not_in','query_builder[tag__not_in][]',__('Tags Exclude List',i18n::$textdomain),$query_builder->get_matched_items($query, 'tag__not_in'),'[*]',__('Get entries not having any of the selected tag ids', i18n::$textdomain),true,'','select2-wf-to-wp', array(
			'subject' => 'tag',
			'query_meta' => 'name',
			'minimum_input_length' => 2,
			'minimum_results_for_search' => 0,
		));

		return $form->get_form();
	}

	private static function get_post_form($query){

		$query_builder = Query::factory('post', 'status');

		$form = new Form();
		$form->add_select('post_status','query_builder[post_status][]',__('Status',i18n::$textdomain),$query_builder->get_matched_items($query, 'post_status'),'[*]',__('Get entries by selected status', i18n::$textdomain),true,'','select2-wf-to-wp', array(
			'subject' => 'post',
			'query_meta' => 'status',
			'minimum_input_length' => 0,
			'minimum_results_for_search' => -1, //display all available options without search input
		));
		$form->add_break_line();
		$form->add_select('post_type','query_builder[post_type][]',__('Type',i18n::$textdomain),$query_builder->get_matched_items($query, 'post_type'),'[*]',__('Get entries by selected post type', i18n::$textdomain),false,'','select2-wf-to-wp', array(
			'subject' => 'post',
			'query_meta' => 'type',
			'minimum_input_length' => 0,
			'minimum_results_for_search' => -1, //display all available options without search input
		));
		$form->add_break_line();

		$query_builder = Query::factory('post', 'name');

		$form->add_select('post__in','query_builder[post__in][]',__('List',i18n::$textdomain),$query_builder->get_matched_items($query, 'post__in'),'[*]',__('Get posts by id', i18n::$textdomain),true,'','select2-wf-to-wp', array(
			'subject' => 'post',
			'query_meta' => 'name',
			'minimum_input_length' => 2,
			'minimum_results_for_search' => 0,
		));
		$form->add_break_line();
		$form->add_select('post__not_in','query_builder[post__not_in][]',__('Exclude List',i18n::$textdomain),$query_builder->get_matched_items($query, 'post__not_in'),'[*]',__('Exclude selected posts', i18n::$textdomain),true,'','select2-wf-to-wp', array(
			'subject' => 'post',
			'query_meta' => 'name',
			'minimum_input_length' => 2,
			'minimum_results_for_search' => 0,
		));
		return $form->get_form();
	}

	private static function get_date_form($query){
		$form = new Form();
		$form->add_number('year','query_builder[date_query][year]',__('Year', i18n::$textdomain),'',isset($query['date_query']['year']) ? $query['date_query']['year'] : '',0,3000,'Entries posted in the year','','','','1');
		$form->add_number('month','query_builder[date_query][month]',__('Month', i18n::$textdomain),'',isset($query['date_query']['month']) ? $query['date_query']['month'] : '',1,12,'Entries posted in the month','','','1');
		$form->add_number('week','query_builder[date_query][week]',__('Week',i18n::$textdomain),'',isset($query['date_query']['week']) ? $query['date_query']['week'] : '',0,53,'Entries posted in the week','','','1');
		$form->add_break_line('');
		$form->add_number('day','query_builder[date_query][day]',__('Day',i18n::$textdomain),'',isset($query['date_query']['day']) ? $query['date_query']['day'] : '',1,31,'Entries posted in the day','','','1');
		$form->add_number('hour','query_builder[date_query][hour]',__('Hour',i18n::$textdomain),'',isset($query['date_query']['hour']) ? $query['date_query']['hour'] : '',0,23,'Entries posted in the hour','','','1');
		$form->add_number('minute','query_builder[date_query][minute]',__('Minute',i18n::$textdomain),'',isset($query['date_query']['minute']) ? $query['date_query']['minute'] : '',0,59,'Entries posted in the minute','','','1');
		$form->add_number('second','query_builder[date_query][second]',__('Second',i18n::$textdomain),'',isset($query['date_query']['second']) ? $query['date_query']['second'] : '',0,59,'Entries posted in the second','','','1');
		return $form->get_form();
	}

	private static function get_meta_custom_field_form($query){

		$form = new Form();
		$form->add_text('meta_key','query_builder[meta_query][key]',__('Meta key', i18n::$textdomain),'',isset($query['meta_query']['key']) ? $query['meta_query']['key'] : '');
		$form->add_text('meta_value','query_builder[meta_query][value]',__('Meta value',i18n::$textdomain),'',isset($query['meta_query']['value']) ? $query['meta_query']['value'] : '');
		$form->add_break_line();
		$form->add_select('post_type','query_builder[meta_query][compare]',__('Meta compare', i18n::$textdomain),array(
			isset($query['meta_query']['compare'] ) ? $query['meta_query']['compare']  : ''=> isset($query['meta_query']['compare']) ? $query['meta_query']['compare'] : '',
		),isset($query['meta_query']['compare']) ? $query['meta_query']['compare'] : '',__('Get entries by selected post type', i18n::$textdomain),false,'','select2-wf-to-wp', array(
			'subject' => 'post_meta',
			'query_meta' => 'compare',
			'minimum_input_length' => 0,
			'minimum_results_for_search' => -1, //display all available options without search input
		));
		return $form->get_form();
	}

	private static function get_sorting_form($query){

		$form = new Form();
		$form->add_select('orderby','query_builder[orderby]',__('Sort By', i18n::$textdomain),array(
			isset($query['orderby']) ?  $query['orderby'] : ''=> isset($query['orderby']) ? $query['orderby'] : ''
		),isset($query['orderby']) ? $query['orderby'] : '','',false,'','select2-wf-to-wp', array(
			'subject' => 'sorting',
			'query_meta' => 'orderby',
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
		return $form->get_form();
	}

	private static function get_pagination_form($query){
		$form = new Form();
		$form->add_number('posts_per_page','query_builder[posts_per_page]',__('Posts Per Page',i18n::$textdomain),'',isset($query['posts_per_page']) ? $query['posts_per_page'] : '',0,1000,'','','',1);
		$form->add_number('offset','query_builder[offset]','Offset','',isset($query['offset']) ? $query['offset'] : '',0,1000,'','','',1);
		return $form->get_form();
	}

	private static function get_related_form($query){
		$form = new Form();
		$form->add_raw('<p>'.__('By checking an option other than "No related elements" all the other options, except "Sorting" and "Pagination", will be overridden.',i18n::$textdomain).'</p>');
		$form->add_break_line();
		$form->add_radio('off','query_builder[related]','No related elements', 'off',isset($query['related']) && $query['related'] == 'off' ? : '');
		$form->add_radio('contents','query_builder[related]','Only related tags', 'contents',isset($query['related']) && $query['related'] == 'contents' ? : '');
		$form->add_radio('categories','query_builder[related]','Only related categories', 'categories',isset($query['related']) && $query['related'] == 'categories' ? : '');
		return $form->get_form();
	}

}