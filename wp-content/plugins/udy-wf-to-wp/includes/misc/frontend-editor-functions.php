<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 16/04/2018
 * Time: 11:01
 */

use UdyWfToWp\Plugins\FrontendEditor\FrontendEditor_Configuration;
use UdyWfToWp\Plugins\FrontendEditor\FrontendEditor_Assets;

 function udesly_get_fe_items($page_name) {
     global $wpdb;
     $results = $wpdb->get_results(
       "SELECT post_content, post_title FROM $wpdb->posts WHERE `post_title` LIKE '%" . $wpdb->esc_like($page_name) . "_udesly_frontend_editor_%'"
     );
     $items = array();
     foreach($results as $item) {
         $items[str_replace($page_name. "_udesly_frontend_editor_", '', $item->post_title )] = $item->post_content;
     }
     return $items;
}


function udesly_set_fe_items($page_name) {

     $cache = get_transient("udesly_fe_items_$page_name");

     $cache = false;
     if (false !== $cache) {
         return $cache;
     }else {
         $items = _udesly_set_fe_items($page_name);
         set_transient("udesly_fe_items_$page_name",$items);
         return $items;
     }
}

function _udesly_set_fe_items($page_name) {

     $items = udesly_get_fe_items($page_name);

     $theme_dir = trailingslashit(get_stylesheet_directory_uri());

     $udesly_fe_items = array();
     foreach ($items as $key => $value) {
         if (udesly_string_starts_with($key, 'image_')) {
             $value = json_decode($value);

             if(isset($value->id)) {

                 $id = $value->id;

                 $img = wp_get_attachment_image_src(sanitize_key($id), 'full');


                 if ($img) {
                     $value = (object) array(
                         'src' => wp_get_attachment_image_src(sanitize_key($id), 'full')[0],
                         'srcset' => wp_get_attachment_image_srcset(sanitize_key($id)),
                         'alt' => trim(strip_tags(get_post_meta(sanitize_key($id), '_wp_attachment_image_alt', true)))
                     );
                 }else {
                     $value = (object) array(
                             'src' => '',
                             'srcset' => '',
                             'alt' => ''
                     );
                 }

             }else {
                 if (!udesly_string_is_absolute($value->src)) {
                     $value->src = $theme_dir . $value->src;

                 }
                 if (is_array($value->srcset)) {
                     $images = array();
                     foreach ($value->srcset as $img) {
                         if (!udesly_string_is_absolute($img)) {
                             $images[] = $theme_dir . udesly_string_strip_subdirectory_dots($img);
                         }else {
                             $images[] = $img;
                         }
                     }
                     $value->srcset = implode(', ', $images);

                 }
             }

         }
         if (udesly_string_starts_with($key, 'bg_image_')) {
             if ($value === 'udesly-no-content') {
                 $value = '';
             }else if(is_numeric($value)){
                 $img = wp_get_attachment_image_src(sanitize_key($value), 'full')[0];
                 $value = "background-image: url($img)";
             }else {
                 $value = "background-image: url($theme_dir$value)";
             }
         }
         if (udesly_string_starts_with($key, 'video_')) {
             $videos = '';
             $value = json_decode($value);

             foreach ($value->videos as $video) {
                     if (!udesly_string_is_absolute($video)) {
                         $videos .=  "<source src='". $theme_dir . udesly_string_strip_subdirectory_dots($video) . "' data-wf-ignore='true'>";
                     }else {
                         $videos .=  "<source src='". $video . "' data-wf-ignore='true'>";
                     }
             }

             $value->videos = $videos;
         }
         if (udesly_string_starts_with($key, 'iframe_')) {
             if (!udesly_string_is_absolute($value)) {
                 $value = $theme_dir . $value;
             }
         }
         if (udesly_string_starts_with($key, 'link_')) {
             if (!udesly_string_is_absolute($value) && !udesly_string_starts_with($value, 'mailto:') && !udesly_string_starts_with($value, 'tel:') && !udesly_string_starts_with($value, 'javascript:') && !udesly_string_starts_with($value, '#')) {
                 if ($value === 'index') {
                     $value = get_site_url();
                 } else {
                     $value = udesly_get_permalink_by_slug($value);
                 }
             }
         }
         $udesly_fe_items[$key] = $value;
     }
     return $udesly_fe_items;
}


function udesly_set_fe_configuration($items, $page) {
    if (FrontendEditor_Configuration::current_user_can_use_frontend_editor() && FrontendEditor_Assets::FE2 == FrontendEditor_Assets::frontend_editor_status()) {
        if ($items) { ?>
            <script type="application/json" id="udesly-fe-config" data-page="<?php echo $page; ?>">
              <?php  echo json_encode($items); ?>
            </script>
        <?php }
    }
}

/*
 * Old frontend editor content
 * @deprecated
 */
function udesly_get_frontend_editor_content($name, $type){

    $post = get_page_by_title( $name, 'OBJECT', 'udesly-fe' );

    if(is_null($post) || is_wp_error($post))
        return;

    switch ($type) {
        case 'text':
            return $post->post_content;
            break;

        case 'image-src':
            $post_content = json_decode($post->post_content);

            if( strpos($post_content->src,'http') !== false){
                return $post_content->src;
            }

            $image_dir = trailingslashit(get_stylesheet_directory_uri());

            return $image_dir.$post_content->src;
            break;

        case 'image-alt':
            $post_content = json_decode($post->post_content);

            if(isset($post_content->alt)){
                return $post_content->alt;
            }

            return '';
            break;

        case 'image-srcset':
            $post_content = json_decode($post->post_content);
            $image_dir = trailingslashit(get_stylesheet_directory_uri());

            $srcset_string = '';


            if(is_string($post_content->srcset))
                return str_replace('../', '', $post_content->srcset);

            $srcset_size = count($post_content->srcset);
            for($i = 0; $i < $srcset_size; $i++){
                if($i != $srcset_size-1) {
                    if(!is_null($post_content->srcset[ $i ])) {
                        if (strpos($post_content->srcset[$i], 'http') !== false) {
                            $srcset_string .= $post_content->srcset[$i] . ', ';
                        } else {
                            $srcset_string .= $image_dir .  str_replace('../', '', $post_content->srcset[$i]) . ', ';
                        }
                    }
                }else{
                    if(!is_null($post_content->srcset[ $i ])) {
                        if (strpos($post_content->srcset[$i], 'http') !== false) {
                            $srcset_string .= $post_content->srcset[$i];
                        } else {
                            $srcset_string .= $image_dir . $post_content->srcset[$i];
                        }
                    }
                }
            }

            return $srcset_string;
            break;

        case 'video':
            $post_content = json_decode($post->post_content);
            $video_dir = trailingslashit(get_stylesheet_directory_uri());

            if(is_string($post_content->videos)){
                $video_src = $post_content->videos;
                if (strpos($video_src,'http') !== false){
                    return "<source src='$video_src' data-wf-ignore='true'>";
                }
                else {
                    return "<source src='$video_dir$video_src' data-wf-ignore='true'>";
                }

            }

            $html = '';
            foreach ($post_content->videos as $video_src){
                if (strpos($video_src,'http') !== false){
                    $html .= "<source src='$video_src' data-wf-ignore='true'>";
                }else {
                    $html .= "<source src='$video_dir$video_src' data-wf-ignore='true'>";
                }
            }

            return $html;

            break;

        case 'bg-image':
            $post_content = $post->post_content;

            if($post_content == 'udesly-no-content')
                return '';

            if( strpos($post_content,'http') !== false){
                return 'background-image: url('.$post_content.')';
            }

            $image_dir = trailingslashit(get_stylesheet_directory_uri());
            return 'background-image: url('.$image_dir.$post_content.')';

            break;

        case 'iframe':
            return $post->post_content;

            break;
    }

}

