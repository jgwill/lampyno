// Counter
jQuery(document).ready(function($) {
    $('.counter').counterUp({
	    delay: 10,
	    time: 1000,
	    offset: 70,
	    beginAt: 100,
	    formatter: function (n) {
	      return n.replace(/,/g, '.');
	    }
	});
});