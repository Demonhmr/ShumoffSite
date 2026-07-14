/* ============================================
   Shumoff Quiz — квиз-калькулятор стоимости.

   Разметка: template-parts/quiz-modal.php.
   Конфиг (цены, зоны, скидка): window.shumoffQuiz
   из shumoff-core (includes/quiz.php).
   Открытие: любой элемент с [data-quiz-open].
   Смета считается по реальному прайсу и носит
   ознакомительный характер — сервер пересчитывает
   её заново при приёме лида.
   ============================================ */

(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById('quiz-modal');
    var cfg = window.shumoffQuiz;
    if (!modal || !cfg) return;

    var form = modal.querySelector('[data-quiz-form]');
    var steps = Array.prototype.slice.call(modal.querySelectorAll('[data-quiz-step]'));
    var prevBtn = modal.querySelector('[data-quiz-prev]');
    var nextBtn = modal.querySelector('[data-quiz-next]');
    var submitBtn = modal.querySelector('[data-quiz-submit]');
    var progressBar = modal.querySelector('[data-quiz-progress]');
    var stepCaption = modal.querySelector('[data-quiz-step-current]');
    var status = modal.querySelector('.quiz-form__status');
    var successBox = modal.querySelector('[data-quiz-success]');
    var current = 1;
    var total = steps.length;
    var lastFocused = null;

    captureUtm();

    // ─── Открытие/закрытие ───────────────────────
    document.addEventListener('click', function (e) {
      var opener = e.target.closest('[data-quiz-open]');
      if (opener) {
        e.preventDefault();
        openModal();
        return;
      }
      if (e.target.closest('[data-quiz-close]')) {
        closeModal();
      }
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && !modal.hidden) {
        closeModal();
      }
    });

    function openModal() {
      lastFocused = document.activeElement;
      modal.hidden = false;
      document.body.classList.add('quiz-open');
      var pageField = form.querySelector('input[name="quiz_page"]');
      if (pageField) pageField.value = window.location.href.split('#')[0];
      var utmField = form.querySelector('input[name="quiz_utm"]');
      if (utmField) utmField.value = storedUtm();
      goToStep(current);
      var firstInput = steps[current - 1].querySelector('input, select');
      if (firstInput) firstInput.focus();
    }

    function closeModal() {
      modal.hidden = true;
      document.body.classList.remove('quiz-open');
      if (lastFocused && lastFocused.focus) lastFocused.focus();
    }

    // ─── Навигация по шагам ──────────────────────
    function goToStep(step) {
      current = step;
      steps.forEach(function (fieldset, i) {
        fieldset.hidden = i !== step - 1;
      });
      prevBtn.hidden = step === 1;
      nextBtn.hidden = step === total;
      submitBtn.hidden = step !== total;
      if (progressBar) progressBar.style.width = (step / total) * 100 + '%';
      if (stepCaption) stepCaption.textContent = step;
      setStatus('', '');
      if (step === total) renderEstimate();
    }

    prevBtn.addEventListener('click', function () {
      if (current > 1) goToStep(current - 1);
    });

    nextBtn.addEventListener('click', function () {
      if (!validateStep(current)) return;
      if (current < total) goToStep(current + 1);
    });

    function validateStep(step) {
      var fieldset = steps[step - 1];

      var radios = fieldset.querySelectorAll('input[type="radio"][required]');
      if (radios.length && !fieldset.querySelector('input[type="radio"]:checked')) {
        setStatus('Выберите один из вариантов.', 'error');
        return false;
      }

      var required = fieldset.querySelectorAll('select[required], input[type="text"][required]');
      for (var i = 0; i < required.length; i++) {
        if (!required[i].value.trim()) {
          required[i].focus();
          setStatus('Заполните обязательные поля.', 'error');
          return false;
        }
      }

      // Шаг «что беспокоит»: хотя бы один чекбокс
      var boxes = fieldset.querySelectorAll('input[type="checkbox"][name="quiz_concerns[]"]');
      if (boxes.length && !fieldset.querySelector('input[name="quiz_concerns[]"]:checked')) {
        setStatus('Отметьте хотя бы один вариант.', 'error');
        return false;
      }

      return true;
    }

    // ─── Смета по прайсу ─────────────────────────
    function collectAnswers() {
      var classInput = form.querySelector('input[name="quiz_class"]:checked');
      var packageInput = form.querySelector('input[name="quiz_package"]:checked');
      var concerns = Array.prototype.slice
        .call(form.querySelectorAll('input[name="quiz_concerns[]"]:checked'))
        .map(function (box) { return box.value; });
      return {
        carClass: classInput ? classInput.value : '',
        pack: packageInput ? packageInput.value : '',
        concerns: concerns
      };
    }

    function computeEstimate() {
      var a = collectAnswers();
      var prices = (cfg.prices || {})[a.carClass];
      if (!prices || !a.pack) return null;

      var zones = [];
      for (var i = 0; i < a.concerns.length; i++) {
        var concern = (cfg.concerns || {})[a.concerns[i]];
        if (!concern) continue;
        if (concern.full) { zones = ['Полная комплектация']; break; }
        zones = zones.concat(concern.zones || []);
      }
      zones = zones.filter(function (zone, i) { return zones.indexOf(zone) === i; });
      if (!zones.length) return null;

      var totalSum = 0;
      var matSum = 0;
      for (var j = 0; j < zones.length; j++) {
        var price = prices[zones[j]] && prices[zones[j]][a.pack];
        if (!price) return null;
        totalSum += price.total;
        matSum += price.mat;
      }

      var discount = Math.round(matSum * (cfg.discount || 0.1));
      return { total: totalSum, final: totalSum - discount };
    }

    function renderEstimate() {
      var box = modal.querySelector('[data-quiz-estimate]');
      var fallback = modal.querySelector('[data-quiz-estimate-fallback]');
      var title = modal.querySelector('[data-quiz-final-title]');
      var estimate = computeEstimate();

      if (title) {
        var brand = form.querySelector('select[name="quiz_brand"]');
        var model = form.querySelector('input[name="quiz_model"]');
        var car = ((brand && brand.value !== 'other' ? brand.value : '') + ' ' + (model ? model.value : '')).trim();
        title.textContent = car
          ? 'Отлично! Мы уже делаем предварительный расчёт для вашего ' + car + '.'
          : 'Отлично! Мы уже делаем предварительный расчёт.';
      }

      if (estimate) {
        box.querySelector('[data-quiz-estimate-total]').textContent = 'от ' + formatPrice(estimate.total) + ' ₽';
        box.querySelector('[data-quiz-estimate-final]').textContent = 'от ' + formatPrice(estimate.final) + ' ₽';
        box.hidden = false;
        fallback.hidden = true;
      } else {
        box.hidden = true;
        fallback.hidden = false;
      }
    }

    function formatPrice(value) {
      return String(value).replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
    }

    // ─── Отправка ────────────────────────────────
    form.addEventListener('submit', function (e) {
      e.preventDefault();

      // Enter на промежуточном шаге — «Далее», а не отправка.
      if (current < total) {
        nextBtn.click();
        return;
      }

      var phone = form.querySelector('[data-validate-phone]');
      var cleaned = phone ? phone.value.trim().replace(/[\s+()-]/g, '') : '';
      if (!/^\d{10,15}$/.test(cleaned)) {
        if (phone) {
          phone.classList.add('error');
          phone.focus();
        }
        setStatus('Укажите корректный номер телефона.', 'error');
        return;
      }

      var consent = form.querySelector('input[name="quiz_consent"]');
      if (consent && !consent.checked) {
        setStatus('Подтвердите согласие с политикой обработки данных.', 'error');
        return;
      }

      var themeCfg = window.shumoffTheme || {};
      if (!themeCfg.ajaxurl || !window.fetch) {
        setStatus('Не удалось отправить. Позвоните нам, пожалуйста.', 'error');
        return;
      }

      var data = new FormData(form);
      data.append('action', 'shumoff_quiz');

      submitBtn.disabled = true;
      setStatus('Отправляем…', 'sending');

      fetch(themeCfg.ajaxurl, {
        method: 'POST',
        body: data,
        credentials: 'same-origin'
      })
        .then(function (response) { return response.json(); })
        .then(function (result) {
          var payload = (result && result.data) || {};
          if (result && result.success) {
            form.hidden = true;
            modal.querySelector('.quiz-modal__header').hidden = true;
            successBox.hidden = false;
          } else {
            setStatus(payload.message || 'Не удалось отправить заявку. Позвоните нам, пожалуйста.', 'error');
          }
        })
        .catch(function () {
          setStatus('Не удалось отправить. Проверьте соединение или позвоните нам.', 'error');
        })
        .finally(function () {
          submitBtn.disabled = false;
        });
    });

    function setStatus(message, state) {
      if (!status) return;
      status.textContent = message;
      status.className = 'quiz-form__status' + (state ? ' is-' + state : '');
    }

    // ─── UTM: запоминаем на время визита ─────────
    function captureUtm() {
      try {
        var params = new URLSearchParams(window.location.search);
        var pairs = [];
        ['utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term'].forEach(function (key) {
          var value = params.get(key);
          if (value) pairs.push(key + '=' + value);
        });
        if (pairs.length) {
          sessionStorage.setItem('shumoff_utm', pairs.join('&'));
        }
      } catch (err) { /* приватный режим — работаем без UTM */ }
    }

    function storedUtm() {
      try {
        return sessionStorage.getItem('shumoff_utm') || '';
      } catch (err) {
        return '';
      }
    }
  });
})();
