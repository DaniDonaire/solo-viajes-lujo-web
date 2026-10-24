# Solo Viajes de Lujo

Copia del sitio PHP/MySQL, con catálogo, administrador histórico, presupuestos y phpList.
Los recursos gráficos y las dependencias PHP existentes se conservan en el repositorio.

## Preproducción y despliegue

Procedimiento y comandos en [docs/despliegue.md](docs/despliegue.md). La copia puede
usar `/preproduccion/` con configuración `staging`, bases exclusivas, autenticación
Apache y correos capturados. `config/staging.example.php` es solo una plantilla sin
credenciales. El push del código no publica ni migra las bases del hosting.

`tools/deployment-check.php` comprueba configuración y metadatos sin escribir.
`tools/migrate-forms-staging.php` muestra un plan por defecto y solo permite aplicar
el esquema en staging. La protección Apache de ejemplo es exclusiva de esa copia:
no sustituir con ella el `.htaccess` productivo.

## Configuración privada

Las credenciales no forman parte del repositorio. Los conectores cargan `config/database.php`.
Para otra instalación, copiar `config/local.example.php` a `config/local.php` y completar las
dos conexiones; también se pueden definir `SVL_WEB_DB_HOST`, `SVL_WEB_DB_NAME`,
`SVL_WEB_DB_USER`, `SVL_WEB_DB_PASSWORD`, `SVL_WEB_DB_SOCKET` y sus equivalentes
`SVL_NEWSLETTER_DB_*`. `SVL_CONFIG_FILE` permite situar el archivo privado fuera del sitio.

phpList requiere copiar `lists/config/config.example.php` a `lists/config/config.php`.
Sus credenciales SMTP/buzón se suministran mediante `SVL_SMTP_*` y `SVL_BOUNCE_*`.
Los tokens de los procesos históricos de registro y exportación se configuran con
`SVL_REGISTRATION_TOKEN` y `SVL_PASSENGER_EXPORT_TOKEN`. El formulario público de
newsletter utiliza validación de email y un campo antispam, sin un token incrustado.
Los conectores FTP históricos usan `SVL_FTP_HOST`, `SVL_FTP_USER` y `SVL_FTP_PASSWORD`.

## Vista local de la web pública

Con MySQL de XAMPP iniciado y las dos bases locales ya importadas:

```sh
python3 tools/serve-local.py --setup-forms
python3 tools/serve-local.py
```

Abrir `http://127.0.0.1:8099/`. El script lee el último perfil privado guardado en
`~/SoloViajesLocal/ultimo-respaldo-db.json` sin copiar contraseñas al proyecto.
Puede usarse `--credentials /ruta/conexiones-locales.json` o `--port 8100`.

El árbol contiene rutas distintas por mayúsculas, como `viajes/ALASKA` y
`viajes/Alaska`. En macOS debe alojarse en un volumen sensible a mayúsculas.

La vista está enlazada únicamente a loopback y habilita las etiquetas PHP cortas por
proceso. Permite los formularios de contacto y newsletter, el inicio del administrador
`http://127.0.0.1:8099/eslogin/` y la bandeja de consulta
`http://127.0.0.1:8099/eslogin/formularios.php`. Las pantallas del catálogo están
disponibles para navegar y consultar; sus filtros POST solo leen datos. Los procesos
antiguos de guardar, borrar, subir archivos o publicar siguen bloqueados, igual que
los archivos privados y los recursos externos de tracking.
Para detenerla, Ctrl+C en su terminal.

## Contacto y newsletter locales

La preparación crea `svl_form_submissions`, convierte `presupuesto` a UTF-8 completo y
amplía los dos campos IP para IPv6, únicamente en una base local `svl_local_*`.
Conserva el histórico y el trigger existente que añade el email del presupuesto a
`nuevos_mails`. Las altas de newsletter siguen guardándose en esa tabla de la base
web; este cambio no sincroniza ni envía campañas de phpList.

La solicitud, sus campos y el correo preparado se guardan en una transacción antes
de intentar el envío. La bandeja distingue guardado y resultado del correo. Si
falla el correo, la solicitud permanece guardada. No hay reenvío automático.

En local los correos se capturan como `.eml` privados fuera del proyecto, por defecto
en `/private/tmp/solo-viajes-lujo-mail`; `SVL_MAIL_CAPTURE_DIR` permite cambiar esa ruta.
El servidor local desactiva además la función `mail`. No se envían correos reales.
El correo lleva HTML y texto en UTF-8, destinatario del formulario y copia a
`info@soloviajesdelujo.com`. «Aceptado por el servidor» no prueba recepción en el buzón.

El menú lateral se comparte con las pantallas del administrador. La entrada antigua
`admin_especialidad_visul.php` conserva la consulta de especialidades y añade los
accesos separados a contactos y suscriptores de newsletter. Los registros existentes
y los que se reciban se consultan juntos en cada vista, con búsqueda, filtros y
paginación. Las URLs canónicas son `formularios.php?view=contacts` y
`formularios.php?view=newsletter`; los enlaces anteriores siguen siendo compatibles. Las
acciones del catálogo conservan sus formularios y endpoints; el login y la
protección Apache del directorio no se han modificado.

Las consultas unificadas son de solo lectura: cada solicitud de `presupuesto` se
enlaza con su último correo por referencia, sin volver a añadirla al listado.
Newsletter conserva las altas de `nuevos_mails` y muestra la última confirmación
registrada para el email de la lista 5. No se borran altas repetidas del origen.
Cuando no hay constancia del correo, el estado es «Sin registro».
Los filtros permiten buscar por nombre/email/teléfono, fechas, destino, origen y
correo en contactos; y por email, fechas, lista y correo en newsletter. La
paginación y la vuelta desde el detalle conservan los filtros.

Estos cambios están preparados y probados en local. Antes de un futuro despliegue,
habrá que aplicar el esquema y las adaptaciones de columnas en staging, configurar
`SVL_RECAPTCHA_SECRET` (o `recaptcha_secret` en la configuración privada) y verificar
el transporte de correo. La protección Apache del administrador debe permanecer
activa. No copiar la configuración local ni el router de pruebas a producción.

## Landing SEO de Egipto desde Barcelona

Vista local: `http://127.0.0.1:8099/viajes/Egipto/viajes-egipto-desde-barcelona.php`.
La página conserva el catálogo histórico de Egipto y se enlaza con él; no necesita
crear ni modificar registros del catálogo. El contenido editorial basado en la
documentación de Pilar se mantiene en `include/landings/egipto-barcelona.php` y la
vista compartida en `viajes/landing-seo.php`, con CSS y JavaScript propios. No se
edita desde el administrador histórico.

El formulario utiliza `confirmacion.php`, con destino Egipto, ciudad Barcelona y
sin asociar por error el destino 27 a una ficha de viaje. Su procedencia queda en
el registro del correo preparado. La respuesta en la propia landing solo confirma
el éxito después de recibir la confirmación de guardado. El evento `generate_lead`
se prepara tras esa confirmación, sin datos personales y solo en el dominio público;
no se ha activado ni modificado ninguna cuenta de Analytics o Search Console.

Se incluyen metadatos, canonical, datos estructurados de agencia/página/migas,
enlazado y actualización local de sitemap, robots y llms. Las imágenes se reutilizan
de la copia de producción y están en una carpeta pública; la landing no depende
de recursos de la newsletter bloqueados a buscadores. En local conserva la cabecera
`X-Robots-Tag: noindex, nofollow` del servidor de pruebas.

Los vuelos directos, precios, disponibilidad, excursiones y seguros no se dan por
garantizados: se concretan en cada propuesta. No se han añadido cifras de años de
experiencia mientras la documentación y la web muestran datos diferentes.
Antes de publicar habrá que verificar las condiciones comerciales, el dominio
canónico y reCAPTCHA/transporte de correo en staging. No se ha desplegado a producción.

### Reglas visuales de las landings

- Usar Montserrat, la misma familia de la web, en pesos 400 y 700. La landing la
  sirve desde el proyecto, con su licencia, para que también se vea bien en local.
- Conservar dorado `#c29b4d`, marrón `#714f09`, gris oscuro `#333`, blanco y gris
  claro `#f9f9f9`. Títulos principales en mayúsculas y botones con el dorado de marca.
- Separar los bloques con fondos, bordes y espacio; añadir una fotografía pertinente
  al menos cada dos secciones. Las imágenes deben corresponder al lugar descrito,
  tener texto alternativo y cargarse de forma diferida fuera de la cabecera.
- Usar iconos del repertorio existente para servicios y contacto. WhatsApp debe
  identificarse con su propio icono y abrir ese canal; teléfono y email mantienen
  enlaces independientes. No se mandan mensajes automáticamente.
- Incluir variantes naturales de la búsqueda principal en los títulos y el texto,
  sin repetirla mecánicamente ni prometer precios, disponibilidad o vuelos directos.
- En el catálogo, presentar la landing como una ficha con imagen y botón Detalles,
  conservando las fichas históricas y sin inventar duración o precio.

## Estado del código

El frontend usa PHP procedural/MySQLi, Bootstrap 3 y jQuery 2. La newsletter incluye
phpList 3.6.15 y dependencias vendorizadas; no ejecutar una actualización masiva de
Composer sobre esta copia sin revisar sus versiones y restricciones.

Hay problemas heredados de seguridad y compatibilidad con PHP 8 en administración y
presupuestos. Los nuevos formularios requieren PHP 8.1 o posterior con MySQLi/mysqlnd,
mbstring y cURL; la integración local se prueba con PHP 8.2. La compatibilidad del
proyecto completo con PHP 8.5 sigue pendiente de una prueba aislada, especialmente
administración, presupuestos históricos y phpList. Esta vista no constituye una
configuración de producción.

No versionar volcados reales, logs, autenticación privada, credenciales o backups.
Mantener los esquemas SQL fuente y los recursos que necesita el sitio.
