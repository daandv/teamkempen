<?php

/**
 * The single template specifically designed for the shortcode.
 * This file may be overridden by copying it into your theme directory, into a folder titled wpinventory/views/single-loop-all.php
 * While inventory does not use the WP post types, it does model functions after the WP core functions
 * to provide similar functionality.
 * */


$inventory_display = wpinventory_get_display_settings( 'widget' );
$display_labels    = apply_filters( 'wpim_widget_display_labels', FALSE );
global $wpim_widget_page_id;

?>
<div class="<?php wpinventory_class(); ?>">
	<?php foreach ( $inventory_display

	AS $sort => $field ) { ?>
    <p class="<?php echo $field; ?>">
		<?php if ( $display_labels ) { ?>
            <span class="label"><?php wpinventory_the_label( $field ); ?></span>
		<?php } ?>
		<?php if ( $field != 'inventory_description' ) { ?>
            <a href="<?php wpinventory_the_permalink( $wpim_widget_page_id ); ?>"><?php wpinventory_the_field( $field ); ?></a>
		<?php } else { ?>
			<?php wpinventory_the_field( $field ); ?>
		<?php } ?>
		<?php }
		do_action( 'wpim_template_loop_all_item_end', 'grid' ); ?>
</div>