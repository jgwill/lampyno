jQuery(document).ready(function ($) {
    "use strict";
    $(function () {
        $('#mainslider').slick({
            dots: false,
            autoplay: true,
            autoplaySpeed: 8000,
            infinite: true,
            speed: 500,
            fade: true,
            cssEase: 'linear',
            navigation: false,
            prevArrow: $('.prev'),
            nextArrow: $('.next'),
        });

        $(".gallery-columns-1, .wp-block-gallery.columns-1").each(function () {
            $(this).slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                fade: true,
                autoplay: true,
                autoplaySpeed: 8000,
                infinite: true,
                dots: true,
                nextArrow: '<i class="nav nav-angle-right"></i>',
                prevArrow: '<i class="nav nav-angle-left"></i>',
            });
        });

    });

    $(function () {
        jQuery('.widget-area').theiaStickySidebar({
            additionalMarginTop: 30
        });
    });

    $(function () {
        $('.icon-search').on('click', function() {
            $('body').toggleClass('united-model');
        });
        $('.cross-exit').on('click', function() {
            $('body').removeClass('united-model');
        });
    });

    $(".gallery, .blocks-gallery-item, div.zoom-gallery").each(function () {
        $(this).magnificPopup({
            delegate: 'a',
            type: 'image',
            closeOnContentClick: false,
            closeBtnInside: false,
            mainClass: 'mfp-with-zoom mfp-img-mobile',
            image: {
                verticalFit: true,
                titleSrc: function (item) {
                    return item.el.attr('title');
                }
            },
            gallery: {
                enabled: true
            },
            zoom: {
                enabled: true,
                duration: 300,
                opener: function (element) {
                    return element.find('img');
                }
            }
        });
    });

    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.scroll-up').fadeIn();
        } else {
            $('.scroll-up').fadeOut();
        }
    });

    $('.scroll-up').on("click", function (e) {
        $("html, body").animate({scrollTop: 0}, 600);
        return false;
    });

});