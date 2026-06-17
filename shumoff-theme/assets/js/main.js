/* ============================================
   Shumoff Theme — Main JavaScript
   Interactions: header scroll, mobile menu,
   FAQ accordion, before/after slider,
   smooth scroll, form validation.
   ============================================ */

(function () {
  'use strict';

  // ─── DOM Ready ───────────────────────────────
  document.addEventListener('DOMContentLoaded', function () {
    initHeaderScroll();
    initMobileMenu();
    initFaqAccordion();
    initBaSlider();
    initSmoothScroll();
    initFormValidation();
  });

  // ─── Header Scroll Effect ────────────────────
  function initHeaderScroll() {
    var header = document.querySelector('.header');
    if (!header) return;

    var scrollThreshold = 50;

    function onScroll() {
      if (window.scrollY > scrollThreshold) {
        header.classList.add('is-scrolled');
      } else {
        header.classList.remove('is-scrolled');
      }
    }

    // Throttle with rAF
    var ticking = false;
    window.addEventListener('scroll', function () {
      if (!ticking) {
        window.requestAnimationFrame(function () {
          onScroll();
          ticking = false;
        });
        ticking = true;
      }
    });

    // Initial check
    onScroll();
  }

  // ─── Mobile Menu Toggle ──────────────────────
  function initMobileMenu() {
    var burger = document.querySelector('.header__burger');
    var menu = document.querySelector('.mobile-menu');
    if (!burger || !menu) return;

    burger.addEventListener('click', function () {
      menu.classList.toggle('is-open');
      burger.classList.toggle('is-active');
    });

    // Close menu on link click
    var links = menu.querySelectorAll('.mobile-menu__link');
    links.forEach(function (link) {
      link.addEventListener('click', function () {
        menu.classList.remove('is-open');
        burger.classList.remove('is-active');
      });
    });

    // Close on Escape
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && menu.classList.contains('is-open')) {
        menu.classList.remove('is-open');
        burger.classList.remove('is-active');
      }
    });
  }

  // ─── FAQ Accordion ───────────────────────────
  function initFaqAccordion() {
    var items = document.querySelectorAll('.faq-item');
    if (!items.length) return;

    items.forEach(function (item) {
      var title = item.querySelector('.faq-item__title');
      if (!title) return;

      title.addEventListener('click', function () {
        var isActive = item.classList.contains('is-active');

        // Close all items (uncomment for single-open behavior)
        // items.forEach(function (other) {
        //   other.classList.remove('is-active');
        // });

        // Toggle current
        if (isActive) {
          item.classList.remove('is-active');
        } else {
          item.classList.add('is-active');
        }
      });
    });
  }

  // ─── Before/After Slider ─────────────────────
  function initBaSlider() {
    var sliders = document.querySelectorAll('.ba-slider');
    if (!sliders.length) return;

    sliders.forEach(function (slider) {
      var handle = slider.querySelector('.ba-slider__handle');
      var afterImage = slider.querySelector('.ba-slider__image--after');
      if (!handle || !afterImage) return;

      var isDragging = false;

      function updateSlider(x) {
        var rect = slider.getBoundingClientRect();
        var pos = Math.max(0, Math.min(1, (x - rect.left) / rect.width));
        handle.style.left = pos * 100 + '%';
        afterImage.style.clipPath = 'inset(0 ' + (100 - pos * 100) + '% 0 0)';
      }

      slider.addEventListener('mousedown', function (e) {
        isDragging = true;
        updateSlider(e.clientX);
        e.preventDefault();
      });

      window.addEventListener('mousemove', function (e) {
        if (isDragging) {
          updateSlider(e.clientX);
        }
      });

      window.addEventListener('mouseup', function () {
        isDragging = false;
      });

      // Touch support
      slider.addEventListener('touchstart', function (e) {
        isDragging = true;
        updateSlider(e.touches[0].clientX);
      });

      window.addEventListener('touchmove', function (e) {
        if (isDragging) {
          updateSlider(e.touches[0].clientX);
        }
      });

      window.addEventListener('touchend', function () {
        isDragging = false;
      });
    });
  }

  // ─── Smooth Scroll for Anchor Links ──────────
  function initSmoothScroll() {
    var header = document.querySelector('.header');
    var headerHeight = header ? header.offsetHeight : 0;

    document.querySelectorAll('a[href^="#"]').forEach(function (link) {
      link.addEventListener('click', function (e) {
        var href = this.getAttribute('href');
        if (!href || href === '#') return;

        var target = document.querySelector(href);
        if (!target) return;

        e.preventDefault();
        var top = target.getBoundingClientRect().top + window.pageYOffset - headerHeight;

        window.scrollTo({
          top: top,
          behavior: 'smooth'
        });
      });
    });
  }

  // ─── Phone Validation ────────────────────────
  function initFormValidation() {
    var forms = document.querySelectorAll('form[data-validate]');
    if (!forms.length) return;

    forms.forEach(function (form) {
      var phoneInput = form.querySelector('[data-validate-phone]');
      var submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');

      if (!submitBtn) return;

      submitBtn.addEventListener('click', function (e) {
        var isValid = true;

        if (phoneInput) {
          var value = phoneInput.value.trim();
          var phoneError = phoneInput.parentElement.querySelector('.form__error') ||
                           form.querySelector('[data-error-for="phone"]');

          // Remove + and spaces
          var cleaned = value.replace(/[\s+()-]/g, '');

          // Must be digits only, 10-15 chars
          if (!/^\d{10,15}$/.test(cleaned)) {
            isValid = false;
            phoneInput.classList.add('error');
            if (phoneError) {
              phoneError.style.display = 'block';
            }
          } else {
            phoneInput.classList.remove('error');
            if (phoneError) {
              phoneError.style.display = 'none';
            }
          }
        }

        if (!isValid) {
          e.preventDefault();
        }
      });

      // Clear error on input
      if (phoneInput) {
        phoneInput.addEventListener('input', function () {
          this.classList.remove('error');
          var error = this.parentElement.querySelector('.form__error') ||
                     form.querySelector('[data-error-for="phone"]');
          if (error) error.style.display = 'none';
        });
      }
    });
  }

})();
