/* ============================================
   Shumoff Theme — Main JavaScript
   Взаимодействия: скролл-эффект шапки, мобильное
   меню, FAQ (одиночное раскрытие), слайдер
   «до/после», плавный скролл, валидация формы.

   Селекторы соответствуют разметке темы:
   .site-header, .burger-menu, #main-navigation,
   .mobile-menu-overlay, .faq-item (details),
   form[data-validate].
   ============================================ */

(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {
    initHeaderScroll();
    initMobileMenu();
    initFaqSingleOpen();
    initBaSlider();
    initSmoothScroll();
    initFormValidation();
  });

  // ─── Header Scroll Effect ────────────────────
  function initHeaderScroll() {
    var header = document.querySelector('.site-header');
    if (!header) return;

    var scrollThreshold = 50;
    var ticking = false;

    function onScroll() {
      header.classList.toggle('is-scrolled', window.scrollY > scrollThreshold);
    }

    window.addEventListener('scroll', function () {
      if (!ticking) {
        window.requestAnimationFrame(function () {
          onScroll();
          ticking = false;
        });
        ticking = true;
      }
    });

    onScroll();
  }

  // ─── Mobile Menu Toggle ──────────────────────
  function initMobileMenu() {
    var burger = document.getElementById('burger-menu');
    var nav = document.getElementById('main-navigation');
    var overlay = document.getElementById('mobile-menu-overlay');
    if (!burger || !nav) return;

    function setMenu(open) {
      nav.classList.toggle('is-open', open);
      burger.classList.toggle('active', open);
      burger.setAttribute('aria-expanded', open ? 'true' : 'false');
      document.body.classList.toggle('menu-open', open);
      if (overlay) {
        overlay.classList.toggle('is-active', open);
        overlay.setAttribute('aria-hidden', open ? 'false' : 'true');
      }
    }

    burger.addEventListener('click', function () {
      setMenu(!nav.classList.contains('is-open'));
    });

    if (overlay) {
      overlay.addEventListener('click', function () {
        setMenu(false);
      });
    }

    nav.addEventListener('click', function (e) {
      if (e.target.closest('a')) {
        setMenu(false);
      }
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && nav.classList.contains('is-open')) {
        setMenu(false);
      }
    });

    // Сброс состояния при переходе на десктопную ширину
    window.addEventListener('resize', function () {
      if (window.innerWidth > 992 && nav.classList.contains('is-open')) {
        setMenu(false);
      }
    });
  }

  // ─── FAQ: одновременно открыт один вопрос ────
  // Разметка на нативных <details> — работает и без JS,
  // скрипт лишь закрывает остальные при открытии нового.
  function initFaqSingleOpen() {
    var items = document.querySelectorAll('details.faq-item');
    if (!items.length) return;

    items.forEach(function (item) {
      item.addEventListener('toggle', function () {
        if (!item.open) return;
        items.forEach(function (other) {
          if (other !== item) {
            other.open = false;
          }
        });
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

      slider.addEventListener('pointerdown', function (e) {
        isDragging = true;
        slider.setPointerCapture(e.pointerId);
        updateSlider(e.clientX);
        e.preventDefault();
      });

      slider.addEventListener('pointermove', function (e) {
        if (isDragging) {
          updateSlider(e.clientX);
        }
      });

      slider.addEventListener('pointerup', function () {
        isDragging = false;
      });

      slider.addEventListener('pointercancel', function () {
        isDragging = false;
      });
    });
  }

  // ─── Smooth Scroll for Anchor Links ──────────
  function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(function (link) {
      link.addEventListener('click', function (e) {
        var href = this.getAttribute('href');
        if (!href || href === '#') return;

        var target = document.querySelector(href);
        if (!target) return;

        e.preventDefault();
        var header = document.querySelector('.site-header');
        var headerHeight = header ? header.offsetHeight : 0;
        var top = target.getBoundingClientRect().top + window.pageYOffset - headerHeight;

        window.scrollTo({
          top: top,
          behavior: 'smooth'
        });
      });
    });
  }

  // ─── Form Validation ─────────────────────────
  function initFormValidation() {
    var forms = document.querySelectorAll('form[data-validate]');
    if (!forms.length) return;

    forms.forEach(function (form) {
      form.addEventListener('submit', function (e) {
        var isValid = true;

        // Обязательные текстовые поля
        form.querySelectorAll('input[required]').forEach(function (input) {
          if (input.hasAttribute('data-validate-phone')) return;
          var ok = input.value.trim().length > 0;
          toggleFieldError(form, input, ok);
          if (!ok) isValid = false;
        });

        // Телефон: 10–15 цифр после очистки
        var phoneInput = form.querySelector('[data-validate-phone]');
        if (phoneInput) {
          var cleaned = phoneInput.value.trim().replace(/[\s+()-]/g, '');
          var ok = /^\d{10,15}$/.test(cleaned);
          toggleFieldError(form, phoneInput, ok);
          if (!ok) isValid = false;
        }

        if (!isValid) {
          e.preventDefault();
        }
      });

      // Снятие ошибки при вводе
      form.querySelectorAll('input').forEach(function (input) {
        input.addEventListener('input', function () {
          toggleFieldError(form, input, true);
        });
      });
    });
  }

  function toggleFieldError(form, input, ok) {
    input.classList.toggle('error', !ok);
    var error = input.parentElement.querySelector('.form__error');
    if (error) {
      error.classList.toggle('is-visible', !ok);
    }
  }

})();
