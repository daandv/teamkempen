<?php
/**
 * Created by PhpStorm.
 * User: sydre
 * Date: 07/05/2018
 * Time: 14:45
 */

namespace UdyWfToWp\Plugins\Blog;

class Blog_Terms {

	static function extra_category_fields( $tag ) {    //check for existing featured ID
		$t_id     = $tag->term_id;
		$cat_meta = get_term_meta($t_id, '_featured_image', true);
		wp_enqueue_media();
		?>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="cat_Image_url"><?php _e( 'Featured Image' ); ?></label></th>
            <td>
               <?php echo self::image_uploader_field('featured_image', $cat_meta); ?>
            </td>
        </tr>
        <script>
            jQuery(document).ready( function( $ ) {

                $('body').on('click', '.udesly_upload_image_button', function () {

                    var button = $(this),
                        custom_uploader = wp.media({
                            title: 'Insert image',
                            library: {
                                // uncomment the next line if you want to attach image to the current post
                                // uploadedTo : wp.media.view.settings.post.id,
                                type: 'image'
                            },
                            button: {
                                text: 'Use this image' // button label text
                            },
                            multiple: false // for multiple image selection set to true
                        }).on('select', function () { // it also has "open" and "close" events
                            var attachment = custom_uploader.state().get('selection').first().toJSON();
                            $(button).removeClass('button').html('<img class="true_pre_image" src="' + attachment.url + '" style="max-width:95%;display:block;" />').next().val(attachment.id).next().show();

                        })
                            .open();
                });
                $('body').on('click', '.udesly_remove_image_button', function(){
                    $(this).hide().prev().val('').prev().addClass('button').html('Upload image');
                    return false;
                });
            });
        </script>
		<?php

	}

	static function save_extra_category_fields($term_id) {
		if ( isset( $_POST['featured_image'] ) ) {
			update_term_meta(sanitize_key($_POST['tag_ID']), '_featured_image', sanitize_text_field($_POST['featured_image']));
		}
    }

    static function image_uploader_field( $name, $value = '') {
	    $image = ' button">Upload image';
	    $image_size = 'full'; // it would be better to use thumbnail size here (150x150 or so)
	    $display = 'none'; // display state ot the "Remove image" button

	    if( $image_attributes = wp_get_attachment_image_src( $value, $image_size ) ) {

		    // $image_attributes[0] - image URL
		    // $image_attributes[1] - image width
		    // $image_attributes[2] - image height

		    $image = '"><img src="' . $image_attributes[0] . '" style="max-width:95%;display:block;" />';
		    $display = 'inline-block';

	    }

	    return '
	<div>
		<a href="#" class="udesly_upload_image_button' . $image . '</a>
		<input type="hidden" name="' . $name . '" id="' . $name . '" value="' . $value . '" />
		<a href="#" class="udesly_remove_image_button" style="display:inline-block;display:' . $display . '">Remove image</a>
	</div>';
    }
}