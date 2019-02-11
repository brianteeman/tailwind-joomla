(function() {
	'use strict';

	function trackScroll() {
		var scrolled = window.pageYOffset;
		var coords = document.documentElement.clientHeight;

		var goTopBtn = document.getElementById('back-to-top');

		if (typeof goTopBtn === "undefined") {
			return;
		}

		if (scrolled > coords) {
			goTopBtn.classList.remove('hidden');
		}
		if (scrolled < coords) {
			goTopBtn.classList.add('hidden');
		}
	}

	function backToTop() {
		if (window.pageYOffset > 0) {
			window.scrollBy(0, -80);
			setTimeout(backToTop, 0);
		}
	}

	document.addEventListener("DOMContentLoaded", function() {
		var goTopBtn = document.getElementById('back-to-top');

		if (goTopBtn) {
			window.addEventListener('scroll', trackScroll);
			goTopBtn.addEventListener('click', backToTop);
		}

		var alertCloseButtons = document.querySelectorAll("[data-dismiss='tailalert']");

		for (var i = 0, len = alertCloseButtons.length; i < len; i++) {
			alertCloseButtons[i].addEventListener('click', function(){
				var parent = this.parentNode;
				
				if (parent) {
					parent.parentNode.removeChild(parent);
				}
			});
		}

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
})();
