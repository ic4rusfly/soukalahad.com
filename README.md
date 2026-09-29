# soukalahad.com — Souk Al Ahad · Agadir

The digital gateway to **Souk Al Ahad**, Africa's largest urban market:
a multilingual manual, an interactive map, merchant shops online, and a 360° virtual tour.

**Read [`PLAN.md`](PLAN.md) first** — roadmap, phases, architecture, field protocols, kill criteria.

## Stack
- PHP 8.2+ (no framework), MySQL from Phase 2
- Vanilla CSS + ES-module JavaScript (no build step)
- Leaflet.js (map, Phase 2) · Marzipano (360° tour, Phase 4)

## Run locally
```bash
php -S localhost:8000 router.php
```
Then open <http://localhost:8000> — it redirects to a language prefix:
`/en` · `/fr` · `/ar` (Arabic renders RTL).

In production: point the Apache document root at `public/` (`.htaccess` included).

## Structure
```
public/      document root — front controller, assets, .htaccess
app/lang/    translation dictionaries (en, fr, ar)
app/views/   PHP templates
data/        field data (POIs, merchants, articles) — from Phase 1
PLAN.md      the master plan
```

## Phase status
- **Phase 0 — Foundations: done** (multilingual skeleton with RTL)
- **Phase 1 — The Manual: core shipped** — 19 unique articles × EN/FR/AR = 57 files (history core, complete 13-gates series, practical guides)
- **Phase 2 — Map: v1 live** — Leaflet + `gates.json`, search + category filters, gate popups linked to guides (positions approximate until the field survey)
- **Phase 3 — Shop: pilot live** — `products.json` catalogue, order-list builder, single-message WhatsApp checkout, COD + worldwide notes
- **Phase 4 — 360° Tour: v1 live** — Marzipano equirect scenes, scene switcher, fullscreen; service worker (`sw.js`) makes the site work offline after first visit
- **All six sections are live — no coming-soon pages.** Modern theme (light/dark, glass header, RTL throughout).

## Structure
```
public/             document root — front controller, assets, .htaccess, sw.js, robots.txt
public/assets/js/   app.js · map.js · shop.js · tour.js (ES modules, no build step)
public/assets/data/ gates.json (map markers) · products.json (shop catalogue + WhatsApp number)
public/assets/tour/ 360° equirectangular scenes (preview scenes now; real captures later)
app/lang/           translation dictionaries (en, fr, ar)
app/views/          PHP templates
data/articles/      manual content: {lang}/{slug}.md → cached HTML
preview/            static mirrors of the PHP pages for design review (same CSS/JS)
PLAN.md             the master plan · DEPLOY.md — hosting guide
```

## Before launch (owner checklist)
1. Buy LAMP hosting (PHP 8.2+), deploy per [`DEPLOY.md`](DEPLOY.md)
2. Set the real WhatsApp order line in `public/assets/data/products.json`
3. Photo walk: replace tour preview scenes + verify gate GPS positions in `gates.json`
