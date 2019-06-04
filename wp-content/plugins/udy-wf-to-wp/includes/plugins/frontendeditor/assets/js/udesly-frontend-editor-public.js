(function( $ ) {
	'use strict';

	$(document).ready(function(){

		var udesly_tools;

		udesly_tools = [
            [
                'bold',
                'italic',
                'link',
                'align-left',
                'align-center',
                'align-right',
                'unordered-list',
                'ordered-list',
                'line-break',
                'undo',
                'redo',
                'video'
            ]
        ];

        // pezza duplicati

        var fe_elements = [];
        $.each($('[udesly-data-name]'), function (el, index) {
            fe_elements.push($(this).attr('udesly-data-name'));
        });

         fe_elements = $.unique(fe_elements);

            $.each(fe_elements, function(index, el){

               $.each($('[udesly-data-name="'+el+'"]'), function(index,el){

                  if(index > 0){
                      $(el).removeAttr('udesly-data-editable');
                  }
               });
            });

        var editor = ContentTools.EditorApp.get();

        editor.init('[udesly-data-editable]', 'udesly-data-name');


        editor.toolbox().tools(udesly_tools);

        $('.ct-app .ct-widget').append('<div title="Enable media editing" class="ct-ignition__button ct-ignition__button--enable-images-videos"></div>');

        $('.ct-ignition__button--enable-images-videos').on('click', function () {
            if($('.udesly-wp-media-btn').is(":visible")) {
                $('.udesly-wp-media-btn').hide();
                $('.ct-ignition__button--enable-images-videos').removeClass('images-videos-disabled');
                $('.ct-ignition__button--enable-images-videos').attr('title','Enable media editing');
                $('udesly-fe').css('position','initial');
            }else{
                $('.ct-ignition__button--enable-images-videos').addClass('images-videos-disabled');
                $('.ct-ignition__button--enable-images-videos').attr('title','Disable media editing');
                $('udesly-fe').css('position','relative');
                $('.udesly-wp-media-btn').show();
            }
        });

        editor.addEventListener('start', function (ev) {
            $('[udesly-data-editable]').addClass('udesly-highlighted');
        });

        editor.addEventListener('stop', function (ev) {
            $('.udesly-wp-media-btn').hide();
            $('[udesly-data-editable]').removeClass('udesly-highlighted');

            $('.ct-ignition__button--enable-images-videos').removeClass('images-videos-disabled');
            $('.ct-ignition__button--enable-images-videos').attr('title','Enable media editing');
            $('udesly-fe').css('position','initial');

            if($('[udesly-fee-wp-image-id]').length ||
                $('[udesly-fee-wp-video-id]').length ||
                $('[udesly-fee-wp-bg-image-id]').length ||
                $('[udesly-fee-wp-iframe-id]').length
            )
                window.location.reload(true);
        });

        editor.addEventListener('saved', function (ev) {

            $('[udesly-data-editable]').removeClass('udesly-highlighted');
            var name, payload, regions, xhr;
            // Check that something changed
            regions = ev.detail().regions;

            if (Object.keys(regions).length == 0 &&
                $('[udesly-fee-wp-image-id]').length == 0 &&
                $('[udesly-fee-wp-video-id]').length == 0 &&
                $('[udesly-fee-wp-bg-image-id]').length == 0 &&
                $('[udesly-fee-wp-iframe-id]').length == 0
            ) {
                return;
            }

            // Set the editor as busy while we save our changes
            this.busy(true);

            // Collect the contents of each region into a FormData instance
            payload = {};
            var page_name = $('body').attr('udesly-page-name');

            for (name in regions) {
                if (regions.hasOwnProperty(name)) {
                    // payload[name]= regions[name];

                    var post_name = page_name + '_udesly_frontend_editor_' + name;

                    payload[post_name] = regions[name];
                }
            }

            // Send the update content to the server to be saved
            function onStateChange(ev) {
                // Check if the request is finished
				editor.busy(false);
				if (ev) {
					// Save was successful, notify the user with a flash
					new ContentTools.FlashUI('ok');
				} else {
					// Save failed, notify the user with a flash
					new ContentTools.FlashUI('no');
				}
            };

            var wp_images = {};
            $('[udesly-fee-wp-image-id]').each(function (i,el) {
                var udesly_fee_postid = page_name + '_udesly_frontend_editor_' + $(el).attr('udesly-data-name');
                wp_images[udesly_fee_postid] = $(el).attr('udesly-fee-wp-image-id');
            });

            var wp_bg_images = {};
            $('[udesly-fee-wp-bg-image-id]').each(function (i,el) {
                var udesly_fee_postid = page_name + '_udesly_frontend_editor_' + $(el).attr('udesly-data-name');
                wp_bg_images[udesly_fee_postid] = $(el).attr('udesly-fee-wp-bg-image-id');
            });

            var wp_videos = {};
            $('[udesly-fee-wp-video-id]').each(function (i,el) {
                var udesly_fee_postid = page_name + '_udesly_frontend_editor_' + $(el).attr('udesly-data-name');
                wp_videos[udesly_fee_postid] = $(el).attr('udesly-fee-wp-video-id');
            });

            var wp_iframes = {};
            $('[udesly-fee-wp-iframe-id]').each(function (i,el) {
                var udesly_fee_postid = page_name + '_udesly_frontend_editor_' + $(el).attr('udesly-data-name');
                wp_iframes[udesly_fee_postid] = $(el).attr('udesly-fee-wp-iframe-id');
            });

            var data = {
                'action': 'save_content_editable',
                'payload': payload,     // We pass php values differently!
                'images' : wp_images,
                'videos' : wp_videos,
                'bg_images' : wp_bg_images,
                'iframes' : wp_iframes
            };

            $.post(ajax_object.ajax_url, data, function(response) {
				onStateChange(response);
				window.location.reload(true);
            });


        });

        var file_frame; // variable for the wp.media file_frame
        var img_btn;

        $('body').on('click', '.udesly-fe-iframe-modal .ct-dialog__close', function () {
           $('.udesly-modal-wrap').remove();
        });

        $('body').on('click', '.udesly-fe-iframe-modal .ct-control--insert', function () {
           var url = $('.udesly-modal-wrap [name="url"]').val();

           var embed = getIframeUrl(url);

           if(embed == 'error')
               return;

           var udesly_data_name = $('.udesly-modal-wrap');

           var udesly_fe_tag = $('[udesly-data-name="'+ udesly_data_name.attr('udesly-data-name-modal') +'"]');

           udesly_fe_tag.find('iframe').attr('src', embed);

           udesly_fe_tag.attr('udesly-fee-wp-iframe-id', embed);

           udesly_data_name.remove();

        });

        // attach a click event (or whatever you want) to some element on your page
        $( 'body' ).on( 'click', '.udesly-wp-media-btn', function( event ) {

            img_btn = $(this);
            var media_type = img_btn.attr('media-type');

            event.preventDefault();

            if(media_type == 'iframe'){

                var udesly_data_name = $(this).parent().attr('udesly-data-name');

                $('.ct-app').append('<div class="udesly-modal-wrap" udesly-data-name-modal="' + udesly_data_name + '">' +
                    '<div class="udesly-fe-modal-bg ct-widget ct-modal ct-widget--active"></div>' +
                    '<div class="ct-widget ct-dialog ct-video-dialog ct-widget--active udesly-fe-iframe-modal">' +
                    '<div class="ct-dialog__header"><div class="ct-dialog__caption">Insert video</div>' +
                    '<div class="ct-dialog__close"></div></div><div class="ct-dialog__body">' +
                    '<div class="ct-dialog__controls"><div class="ct-control-group">' +
                    '<input class="ct-video-dialog__input" name="url" placeholder="Paste YouTube URL..." type="text">' +
                    '<div class="ct-control ct-control--text ct-control--insert ct-control">Insert</div></div></div></div><div class="ct-dialog__busy"></div></div>' +
                    '</div>');
                return;
            }

            if(media_type == 'image' || media_type == 'bg-image') {
                file_frame = wp.media.frames.file_frame = wp.media({
                    title: $(this).data('uploader_title'),
                    button: {
                        text: $(this).data('uploader_button_text'),
                    },
                    multiple: false, // set this to true for multiple file selection
                    library: {
                        type: ['image']
                    }
                });
            }

            if(media_type == 'video'){
                file_frame = wp.media.frames.file_frame = wp.media({
                    title: $(this).data('uploader_title'),
                    button: {
                        text: $(this).data('uploader_button_text'),
                    },
                    multiple: false, // set this to true for multiple file selection
                    library: {
                        type: ['video']
                    }
                });
            }

            file_frame.on( 'select', function() {

                var attachment = file_frame.state().get('selection').first().toJSON();

                if(attachment.type == 'image' && media_type == 'image') {
                    img_btn.parent().find('img').attr('src',attachment.url);
                    img_btn.parent().find('img').removeAttr('srcset');
                    img_btn.parent().attr('udesly-fee-wp-image-id', attachment.id);
                }

                if(attachment.type == 'image' && media_type == 'bg-image') {
                    img_btn.parent().css('background-image', 'url('+attachment.url+')');
                    img_btn.parent().attr('udesly-fee-wp-bg-image-id', attachment.id);
                }

                if(attachment.type == 'video') {
                    img_btn.closest('.udesly-frontend-editor-video').find('source').attr('src', attachment.url);
                    img_btn.closest('.udesly-frontend-editor-video').find('video')[0].load();
                    img_btn.parent().attr('udesly-fee-wp-video-id', attachment.id);
                }

            });

            file_frame.open();
        });

        function getIframeUrl(url){
            var pattern1 = /(?:http?s?:\/\/)?(?:www\.)?(?:vimeo\.com)\/?(.+)/g;
            var pattern2 = /(?:http?s?:\/\/)?(?:www\.)?(?:youtube\.com|youtu\.be)\/(?:watch\?v=)?(.+)/g;

            if(pattern1.test(url)){
                var replacement = '//player.vimeo.com/video/$1';
                return url.replace(pattern1, replacement);
            }


            if(pattern2.test(url)){
                var replacement = '//www.youtube.com/embed/$1';
                return url.replace(pattern2, replacement);
            }

            return 'error';
        }

	});

})( jQuery );
