/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
(function (e) {
    "use strict";
    var n = window.NAV_JS || {};

    n.stickyMenu = function () {
        e(window).scrollTop() > 350 ? e("body").addClass("nav-affix") : e("body").removeClass("nav-affix")
    },
        n.mobileMenu = {
            init: function () {
                this.toggleMenu(), this.menuMobile(), this.menuArrow()
            },
            toggleMenu: function () {
                e('.site-header').on('click', '.toggle-menu', function (event) {
                    var ethis = e('.main-navigation .menu .menu-mobile');
                    if (ethis.css('display') == 'block') {
                        ethis.slideUp('300');
                        e(".site-header").removeClass('mmenu-active');
                    } else {
                        ethis.slideDown('300');
                        e(".site-header").addClass('mmenu-active');
                    }
                    e('.ham').toggleClass('exit');
                });
                e('.site-header .main-navigation ').on('click', '.menu-mobile a i', function (event) {
                    event.preventDefault();
                    var ethis = e(this),
                        eparent = ethis.closest('li'),
                        esub_menu = eparent.find('> .sub-menu');
                    if (esub_menu.css('display') == 'none') {
                        esub_menu.slideDown('300');
                        ethis.addClass('active');
                    } else {
                        esub_menu.slideUp('300');
                        ethis.removeClass('active');
                    }
                    return false;
                });
            },
            menuMobile: function () {
                if (e('.main-navigation .menu > ul').length) {
                    var ethis = e('.main-navigation .menu > ul'),
                        eparent = ethis.closest('.main-navigation'),
                        pointbreak = eparent.data('epointbreak'),
                        window_width = window.innerWidth;
                    if (typeof pointbreak == 'undefined') {
                        pointbreak = 991;
                    }
                    if (pointbreak >= window_width) {
                        ethis.addClass('menu-mobile').removeClass('menu-desktop');
                        e('.main-navigation .toggle-menu').css('display', 'block');
                    } else {
                        ethis.addClass('menu-desktop').removeClass('menu-mobile').css('display', '');
                        e('.main-navigation .toggle-menu').css('display', '');
                    }
                }
            },
            menuArrow: function () {
                if (e('.site-header .main-navigation div.menu > ul').length) {
                    e('.site-header .main-navigation div.menu > ul .sub-menu').parent('li').find('> a').append('<i class="ion-ios-arrow-down">');
                }
            }
        },
        
        e(document).ready(function () {
            n.mobileMenu.init();
        }),
        e(window).scroll(function () {
            n.stickyMenu();
        }),
        e(window).resize(function () {
            n.mobileMenu.menuMobile();
        })
})(jQuery);