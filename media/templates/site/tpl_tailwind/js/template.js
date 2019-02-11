(function() {
  'use strict';

  function trackScroll() {
    var goTopBtn = document.getElementById('back-to-top');

    if (goTopBtn) {
      var scrolled = window.pageYOffset;
      var coords = document.documentElement.clientHeight;

      if (scrolled > coords) {
        goTopBtn.classList.remove('hidden');
      }
      if (scrolled < coords) {
        goTopBtn.classList.add('hidden');
      }
    }
  }

  function backToTop() {
    if (window.pageYOffset > 0) {
      window.scrollBy(0, -80);
      setTimeout(backToTop, 0);
    }
  }

  function closeAlert(event) {
    event.target.removeEventListener('click', this)
    var parent = event.target.parentNode;

    if (parent) {
      parent.parentNode.removeChild(parent);
    }
  }

  function navToggle(event) {
    // Get the "main-nav" element
    var $target = document.getElementById('main-nav');

    // Toggle the class on "main-nav"
    $target.classList.toggle('hidden');
  }

  function init() {
    // Let GC remove unneeded parts
    document.removeEventListener('DOMContentLoaded', init);

    var goTopBtn = document.getElementById('back-to-top');

    if (goTopBtn) {
      window.addEventListener('scroll', trackScroll);
      goTopBtn.addEventListener('click', backToTop);
    }

    var alertCloseButtons = document.querySelectorAll("[data-dismiss='tailalert']");

    for (var i = 0, len = alertCloseButtons.length; i < len; i++) {
      alertCloseButtons[i].addEventListener('click', closeAlert);
    }

    // Get all "navbar-burger" elements
    var $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

    // Check if there are any navbar burgers
    if ($navbarBurgers.length) {
      // Add a click event on each of them
      $navbarBurgers.forEach(function($el) {
        $el.addEventListener('click', navToggle);
      });
    }
  }

  document.addEventListener("DOMContentLoaded", init);
})();
