<?php

/**
 * This file contains "default" filters that are run as part of the core WP Inventory installation.
 */

/**
 * These filters ensure that inventory displays, even when no display is configured.
 * To override: add_filter( 'wpim_ignore_default_display', function() { return TRUE; } );
 */
if ( ! apply_filters( 'wpim_ignore_default_display', FALSE ) ) {
	add_filter( 'wpim_display_settings', 'wpinventory_default_display_settings', 10, 2 );
	add_filter( 'wpim_display_listing_settings', 'wpinventory_default_listing_display_settings', 20 );
	add_filter( 'wpim_display_detail_settings', 'wpinventory_default_detail_display_settings', 20 );
}


if ( ! apply_filters( 'wpim_ignore_default_display', FALSE ) ) {
	add_action( 'wpim_single_before_the_field', array( 'WPIMDefaultLayout', 'open_column' ), 10, 2 );
	add_action( 'wpim_the_field_close', array( 'WPIMDefaultLayout', 'close_column' ), 10, 2 );
}


class WPIMDefaultLayout {
	private static $column_opened = FALSE;

	/**
	 * Function to determine if "two column" display should be used.
	 * If so, "open" the column tag.
	 *
	 * @param string $field
	 * @param        $display
	 */
	public static function open_column( $field, $display ) {
		if ( self::$column_opened ) {
			return;
		}

		if ( ! self::image_is_first( $display ) ) {
			return;
		}

		if ( ! self::is_image_field( $field ) ) {
			return;
		}

		self::$column_opened = TRUE;

		echo '<div class="wpinventory-column wpinventory-default-left-column">';
	}

	public static function close_column( $field, $display ) {
		if ( ! self::$column_opened ) {
			return;
		}

		$position = array_search( $field, $display );

		if ( ( $position - 1 ) >= count( $display ) ) {
			echo '</div>';
		} else if ( $position <= 1 ) {
			$second_field = ( ! empty( $display[1] ) ) ? $display[1] : NULL;

			if ( ( 1 === $position ) && self::is_image_field( $second_field ) ||
			     ( 0 === $position ) && ! self::is_image_field( $second_field ) ) {
				echo '</div>';
				echo '<div class="wpinventory-column wpinventory-default-right-column">';
			}
		}
	}

	private static function image_is_first( $display ) {
		$first_field = reset( $display );

		return self::is_image_field( $first_field );
	}

	private static function is_image_field( $field ) {
		return ( in_array( $field, array( 'inventory_image', 'inventory_images' ) ) );
	}
}

class WPIMStockNotices {
	public static function init() {
		add_action( 'wpim_before_reserve_form', [ __CLASS__, 'wpim_before_reserve_form' ] );
		add_action( 'wpim_template_loop_all_item_start', [ __CLASS__, 'wpim_template_loop_all_item_start' ] );
		add_action( 'wpim_admin_pre_edit_item', [ __CLASS__, 'wpim_admin_pre_edit_item' ] );
		add_filter( 'wpim_out_of_stock', [ __CLASS__, 'wpim_out_of_stock' ] );
		add_filter( 'wpim_low_quantity_notice', [ __CLASS__, 'wpim_low_quantity_notice' ] );
	}

	/**
	 * WPIM action, run right before the reserve cart in a single item view.
	 * NOTE: this action ALSO triggers the Reserve Cart to NOT display if the item
	 * is out of stock.
	 */
	public static function wpim_before_reserve_form() {
		$show_message          = wpinventory_get_config( 'out_of_stock_message' );
		$out_of_stock_quantity = (float) wpinventory_get_config( 'out_of_stock_quantity' );
		$item_quantity         = (float) wpinventory_get_field( 'inventory_quantity' );

		if ( $show_message && $item_quantity <= $out_of_stock_quantity ) {
			$content = '<div class="wpinventory_error out_of_stock">';
			$message = WPIMCore::__( 'This item is currently out of stock' );
			$content .= apply_filters( 'wpim_detail_out_of_stock_text', $message );
			$content .= '</div>';

			echo $content;

			WPIMReserveService::display( FALSE );
		}
	}

	/**
	 * WPIM action, run right before displaying an item in the "listing" screen
	 *
	 * @param string $display_type
	 */
	public static function wpim_template_loop_all_item_start( $display_type ) {
		if ( 'grid' != $display_type ) {
			return;
		}

		$message               = wpinventory_get_config( 'out_of_stock_message' );
		$out_of_stock_quantity = wpinventory_get_config( 'out_of_stock_quantity' );
		$item_quantity         = (float) wpinventory_get_field( "inventory_quantity" );

		if ( (int) $message && ( $item_quantity <= $out_of_stock_quantity ) && ( apply_filters( 'wpim_single_loop_all_show_stock_warning', TRUE ) ) ) {
			echo self::wpim_out_of_stock();
		}
	}

	/**
	 * WPIM action, run immediately before rendering an item in the admin "edit" screen
	 *
	 * @param object $item
	 */
	public static function wpim_admin_pre_edit_item( $item ) {
		$inventory_quantity = ( ! empty( $item->inventory_quantity ) ) ? (float) $item->inventory_quantity : 0;
		if ( (int) wpinventory_get_config( 'low_quantity_alert' ) && ( $inventory_quantity < wpinventory_get_config( 'low_quantity_amount' ) ) ) {
			echo self::wpim_low_quantity_notice();
		}
	}

	/**
	 * "Out of Stock" message.
	 *
	 * Can be displayed either with `echo apply_filters('wpim_out_of_stock');`
	 * OR from within this class with `echo self::wpim_out_of_stock();`
	 *
	 * @return string
	 */
	public static function wpim_out_of_stock() {
		$content = '<div class="wpinventory_error out_of_stock">';
		$message = WPIMCore::__( 'Out of Stock' );
		$content .= apply_filters( 'wpim_listing_out_of_stock_text', $message );
		$content .= '</div>';

		return $content;
	}

	/**
	 * "This item is below low quantity" message.
	 *
	 * Can be displayed either with `echo apply_filters('wpim_low_quantity_notice');`
	 * OR from within this class with `echo self::wpim_low_quantity_notice();`
	 *
	 * @return string
	 */
	public static function wpim_low_quantity_notice() {
		$message = sprintf( WPIMCore::__( 'This item has fallen below the low quantity amount of %d' ), wpinventory_get_config( 'low_quantity_amount' ) );
		$message = apply_filters( 'wpim_admin_item_edit_low_quantity_message', $message );
		$content = '<div class="wpim_notice wpim_error low_quantity_warning">' . $message . '.</div>';

		return $content;
	}
}

WPIMStockNotices::init();
