jQuery( function() {
		
		// Search toggle.
		var searchbutton = jQuery('#search-toggle');
		var searchbox = jQuery('#search-box');

			searchbutton.on('click', function(){
		    if (searchbutton.hasClass('header-search')){
		        searchbutton.removeClass('header-search').addClass('header-search-x');
		        searchbox.addClass('show-search-box');
		    }
		    
		    else{
		        searchbutton.removeClass('header-search-x').addClass('header-search');
		        searchbox.removeClass('show-search-box');
		    }
		});

		// Add class
		jQuery( function() {
			var jQuerymuse = jQuery("#page div");
			var jQuerysld = jQuery("body");

			if (jQuerymuse.hasClass("main-slider")) {
			       jQuerysld.addClass("sld-plus");
			}
		});

		// Big font for Post date
		jQuery(".post-image-content .entry-meta .posted-on a").html(function(){
		  var text= jQuery(this).text().trim().split(" ");
		  var first = text.shift();
		  return (text.length > 0 ? "<span class='big-font'>"+ first + "</span> " : first) + text.join(" ");
		});

		// Menu toggle for below 981px screens.
		( function() {
			var togglenav = jQuery( '.main-navigation' ), button, menu;
			if ( ! togglenav ) {
				return;
			}

			button = togglenav.find( '.menu-toggle' );
			if ( ! button ) {
				return;
			}
			
			menu = togglenav.find( '.menu' );
			if ( ! menu || ! menu.children().length ) {
				button.hide();
				return;
			}

			jQuery( '.menu-toggle' ).on( 'click', function() {
				jQuery(this).toggleClass("on");
				togglenav.toggleClass( 'toggled-on' );
			} );
		} )();

		// Menu toggle for side nav.
		jQuery(document).ready( function() {
		  //when the button is clicked
		  jQuery(".show-menu-toggle, .hide-menu-toggle, .page-overlay").click( function() {
		    //apply toggleable classes
		    jQuery(".side-menu").fadeToggle('slow');
		    jQuery(".side-menu").addClass("show");
		    jQuery(".page-overlay").toggleClass("side-menu-open"); 
		    jQuery("#page").addClass("side-content-open");  
		  });
		  
		  jQuery(".hide-menu-toggle, .page-overlay").click( function() {
		    jQuery(".side-menu").removeClass("show");
		    jQuery(".page-overlay").removeClass("side-menu-open");
		    jQuery("#page").removeClass("side-content-open");
		  });
		});

		/* allow keyboard access for portfolio link */
		var portfolioLink = jQuery('.portfolio-img, .portfolio-content .entry-header h2, .portfolio-content .entry-header div span').children('a');

		    portfolioLink.on( 'focus', function(){
		        jQuery(this).parents('.portfolio-content').addClass('focus');
		    });
		    portfolioLink.on( 'focusout', function(){
		        jQuery(this).parents('.portfolio-content').removeClass('focus');
		    });

		// Go to top button.
		jQuery(document).ready(function(){

		// Hide Go to top icon.
		jQuery(".go-to-top").hide();

		  jQuery(window).scroll(function(){

		    var windowScroll = jQuery(window).scrollTop();
		    if(windowScroll > 900)
		    {
		      jQuery('.go-to-top').fadeIn();
		    }
		    else
		    {
		      jQuery('.go-to-top').fadeOut();
		    }
		  });

		  // scroll to Top on click
		  jQuery('.go-to-top').click(function(){
		    jQuery('html,header,body').animate({
		    	scrollTop: 0
			}, 700);
			return false;
		  });

		});

} );