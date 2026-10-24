#!/bin/sh
# Run via SSH. Read-only: no passwords, customer data, backups or configuration are printed.
set -eu
svl_web_root="$HOME/www"
printf 'Cuenta SSH: %s\n' "$(id -un)"
printf 'Directorio web: %s\n' "$svl_web_root"
for svl_program in git php mariadb mariadb-dump mysqldump rsync; do
    if command -v "$svl_program" >/dev/null 2>&1; then
        command -v "$svl_program"
    else
        printf 'No disponible: %s\n' "$svl_program"
    fi
done
if command -v php >/dev/null 2>&1; then
    php -r 'echo json_encode(array("php_cli"=>PHP_VERSION,"short_open_tag"=>ini_get("short_open_tag"),"mysqli"=>extension_loaded("mysqli"),"mbstring"=>extension_loaded("mbstring"),"curl"=>extension_loaded("curl")), JSON_PRETTY_PRINT), PHP_EOL;'
fi
if [ ! -d "$svl_web_root" ]; then
    printf 'No existe el directorio web esperado. Detener antes de preparar preproducción.\n'
    exit 1
fi
df -h "$svl_web_root"
du -sh "$svl_web_root"
if [ -r "$svl_web_root/eslogin/.htpasswd" ]; then
    printf 'Archivo de autenticación actual: existe y es legible; contenido omitido.\n'
else
    printf 'Archivo de autenticación actual: no se pudo comprobar.\n'
fi
if [ -e "$svl_web_root/preproduccion" ]; then
    printf 'ATENCIÓN: /preproduccion ya existe. No sobrescribirla.\n'
else
    printf '/preproduccion está libre.\n'
fi
printf 'Diagnóstico terminado. Ningún archivo ni base de datos se ha modificado.\n'
