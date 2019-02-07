(function($){
	function backToTopInit(duration){
	 $('.back-to-top').click(function(event) {
	 	event.preventDefault();
	 	$('html, body').animate({scrollTop: 0}, duration);
	 	return false;
	 });
	}

	function debounce(func, wait, immediate) {
		var timeout;
		return function() {
			var context = this,
				args = arguments;
			var later = function() {
				timeout = null;
				if (!immediate) func.apply(context, args);
			};
			var callNow = immediate && !timeout;
			clearTimeout(timeout);
			timeout = setTimeout(later, wait);
			if (callNow) func.apply(context, args);
		};
	};

	function createSticky($element) {
		if (!$element.length) {
			return;
		}

		var pos = $element.offset().top + 170,
			win = jQuery(window);


		win.on("scroll", function() {
			debounce(function() {}, 250);

			if( win.scrollTop() > pos ) {
				$element.addClass("sticky").removeClass('stickyOFF');
			} else {
				$element.removeClass("sticky").addClass('stickyOFF');
			}
		});
	}

	/**
	 * Ensure min-height on pages without a lot of content
	 */
	function setMainMinHeight()
	{
		var pageHeight = $('.page').height();
		var bodyHeight = $('body').height();
		var mainHeight = $('#main').height();

		if (bodyHeight > pageHeight) {
			var minHeight = mainHeight + (bodyHeight - pageHeight);
			$('#main').css('min-height', minHeight);
		}
	}

	// Navbar Toggle
	document.addEventListener('DOMContentLoaded', function () {

	  // Get all "navbar-burger" elements
	  var $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

	  // Check if there are any navbar burgers
	  if ($navbarBurgers.length > 0) {

	    // Add a click event on each of them
	    $navbarBurgers.forEach(function ($el) {
	      $el.addEventListener('click', function () {

	        // Get the "main-nav" element
	        var $target = document.getElementById('main-nav');

	        // Toggle the class on "main-nav"
	        $target.classList.toggle('hidden');

	      });
	    });
	  }

	});

	$(document).ready(function(){
		createSticky(jQuery(".sticky-header"));
		setMainMinHeight();
		backToTopInit(700);
	});
	window.onresize = function() {
		setMainMinHeight();
	}
})(jQuery);
