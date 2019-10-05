(function ($) {
    'use strict';

    window.tpgFixLazyLoad = function () {
        $('.rt-tpg-container').each(function () {
            // jetpack Lazy load
            $(this).find('img.jetpack-lazy-image:not(.jetpack-lazy-image--handled)').each(function () {
                $(this).addClass('jetpack-lazy-image--handled').removeAttr('srcset').removeAttr('data-lazy-src').attr('data-lazy-loaded', 1);
            });
        });
    };

    window.initTpg = function () {
        $(".rt-tpg-container").each(function () {
            var $isotopeHolder = $(this).find('.tpg-isotope');
            var $isotope = $isotopeHolder.find('.rt-tpg-isotope');
            if ($isotope.length) {
                $isotopeHolder.trigger('tpg_item_before_load');
                tpgFixLazyLoad();
                var isotope = $isotope.imagesLoaded(function () {
                    $.when(tgpHeightResize()).done(function () {
                        isotope.isotope({
                            itemSelector: '.isotope-item',
                        });
                        setTimeout(function () {
                            isotope.isotope();
                            $isotopeHolder.trigger('tpg_item_after_load');
                        }, 100);
                    });
                });
                var $isotopeButtonGroup = $isotopeHolder.find('.rt-tpg-isotope-buttons');
                $isotopeButtonGroup.on('click', 'button', function (e) {
                    e.preventDefault();
                    var filterValue = $(this).attr('data-filter');
                    isotope.isotope({filter: filterValue});
                    $(this).parent().find('.selected').removeClass('selected');
                    $(this).addClass('selected');
                });
            }
            tgpHeightResize();
            overlayIconResizeTpg();
            $isotopeHolder.trigger("tpg_loaded");
        });
    };
    initTpg();
    $(window).on('load resize', function () {
        tgpHeightResize();
        overlayIconResizeTpg();
        $(".rt-tpg-container").trigger("tpg_loaded");
    });

    function tgpHeightResize() {
        var wWidth = $(window).width();
        if (wWidth > 767) {
            $(".rt-tpg-container").each(function () {
                var self = $(this),
                    rtMaxH = 0;
                self.imagesLoaded(function () {
                    self.children('.rt-row').children(".rt-equal-height:not(.rt-col-md-12)").height("auto");
                    self.children('.rt-row').children('.rt-equal-height:not(.rt-col-md-12)').each(function () {
                        var $thisH = $(this).actual('outerHeight');
                        if ($thisH > rtMaxH) {
                            rtMaxH = $thisH;
                        }
                    });
                    self.children('.rt-row').children(".rt-equal-height:not(.rt-col-md-12)").css('height', rtMaxH + "px");

                });
            });
        } else {
            $(".rt-tpg-container").find(".rt-equal-height").height('auto');
        }
    }

    function overlayIconResizeTpg() {
        $('.overlay').each(function () {
            var holder_height = $(this).height();
            var target = $(this).children('.link-holder');
            var targetd = $(this).children('.view-details');
            var a_height = target.height();
            var ad_height = targetd.height();
            var h = (holder_height - a_height) / 2;
            var hd = (holder_height - ad_height) / 2;
            target.css('top', h + 'px');
            targetd.css('margin-top', hd + 'px');
        });
    }

})(jQuery);
