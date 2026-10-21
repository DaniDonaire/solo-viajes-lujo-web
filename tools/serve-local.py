#!/usr/bin/env python3
"""Start an isolated local preview using the existing private imported DB profiles."""
import argparse
import json
import os
from pathlib import Path
import subprocess
import sys


def main():
    parser = argparse.ArgumentParser(description=__doc__)
    parser.add_argument('--port', type=int, default=8099)
    parser.add_argument('--credentials', type=Path)
    args = parser.parse_args()
    root = Path(__file__).resolve().parent.parent
    if args.credentials:
        credentials_path = args.credentials.expanduser().resolve()
    else:
        storage = Path.home() / 'SoloViajesLocal'
        last = json.loads((storage / 'ultimo-respaldo-db.json').read_text())
        credentials_path = Path(last['directory']) / 'conexiones-locales.json'
    credentials = json.loads(credentials_path.read_text())
    environment = dict(os.environ)
    environment.pop('SVL_CONFIG_FILE', None)
    environment.update(SVL_ENV='local', SVL_REGISTRATION_TOKEN='', SVL_PASSENGER_EXPORT_TOKEN='',
                       SVL_SMTP_HOST='127.0.0.1', SVL_SMTP_USER='', SVL_SMTP_PASSWORD='',
                       SVL_FTP_HOST='127.0.0.1', SVL_FTP_USER='', SVL_FTP_PASSWORD='')
    for role, prefix in [('web', 'SVL_WEB_DB_'), ('newsletter', 'SVL_NEWSLETTER_DB_')]:
        profile = credentials[role]
        if profile['host'] not in ('localhost', '127.0.0.1') or not profile['database'].startswith('svl_local_'):
            raise RuntimeError('The preview accepts only the imported local databases.')
        for key, suffix in [('host', 'HOST'), ('database', 'NAME'), ('user', 'USER'), ('password', 'PASSWORD'), ('socket', 'SOCKET')]:
            environment[prefix + suffix] = profile.get(key, '')
    php = '/Applications/XAMPP/xamppfiles/bin/php'
    url = 'http://127.0.0.1:' + str(args.port) + '/'
    print('Vista local:', url, flush=True)
    print('Solo navegación pública. Formularios, correo, tracking y administración desactivados.', flush=True)
    command = [php, '-d', 'short_open_tag=On', '-d', 'display_errors=Off', '-d', 'log_errors=On',
               '-d', 'disable_functions=mail,exec,shell_exec,system,passthru,popen,proc_open',
               '-S', '127.0.0.1:' + str(args.port), '-t', str(root), str(root / 'tools/local-router.php')]
    return subprocess.call(command, cwd=root, env=environment)


if __name__ == '__main__':
    try:
        sys.exit(main())
    except KeyboardInterrupt:
        pass
    except Exception as error:
        print('No se pudo iniciar la vista local:', str(error), file=sys.stderr)
        sys.exit(1)
