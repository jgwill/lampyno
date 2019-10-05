jQuery(document).ready(function()
{

	/*

		SCROLL TO NOTES OR BIB ENTRY

	*/

    jQuery(".zp-List").on( "click", ".zp-Notes-Reference a", zp_scroll_to );
    jQuery("body").on( "click", "a.zp-ZotpressInText", zp_scroll_to );

    function zp_scroll_to()
    {
        var $this = jQuery(this);

        var adminBarShowing = 0;
        if ( jQuery("#wpadminbar").length > 0 )
            adminBarShowing = jQuery("#wpadminbar").height();

        jQuery([document.documentElement, document.body]).animate({
            scrollTop: jQuery( $this.attr("href") ).offset().top - adminBarShowing
        }, 800, 'swing' );
    }


    /*

		HIGHLIGHT ENTRY

	*/

    jQuery(".zp-InText-Citation").on( "click", ".zp-ZotpressInText", function()
	{
		jQuery(jQuery(this).attr("href")).effect("highlight", { color: "#C5EFF7", easing: "easeInExpo" }, 1200);
	});


});
