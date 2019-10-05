jQuery( document ).ready(function($) {
	var $window = $(window),
		flexslider = { vars:{} };
 
	// tiny helper function to add breakpoints
	function getGridSize() {
	return (window.innerWidth < 360) ? 1 :
			(window.innerWidth < 480) ? 2 :
			(window.innerWidth < 768) ? 3 :
	       (window.innerWidth < 1024) ? 4 : 5;
	}

	function getGridmbrSize() {
	return (window.innerWidth < 480) ? 1 :
			(window.innerWidth < 768) ? 2 :
	       (window.innerWidth < 1024) ? 3 : 4;
	}

	function getGridmultiSize() {
	return (window.innerWidth < 768) ? 1 :
	       (window.innerWidth < 1024) ? 2 : 3;
	}

	$('.layer-slider').flexslider({
	    animation: idyllic_slider_value.idyllic_animation_effect,
	    animationLoop: true,
	    slideshow: true,
	    slideshowSpeed: idyllic_slider_value.idyllic_slideshowSpeed,
	    animationSpeed: idyllic_slider_value.idyllic_animationSpeed,
	    smoothHeight: true
	});

	$('.multi-slider').flexslider({
	    animation: "slide",
	    animationLoop: true,
	    slideshow: true,
	    slideshowSpeed: idyllic_slider_value.idyllic_slideshowSpeed,
	    animationSpeed: idyllic_slider_value.idyllic_animationSpeed,
	    smoothHeight: true,
	    itemWidth: 200,
	    itemMargin: 20,
		move: 1,
		minItems: getGridmultiSize(), // use function to pull in initial value
		maxItems: getGridmultiSize() // use function to pull in initial value
	});

	$('.team-slider').flexslider({
		animation: "slide",
		animationLoop: true,
		slideshow: true,
		controlNav: false,
		smoothHeight: false,
		slideshowSpeed: 5000,
		animationSpeed: 500,
		pauseOnHover: true,
		itemWidth: 200,
		itemMargin: 30,
		move: 1,
		minItems: getGridmbrSize(), // use function to pull in initial value
		maxItems: getGridmbrSize() // use function to pull in initial value
	});

	$('.client-slider').flexslider({
		animation: "slide",
		animationLoop: true,
		slideshow: true,
		controlNav: false,
		directionNav: false,
		smoothHeight: false,
		slideshowSpeed: 5000,
		animationSpeed: 2000,
		itemWidth: 200,
		itemMargin: 15,
		move: 1,
		minItems: getGridSize(), // use function to pull in initial value
		maxItems: getGridSize() // use function to pull in initial value
	});

	$('.testimonial-slider').flexslider({
		animation: "slide",
		animationLoop: true,
		slideshow: true,
		directionNav: false,
		smoothHeight: false,
		slideshowSpeed: 5000,
		animationSpeed: 1000,
		pauseOnHover: true
	});

	$window.resize(function() {
	    var gridSize = getGridSize();
	    var gridSize = getGridmbrSize();
	    var gridSize = getGridmultiSize();
	 
	    flexslider.vars.minItems = gridSize;
	    flexslider.vars.maxItems = gridSize;
	});
});

		