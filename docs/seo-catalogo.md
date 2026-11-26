# URLs del catálogo e indexación

Se conservan los registros, los formularios y las URLs históricas. No hay migración
ni escrituras en las bases de datos en este cambio.

- La versión pública preferida es `https://soloviajesdelujo.com`, sin `www`.
  Apache redirige `www` con 308 para conservar método y cuerpo en los formularios.
  Se mantiene la excepción ACME y la protección de archivos privados.
- Las fichas y categorías declaran su URL canónica, sin parámetros de seguimiento.
  Un ID inexistente o inválido devuelve 404; un ID válido bajo otra carpeta se
  redirige al destino real. Se mantienen los parámetros `id` e `id_viaje`.
- Los itinerarios de Egipto 974/978 y 975/979 se comprobaron idénticos. Las versiones
  principales son **978** (con visibilidad en la exportación anterior de Search
  Console) y **975** (indexada). 974 y 979 siguen mostrando sus contenidos y
  mantienen sus referencias de contacto; su canónica apunta a la versión principal.
  Los enlaces públicos y sitemaps señalan las versiones principales. Si esos viajes
  pasan a tener itinerarios diferentes, revisar el mapa en `include/catalogue-seo.php`
  y volver a añadir las versiones independientes a los sitemaps.
- El sitemap principal contiene **496** URLs y el auxiliar **19**: se eliminan
  únicamente las dos versiones duplicadas y la ficha alemana 927, que estaba vacía
  también en producción. Los 14 programas de Egipto siguen accesibles.
- `robots.txt` permite `/newsletter/images/`, donde viven fotografías públicas;
  el resto de `/newsletter/`, phpList y el administrador siguen excluidos.
- La plantilla de programas tiene encabezados cerrados e idioma español. La hoja
  `css/catalogue-seo.css` conserva la tipografía y los espacios históricos.

Comprobación de lectura, con MySQL local iniciado:

```sh
python3 tools/serve-local.py
python3 tools/check-catalogue-seo.py
```

La comprobación recorre las URLs del sitemap, valida canónicas, robots, imágenes,
404 y redirecciones, y abre pantallas de consulta del admin y formularios. No envía
formularios ni modifica registros. El router local mantiene su `noindex` de pruebas.
Para publicar se deben fusionar las reglas nuevas con el `.htaccess` real del
hosting, guardar una copia verificable de todos los archivos sustituidos y preservar
configuraciones privadas, autenticación y bases. Que las pruebas pasen no garantiza
que Google indexe inmediatamente todas las páginas.
