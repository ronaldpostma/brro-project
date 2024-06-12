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
	function brro_sticky_effects() {
		if (screen.scrollTop() >= 20) {
			header.addClass('brro-sticky-effects');
			if (body.hasClass('home')) {
				$('#twow_bd_logo').css('transition','opacity 100ms var(--cubix)');
			}
		} else {
			header.removeClass('brro-sticky-effects');
			if (body.hasClass('home')) {
				$('.home #twow_bd_logo').css('transition','width 400ms var(--cubix), height 400ms var(--cubix), transform 400ms var(--cubix),opacity 300ms ease').css('opacity','1');
			}
		}
	}
	brro_sticky_effects();
	// ON SCROLL: HEADER MANIPULATIONS
	function brro_stickyheader() {
		// ADD STICKY MADE UP EFFECTS CLASS
		brro_sticky_effects();
		// MAKE HEADER GO UP AND DOWN CLASS 	
		screenPosition >= 1 && screen.scrollTop() > screenPosition
			? header.addClass('brro-headerup')
			: header.removeClass('brro-headerup')
        screenPosition = screen.scrollTop();
    }
	// ON SCROLL: SHOW WINKEL CONTENT
	function brro_winkelsectie() {
		if ( ($('#winkel').length > 0) && (body.hasClass('home') || body.hasClass('woocommerce-shop')) )  {
    		var winkelTop = $('#winkel').offset().top; // Get the distance of #winkel from the top of the document
    		var distance = winkelTop - screenPosition; // Calculate the distance from #winkel to the top of the window
			if(distance <= 150) {
        		$('#winkel').addClass('open');
    		} else {
				$('#winkel').removeClass('open');
			}
		}
	}
	brro_winkelsectie();
	// HEADER: OPEN SEARCH
	$(document).on('click', '#searchicon-widget', function() {
		if ($(this).hasClass('activesearch') && $('#sitesearch input').val() !== '') {
			$('#sitesearch form').submit();
		} else {
			$('#sitesearch').toggleClass('activesearch');
			$(this).toggleClass('activesearch');
		}
	});
	// HEADER: CLOSE SEARCH
	$(document).on('click', function(event) {
		// Check if the clicked element is not #searchicon-widget or #sitesearch
		if (!$(event.target).closest('#searchicon-widget, #sitesearch').length) {
			// Check if both #searchicon-widget and #sitesearch have 'activesearch' class
			if ($('#searchicon-widget').hasClass('activesearch') && $('#sitesearch').hasClass('activesearch')) {
				$('#searchicon-widget').removeClass('activesearch'); // Remove 'activesearch' class from #searchicon-widget
				$('#sitesearch').removeClass('activesearch'); // Remove 'activesearch' class from #sitesearch
			}
		}
	});
	// HOME: CLICK ON OPENINGSTIJDEN
	if (body.hasClass('home')) {
		$(document).on('click', '#open-trigger', function() {
			$('#adres-openingstijden').toggleClass('open');
			$('#open-trigger').css('opacity','0');
			$('#open-trigger').slideUp(200);
			$('#info').slideDown(200);
			setTimeout(function() {
				$('#info').css('opacity','1');
			}, 400);
		});
		$(document).on('click', '#close-trigger', function() {
			$('#adres-openingstijden').toggleClass('open');
			$('#info').css('opacity','0');
			$('#info').slideUp(200);
			$('#open-trigger').slideDown(200);
			setTimeout(function() {
				$('#open-trigger').css('opacity','1');
			}, 400);
		});
	}
	// HOME AND WOOCOMMERCE: ADD SALE PRICE TAG
	function brro_productloop_sale() {
		$('.e-loop-item.sale').each(function() {
        	// Extract the original price
        	var originalPrice = $(this).find('del .woocommerce-Price-amount.amount').text();
        	originalPrice = parseFloat(originalPrice.replace('€', '').replace(',', '.').trim());
        	// Extract the sale price
        	var salePrice = $(this).find('ins .woocommerce-Price-amount.amount').text();
        	salePrice = parseFloat(salePrice.replace('€', '').replace(',', '.').trim());
        	// Calculate discount percentage
       		var discountPercent = Math.round((originalPrice - salePrice) / originalPrice * 100);
        	// Output the discount percentage in the 'sale-discount' div
        	$(this).find('.sale-discount').text('-' + discountPercent + '%').css('opacity','1');
    	});
	}
	if (body.hasClass('home')) {
		brro_productloop_sale();
	}
	// TERUG (ARROW) BUTTON HREF TO REFERRER
	if ($('a.twowbutton.terug').length) {
		$('.product_tag-wandelschoenen a.twowbutton.terug').attr('href', '/webshop/wandelschoenen/');
		$('.product_tag-kleding a.twowbutton.terug').attr('href', '/webshop/kleding/');
		$('.product_tag-accessoires a.twowbutton.terug').attr('href', '/webshop/accessoires/');
		$('body:not(.single-twow_teamlid) a.twowbutton.terug').on('click', function(event) {
            // Attempt to go back using history API
            if (window.history.length > 1) {
				event.preventDefault();
	            window.history.back();
			}
		});
	}
	// WEBSHOP SEARCH TRIGGER
	$(document).on('click', '#webshopsearch-trigger', function() {
		$('#webshopsearch').toggleClass('webshopsearch-open');
		setTimeout(function() {
			$('#productsearch').toggleClass('webshopsearch-open');
		}, 200);		
	});
	// Scroll back to top
	$(document).on('click', 'a#to-top', function() {
		setTimeout(function() {
			header.removeClass('brro-sticky-effects');	
		}, 700);
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
		brro_winkelsectie();
		brro_back_to_top();
	}
	// LISTEN AND EXECUTE RESIZE AND SCROLL FUNCTIONS
	screen.on('scroll', window.brro_throttle_scroll(brro_run_on_scroll, 25));
	// Active page a class
	if (body.hasClass('single-post')) {
		$('li.inspiratie a').css('color','var(--yellow)');
	}
	if (body.hasClass('single-twow_evenement')) {
		$('li.evenementen a').css('color','var(--yellow)');
	} 
	if ( body.hasClass('single-product') || (body.hasClass('woocommerce') && body.hasClass('archive')) ) {
		$('li.webshop a').css('color','var(--yellow)');
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