<?php
/** Lightweight server-rendered destination landing; content is edited separately. */
if (!isset($landing) || !is_array($landing)) {
    http_response_code(404);
    exit;
}
require_once __DIR__.'/../include/site-path.php';
$isLocal = svl_is_test_environment();
$escape = static function ($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
};
$siteUrl = static function ($path) use ($escape) {
    return $escape(svl_site_path($path));
};
$origin = 'https://soloviajesdelujo.com';
$canonical = $origin.$landing['path'];
$schema = array('@context' => 'https://schema.org', '@graph' => array(
    array('@type' => 'TravelAgency', '@id' => $origin.'/#agencia',
        'name' => 'Solo Viajes de Lujo', 'legalName' => 'Grupo Global MPS Viajes y Cruceros S.L.',
        'url' => $origin.'/', 'logo' => $origin.'/img/logo_sticky_2x.png',
        'telephone' => '+34610461529', 'email' => 'info@soloviajesdelujo.com',
        'description' => 'Agencia de viajes a medida en Barcelona. Organización de viajes a Egipto, circuitos en español y cruceros por el Nilo.',
        'address' => array('@type' => 'PostalAddress', 'streetAddress' => 'Rector Ubach 16',
            'addressLocality' => 'Barcelona', 'postalCode' => '08021', 'addressCountry' => 'ES')),
    array('@type' => 'WebPage', '@id' => $canonical.'#pagina', 'url' => $canonical,
        'name' => $landing['title'], 'description' => $landing['description'], 'inLanguage' => 'es',
        'publisher' => array('@id' => $origin.'/#agencia'),
        'breadcrumb' => array('@id' => $canonical.'#migas')),
    array('@type' => 'BreadcrumbList', '@id' => $canonical.'#migas', 'itemListElement' => array(
        array('@type' => 'ListItem', 'position' => 1, 'name' => 'Inicio', 'item' => $origin.'/'),
        array('@type' => 'ListItem', 'position' => 2, 'name' => 'Egipto', 'item' => $origin.$landing['catalogue']),
        array('@type' => 'ListItem', 'position' => 3, 'name' => 'Egipto desde Barcelona', 'item' => $canonical)
    ))
));
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $escape($landing['title']) ?></title>
    <meta name="description" content="<?= $escape($landing['description']) ?>">
    <link rel="canonical" href="<?= $escape($canonical) ?>">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="es_ES">
    <meta property="og:site_name" content="Solo Viajes de Lujo">
    <meta property="og:title" content="<?= $escape($landing['title']) ?>">
    <meta property="og:description" content="<?= $escape($landing['description']) ?>">
    <meta property="og:url" content="<?= $escape($canonical) ?>">
    <meta property="og:image" content="<?= $escape($origin.$landing['hero']) ?>">
    <meta property="og:image:alt" content="Pirámides de Giza al atardecer">
    <link rel="icon" type="image/png" href="<?= $siteUrl('/img/logo_sticky_2x.png') ?>">
    <link rel="preload" href="<?= $siteUrl('/css/fonts/montserrat/montserrat-latin.woff2') ?>" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="<?= $siteUrl('/css/landing-destino.css') ?>">
    <script type="application/ld+json"><?= json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?></script>
    <script src="<?= $siteUrl('/js/google-analytics.js') ?>" data-environment="<?= $escape(svl_configuration()['env']) ?>" defer></script>
    <script src="<?= $siteUrl('/js/landing-destino.js') ?>" defer></script>
    <?php if (!$isLocal): ?>
    <script src="https://www.google.com/recaptcha/api.js?hl=es" async defer></script>
    <?php endif; ?>
</head>
<body class="destination-landing">
<a class="skip-link" href="#contenido">Saltar al contenido</a>
<div class="contact-bar"><div class="wrap"><span>Viajes a medida · Barcelona</span><a href="tel:+34610461529"><i class="landing-icon icon-phone" aria-hidden="true"></i> +34 610 461 529</a><a class="contact-email" href="mailto:info@soloviajesdelujo.com"><i class="landing-icon icon-mail" aria-hidden="true"></i> info@soloviajesdelujo.com</a></div></div>
<header class="site-header">
    <div class="wrap header-inner">
        <a class="brand" href="<?= $siteUrl('/index.php') ?>"><img src="<?= $siteUrl('/img/logo_sticky_2x.png') ?>" width="152" height="69" alt="Solo Viajes de Lujo"></a>
        <nav class="primary-nav" aria-label="Navegación principal">
            <a href="<?= $siteUrl('/nosotros.html') ?>">Quiénes somos</a>
            <a href="<?= $siteUrl('/index.php#destinos') ?>">Destinos</a>
            <a href="<?= $siteUrl('/cruceros.html') ?>">Cruceros</a>
            <a href="<?= $siteUrl($landing['catalogue']) ?>">Todos los viajes a Egipto</a>
            <a class="nav-contact" href="#presupuesto">Tu viaje a medida <span aria-hidden="true">↗</span></a>
        </nav>
    </div>
</header>
<main id="contenido">
    <nav class="wrap breadcrumbs" aria-label="Ruta de navegación"><a href="<?= $siteUrl('/index.php') ?>">Inicio</a><span aria-hidden="true">/</span><a href="<?= $siteUrl($landing['catalogue']) ?>">Egipto</a><span aria-hidden="true">/</span><span aria-current="page">Desde Barcelona</span></nav>
    <section class="hero" aria-labelledby="landing-title">
        <div class="hero-copy">
            <p class="eyebrow">EGIPTO, A TU MANERA</p>
            <h1 id="landing-title"><?= $escape($landing['heading']) ?></h1>
            <p class="hero-intro"><?= $escape($landing['introduction']) ?></p>
            <a class="button" href="#presupuesto">Preparar mi viaje <span aria-hidden="true">↗</span></a>
            <a class="text-link hero-secondary" href="#opciones">Descubrir las opciones <span aria-hidden="true">↓</span></a>
        </div>
        <figure class="hero-photo">
            <img src="<?= $siteUrl($landing['hero']) ?>" width="1000" height="666" fetchpriority="high" alt="Pirámides de Giza al atardecer, con una caravana de camellos en primer plano">
            <figcaption>Giza, Egipto</figcaption>
        </figure>
    </section>
    <div class="wrap service-notes" id="asesoramiento" aria-label="Cómo organizamos tu viaje">
        <div class="service-note"><i class="landing-icon icon-compass" aria-hidden="true"></i><div><strong>Asesoramiento especializado</strong><span>Te ayudamos a elegir el recorrido y el barco.</span></div></div>
        <div class="service-note"><i class="landing-icon icon-comments" aria-hidden="true"></i><div><strong>Circuitos en español</strong><span>Opciones regulares y viajes en privado.</span></div></div>
        <div class="service-note"><i class="landing-icon icon-document" aria-hidden="true"></i><div><strong>Una propuesta para ti</strong><span>Servicios y condiciones detallados antes de reservar.</span></div></div>
    </div>
    <section class="wrap section intro-section" aria-labelledby="especialistas-title">
        <figure class="section-photo intro-photo"><img src="<?= $siteUrl('/viajes/Egipto/img/dahabeya-nilo.jpg') ?>" width="640" height="395" loading="lazy" decoding="async" alt="Una Dahabeya de vela navegando por el Nilo, en Egipto"><figcaption>El Nilo, otra forma de descubrir Egipto.</figcaption></figure>
        <div class="intro-text"><p class="eyebrow">SOLO VIAJES DE LUJO</p><h2 id="especialistas-title">Especialistas en Egipto,<br> cerca de ti en Barcelona</h2><p>En Egipto, elegir bien el recorrido y el crucero marca la diferencia. Somos una agencia de viajes a medida en Barcelona y trabajamos con circuitos en español, viajes privados y distintas categorías de barcos por el Nilo.</p><p>Partimos de tus fechas, de cómo te gusta viajar y de lo que quieres descubrir. Organizamos tu viaje a Egipto desde Barcelona coordinando vuelos, hoteles, traslados y visitas, con el detalle de los servicios que contratas.</p></div>
    </section>
    <section class="options-band" id="opciones" aria-labelledby="opciones-title">
      <div class="wrap section options-section">
        <div class="section-heading"><div><p class="eyebrow">ENCUENTRA TU RECORRIDO</p><h2 id="opciones-title">Circuitos y cruceros por Egipto<br> desde Barcelona</h2></div><p>El Cairo, el Nilo y mucho más.<br> Estas son algunas opciones para tu viaje.</p></div>
        <div class="travel-options">
        <?php foreach ($landing['options'] as $option): ?>
            <article class="travel-option">
                <img src="<?= $siteUrl($option['image']) ?>" width="<?= (int) $option['width'] ?>" height="<?= (int) $option['height'] ?>" loading="lazy" decoding="async" alt="<?= $escape($option['alt']) ?>">
                <span class="option-number"><?= $escape($option['number']) ?></span>
                <h3><?= $escape($option['title']) ?></h3>
                <p><?= $escape($option['text']) ?></p>
                <p class="option-detail"><?= $escape($option['detail']) ?></p>
            </article>
        <?php endforeach; ?>
        </div>
        <p class="catalogue-link">¿Quieres consultar el catálogo? <a class="text-link" href="<?= $siteUrl($landing['catalogue']) ?>">Ver todos los viajes a Egipto <span aria-hidden="true">→</span></a></p>
      </div>
    </section>
    <section class="departure-section" aria-labelledby="barcelona-title">
        <div class="wrap departure-inner">
            <div class="departure-story"><p class="eyebrow">CON SALIDA DESDE BARCELONA</p><h2 id="barcelona-title">Tu viaje a Egipto desde Barcelona,<br> paso a paso</h2><p>Para organizar un viaje a Egipto desde Barcelona, combinamos los vuelos disponibles con las noches en El Cairo, el embarque del crucero por el Nilo y los traslados. Te explicamos la ruta aérea, las posibles escalas y los servicios incluidos antes de reservar.</p><p>Si buscas un circuito por Egipto con salida desde Barcelona, estudiamos cómo encajar el recorrido y las visitas en tus fechas. Si prefieres viajar en privado o añadir Hurghada, adaptamos la propuesta a esa combinación.</p><p class="departure-condition">La ruta aérea, los horarios y las posibles escalas se confirman en cada presupuesto, según disponibilidad.</p></div>
            <figure class="section-photo departure-photo"><img src="<?= $siteUrl('/viajes/Egipto/img/patio-el-cairo.jpg') ?>" width="640" height="395" loading="lazy" decoding="async" alt="Patio porticado de una mezquita egipcia, con cúpulas y un minarete"><figcaption>El Cairo, una de las etapas de tu viaje.</figcaption></figure>
            <ol class="planning-steps">
                <li><span>01</span><div><h3>Salida desde Barcelona</h3><p>Revisamos tus fechas, cuántos días tienes y las conexiones aéreas disponibles para organizar la llegada a Egipto.</p></div></li>
                <li><span>02</span><div><h3>Tu circuito por Egipto</h3><p>Combinamos El Cairo, el crucero por el Nilo y las visitas, con opciones regulares en español o servicios privados.</p></div></li>
                <li><span>03</span><div><h3>El presupuesto, con detalle</h3><p>Te indicamos los servicios incluidos, las excursiones, los suplementos y las condiciones de tu propuesta.</p></div></li>
            </ol>
        </div>
    </section>
    <section class="wrap section faq-section" aria-labelledby="faq-title">
        <div class="faq-intro"><p class="eyebrow">ANTES DE VIAJAR</p><h2 id="faq-title">Qué saber antes<br> de viajar a Egipto</h2><p>Información para empezar a preparar tu viaje a Egipto desde Barcelona.</p><figure class="section-photo faq-photo"><img src="<?= $siteUrl('/viajes/Egipto/img/piramides-giza.jpg') ?>" width="640" height="395" loading="lazy" decoding="async" alt="Las pirámides de Giza sobre la meseta desértica de Egipto"><figcaption>Giza, uno de los lugares que puedes incluir en tu recorrido.</figcaption></figure></div>
        <div class="faq-list">
        <?php foreach ($landing['faqs'] as $index => $faq): ?>
            <details<?= $index === 0 ? ' open' : '' ?>><summary><?= $escape($faq['question']) ?></summary><p><?= $escape($faq['answer']) ?></p></details>
        <?php endforeach; ?>
        </div>
    </section>
    <section class="request-section" id="presupuesto" aria-labelledby="presupuesto-title">
        <div class="wrap request-inner">
            <div class="request-copy"><p class="eyebrow">TU VIAJE EMPIEZA AQUÍ</p><h2 id="presupuesto-title">Pide tu presupuesto para Egipto<br> desde Barcelona</h2><p>Dinos cuándo te gustaría viajar y qué te apetece descubrir. Prepararemos una propuesta a medida con salida desde Barcelona.</p><div class="request-contact"><p>Si prefieres hablar con nosotros:</p><a class="whatsapp-contact" href="https://wa.me/34610461529" target="_blank" rel="noopener noreferrer"><i class="landing-icon icon-whatsapp" aria-hidden="true"></i><span>Escríbenos por WhatsApp<small>+34 610 461 529</small></span></a><a class="contact-method" href="tel:+34610461529"><i class="landing-icon icon-phone" aria-hidden="true"></i><span>Llámanos al +34 610 461 529</span></a><a class="contact-method" href="mailto:info@soloviajesdelujo.com"><i class="landing-icon icon-mail" aria-hidden="true"></i><span>info@soloviajesdelujo.com</span></a></div></div>
            <div class="request-form-wrap">
                <form class="request-form" id="egypt-request" method="post" action="<?= $siteUrl('/confirmacion.php') ?>" data-local="<?= $isLocal ? 'true' : 'false' ?>">
                    <div class="honeypot" aria-hidden="true"><label>Dejar este campo vacío<input name="website" type="text" tabindex="-1" autocomplete="off"></label></div>
                    <input type="hidden" name="id" value="0">
                    <div class="form-grid">
                        <div class="field"><label for="egypt-name">Nombre *</label><input id="egypt-name" name="name_contact" autocomplete="given-name" required maxlength="120"></div>
                        <div class="field"><label for="egypt-lastname">Apellidos</label><input id="egypt-lastname" name="lastname_contact" autocomplete="family-name" maxlength="120"></div>
                        <div class="field"><label for="egypt-email">Email *</label><input id="egypt-email" type="email" name="email_contact" autocomplete="email" required maxlength="254"></div>
                        <div class="field"><label for="egypt-phone">Teléfono</label><input id="egypt-phone" type="tel" name="phone_contact" autocomplete="tel" maxlength="60"></div>
                        <div class="field"><label for="egypt-destination">Destino</label><input id="egypt-destination" name="destino" value="<?= $escape($landing['destination']) ?>" readonly maxlength="100"></div>
                        <div class="field"><label for="egypt-departure">Ciudad de salida</label><input id="egypt-departure" name="ciudad_inicial" value="<?= $escape($landing['departure']) ?>" maxlength="200"></div>
                        <div class="field"><label for="egypt-date">Fecha aproximada</label><input id="egypt-date" type="date" name="fecha-viaje"></div>
                        <div class="traveller-fields"><div class="field"><label for="egypt-adults">Adultos</label><select id="egypt-adults" name="exampleSelect1"><?php for ($n = 1; $n <= 10; $n++): ?><option value="<?= $n ?>"<?= $n === 2 ? ' selected' : '' ?>><?= $n === 10 ? '10' : $n ?></option><?php endfor; ?></select></div><div class="field"><label for="egypt-children">Niños</label><select id="egypt-children" name="exampleSelect2"><?php for ($n = 0; $n <= 10; $n++): ?><option value="<?= $n ?>"><?= $n ?></option><?php endfor; ?></select></div></div>
                        <div class="field full-width"><label for="egypt-message">¿Cómo te gustaría viajar?</label><textarea id="egypt-message" name="message_contact" rows="4" maxlength="8000" placeholder="Crucero por el Nilo, viaje privado, Dahabeya, días en Hurghada… Cuéntanos tus ideas."></textarea></div>
                    </div>
                    <p class="privacy-note">Grupo Global MPS Viajes y Cruceros S.L. tratará tus datos para atender esta solicitud. Puedes consultar la información y tus derechos en nuestra <a href="<?= $siteUrl('/politica-privacidad.html') ?>">política de privacidad</a>.</p>
                    <?php if (!$isLocal): ?><div class="g-recaptcha" data-sitekey="6LeUddUUAAAAAFl8kcpUvMH1QySg_qYAA__8_ukq" data-callback="svlEgyptCaptchaReady" data-expired-callback="svlEgyptCaptchaExpired"></div><?php endif; ?>
                    <button class="button" type="submit"<?= $isLocal ? '' : ' disabled' ?>>Solicitar mi propuesta <span aria-hidden="true">↗</span></button>
                    <p class="form-note">Los campos con * son obligatorios.</p>
                </form>
                <p class="form-result" id="egypt-result" role="status" aria-live="polite" tabindex="-1" hidden></p>
            </div>
        </div>
    </section>
</main>
<footer class="site-footer">
    <div class="wrap footer-main">
        <div><a href="<?= $siteUrl('/index.php') ?>"><img src="<?= $siteUrl('/img/logo_sticky_2x.png') ?>" width="152" height="69" loading="lazy" alt="Solo Viajes de Lujo, inicio"></a><p>Viajes a medida, circuitos en español<br> y asesoramiento especializado en Egipto.</p></div>
        <div><h2>Descubre</h2><a href="<?= $siteUrl($landing['catalogue']) ?>">Todos los viajes a Egipto</a><a href="<?= $siteUrl('/index.php#destinos') ?>">Nuestros destinos</a><a href="<?= $siteUrl('/nosotros.html') ?>">Quiénes somos</a></div>
        <div><h2>Estamos en Barcelona</h2><p>Rector Ubach 16 · 08021 Barcelona</p><a href="https://wa.me/34610461529" target="_blank" rel="noopener noreferrer"><i class="landing-icon icon-whatsapp" aria-hidden="true"></i> WhatsApp · +34 610 461 529</a><a href="tel:+34610461529"><i class="landing-icon icon-phone" aria-hidden="true"></i> +34 610 461 529</a><a href="mailto:info@soloviajesdelujo.com"><i class="landing-icon icon-mail" aria-hidden="true"></i> info@soloviajesdelujo.com</a></div>
    </div>
    <div class="wrap footer-legal"><span>© <?= date('Y') ?> Solo Viajes de Lujo · Grupo Global MPS Viajes y Cruceros S.L.</span><div><a href="<?= $siteUrl('/terminos-condiciones.html') ?>">Términos y condiciones</a><a href="<?= $siteUrl('/politica-privacidad.html') ?>">Privacidad</a></div></div>
</footer>
</body>
</html>
