# Imágenes y enlaces públicos

Cambios preparados en local el 25/11/2026. No necesitan migrar ni modificar bases de datos.

- `include/public-media.php` y su manifiesto resuelven nombres antiguos, diferencias
  de mayúsculas, acentos y carpetas de imágenes. Los registros originales se conservan.
- `img/optimized/` contiene copias WebP de las fotografías, con proporciones y perfiles
  de color conservados: 800 px para tarjetas y hasta 1920 px para cabeceras. Los originales
  no se sobrescriben. La imagen inicial del slider carga con prioridad; las tarjetas
  de portada y categorías usan carga diferida. El slider reserva su espacio antes del JS.
- `tools/public-media-sources.json` enumera los originales y sus equivalencias verificadas.
  Para reconstruir las copias: `python3 tools/optimize-public-images.py`, con Pillow y
  soporte WebP/AVIF. El hosting solo sirve los archivos generados; no necesita Python.
- `img/recovered/china-10.png` es la decodificación de la fotografía JPEG XR antigua,
  usando JxrDecApp. El archivo `.jxr` original se conserva. Su alias sirve WebP compatible
  con los navegadores habituales.
- Donde no existe una foto recuperable se mantiene el tamaño de tarjeta con
  `img/destination-placeholder.svg`, una imagen neutra de la marca. No se atribuye una
  fotografía de otro país. La foto correcta puede añadirse después al manifiesto.
- Las entradas PHP de compatibilidad recuperan rutas del catálogo que ya estaban en
  enlaces y sitemap. Utilizan las mismas plantillas y consultas, sin duplicar registros.
  Si falta el parámetro, cada entrada abre su propio destino; las fichas sin viaje
  seleccionado vuelven al catálogo correspondiente. Las plantillas compartidas
  responden 404 cuando se intenta ejecutarlas directamente.
- El renderizado de enlaces `[web=…]` corrige espacios, prefijos y errores verificables.
  Una dirección ambigua queda como texto legible, sin crear enlaces locales ficticios.
- Las referencias decorativas a imágenes inexistentes conservan el fondo de color que
  ya se veía. Los iconos de Bootstrap y los favicons recuperan sus recursos de marca.
- El PDF histórico `CLAUSULADO-2000.pdf` no está en la copia: se conserva su texto en
  privacidad, sin el enlace roto. No se ha sustituido por otro documento contractual.

## Publicación posterior

No publicar solo las plantillas PHP. Primero deben estar disponibles el helper, el
manifiesto, todas las copias WebP, las imágenes recuperadas, los favicons, las fuentes y
las nuevas entradas de compatibilidad; después, las plantillas y CSS. Directorios
públicos 755 y archivos públicos 644; la configuración privada conserva su protección.
Mantener una copia de los archivos sustituidos. No importar la base local a producción.

Después de publicar, verificar URLs e imágenes por HTTP, revisar móvil/escritorio y
repetir PageSpeed sobre producción. La reducción de bytes local no constituye una
puntuación de PageSpeed ni una medición de usuarios reales. La disponibilidad de los
sitios externos enlazados debe revisarse por separado.
