jQuery(function($) {
	var body = $('body');
	var screen = $(window);
    var screenPosition = screen.scrollTop();
	var footer = $('footer');
    var header = $('header.brro-sticky');
	// GLOBAL HELPER FUNCTIONS
	//
	//
	// CHECK IF *ELEMENT IS IN VIEWPORT - REMOVE IF NOT USED
	$.fn.brroViewport = function(viewportTop, viewportBottom) {
		//var elementTop = $(this).offset().top;
		var element = $(this);
		var elementTop = element.length ? element.offset().top : 0;
    	var elementBottom = elementTop + $(this).outerHeight();
    	return elementBottom > viewportTop && elementTop < viewportBottom;
	};
	// Helper function to get the viewport boundaries set at top of functions with "var viewport = brro_calc_viewport();"
	function brro_calc_viewport() { 
    	var top = screen.scrollTop();
    	var bottom = top + screen.height();
    	return { top, bottom };
	}
	// Example usage to check if item is viewport.
	function brro_check_if_in_viewport() {
		var viewport = brro_calc_viewport();
		var exampleDiv = $('#thisdiv');
		if (exampleDiv.length && thisDiv.brroViewport(viewport.top, viewport.bottom)) {
			console.log('#thisdiv is in the viewport');
		} else {
			console.log('#thisdiv is not in the viewport');
		}
	}
	// Also add to scroll function brro_run_on_scroll()
	brro_check_if_in_viewport()
	//
	//
	//
	//
	// THROTTLE TO LIMIT CALLS ON SCROLL, USED IN SCROLL FUNCTIONS - DON'T REMOVE
	window.brro_throttle_scroll = function(func, limit) {
    	let inThrottle;
    	return function() {
        	const args = arguments;
        	const context = this;
        	if (!inThrottle) {
            	func.apply(context, args);
            	inThrottle = true;
            	setTimeout(() => inThrottle = false, limit);
        	}
    	}
	};
	//
	//
	//
	//
	//
	// ON PAGE LOAD: HEADER MANIPULATIONS
	// ADD STICKY MADE UP EFFECTS CLASS
	function brro_sticky_header_effects() {
		if (screen.scrollTop() >= 20) {
			header.addClass('brro-sticky-effects');
			if (body.hasClass('home')) {
				// Do something to the logo if needed
			}
		} else {
			header.removeClass('brro-sticky-effects');
			if (body.hasClass('home')) {
				// Revert doing something to the logo if needed
			}
		}
	}
	brro_sticky_header_effects();
	// ON SCROLL: HEADER MANIPULATIONS
	function brro_stickyheader() {
		// ADD STICKY MADE UP EFFECTS CLASS
		brro_sticky_header_effects();
		// MAKE HEADER GO UP AND DOWN CLASS 	
		screenPosition >= 1 && screen.scrollTop() > screenPosition
			? header.addClass('brro-headerup')
			: header.removeClass('brro-headerup')
        screenPosition = screen.scrollTop();
    }
	//
	//
	//
	//
	//
	// Active page a class
	if (body.hasClass('single-post')) {
		$('li.blog-post a').addClass('current-page-open');
	}
	if (body.hasClass('single-custom_post')) {
		$('li.custom-post a').addClass('current-page-open');
	} 
	var currentUrl = window.location.origin + window.location.pathname;
    $('header a, footer a').each(function() {
        var linkUrl = $(this).attr('href');
        if (linkUrl) {
            var fullLinkUrl = linkUrl.startsWith('/') ? window.location.origin + linkUrl : linkUrl;
            if (fullLinkUrl === currentUrl) {
                $(this).addClass('current-page-open');
            }
        }
    });
	//
	//
	//
	//
	//
	//
	// Scroll back to top
	function brro_add_back_to_top() {
        // Add a back to top button to the page 'a#to-top'
    	if (footer.length) {
        	footer.append('<a id="to-top" href="#page-top" class="not-to-top" aria-label="Terug naar boven" role="button"><img src="https://brro.nl/wp-content/uploads/2024/11/brro-arrow-up.svg" alt="Terug naar boven"></a>');
		} else {
        	body.append('<a id="to-top" href="#page-top" class="not-to-top" aria-label="Terug naar boven" role="button"><img src="https://brro.nl/wp-content/uploads/2024/11/brro-arrow-up.svg" alt="Terug naar boven"></a>');
		}
		if ($('.elementor-location-header').length) {
			$('.elementor-location-header').prepend('<div id="page-top"></div>');
    	} else {
			body.prepend('<div id="page-top"></div>');
    	}
	}
	brro_add_back_to_top();
	//
	$(document).on('click', 'a#to-top', function() {
		let attempts = 0;
		const interval = setInterval(function() {
			if (header.hasClass('brro-sticky-effects') || attempts >= 8) {
				header.removeClass('brro-sticky-effects');
				clearInterval(interval);
			}
			attempts++;
		}, 200);
	});
	//
	function brro_back_to_top() {
        var totalHeight = $(document).height();
        // Check both conditions: total page height and scrolled amount
        if (totalHeight > 1800 && screenPosition > 1200) {
            $('#to-top').removeClass('not-to-top');
        } else {
            $('#to-top').addClass('not-to-top');
        }
    }
	brro_back_to_top();
	//
	//
	//
	//
	// Close popup elementor on click
	$(document).on('click','.close-popup',function(event) {
		elementorProFrontend.modules.popup.closePopup({},event);
	});
	//
	//
	//
	//
	//
	//
	// GROUP ALL RESIZE AND SCROLL FUNCTIONS
	function brro_run_on_scroll() {
		brro_stickyheader();
		brro_back_to_top();
	}
	// LISTEN AND EXECUTE RESIZE AND SCROLL FUNCTIONS
	screen.on('scroll', window.brro_throttle_scroll(brro_run_on_scroll, 25));
	//
	//
	//
	//
	// Click function exmaple
	//$(document).on('click', '#some-trigger', function() {
		// do something
	//});
});