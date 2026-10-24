(function () {
    'use strict';
    var form = document.getElementById('egypt-request');
    if (!form) return;
    var button = form.querySelector('button[type="submit"]');
    var result = document.getElementById('egypt-result');
    var busy = false;
    var saved = false;
    var needsCaptcha = form.dataset.local !== 'true';
    var captchaReady = !needsCaptcha;

    window.svlEgyptCaptchaReady = function () {
        captchaReady = true;
        if (!busy && !saved) button.disabled = false;
    };
    window.svlEgyptCaptchaExpired = function () {
        captchaReady = false;
        button.disabled = true;
    };

    // Without fetch the regular HTML form still uses the existing intake endpoint.
    if (!window.fetch || !window.FormData) return;
    form.addEventListener('submit', function (event) {
        event.preventDefault();
        if (busy || saved || !captchaReady || !form.reportValidity()) return;
        busy = true;
        button.disabled = true;
        form.setAttribute('aria-busy', 'true');
        result.hidden = true;
        fetch(form.action, {
            method: 'POST', body: new FormData(form), credentials: 'same-origin',
            headers: { 'Accept': 'application/json' }
        }).then(function (response) {
            return response.json().then(function (data) {
                if (!response.ok || data.success !== true || data.saved !== true) {
                    throw new Error(data.message || 'No hemos podido guardar tu solicitud. Revisa los datos e inténtalo de nuevo.');
                }
                saved = true;
                form.hidden = true;
                result.classList.remove('is-error');
                result.textContent = 'Tu solicitud para viajar a Egipto se ha guardado correctamente. Nuestro equipo se pondrá en contacto contigo para preparar la propuesta.';
                result.hidden = false;
                result.focus();
                // No personal data or local test traffic is sent to Analytics.
                if (['soloviajesdelujo.com', 'www.soloviajesdelujo.com'].indexOf(window.location.hostname) !== -1
                    && window.svlAnalyticsInitialized === true
                    && typeof window.gtag === 'function') {
                    window.gtag('event', 'generate_lead', {
                        form_name: 'egipto_desde_barcelona', destination: 'Egipto', departure_city: 'Barcelona'
                    });
                }
            });
        }).catch(function (error) {
            result.textContent = error instanceof TypeError
                ? 'No hemos podido confirmar el resultado del envío. Tus datos siguen en pantalla. Puedes contactar con nosotros en el +34 610 461 529 antes de volver a enviarlo.'
                : error.message;
            result.classList.add('is-error');
            result.hidden = false;
            result.focus();
            if (needsCaptcha && window.grecaptcha) {
                window.grecaptcha.reset();
                captchaReady = false;
            }
        }).finally(function () {
            busy = false;
            button.disabled = saved || !captchaReady;
            form.removeAttribute('aria-busy');
        });
    });
}());
