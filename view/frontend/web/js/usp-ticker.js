define([
	'jquery',
	'domReady!'
], function ($) {
	'use strict';
	
	return function (config) {
		var ticker = $('#cravendunnill-headerusps-ticker'),
			slides = ticker.find('.cravendunnill-headerusp-slide'),
			currentSlide = 0,
			slideCount = slides.length,
			interval,
			animationSpeed = 800,
			slideInterval = 5000,
			isAnimating = false;
			
		if (slideCount <= 0) {
			return;
		}
		
		// Hide all slides except the first one
		slides.hide();
		$(slides[0]).show();
		updateTicker($(slides[0]));
		
		// Start the slide show
		startSlideShow();
		
		/**
		 * Start slide show
		 */
		function startSlideShow() {
			interval = setInterval(function () {
				if (!isAnimating) {
					nextSlide();
				}
			}, slideInterval);
		}
		
		/**
		 * Show next slide
		 */
		function nextSlide() {
			isAnimating = true;
			var nextIndex = (currentSlide + 1) % slideCount;
			var currentBackground = $(slides[currentSlide]).data('background') || '#122C58';
			var nextBackground = $(slides[nextIndex]).data('background') || '#122C58';
			var currentTextColor = $(slides[currentSlide]).data('text-color') || '#FFFFFF';
			var nextTextColor = $(slides[nextIndex]).data('text-color') || '#FFFFFF';
			
			// Prepare the next slide content
			var nextSlide = $(slides[nextIndex]);
			var nextUrl = nextSlide.data('url') || '#';
			var nextIsBold = nextSlide.data('is-bold');
			var nextContent = nextSlide.html();
			var nextLinkHtml = '<a href="' + nextUrl + '" class="cravendunnill-usp-link" style="color: ' + nextTextColor + '; font-weight: ' + (nextIsBold ? 'bold' : 'normal') + ';">' + nextContent + '</a>';
			
			// Fade out current content
			ticker.find('.cravendunnill-headerusps-container').fadeOut(animationSpeed/2, function() {
				// Change background if different
				if (currentBackground !== nextBackground) {
					ticker.css({
						'transition': 'background-color 0.5s ease',
						'background-color': nextBackground,
						'color': nextTextColor
					});
				}
				
				// Update the content
				$(this).html(nextLinkHtml).fadeIn(animationSpeed/2, function() {
					currentSlide = nextIndex;
					isAnimating = false;
				});
				
				// Update hover styles
				updateHoverStyles(nextSlide);
			});
		}
		
		/**
		 * Update ticker styles based on slide data
		 *
		 * @param {jQuery} slide
		 */
		function updateTicker(slide) {
			var backgroundColor = slide.data('background') || '#122C58',
				textColor = slide.data('text-color') || '#FFFFFF',
				url = slide.data('url') || '#',
				isBold = slide.data('is-bold');
				
			// Update styles
			ticker.css({
				'background-color': backgroundColor,
				'color': textColor
			});
			
			// Create or update the link
			var content = slide.html();
			var linkHtml = '<a href="' + url + '" class="cravendunnill-usp-link" style="color: ' + textColor + '; font-weight: ' + (isBold ? 'bold' : 'normal') + ';">' + content + '</a>';
			
			// Update container content
			ticker.find('.cravendunnill-headerusps-container').html(linkHtml);
			
			// Update hover styles
			updateHoverStyles(slide);
		}
		
		/**
		 * Update hover styles for the current slide
		 *
		 * @param {jQuery} slide
		 */
		function updateHoverStyles(slide) {
			var hoverBackground = slide.data('hover-background') || '#000000',
				textColor = slide.data('text-color') || '#FFFFFF';
			
			// Create CSS for hover state
			var styleId = 'cravendunnill-headerusp-style';
			var styleElement = $('#' + styleId);
			
			if (styleElement.length === 0) {
				styleElement = $('<style id="' + styleId + '"></style>').appendTo('head');
			}
			
			var css = '.cravendunnill-headerusps-ticker:hover { background-color: ' + hoverBackground + ' !important; }';
			css += '.cravendunnill-usp-link::after { background-color: ' + textColor + '; }';
			css += '.cravendunnill-usp-link:hover::after { width: 100%; }';
			
			styleElement.html(css);
		}
	};
});