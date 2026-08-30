(function () {
  var form = document.getElementById('contactForm');
  if (!form) return;

  var statusEl = document.getElementById('formStatus');
  var submitBtn = form.querySelector('button[type="submit"]');

  function clearFieldErrors() {
    form.querySelectorAll('.field--error').forEach(function (f) { f.classList.remove('field--error'); });
    form.querySelectorAll('.field__error').forEach(function (e) { e.remove(); });
  }

  function showFieldError(name, message) {
    var field = form.querySelector('[data-field="' + name + '"]');
    if (!field) return;
    field.classList.add('field--error');
    var msg = document.createElement('div');
    msg.className = 'field__error';
    msg.textContent = message;
    field.appendChild(msg);
  }

  function setStatus(type, message) {
    if (!statusEl) return;
    statusEl.className = 'form-status is-' + type;
    statusEl.textContent = message;
  }

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    clearFieldErrors();
    if (statusEl) { statusEl.className = 'form-status'; statusEl.textContent = ''; }

    if (submitBtn) { submitBtn.disabled = true; submitBtn.dataset.originalText = submitBtn.textContent; submitBtn.textContent = 'Sending…'; }

    fetch(form.getAttribute('action'), {
      method: 'POST',
      headers: { 'X-Requested-With': 'fetch' },
      body: new FormData(form)
    })
      .then(function (res) { return res.json().then(function (data) { return { ok: res.ok, data: data }; }); })
      .then(function (result) {
        if (result.ok && result.data.status === 'ok') {
          setStatus('success', result.data.message || "Thanks — we'll get back to you shortly.");
          form.reset();
        } else {
          setStatus('error', result.data.message || 'Something went wrong. Please check the form and try again.');
          if (result.data.errors) {
            Object.keys(result.data.errors).forEach(function (name) {
              showFieldError(name, result.data.errors[name]);
            });
          }
        }
      })
      .catch(function () {
        setStatus('error', 'Network error — please try again in a moment.');
      })
      .finally(function () {
        if (submitBtn) { submitBtn.disabled = false; submitBtn.textContent = submitBtn.dataset.originalText; }
      });
  });
})();
