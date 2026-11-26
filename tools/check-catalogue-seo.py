#!/usr/bin/env python3
"""Read-only HTTP regression checks; never submit a form or write to MySQL."""
import argparse
import json
from html.parser import HTMLParser
from pathlib import Path
import urllib.error
import urllib.parse
import urllib.request
import urllib.robotparser
import xml.etree.ElementTree as ET


class Page(HTMLParser):
    def __init__(self, body):
        super().__init__(convert_charrefs=True)
        self.canonicals = []
        self.images = []
        self.links = []
        self.lang = None
        self.feed(body.decode('utf-8', errors='replace'))

    def handle_starttag(self, tag, attrs):
        a = dict(attrs)
        if tag == 'html':
            self.lang = a.get('lang')
        if tag == 'link' and 'canonical' in a.get('rel', '').split():
            self.canonicals.append(a.get('href'))
        if tag == 'a' and 'href' in a:
            self.links.append(a['href'])
        if 'data-image-src' in a:
            self.images.append(a['data-image-src'])


class NoRedirect(urllib.request.HTTPRedirectHandler):
    def redirect_request(self, req, fp, code, msg, headers, newurl):
        return None


def main():
    parser = argparse.ArgumentParser(description=__doc__)
    parser.add_argument('--origin', default='http://127.0.0.1:8099')
    args = parser.parse_args()
    origin = args.origin.rstrip('/')
    opener = urllib.request.build_opener(NoRedirect())
    checks = []

    def fetch(path):
        try:
            response = opener.open(origin + path, timeout=20)
        except urllib.error.HTTPError as error:
            response = error
        return response.status, response.headers, response.read()

    def expect(condition, name):
        if not condition:
            raise AssertionError(name)
        checks.append(name)

    status, _, body = fetch('/robots.txt')
    expect(status == 200, 'robots accessible')
    robots = urllib.robotparser.RobotFileParser()
    robots.parse(body.decode().splitlines())
    expect(robots.can_fetch('Googlebot', origin+'/newsletter/images/132/photo.jpg'), 'public images crawlable')
    expect(not robots.can_fetch('Googlebot', origin+'/newsletter/private.php'), 'newsletter applications remain excluded')
    sets = {}
    ns = {'s': 'http://www.sitemaps.org/schemas/sitemap/0.9'}
    for path, count in [('/sitemap.xml', 496), ('/sitemap-ia.xml', 19)]:
        status, _, body = fetch(path)
        urls = [n.text for n in ET.fromstring(body).findall('s:url/s:loc', ns)]
        expect(status == 200 and len(urls) == len(set(urls)) == count, path+' unique canonical URLs')
        sets[path] = set(urls)
    expect(sets['/sitemap-ia.xml'] <= sets['/sitemap.xml'], 'auxiliary sitemap is a subset')
    for url in sorted(sets['/sitemap.xml']):
        u = urllib.parse.urlsplit(url)
        path = u.path + ('?'+u.query if u.query else '')
        status, _, body = fetch(path)
        expect(status == 200, 'sitemap 200 '+path)
        canonical = Page(body).canonicals
        expect(not canonical or canonical == [url], 'sitemap canonical '+path)
    for i in [1207, 1423, 1449, 972, 973, 974, 975, 976, 978, 979, 981, 982, 983, 984]:
        path = '/viajes/Egipto/viaje-Egipto.php?id_viaje='+str(i)
        status, _, body = fetch(path)
        page = Page(body)
        preferred = {974:978, 979:975}.get(i, i)
        expected = 'https://soloviajesdelujo.com/viajes/Egipto/viaje-Egipto.php?id_viaje='+str(preferred)
        expect(status == 200 and page.canonicals == [expected] and page.lang == 'es', 'Egypt canonical '+str(i))
        expect(bool(page.images) and all(robots.can_fetch('Googlebot', urllib.parse.urljoin(origin+path, img)) for img in page.images), 'Egypt images crawlable '+str(i))
        expect((expected in sets['/sitemap.xml']) and ((expected.replace(str(preferred), str(i)) in sets['/sitemap.xml']) == (i == preferred)), 'Egypt sitemap selection '+str(i))
    for path in ['/viajes/Egipto/viaje-Egipto.php', '/viajes/Egipto/viaje-Egipto.php?id_viaje=99999999', '/viajes/Egipto/viaje-Egipto.php?id_viaje[]=1449', '/viajes/Egipto/viaje-Egipto.php?id_viaje=invalid', '/viajes/Egipto/viajes-Egipto.php?id=99999999', '/viajes/Alemania/viaje-Alemania.php?id_viaje=927']:
        expect(fetch(path)[0] == 404, 'invalid entry returns 404 '+path)
    for path, expected in [('/viajes/Turquia/viaje-Turquia.php?id_viaje=1449','/viajes/Egipto/viaje-Egipto.php?id_viaje=1449'),('/viajes/Turquia/viajes-Turquia.php?id=27','/viajes/Egipto/viajes-Egipto.php?id=27')]:
        status, headers, _ = fetch(path)
        expect(status == 301 and headers['Location'] == expected, 'destination alias redirects '+path)
    status, _, body = fetch('/viajes/Egipto/viajes-Egipto.php?id=27')
    links = Page(body).links
    expect(status == 200 and not any('id_viaje=974' in x or 'id_viaje=979' in x for x in links), 'category links to preferred programs')
    for path in ['/contacto.php','/contacto.php?id=1449','/viajes/Egipto/viajes-egipto-desde-barcelona.php','/eslogin/','/eslogin/formularios.php?view=contacts','/eslogin/formularios.php?view=newsletter','/eslogin/admin_destinos_visul.php','/eslogin/admin_especialidad_visul.php','/eslogin/admin_news_visul.php','/eslogin/admin_news_agencias_visul.php','/eslogin/admin_lanza_visul.php','/eslogin/admin_copiarNews_add.php','/eslogin/assets/admin.css']:
        status, _, _ = fetch(path)
        allowed = [200, 401] if path.startswith('/eslogin/') and '127.0.0.1' not in origin and 'localhost' not in origin else [200]
        expect(status in allowed, 'navigation/form accessible '+path)
    print(json.dumps({'origin':origin,'passed':len(checks),'sitemap_urls':496,'egypt_programs':14,'database_writes':0,'form_submissions':0}))


if __name__ == '__main__':
    main()
