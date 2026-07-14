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
    initPhoneMask();
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
        // Кнопки квиза обрабатывает quiz.js — не скроллим.
        if (this.hasAttribute('data-quiz-open')) return;

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

  // ─── Phone Mask: +7 (XXX) XXX-XX-XX ──────────
  function initPhoneMask() {
    var inputs = document.querySelectorAll('input[data-validate-phone]');
    if (!inputs.length) return;

    inputs.forEach(function (input) {
      input.addEventListener('input', function (e) {
        // При удалении не переформатируем: иначе Backspace на скобке/дефисе
        // тут же восстанавливается маской и поле «залипает».
        if (e.inputType && e.inputType.indexOf('delete') === 0) return;

        var value = input.value;

        // Иностранные номера (+ не с 7) не форматируем
        if (/^\+(?!7)/.test(value.trim())) return;

        var digits = value.replace(/\D/g, '');
        if (!digits) {
          input.value = '';
          return;
        }
        if (digits.charAt(0) === '8') digits = '7' + digits.slice(1);
        if (digits.charAt(0) !== '7') digits = '7' + digits;
        digits = digits.slice(0, 11);

        var out = '+7';
        if (digits.length > 1) out += ' (' + digits.slice(1, 4);
        if (digits.length >= 4) out += ')';
        if (digits.length > 4) out += ' ' + digits.slice(4, 7);
        if (digits.length > 7) out += '-' + digits.slice(7, 9);
        if (digits.length > 9) out += '-' + digits.slice(9, 11);
        input.value = out;
      });
    });
  }

  // ─── Form Validation + AJAX Submit ───────────
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
          return;
        }

        // AJAX-отправка; без fetch/настроек — обычный POST (фолбэк)
        var action = form.getAttribute('data-ajax-action');
        var cfg = window.shumoffTheme || {};
        if (!action || !cfg.ajaxurl || !window.fetch) return;

        e.preventDefault();
        submitFormAjax(form, action, cfg.ajaxurl);
      });

      // Снятие ошибки при вводе
      form.querySelectorAll('input').forEach(function (input) {
        input.addEventListener('input', function () {
          toggleFieldError(form, input, true);
        });
      });
    });
  }

  function submitFormAjax(form, action, ajaxurl) {
    var button = form.querySelector('button[type="submit"]');
    var status = form.querySelector('.appointment-form__status');
    var data = new FormData(form);
    data.append('action', action);

    if (button) button.disabled = true;
    setFormStatus(status, 'Отправляем…', 'sending');

    fetch(ajaxurl, {
      method: 'POST',
      body: data,
      credentials: 'same-origin'
    })
      .then(function (response) { return response.json(); })
      .then(function (result) {
        var payload = (result && result.data) || {};
        if (result && result.success) {
          form.reset();
          setFormStatus(status, payload.message || 'Заявка отправлена!', 'success');
        } else {
          setFormStatus(status, payload.message || 'Не удалось отправить заявку. Позвоните нам, пожалуйста.', 'error');
          if (payload.field === 'phone') {
            var phone = form.querySelector('[data-validate-phone]');
            if (phone) toggleFieldError(form, phone, false);
          }
          if (payload.field === 'name') {
            var name = form.querySelector('input[name="appt_name"]');
            if (name) toggleFieldError(form, name, false);
          }
        }
      })
      .catch(function () {
        setFormStatus(status, 'Не удалось отправить заявку. Проверьте соединение или позвоните нам.', 'error');
      })
      .finally(function () {
        if (button) button.disabled = false;
      });
  }

  function setFormStatus(status, message, state) {
    if (!status) return;
    status.textContent = message;
    status.className = 'appointment-form__status' + (state ? ' is-' + state : '');
  }

  function toggleFieldError(form, input, ok) {
    input.classList.toggle('error', !ok);
    var error = input.parentElement.querySelector('.form__error');
    if (error) {
      error.classList.toggle('is-visible', !ok);
    }
  }

})();
