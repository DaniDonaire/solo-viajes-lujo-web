#!/usr/bin/env python3
"""Build versioned public WebP copies. Originals and database records are never changed.

Requires Pillow with WebP support. Run from any directory; sources are explicitly
listed in public-media-sources.json so future uploads are not silently rewritten.
"""
from concurrent.futures import ThreadPoolExecutor
from hashlib import sha256
import json
from pathlib import Path

from PIL import Image, ImageOps

ROOT = Path(__file__).resolve().parent.parent
SOURCE = json.loads((ROOT / 'tools/public-media-sources.json').read_text())
OUTPUT = ROOT / 'img/optimized'


def encode(path):
    source = ROOT / path.lstrip('/')
    settings = b'webp-v2-footer-q88' if path == '/img/pattern.png' else b'webp-v1-q84-card800-hero1920'
    versions = {}
    with Image.open(source) as original:
        profile = original.info.get('icc_profile', b'')
        digest = sha256(source.read_bytes() + settings + (b'-icc' if profile else b'')).hexdigest()[:16]
        image = ImageOps.exif_transpose(original)
        if image.mode not in ('RGB', 'RGBA'):
            image = image.convert('RGBA' if 'transparency' in image.info else 'RGB')
        for label, maximum in [('card', 800), ('hero', 1920)]:
            target = OUTPUT / (digest + '-' + label + '.webp')
            copy = image.copy()
            if copy.width > maximum:
                copy = copy.resize((maximum, round(copy.height * maximum / copy.width)), Image.Resampling.LANCZOS)
            # Preserve proportions; the tiled footer keeps its original full-size geometry.
            copy.save(target, 'WEBP', quality=88 if path == '/img/pattern.png' else 84,
                      method=5, icc_profile=profile)
            versions[label] = '/' + target.relative_to(ROOT).as_posix()
    return path, versions


if __name__ == '__main__':
    OUTPUT.mkdir(exist_ok=True)
    with ThreadPoolExecutor(max_workers=2) as pool:
        images = dict(pool.map(encode, SOURCE['sources']))
    manifest = {'aliases': SOURCE['aliases'], 'images': images}
    (ROOT / 'include/public-media.json').write_text(json.dumps(manifest, ensure_ascii=False, indent=2) + '\n')
    before = sum((ROOT / p.lstrip('/')).stat().st_size for p in images)
    after = sum((ROOT / v['card'].lstrip('/')).stat().st_size for v in images.values())
    print(f'{len(images)} originals preserved; card copies: {before:,} → {after:,} bytes.')
