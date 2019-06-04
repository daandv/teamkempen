(function ($) {
    'use strict';

    $(document).ready(function () {
        var $productGallery = $('[udesly-data="product-gallery"]');
        if ($productGallery.length) {
            var currentImageIndex = 0;
            var currentThumbnailClasses = '';
            var normalThumbnailClasses = '';
            if ($productGallery.find('[udesly-woo-product-thumbnail]').length > 1) {
                currentThumbnailClasses = $productGallery.find('[udesly-woo-product-thumbnail="0"]').attr('class');
                normalThumbnailClasses = $productGallery.find('[udesly-woo-product-thumbnail="1"]').attr('class');
            }
            var originalScript = JSON.parse($productGallery.find('[udesly-woo-product-lb-t="0"] script').text());
            var $firstTrigger = $productGallery.find('[udesly-woo-product-lb-t="0"]');
            var $arrows = $productGallery.find('.w-slider-arrow-right, .w-slider-arrow-left');
            var $dots = $productGallery.find('.w-slider-dot');
            var $thumbnails = $productGallery.find('[udesly-woo-product-thumbnail]');
            var $triggers = $productGallery.find('[udesly-woo-product-lb-t]');
            $arrows.on('click', function () {
                $productGallery.trigger('udeslyWooProductGalleryImageChange');
            });
            $dots.on('click', function () {
                $productGallery.trigger('udeslyWooProductGalleryImageChange');
            });
            $triggers.on('click', function () {
                var previousUrl = $firstTrigger.attr('data-previous-url');
                var latestUrl = $firstTrigger.attr('data-latest-url');
                var previousCaption = $firstTrigger.attr('data-previous-caption');
                var latestCaption = $firstTrigger.attr('data-latest-caption');
                var lightboxInterval = setInterval( function() {
                    if($('.w-lightbox-img').length) {
                        $('.w-lightbox-img[src="'+previousUrl+'"]').attr('src', latestUrl);
                        var currentCaption = $('.w-lightbox-caption').text();
                        if (currentCaption == previousCaption) {
                            $('.w-lightbox-caption').text(latestCaption);
                        }
                        clearInterval(lightboxInterval);
                    }
                }, 50);
            });
            $('body').on('click','.w-lightbox-control, .w-lightbox-img', function() {
                var previousUrl = $firstTrigger.attr('data-previous-url');
                var latestUrl = $firstTrigger.attr('data-latest-url');
                var previousCaption = $firstTrigger.attr('data-previous-caption');
                var latestCaption = $firstTrigger.attr('data-latest-caption');
                $($dots[$('.w-lightbox-item.w-lightbox-active').index()]).trigger('tap');
                var thumbnailInterval = setInterval( function() {
                    if ( $('.w-lightbox-item.w-lightbox-active').index() !== 0) {
                        clearInterval(thumbnailInterval);
                    }else if($('.w-lightbox-image[src="'+previousUrl+'"]').length) {
                        $('.w-lightbox-img[src="'+previousUrl+'"]').attr('src', latestUrl);
                        var currentCaption = $('.w-lightbox-caption').text();
                        if (currentCaption == previousCaption) {
                            $('.w-lightbox-caption').text(latestCaption);
                        }
                        clearInterval(thumbnailInterval);
                    }
                }, 50);
            });
            $productGallery.on('udeslyWooProductGalleryImageChange', function () {
                currentImageIndex = $productGallery.find('.w-slider-dot.w-active').index();
                changeCurrentThumbnail(currentImageIndex);
                changeCurrentTrigger(currentImageIndex);
            });
            $thumbnails.on('click', function () {
                var imageIndex = $(this).attr('udesly-woo-product-thumbnail');
                $($dots[imageIndex]).trigger('tap');
                $productGallery.trigger('udeslyWooProductGalleryImageChange');
            });

            var variations = $('form.variations_form').attr('data-product_variations');
            if (variations) {
                variations = JSON.parse(variations);
                var originalImage = originalScript.items[0].url;
                var originalCaption = originalScript.items[0].caption;
                $firstTrigger.attr('data-previous-url', originalImage);
                $firstTrigger.attr('data-previous-caption', originalCaption);
                $('form.variations_form select').on('change', function (e) {
                    $($dots[0]).trigger('tap');
                    $productGallery.trigger('udeslyWooProductGalleryImageChange');
                    var variationValue = $(this).val();
                    var variationType = 'attribute_' + $(this).attr('id');
                    var currentVariation = variations.filter(function (item) {
                        return item.attributes[variationType] === variationValue;
                    });
                    if (currentVariation[0] && currentVariation[0].image) {
                        var url = currentVariation[0].image.url;
                        var caption = currentVariation[0].image.caption;
                        $productGallery.find('[udesly-woo-product-thumbnail="0"]').css('background-image', 'url(' + url + ')');
                        $($productGallery.find('.w-slide').get(0)).css('background-image', 'url(' + url + ')');
                        $firstTrigger.attr('data-latest-url', url);
                        $firstTrigger.attr('data-latest-caption', caption);
                    }
                    else {
                        $productGallery.find('[udesly-woo-product-thumbnail="0"]').css('background-image', 'url(' + originalImage + ')');
                        $($productGallery.find('.w-slide').get(0)).css('background-image', 'url(' + originalImage + ')');
                        $firstTrigger.attr('data-latest-url', originalImage);
                        $firstTrigger.attr('data-latest-caption', originalCaption);
                    }

                });
            }

        }

        function changeCurrentThumbnail(newIndex) {
            if (normalThumbnailClasses !== '') {
                $thumbnails.attr('class', normalThumbnailClasses);
            }
            if (currentThumbnailClasses !== '') {
                $productGallery.find('[udesly-woo-product-thumbnail="' + newIndex + '"]').attr('class', currentThumbnailClasses);
            }
        }

        function changeCurrentTrigger(newIndex) {
            $triggers.removeClass('current');
            $productGallery.find('[udesly-woo-product-lb-t="' + newIndex + '"]').addClass('current');
        }

        var $tabs = $('[udesly-data="tabs"]');
        if ($tabs.length) {
            var currentTabClasses = $tabs.find('[udesly-data="current-tab"]').attr('class');
            var normalTabClasses = $tabs.find('[udesly-data="tab"]').attr('class');

            $tabs.find('.w-tab-link').on('click', function () {
                $tabs.find('.w-tab-link').attr('class', normalTabClasses);
                $(this).attr('class', currentTabClasses);
            });
        }
    });

})(jQuery);