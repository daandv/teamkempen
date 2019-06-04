<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 26/04/2018
 * Time: 18:03
 */

namespace UdyWfToWp\Plugins\ContentManager\Settings;

class Settings_Blog{

	public static function apply_blog_excerpt($excerpt_lenght){
		$settings = Settings_Manager::get_saved_settings();

		if(isset($settings['excerpt_length']))
			return $settings['excerpt_length'];

		return $excerpt_lenght;
	}

	public static function apply_blog_excerpt_more($excerpt_more){
		$settings = Settings_Manager::get_saved_settings();

		if(isset($settings['excerpt_more']))
			return $settings['excerpt_more'];

		return $excerpt_more;
	}

	public static function filter_archive_title($title){

		$settings = Settings_Manager::get_saved_settings();

		if(!isset($settings['blog_category_title']))
			$settings['blog_category_title'] = 'Category: %s';

		if(!isset($settings['blog_tag_title']))
			$settings['blog_tag_title'] = 'Tag: %s';

		if(!isset($settings['blog_author_title']))
			$settings['blog_author_title'] = 'Author: %s';

		if(!isset($settings['blog_archive_title']))
			$settings['blog_archive_title'] = 'Archives';

		if ( is_category() ) {
			$categories_title = $settings['blog_category_title'];
			$title = sprintf( $categories_title, single_cat_title( '', false ) );
		} elseif ( is_tag() ) {
			$tag_title = $settings['blog_tag_title'];
			$title = sprintf( $tag_title, single_tag_title( '', false ) );
		} elseif ( is_author() ) {
			$author_title = $settings['blog_author_title'];
			$title = sprintf( $author_title, '<span class="vcard">' . get_the_author() . '</span>' );
		} elseif ( is_year() ) {
			/* translators: Yearly archive title. 1: Year */
			$title = sprintf( __( 'Year: %s' ), get_the_date( _x( 'Y', 'yearly archives date format' ) ) );
		} elseif ( is_month() ) {
			/* translators: Monthly archive title. 1: Month name and year */
			$title = sprintf( __( 'Month: %s' ), get_the_date( _x( 'F Y', 'monthly archives date format' ) ) );
		} elseif ( is_day() ) {
			/* translators: Daily archive title. 1: Date */
			$title = sprintf( __( 'Day: %s' ), get_the_date( _x( 'F j, Y', 'daily archives date format' ) ) );
		} elseif ( is_tax( 'post_format' ) ) {
			if ( is_tax( 'post_format', 'post-format-aside' ) ) {
				$title = _x( 'Asides', 'post format archive title' );
			} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
				$title = _x( 'Galleries', 'post format archive title' );
			} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
				$title = _x( 'Images', 'post format archive title' );
			} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
				$title = _x( 'Videos', 'post format archive title' );
			} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
				$title = _x( 'Quotes', 'post format archive title' );
			} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
				$title = _x( 'Links', 'post format archive title' );
			} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
				$title = _x( 'Statuses', 'post format archive title' );
			} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
				$title = _x( 'Audio', 'post format archive title' );
			} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
				$title = _x( 'Chats', 'post format archive title' );
			}
		} elseif ( is_post_type_archive() ) {
			/* translators: Post type archive title. 1: Post type name */
			$title = sprintf( __( 'Archives: %s' ), post_type_archive_title( '', false ) );
		} elseif ( is_tax() ) {
			$tax = get_taxonomy( get_queried_object()->taxonomy );
			/* translators: Taxonomy term archive title. 1: Taxonomy singular name, 2: Current taxonomy term */
			$title = sprintf( __( '%1$s: %2$s' ), $tax->labels->singular_name, single_term_title( '', false ) );
		} else {
			$archive_title = $settings['blog_archive_title'];
			$title = $archive_title;
		}

		return $title;

	}

	public static function new_subcategory_hierarchy( $templates ) {

		$settings = Settings_Manager::get_saved_settings();

		if(isset($settings['blog_use_template_parent_child']) && $settings['blog_use_template_parent_child'] == '1') {

			$category = get_queried_object();

			$parent_id = $category->category_parent;

			$templates = array();

			if ( $parent_id == 0 ) {
				// Use default values from get_category_template()
				$templates[] = "category-{$category->slug}.php";
				$templates[] = "category-{$category->term_id}.php";
				$templates[] = 'category.php';
			} else {
				// Create replacement $templates array
				$parent = get_category( $parent_id );

				// Current first
				$templates[] = "category-{$category->slug}.php";
				$templates[] = "category-{$category->term_id}.php";

				// Parent second
				$templates[] = "category-{$parent->slug}.php";
				$templates[] = "category-{$parent->term_id}.php";
				$templates[] = 'category.php';
			}
			return locate_template( $templates );
		}

		return $templates;
	}

}