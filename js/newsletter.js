(function () {
    'use strict';

    function showMessage(form, message, isError) {
        var output = form.querySelector('[data-newsletter-message]');
        if (!output) {
            output = document.createElement('p');
            output.setAttribute('data-newsletter-message', '');
            output.setAttribute('role', 'status');
            output.setAttribute('aria-live', 'polite');
            form.appendChild(output);
        }
        output.textContent = message;
        output.style.color = isError ? '#ffb3b3' : 'inherit';
    }

    function setup() {
        var forms = document.querySelectorAll('form[data-newsletter-form]');
        Array.prototype.forEach.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                // Without XHR the normal HTML response remains a working fallback.
                if (!window.XMLHttpRequest || !window.FormData) {
                    return;
                }
                event.preventDefault();
                if (form.getAttribute('aria-busy') === 'true') {
                    return;
                }
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }
                var button = form.querySelector('[type="submit"]');
                var request = new XMLHttpRequest();
                form.setAttribute('aria-busy', 'true');
                if (button) {
                    button.disabled = true;
                }
                showMessage(form, 'Guardando suscripción…', false);
                request.open('POST', form.action, true);
                request.timeout = 20000;
                request.setRequestHeader('Accept', 'application/json');
                request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

                function finish(message, isError) {
                    form.removeAttribute('aria-busy');
                    if (button) {
                        button.disabled = false;
                    }
                    showMessage(form, message, isError);
                }

                request.onload = function () {
                    var result;
                    try {
                        result = JSON.parse(request.responseText);
                    } catch (error) {
                        finish('No hemos podido confirmar el registro. Inténtalo de nuevo.', true);
                        return;
                    }
                    if (request.status >= 200 && request.status < 300 && result.success) {
                        finish(result.message || 'Tu suscripción ha quedado guardada.', false);
                        form.reset();
                    } else {
                        finish(result.message || 'No hemos podido guardar la suscripción.', true);
                    }
                };
                request.onerror = request.ontimeout = function () {
                    finish('No hemos podido confirmar el registro. Comprueba tu conexión e inténtalo de nuevo.', true);
                };
                request.send(new FormData(form));
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', setup);
    } else {
        setup();
    }
}());
