(function () {
    'use strict';
    document.querySelectorAll('form[data-recaptcha-version="v3"]').forEach(function (form) {
        var pending = false;
        var verified = false;
        form.addEventListener('submit', function (event) {
            if (verified) {
                verified = false;
                return;
            }
            event.preventDefault();
            event.stopImmediatePropagation();
            if (pending || !form.reportValidity()) return;
            pending = true;
            var button = event.submitter || form.querySelector('[type="submit"]');
            if (button) button.disabled = true;
            var timer;
            new Promise(function (resolve, reject) {
                timer = window.setTimeout(function () {
                    reject(new Error('La comprobación antirrobots no responde. Revisa tu conexión e inténtalo de nuevo.'));
                }, 10000);
                if (!window.grecaptcha || typeof window.grecaptcha.execute !== 'function') {
                    reject(new Error('No se ha cargado la comprobación antirrobots. Recarga la página e inténtalo de nuevo.'));
                    return;
                }
                window.grecaptcha.ready(function () {
                    window.grecaptcha.execute(form.dataset.recaptchaSitekey, { action: 'contact' }).then(resolve, reject);
                });
            }).then(function (token) {
                if (typeof token !== 'string' || !token) throw new Error('No se ha podido validar la comprobación antirrobots.');
                var input = form.querySelector('[name="g-recaptcha-response"]');
                input.value = token;
                pending = false;
                if (button) button.disabled = false;
                verified = true;
                if (typeof form.requestSubmit === 'function') form.requestSubmit(button || undefined);
                else HTMLFormElement.prototype.submit.call(form);
            }).catch(function (error) {
                pending = false;
                verified = false;
                if (button) button.disabled = false;
                window.alert(error.message || 'No se ha podido validar la comprobación antirrobots. Inténtalo de nuevo.');
            }).finally(function () {
                window.clearTimeout(timer);
            });
        }, true);
    });
}());
