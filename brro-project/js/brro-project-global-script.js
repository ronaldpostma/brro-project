jQuery(function($) {
	var body = $('body');
	var screen = $(window);
    var screenPosition = screen.scrollTop();
	var footer = $('footer');
    var header = $('header.brro-sticky');
	// GLOBAL HELPER FUNCTIONS
	//
	// CHECK IF *ELEMENT IS IN VIEWPORT
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
	// THROTTLE TO LIMIT CALLS ON SCROLL
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

	// Click function
	$(document).on('click', '#some-trigger', function() {
		// do something
	});
	// Scroll back to top
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
	// GROUP ALL RESIZE AND SCROLL FUNCTIONS
	function brro_run_on_scroll() {
		brro_stickyheader();
		brro_back_to_top();
	}
	// LISTEN AND EXECUTE RESIZE AND SCROLL FUNCTIONS
	screen.on('scroll', window.brro_throttle_scroll(brro_run_on_scroll, 25));
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
});