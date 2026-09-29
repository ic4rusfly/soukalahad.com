# DEPLOY — soukalahad.com to shared hosting (LAMP)

Target: any Moroccan/EU shared host with **PHP 8.2+** (MySQL not needed until Phase 2).
Cost: ~300–500 MAD/year. Time: ~45 minutes the first time.

## 1. Buy hosting

Any cPanel or DirectAdmin host with PHP 8.2+ works. During checkout, choose "I already own a domain": `soukalahad.com`.

## 2. Point the domain

In your registrar's DNS panel, set:

```
A     @      →  IP your host gives you (e.g. 123.45.67.89)
A     www    →  same IP
```

Wait for DNS (minutes to a few hours). `ping soukalahad.com` from your machine to confirm.

## 3. Upload

FTP (FileZilla) or the host's file manager:

1. Upload the repo contents so that `public/` sits at e.g. `/home/USER/soukalahad.com/public/`.
2. **Best:** in cPanel → *Domains* → *Document Root*, set the domain's root to `.../soukalahad.com/public`. Done — the rest of the app (app/, data/) is then unreachable from the web.
3. **If the host forces `public_html/`:** upload so that `public/*` merges into `public_html/`, and also upload `app/` and `data/` to the directory *above* `public_html/`. `public/index.php` and `.htaccess` handle the rest.

## 4. PHP version + HTTPS

- cPanel → *Select PHP Version* → **8.2 or newer**.
- Enable the free Let's Encrypt / AutoSSL certificate for `soukalahad.com` + `www`. Force HTTPS if the host offers a toggle (do NOT add your own redirect rules on top of it).

## 5. Smoke test (all must pass)

```
https://soukalahad.com            → redirects to /en/ (or /fr/, /ar/ by browser)
https://soukalahad.com/en/        → homepage: hero, stats, explore cards, latest articles
https://soukalahad.com/ar/history/agadir-earthquake-1960  → RTL article
https://soukalahad.com/en/visit/  → guide index (19 articles)
https://soukalahad.com/fr/visit/bargaining-101            → article page
https://soukalahad.com/en/map     → Leaflet map, 13 gate pins, filters + search work
https://soukalahad.com/ar/shop    → product cards, order list, WhatsApp checkout (RTL)
https://soukalahad.com/en/tour    → 360° scenes render, drag + fullscreen work
https://soukalahad.com/en/nope    → 404 "Lost in the souk?"
https://soukalahad.com/sitemap.xml→ XML with hreflang alternates
```

**Also before launch:** set the real WhatsApp order line in `public/assets/data/products.json` (`"whatsapp": "2126XXXXXXXX"`).

## 6. Search engines

1. [Google Search Console](https://search.google.com/search-console) → add property `https://soukalahad.com` → verify via DNS TXT.
2. Sitemaps → submit `https://soukalahad.com/sitemap.xml`.
3. Repeat in [Bing Webmaster Tools](https://www.bing.com/webmasters) (it feeds Bing + DuckDuckGo + ChatGPT search answers).
4. Request indexing for `/en/`, `/fr/`, `/ar/`.

## 7. After every content update

Option A (simple): edit files on your laptop, upload changed files with FileZilla.
Option B (proper): the host likely offers SSH/git — `git pull` in the app directory.

Remember: **edited articles rebuild their own cache automatically** — nothing to clear by hand.

## Troubleshooting

| Symptom | Fix |
|---|---|
| White page / 500 | PHP version < 8.2 — bump it in cPanel |
| Styles missing (unstyled HTML) | Document root wrong — assets must live at `/assets/...` under the domain |
| `/en/` gives 404 | mod_rewrite disabled — ask host to enable it (every shared host has it) |
| Sitemap 404 | You skipped uploading `app/` above the doc root |
