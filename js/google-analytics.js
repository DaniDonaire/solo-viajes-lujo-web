(function (window, document) {
    'use strict';

    window.dataLayer = window.dataLayer || [];
    window.gtag = window.gtag || function () {
        window.dataLayer.push(arguments);
    };

    // A staging copy may use the production hostname under a subdirectory.
    // Require this exact root script, from this origin, before enabling tracking.
    var currentScript = document.currentScript;
    var source;
    try {
        if (!currentScript || !currentScript.src) return;
        source = new URL(currentScript.src, window.location.href);
    } catch (error) {
        return;
    }
    var environment = currentScript.getAttribute('data-environment');

    // Keep local, staging and unknown installations out of the production property.
    if (['soloviajesdelujo.com', 'www.soloviajesdelujo.com'].indexOf(window.location.hostname) === -1
        || /^\/(?:preproduccion|preprod|staging)(?:\/|$)/i.test(window.location.pathname)
        || source.origin !== window.location.origin
        || source.pathname !== '/js/google-analytics.js'
        || (environment !== null && environment !== 'production')
        || window.svlAnalyticsInitialized) {
        return;
    }

    window.svlAnalyticsInitialized = true;
    window.gtag('js', new Date());
    window.gtag('config', 'G-87PYV7NSQE');

    var script = document.createElement('script');
    script.async = true;
    script.src = 'https://www.googletagmanager.com/gtag/js?id=G-87PYV7NSQE';
    document.head.appendChild(script);
}(window, document));
