(function () {
    'use strict';
    var readOnly = document.currentScript.dataset.readOnly === 'true';
    var pending = new WeakSet();

    window.svlSubmitAdminForm = function (form) {
        if (readOnly) {
            window.alert('La publicación del catálogo está desactivada en esta vista de pruebas.');
            return false;
        }
        if (!window.fetch || !window.FormData) {
            HTMLFormElement.prototype.submit.call(form);
            return false;
        }
        if (pending.has(form)) return false;

        pending.add(form);
        var button = form.querySelector('[type="submit"]');
        if (button) button.disabled = true;
        var uncertain = 'El servidor no ha confirmado el guardado. Comprueba el listado antes de volver a publicar.';
        fetch(form.action, {
            method: 'POST', body: new FormData(form), credentials: 'same-origin',
            headers: { 'Accept': 'application/json' }
        }).then(function (response) {
            return response.json().catch(function () { return null; }).then(function (data) {
                if (response.ok && data && data.success === true && typeof data.redirect === 'string') {
                    window.location.assign(data.redirect);
                    return;
                }
                var message = data && typeof data.message === 'string' ? data.message : '';
                if (!message && response.status === 413) message = 'La imagen supera el tamaño permitido por el servidor.';
                if (!message && response.status === 401) message = 'La sesión del administrador ha caducado. Vuelve a iniciar sesión.';
                if (!message && (response.status === 403 || response.status === 405)) message = 'El servidor no permite publicar desde este formulario.';
                window.alert(message || uncertain);
            });
        }).catch(function () {
            window.alert('Se ha interrumpido la conexión. Comprueba el listado antes de volver a publicar.');
        }).finally(function () {
            pending.delete(form);
            if (button) button.disabled = false;
        });
        return false;
    };
}());
