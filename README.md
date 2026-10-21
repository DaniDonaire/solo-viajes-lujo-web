# Solo Viajes de Lujo

Copia del sitio PHP/MySQL, con catálogo, administrador histórico, presupuestos y phpList.
Los recursos gráficos y las dependencias PHP existentes se conservan en el repositorio.

## Configuración privada

Las credenciales no forman parte del repositorio. Los conectores cargan `config/database.php`.
Para otra instalación, copiar `config/local.example.php` a `config/local.php` y completar las
dos conexiones; también se pueden definir `SVL_WEB_DB_HOST`, `SVL_WEB_DB_NAME`,
`SVL_WEB_DB_USER`, `SVL_WEB_DB_PASSWORD`, `SVL_WEB_DB_SOCKET` y sus equivalentes
`SVL_NEWSLETTER_DB_*`. `SVL_CONFIG_FILE` permite situar el archivo privado fuera del sitio.

phpList requiere copiar `lists/config/config.example.php` a `lists/config/config.php`.
Sus credenciales SMTP/buzón se suministran mediante `SVL_SMTP_*` y `SVL_BOUNCE_*`.
Los tokens de registro y exportación se configuran con `SVL_REGISTRATION_TOKEN` y
`SVL_PASSENGER_EXPORT_TOKEN`; vacíos deshabilitan esas acciones.
Los conectores FTP históricos usan `SVL_FTP_HOST`, `SVL_FTP_USER` y `SVL_FTP_PASSWORD`.

## Vista local de la web pública

Con MySQL de XAMPP iniciado y las dos bases locales ya importadas:

```sh
python3 tools/serve-local.py
```

Abrir `http://127.0.0.1:8099/`. El script lee el último perfil privado guardado en
`~/SoloViajesLocal/ultimo-respaldo-db.json` sin copiar contraseñas al proyecto.
Puede usarse `--credentials /ruta/conexiones-locales.json` o `--port 8100`.

El árbol contiene rutas distintas por mayúsculas, como `viajes/ALASKA` y
`viajes/Alaska`. En macOS debe alojarse en un volumen sensible a mayúsculas.

La vista está enlazada únicamente a loopback, habilita las etiquetas PHP cortas por
proceso y bloquea formularios, endpoints mutantes, administradores, archivos privados
y recursos externos de tracking. Para detenerla, Ctrl+C en su terminal.

## Estado del código

El frontend usa PHP procedural/MySQLi, Bootstrap 3 y jQuery 2. La newsletter incluye
phpList 3.6.15 y dependencias vendorizadas; no ejecutar una actualización masiva de
Composer sobre esta copia sin revisar sus versiones y restricciones.

Hay problemas heredados de seguridad y compatibilidad con PHP 8 en administración y
presupuestos. Esta vista local permite revisar el catálogo; no certifica esos módulos
ni constituye una configuración de producción.

No versionar volcados reales, logs, autenticación privada, credenciales o backups.
Mantener los esquemas SQL fuente y los recursos que necesita el sitio.
