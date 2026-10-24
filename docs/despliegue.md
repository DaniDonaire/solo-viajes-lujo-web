# Preproducción y publicación

El push a `main` guarda el código en GitHub. No hay workflows de despliegue en este
repositorio. No se ha configurado un despliegue automático al hosting. Un webhook
externo del proveedor, si existiese, debe comprobarse en su panel.

## Primer paso: diagnóstico del hosting

Ejecutar en Terminal del Mac; la contraseña SSH se introduce solo en Terminal:

```sh
ssh soloviajesdelujo@soloviajesdelujo.com 'sh -s' < /Applications/XAMPP/xamppfiles/htdocs/solo-viajes-lujo-web/tools/hosting-diagnostic.sh
```

El resultado permite comprobar PHP CLI, herramientas, espacio libre, carpeta web y
existencia del archivo de autenticación. No muestra credenciales ni contactos y no
modifica nada. La versión/configuración PHP web puede diferir de la de CLI: debe
validarse también al probar las páginas protegidas.

## Aislamiento de `/preproduccion/`

La copia se prepara primero fuera de `www`, por ejemplo en
`~/svl-releases/preproduccion`. No crearla directamente bajo el directorio público
mientras se clona o se configura. Comprobar antes que las rutas de destino no
existan; no reutilizar ni borrar una instalación anterior sin revisarla.

```sh
mkdir -p "$HOME/svl-releases"
git clone --single-branch --branch main https://github.com/DaniDonaire/solo-viajes-lujo-web.git "$HOME/svl-releases/preproduccion"
cd "$HOME/svl-releases/preproduccion"
git rev-parse HEAD
mkdir -p "$HOME/svl-private/preprod-mail"
chmod 700 "$HOME/svl-private" "$HOME/svl-private/preprod-mail"
```

Anotar el SHA probado; no actualizarlo durante la validación. El repositorio y sus
medios ocupan espacio: el diagnóstico de disco debe permitir alojar la segunda
copia, las bases y los respaldos. No usar enlaces duros a archivos de producción.

Crear en el panel del hosting dos bases nuevas, `solov_preprod_web` y
`solov_preprod_newsletter`, o nombres equivalentes con `_preprod_`/`_staging_`.
Crear un usuario MySQL exclusivo sin permisos sobre `solov_ggmps` ni `solov_wp`.
El código rechaza perfiles staging sin subcarpeta, con nombres no exclusivos o con
ambas bases iguales. Esto complementa los permisos MySQL, que son la barrera real.

Copiar `config/staging.example.php` a
`~/svl-private/preproduccion.php`, rellenarlo con los datos nuevos y conservarlo
fuera de Git y de `www`. No copiar `config/local.php` del Mac ni usar las cuentas
productivas. Los permisos deben permitir leerlo al usuario PHP del hosting; si PHP
se ejecuta con la cuenta de hosting, usar 600 para ese archivo.

Importar una copia reciente de producción **solo en las bases nuevas**. El volcado
debe terminar correctamente, incluir el trigger y no reactivar eventos. Antes de
importar, revisar cualquier `USE`, `CREATE DATABASE`, nombre de base cualificado y
`DEFINER`: nunca ejecutar un dump que seleccione una base productiva. Para la tabla
MyISAM, elegir una estrategia de copia consistente que no bloquee toda la web sin
necesidad. No reutilizar a ciegas los comandos fallidos de exportación anteriores.
La preparación/importación concreta depende de las cuentas y herramientas del panel.

## Esquema y protección

Desde la copia todavía privada, con las credenciales de preproducción ya completas:

```sh
SVL_CONFIG_FILE="$HOME/svl-private/preproduccion.php" php -d short_open_tag=On tools/deployment-check.php
SVL_CONFIG_FILE="$HOME/svl-private/preproduccion.php" php tools/migrate-forms-staging.php
```

El segundo comando muestra un plan sin escribir. Si la copia se ha validado y el
nombre es exactamente el configurado, aplicar únicamente en esa base staging:

```sh
SVL_CONFIG_FILE="$HOME/svl-private/preproduccion.php" php tools/migrate-forms-staging.php --apply --database=solov_preprod_web
SVL_CONFIG_FILE="$HOME/svl-private/preproduccion.php" php -d short_open_tag=On tools/deployment-check.php --require-ready
```

La migración crea el registro de formularios, convierte `presupuesto` a UTF8mb4 y
amplía las IP a 45 caracteres cuando haga falta. No borra ni importa datos. Exige
InnoDB, conserva recuentos y trigger y se niega a ejecutarse en producción. Si
falla una comprobación, mantener cerrada la copia y revisar; los DDL no tienen una
reversión transaccional automática. `tools/setup-forms.php` sigue siendo solo local.

Revisar los paths de `tools/preproduction.htaccess` y copiarlo como `.htaccess`
**solo en la copia de preproducción**, sustituyendo allí la versión del repositorio.
Requiere módulos Apache de autenticación, headers, env y rewrite; no quitar las
directivas si el servidor las rechaza. Configuración preparada:

- Basic Auth en toda la copia, usando el archivo de credenciales existente.
- `SVL_ENV=staging`, `SVL_BASE_PATH=/preproduccion` y perfil privado fuera de `www`.
- `X-Robots-Tag: noindex, nofollow, noarchive` y caché privada.
- CSP que bloquea Google/Ads/GTM y conexiones externas en esta copia.
- Contacto y newsletter activos en sus bases exclusivas; correos capturados fuera
  del directorio público y CAPTCHA en modo prueba dentro del acceso protegido.
- Acciones históricas de borrar/guardar/campañas bloqueadas, igual que en local;
  las pantallas y sus filtros de consulta siguen disponibles.

No cambiar el `.htaccess` ni el `.htpasswd` de la administración productiva. Cuando
todo esté completo y la ruta pública siga libre, mover la carpeta preparada a
`~/www/preproduccion`. Usar solo HTTPS y comprobar primero que sin autenticación
responde 401, que aparecen las cabeceras y que los envíos van a
`/preproduccion/confirmacion.php`/`registro.php`. No abrir la copia si falla alguno.

Dirección prevista, todavía no desplegada:
`https://soloviajesdelujo.com/preproduccion/`.

## Publicación posterior sin sustituir datos

1. Obtener un respaldo reciente y verificado de archivos y ambas bases. Conservar
   configuraciones, autenticación, medios subidos y solicitudes nuevas del servidor.
2. Validar en preproducción exactamente el SHA que se publicará: navegación,
   landing, formularios guardados incluso con fallo de correo, lectura del admin y
   ausencia de tracking/envíos reales en la copia. Confirmar las condiciones de viaje.
3. Preparar una migración revisada sobre **la base productiva actual**. No importar
   las bases del Mac ni las de staging encima de ella. Los `ALTER TABLE` pueden
   bloquear: elegir una ventana controlada y comprobar de nuevo tablas y trigger.
4. Publicar los archivos revisados con lista explícita, sin `rsync --delete`, sin
   copiar perfiles privados, `.htpasswd`, logs ni la protección de staging. Preservar
   el `.htaccess` productivo del hosting y fusionar solo reglas necesarias.
5. Usar `env=production`, `base_path` vacío y las conexiones productivas privadas.
   Confirmar reCAPTCHA y transporte de correo. Probar entregas reales únicamente
   cuando se autorice ese ensayo; aceptación del servidor no demuestra recepción.
6. Comprobar URLs antiguas, landing, formularios y admin; observar errores y nuevos
   registros. Mantener una versión anterior del código para revertir archivos si
   hace falta. No restaurar una base antigua como reversión: borraría leads nuevos.

No se garantiza riesgo cero. Este orden permite detectar fallos en una copia,
limitar la intervención y conservar los datos que sigan llegando al sitio activo.

## Login actual

`eslogin/.htaccess` usa `AuthType Basic`, `AuthName ByPassword` y
`AuthUserFile /home/soloviajesdelujo/www/eslogin/.htpasswd`. El cuadro del navegador
lo muestra Apache, antes de ejecutar PHP; no es un formulario de login de la web.
Se mantiene ahora. Una futura pantalla con sesiones, cierre de sesión y permisos
requerirá un cambio separado; no quitar Basic Auth hasta tener esa alternativa
probada y protegida.
