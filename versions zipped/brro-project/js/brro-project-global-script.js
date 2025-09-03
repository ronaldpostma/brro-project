jQuery(function($) {
	/* ========================================
	   GLOBAL SETUP
	   * DOM refs and helpers
	   ======================================== */
	var body = $('body');
	var screen = $(window);
    var screenPosition = screen.scrollTop();
	var footer = $('footer');
    var header = $('header.brro-sticky');
	/* ========================================
	   HELPERS
	   * Viewport and throttle utilities
	   ======================================== */
	/* ============= viewport utility =================== */
	$.fn.brroViewport = function(viewportTop, viewportBottom) {
		//var elementTop = $(this).offset().top;
		var element = $(this);
		var elementTop = element.length ? element.offset().top : 0;
    	var elementBottom = elementTop + $(this).outerHeight();
    	return elementBottom > viewportTop && elementTop < viewportBottom;
	};
	// Helper function to get the viewport boundaries set at top of functions with 'var viewport = brro_calc_viewport();'
	function brro_calc_viewport() { 
    	var top = screen.scrollTop();
    	var bottom = top + screen.height();
    	return { top, bottom };
	}
	/* ============= example usage: viewport check =================== */
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
	/* ============= throttle for scroll callbacks =================== */
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
	/* ========================================
	   HEADER INTERACTIONS
	   * Sticky effects and scroll behavior
	   ======================================== */
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
	/* ========================================
	   ACTIVE PAGE HIGHLIGHT
	   * Add current page class to header/footer links
	   ======================================== */
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
	/* ========================================
	   SCROLL/RESIZE GROUP
	   * Group callbacks and bind listeners
	   ======================================== */
	// GROUP ALL RESIZE AND SCROLL FUNCTIONS
	function brro_run_on_scroll() {
		brro_stickyheader();
	}
	// LISTEN AND EXECUTE RESIZE AND SCROLL FUNCTIONS
	screen.on('scroll', window.brro_throttle_scroll(brro_run_on_scroll, 25));
	/* ========================================
	   EDIT SHORTCUT FOR LOGGED-IN USERS
	   * Adds fixed edit link for current post/page
	   ======================================== */
	// Function: insert a fixed div in bottom left of the screen when body has class 'logged-in', with a link to edit
	// the current page or post. The ID can be extracted from the body class, it's either page-id-[nr] or postid-[nr], and the 
	// url would be /wp-admin/post.php?post=[nr]&action=edit
	function brro_insert_edit_link() {
		if (body.hasClass('logged-in')) {
			var idMatch = body.attr('class').match(/page-id-(\d+)|postid-(\d+)/);
			if (idMatch) {
				var id = idMatch[1] || idMatch[2];
				var url = '/wp-admin/post.php?post=' + id + '&action=edit';
				body.append('<div id="edit-link" style="position: fixed; bottom: 10px; left: 10px; background-color: rgba(0, 0, 0, 0.7); color: #fff; padding: 5px 10px; border-radius: 5px;z-index: 99999;"><a href="' + url + '" style="color: #fff; text-decoration: none;">Bewerken</a></div>');
			}
		}
	}
	brro_insert_edit_link();
	//
	// Close popup elementor on click
	$(document).on('click','.close-popup',function(event) {
		elementorProFrontend.modules.popup.closePopup({},event);
	});
});
