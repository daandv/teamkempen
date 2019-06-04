<?php
/**
 * Created by PhpStorm.
 * User: umberto
 * Date: 12/04/2018
 * Time: 11:44
 */

namespace UdyWfToWp\Plugins\FrontendEditor;

use UdyWfToWp\Core\Udy_Wf_To_Wp;
use UdyWfToWp\Plugins\ContentManager\Settings\Settings_Manager;
use UdyWfToWp\Utils\Utils;

class FrontendEditor_Assets
{

    const FE1 = 'old_frontend_editor';
    const FE2 = 'new_frontend_editor';
    const FED = 'disabled_frontend_editor';


    public static $assets_folder_url = UDY_WF_TO_WP_PLUGIN_DIRECTORY_URL . 'includes/plugins/frontendeditor/assets/';

    public static function frontend_editor_status()
    {
        if (!defined('UDESLY_ENABLE_FRONTEND_EDITOR')) {
            // old frontend editor
            return self::FE1;
        } else {
            if (UDESLY_ENABLE_FRONTEND_EDITOR == true) {
                return self::FE2;
            } else {
                return self::FED;
            }
        }
    }

    public static function enqueue_styles()
    {
        //enable the frontend editor for admin

        $fe_status = self::frontend_editor_status();
        if (FrontendEditor_Configuration::current_user_can_use_frontend_editor() && self::FE1 == $fe_status) {
            wp_enqueue_style(FrontendEditor_Configuration::$plugin_name . '-content-tools-css', self::$assets_folder_url . 'css/content-tools.min.css', array(), Utils::getPluginVersion(), 'all');
            wp_enqueue_style(FrontendEditor_Configuration::$plugin_name, self::$assets_folder_url . 'css/udesly-frontend-editor-public.css', array(FrontendEditor_Configuration::$plugin_name . '-content-tools-css'), Utils::getPluginVersion(), 'all');
        }
    }

    public static function enqueue_scripts()
    {

        $fe_status = self::frontend_editor_status();
        $current_user_can_use_editor = FrontendEditor_Configuration::current_user_can_use_frontend_editor();
        if ($current_user_can_use_editor) {
            if (self::FE1 == $fe_status) {
                // old fe editor
                wp_enqueue_script(FrontendEditor_Configuration::$plugin_name . '-content-tools-js', self::$assets_folder_url . 'js/content-tools.js', array(), Utils::getPluginVersion(), true);
                wp_enqueue_script(FrontendEditor_Configuration::$plugin_name, self::$assets_folder_url . 'js/udesly-frontend-editor-public.js', array(
                    'jquery',
                    FrontendEditor_Configuration::$plugin_name . '-content-tools-js'
                ), Utils::getPluginVersion(), true);
                wp_localize_script(FrontendEditor_Configuration::$plugin_name, 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
                wp_enqueue_media();
            } else if (self::FE2 == $fe_status) {
                // new fe editor
                wp_enqueue_script(FrontendEditor_Configuration::$plugin_name, self::$assets_folder_url . 'js/udesly-fe-public.js', array(), Utils::getPluginVersion(), true);
                wp_localize_script(FrontendEditor_Configuration::$plugin_name, 'udesly_fe', array('ajax_url' => admin_url('admin-ajax.php'), 'ajax_nonce' => wp_create_nonce('udesly-fe-security')));
                wp_enqueue_media();
            }
        } else {
            if (self::FE1 == $fe_status) {
                wp_enqueue_script(FrontendEditor_Configuration::$plugin_name . '-disabled-js', self::$assets_folder_url . 'js/udesly-frontend-editor-disabled.js', array(), Utils::getPluginVersion(), true);
            }
        }
    }

    public static function enqueue_admin_styles()
    {
        //enable the frontend editor for admin
        if (FrontendEditor_Configuration::current_user_can_use_frontend_editor()) {
            wp_enqueue_style(FrontendEditor_Configuration::$plugin_name . '-admin', self::$assets_folder_url . 'css/udesly-frontend-editor-admin.css', array(), Utils::getPluginVersion(), 'all');
        }
    }


    public static function enqueue_admin_scripts()
    {
        //enable the frontend editor for admin
        if (FrontendEditor_Configuration::current_user_can_use_frontend_editor()) {
            wp_enqueue_script(FrontendEditor_Configuration::$plugin_name . '-admin', self::$assets_folder_url . 'js/udesly-frontend-editor-admin.js', array(
                'jquery'
            ), Utils::getPluginVersion(), true);
            wp_localize_script(FrontendEditor_Configuration::$plugin_name . '-admin', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
        }
    }

    public static function enqueue_frontend_editor_scripts()
    {
        if (FrontendEditor_Configuration::current_user_can_use_frontend_editor() && self::FE2 == self::frontend_editor_status()) {
            ?>
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
            <link href="<?php echo UDY_WF_TO_WP_PLUGIN_DIRECTORY_URL ?>externals/frontend-editor/css/main.3caf1b79.chunk.css" rel="stylesheet"><div id="udesly-frontend-editor-root"></div><script>!function(l){function e(e){for(var r,t,n=e[0],o=e[1],u=e[2],f=0,i=[];f<n.length;f++)t=n[f],p[t]&&i.push(p[t][0]),p[t]=0;for(r in o)Object.prototype.hasOwnProperty.call(o,r)&&(l[r]=o[r]);for(s&&s(e);i.length;)i.shift()();return c.push.apply(c,u||[]),a()}function a(){for(var e,r=0;r<c.length;r++){for(var t=c[r],n=!0,o=1;o<t.length;o++){var u=t[o];0!==p[u]&&(n=!1)}n&&(c.splice(r--,1),e=f(f.s=t[0]))}return e}var t={},p={2:0},c=[];function f(e){if(t[e])return t[e].exports;var r=t[e]={i:e,l:!1,exports:{}};return l[e].call(r.exports,r,r.exports,f),r.l=!0,r.exports}f.m=l,f.c=t,f.d=function(e,r,t){f.o(e,r)||Object.defineProperty(e,r,{enumerable:!0,get:t})},f.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},f.t=function(r,e){if(1&e&&(r=f(r)),8&e)return r;if(4&e&&"object"==typeof r&&r&&r.__esModule)return r;var t=Object.create(null);if(f.r(t),Object.defineProperty(t,"default",{enumerable:!0,value:r}),2&e&&"string"!=typeof r)for(var n in r)f.d(t,n,function(e){return r[e]}.bind(null,n));return t},f.n=function(e){var r=e&&e.__esModule?function(){return e.default}:function(){return e};return f.d(r,"a",r),r},f.o=function(e,r){return Object.prototype.hasOwnProperty.call(e,r)},f.p="/";var r=window.webpackJsonp=window.webpackJsonp||[],n=r.push.bind(r);r.push=e,r=r.slice();for(var o=0;o<r.length;o++)e(r[o]);var s=n;a()}([])</script><script src="<?php echo UDY_WF_TO_WP_PLUGIN_DIRECTORY_URL; ?>externals/frontend-editor/js/1.8e45171e.chunk.js"></script><script src="<?php echo UDY_WF_TO_WP_PLUGIN_DIRECTORY_URL; ?>externals/frontend-editor/js/main.f52b8af4.chunk.js"></script>
            <?php
        }
    }

    public function delete_frontend_editor_page_elements()
    {
        if (isset($_POST['post_id']) && isset($_POST['action']) && $_POST['action'] == 'delete_frontend_editor_page_elements' && FrontendEditor_Configuration::current_user_can_use_frontend_editor()) {
            $post = get_post($_POST['post_id']);
            global $wpdb;
            echo $wpdb->query('DELETE FROM ' . $wpdb->posts . ' WHERE `post_title` LIKE \'%' . $post->post_name . '_udesly_frontend_editor_%\' AND `post_type` LIKE \'udesly-fe\'');
        }
        wp_die();
    }

    // New frontend editor
    public function save_frontend_editor_content_editable()
    {
        check_ajax_referer('udesly-fe-security', 'security');
        if (FrontendEditor_Configuration::current_user_can_use_frontend_editor()) {
            if (!isset($_REQUEST['page_name'])) {
                wp_send_json(
                    array(
                        'error' => 'missing page name parameter'
                    )
                );
                wp_die();
            }
            $page_name = $_REQUEST['page_name'];
            delete_transient("udesly_fe_items_$page_name");

            $text_results = 0;
            $link_results = 0;
            $img_results = 0;
            $bg_image_results = 0;
            $iframe_results = 0;
            foreach ($_POST as $key => $value) {
                $post = get_page_by_title(sanitize_key("$page_name" . "_udesly_frontend_editor_$key"), 'OBJECT', 'udesly-fe');

                if (is_null($post))
                    continue;

                $post_id = $post->ID;
                if (udesly_string_starts_with($key, 'text_')) {

                    $string_to_update = array(
                        'ID' => $post_id,
                        'post_content' => $value,
                    );

                    if (!is_wp_error(wp_update_post($string_to_update))) {
                        $text_results++;
                    };
                } elseif (udesly_string_starts_with($key, 'link_')) {


                    $string_to_update = array(
                        'ID' => $post_id,
                        'post_content' => $value,
                    );
                    if (!is_wp_error(wp_update_post($string_to_update))) {
                        $link_results++;
                    };
                } elseif (udesly_string_starts_with($key, 'image_')) {

                    $string_to_update = array(
                        'ID' => $post_id,
                        'post_content' => json_encode(array('id' => $value)),
                    );
                    if (!is_wp_error(wp_update_post($string_to_update))) {
                        $img_results++;
                    };
                } elseif (udesly_string_starts_with($key, 'bg_image_')) {
                    $string_to_update = array(
                        'ID' => $post_id,
                        'post_content' => $value,
                    );
                    if (!is_wp_error(wp_update_post($string_to_update))) {
                        $bg_image_results++;
                    };
                } elseif (udesly_string_starts_with($key, 'iframe_')) {
                    $string_to_update = array(
                        'ID' => $post_id,
                        'post_content' => $value,
                    );
                    if (!is_wp_error(wp_update_post($string_to_update))) {
                        $iframe_results++;
                    };
                } elseif (udesly_string_starts_with($key, 'video_')) {
                    $videos = (object) array(
                            "videos" => [$value]
                    );
                    $string_to_update = array(
                        'ID' => $post_id,
                        'post_content' => json_encode($videos),
                    );
                    if (!is_wp_error(wp_update_post($string_to_update))) {
                        $iframe_results++;
                    };
                }
            }
            wp_send_json(array(  // send JSON back
                'text_results' => $text_results,
                'link_results' => $link_results,
                'bg_image_results' => $bg_image_results,
                'image_results' => $img_results,
                'iframe_results' => $iframe_results
            ));
        } else {
            wp_send_json(
                array(
                    'error' => 'you are not allowed to do this operation'
                )
            );
            wp_die();
        }


        wp_die();
    }

    // @deprecated
    public function save_content_editable()
    {
        //enable the frontend editor for admin
        if (FrontendEditor_Configuration::current_user_can_use_frontend_editor()) {

            $contents_block = $_POST['payload'];
            $images = $_POST['images'];
            $videos = $_POST['videos'];
            $bg_images = $_POST['bg_images'];
            $iframes = $_POST['iframes'];

            foreach ($contents_block as $post_name => $block) {
                // $id = post ID
                // $block = contenuto HTML

                $post = get_page_by_title(sanitize_key($post_name), 'OBJECT', 'udesly-fe');

                if (is_null($post))
                    continue;

                $post_id = $post->ID;
                $string_to_update = array(
                    'ID' => $post_id,
                    'post_content' => $block,
                );
                $contents_block_result = wp_update_post($string_to_update);

            }

            foreach ($images as $post_name => $image_id) {

                $post = get_page_by_title(sanitize_key($post_name), 'OBJECT', 'udesly-fe');

                if (is_null($post))
                    continue;

                $post_content = json_encode(array(
                    'src' => wp_get_attachment_image_src(sanitize_key($image_id), 'full')[0],
                    'srcset' => wp_get_attachment_image_srcset(sanitize_key($image_id)),
                    'alt' => trim(strip_tags(get_post_meta(sanitize_key($image_id), '_wp_attachment_image_alt', true)))
                ));

                $string_to_update = array(
                    'ID' => $post->ID,
                    'post_content' => wp_kses_post($post_content),
                );
                $images_result = wp_update_post($string_to_update);
            }

            foreach ($bg_images as $post_name => $image_id) {

                $post = get_page_by_title(sanitize_key($post_name), 'OBJECT', 'udesly-fe');

                if (is_null($post))
                    continue;

                $post_content = wp_get_attachment_image_src(sanitize_key($image_id), 'full')[0];

                $string_to_update = array(
                    'ID' => $post->ID,
                    'post_content' => wp_kses_post($post_content),
                );
                $bg_images_result = wp_update_post($string_to_update);
            }

            foreach ($videos as $post_name => $video_id) {

                $post = get_page_by_title(sanitize_key($post_name), 'OBJECT', 'udesly-fe');

                if (is_null($post))
                    continue;

                $media_element_url = wp_get_attachment_url(sanitize_key($video_id));

                $post_content = json_encode(array(
                    'videos' => $media_element_url
                ));

                $string_to_update = array(
                    'ID' => $post->ID,
                    'post_content' => wp_kses_post($post_content),
                );
                $videos_result = wp_update_post($string_to_update);
            }

            foreach ($iframes as $post_name => $iframe_src) {

                $post = get_page_by_title(sanitize_key($post_name), 'OBJECT', 'udesly-fe');

                if (is_null($post))
                    continue;

                $string_to_update = array(
                    'ID' => $post->ID,
                    'post_content' => wp_kses_post($iframe_src)
                );
                $iframes_result = wp_update_post($string_to_update);
            }

            if ($contents_block_result != 0 || $images_result != 0 || $videos_result != 0 || $bg_images_result != 0 || $iframes_result != 0) {

                if (isset($contents_block[0])) {
                    $page_name = explode('_udesly_frontend_editor', $contents_block[0]);

                    if (isset($page_name[0])) {
                        $post = get_page_by_title($page_name[0]);

                        if ($post)
                            FrontendEditor_Configuration::sync_page_fe_editor($post->ID, $post->post_name);

                    }
                }

                echo true;
            } else {
                echo false;
            }

            wp_die();
        }
    }
}