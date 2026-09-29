# PLAN — SoukAlAhad · The Digital Gateway to Souk Al Ahad, Agadir

**Project:** soukalahad.com
**Founder:** you (on-site in Agadir — this is the unfair advantage, use it)
**Stack (fixed by founder decision):** PHP · CSS · JS — no frameworks, no build step
**Date:** 2026-09-28 · **Status:** Direction approved. Phase 0 in progress (this repo).

---

## 1. The vision (restated so nobody can squirm out of it later)

> A multilingual **manual** for Souk Al Ahad — Africa's largest urban market (≈6,000 shops, 13 gates, ~11–13 ha) — featuring an **interactive map** in the class of [thedubaimall.com/en/map](https://thedubaimall.com/en/map), an **online shop** for the souk's merchants, a **360° virtual tour** usable from anywhere (including offline), and a **history archive** of the souk and of Agadir itself — built to encourage tourism.

That vision is **four products plus a media library**. One person building four products simultaneously ships zero products. Hence the rule:

## 2. The one rule of this roadmap

> **Each phase ships publicly before the next phase starts.**
> The only allowed parallelism is *field data collection* (photos, shop locations, merchant interviews) — it is cheap, it compounds, and only you can do it.

Supporting rules — non-negotiable, written for this project specifically:

1. **Real photos from the souk only.** No stock images. Your main competitor publishes Pexels stock; you live minutes from the gates. Every real photo is a moat.
2. **WhatsApp before carts. Carts before marketplaces.** That is how commerce actually works in Morocco in 2026.
3. **Every public page ships in EN + FR + AR (with RTL) — or it doesn't ship.**
4. **If it can't be measured, it doesn't count.** Weekly metrics review, 15 minutes, same day every week.
5. **No paid tools while free ones work. No WordPress. No nulled scripts** (nulled plugins are how Moroccan shared-host sites die).

## 3. Roadmap at a glance

| # | Product | Window (part-time, 10–15 h/wk) | Cost |
|---|---------|-------------------------------|------|
| 0 | Foundations — skeleton, brand, hosting, repo | Sep 29 – Oct 4, 2026 (done today) | ~0 |
| 1 | **The Manual** (EN/FR/AR): 30+ articles, history core | Oct 5 – Nov 22, 2026 → **public launch** | 0 |
| 2 | **Interactive map**: 13 gates, zones, 200+ POIs | Nov 2026 – Jan 2027 | 0 |
| 3 | **The shop**: WhatsApp directory → cart → multi-vendor | Dec 2026 – Feb 2027 | consignment stock |
| 4 | **360° virtual tour**: 40+ nodes, offline PWA | Feb – Mar 2027 | 4,000–6,000 MAD (camera) |
| 5 | **Agadir Memory**: oral histories, photo archive, timeline, +4 languages | continuous from Nov 2026 | 0 |

**Full vision live: ~5 months. First public launch: 8 weeks.** The one thing money cannot buy here is your consistency — that is the real budget.

## 4. Phase 0 — Foundations ✅ (this repo, done today)

**Goal:** a deployed multilingual skeleton so that everything after it is *adding content*, never *starting over*.

Delivered in this repo:

- Front controller with language routing: `/en`, `/fr`, `/ar` (browser-negotiated redirect on `/`)
- RTL-ready Arabic (logical CSS properties), translation dictionaries per language
- Shell pages for all six sections (Home, Visit, History, Map, Shop, 360° Tour)
- Design tokens (souk palette: terracotta / saffron / teal / sand), zero dependencies, no build step
- Apache `.htaccess` for shared hosting; dev router for `php -S`

Remaining (yours, this week):

- [ ] Buy LAMP shared hosting (any Moroccan host: PHP 8.2+, MySQL, FTP/SSH — ~300–500 MAD/yr). Point soukalahad.com at it. Document root → `public/`. Enable free HTTPS.
- [ ] Register Google Search Console + Bing Webmaster; verify all 3 language prefixes.
- [ ] Analytics: Plausible (paid) or a self-hosted counter; GA4 if free-only. No consent-banner mess if avoidable.

**Done when:** `soukalahad.com/{en,fr,ar}` return 200 from real hosting, 404 works, sitemap submitted.

## 5. Phase 1 — The Manual (the SEO engine) — **IN PROGRESS (started 2026-09-28)**

**Shipped so far:** article engine (Markdown → cached HTML, `app/articles.php`), section + article views with breadcrumbs and Article JSON-LD, `sitemap.xml` with hreflang, `robots.txt`, history core (3 articles × EN/FR/AR), **launch batch** (gates 1–5, first-visit plan, bargaining 101, argan guide), **the complete 13-gates series** (gates 1–13 × EN/FR/AR), homepage "Latest from the manual", `DEPLOY.md`. **19 unique articles × 3 languages = 57 published files.**
**Still to do:** remaining practical guides (safety, hours/Monday, Sunday vs weekday, Ramadan, prices list, etiquette & Tachelhit greetings, what to eat, one day in Agadir), photos to replace the placeholder slots, hosting purchase + deploy (DEPLOY.md is ready).

**Goal:** become the most complete, most photographed, fastest guide to Souk Al Ahad on the internet, in three languages. This phase is pure content on the Phase 0 skeleton + a tiny article system (Markdown in, cached HTML out).

### Content outline (32 launch articles — full list in Appendix B)

- **The 13 Gates series** — one article per gate: what's behind it, what to buy there, photos, how to enter (13 articles — this series alone outranks every competitor page)
- **Practical guides** — first visit plan, bargaining with real numbers, fake-argan detection, price list, transport, safety, hours, kids, Ramadan, Sunday crowds, etiquette (Tachelhit/Arabic greetings)
- **Food & craft** — spice glossary with photos, amlou, rugs, what to eat
- **History core** — Talborjt → Amsernat move, the 1960 earthquake in 5 minutes, how Agadir was rebuilt and why it looks the way it does
- **Timeline page** (static CSS/JS interactive) — the seed of Phase 5

### Build

- `article` system: Markdown files per language, PHP renders + caches to static HTML (the manual does not need per-hit dynamic rendering)
- JSON-LD: `TouristAttraction` (gates), `Article`, `BreadcrumbList`; per-language sitemaps; hreflang (already in skeleton)
- Photo discipline: every article ≥3 original photos, alt text in its own language
- Performance budget: <50 KB CSS+JS total, LCP <2.5 s on 3G — your Next.js competitor is heavier; beat them on speed and depth

### Editorial cadence

2 articles/week × EN first, FR/AR within 48 h. 30 articles ≈ 15 weeks — but launch with the first 8 (gates 1–5 + 3 practical), then keep publishing in public. **Ship before it's finished.**

### Done when

- 30+ articles live in EN, core 15 in FR and AR
- Sitemaps indexed; **≥1,000 organic visits/month within 4 months of launch** (kill-criteria checkpoint: if not reached, diagnose content/SEO before ANY map work)

## 6. Phase 2 — The Interactive Map

**Benchmark:** thedubaimall.com/en/map — level selector, category filters, store search, detail cards, directions. The souk is **single-level** (simpler), but has **no official digital plan** (harder — we must create the data ourselves; nobody else will).

### Data (field work, starts in October, in parallel with Phase 1)

- Trace the souk plan: OpenStreetMap outlines + satellite imagery → clean SVG/GeoJSON plan; the 2021 renovation gives coherent geometry
- GPS-pin all 13 gates; define the ~8 thematic zones (spices, produce, pottery, carpets, leather, jewellery, electronics, fish)
- **POI collection protocol (Appendix A):** target 200+ shops in v1 (15–25 per zone) — name, category, gate, alley/landmark, WhatsApp, photo, consent. Phone form, offline-capable (KoboToolbox / Google Forms offline)
- Start collecting on the same photo walks as Phase 1 — one walk, two harvests

### Build (all free, all vanilla)

- **Leaflet.js** with `CRS.Simple` + georeferenced plan image as the base layer (this is exactly how "mall map" experiences are built without paying for indoor-mapping SaaS)
- POIs served from MySQL as GeoJSON; category filter chips; search; gate landing pages (`/en/map?gate=9` — deep-links into the Phase 1 gate articles); share links
- Embeddable `<iframe>` widget for hotels / riads / tourism office
- Admin CRUD (boring PHP: list, add, edit, delete — sessions + CSRF)

### NOT building in Phase 2

No turn-by-turn indoor routing (later, Phase 2.5, only if data supports it). No WebGL. No paid platforms (MapsPeople et al.). No "you are here" indoors (GPS doesn't penetrate roofs; QR codes at gates instead).

### Done when

200+ POIs; search + filters usable on a cheap Android over 3G in <3 s; map used by ≥5% of sessions within 8 weeks (checkpoint).

## 7. Phase 3 — The Shop (staged, WhatsApp-first)

**Reality anchoring:** ~84% of Moroccan online buyers pay **cash on delivery**; Jumia/Avito own marketplace traffic; the souk's shops don't even take cards in person. So we do not start with a marketplace. We start by routing orders to merchants.

- **3a — Merchant directory (rides on Phase 1/2):** every merchant page = photos + story + map pin + hours + **WhatsApp deep-link button** ("Order / Ask in WhatsApp"). Zero logistics, immediate value, sellable in person gate by gate. Free basic listing; **premium listing 100–200 MAD/month** (featured, multi-language, pro photos) — your first revenue.
- **3b — Curated single-vendor cart:** YOU consign 10–30 shippable products (argan, amlou, spices, babouches, small leather, mini-rugs). One checkout, one shipper. Domestic: **COD via Amana/Cathedis** — mitigate refusals with exact photos, weights, dimensions, phone confirmation before dispatch. International: Poste Maroc/DHL + **PayPal** (Stripe doesn't onboard Moroccan entities directly; YouCan Pay / CMI for local cards). Margins 30–40%.
- **3c — Merchant accounts:** phone-first merchant dashboard; new-order notifications via WhatsApp/e-mail; merchant fulfils; you take 15–20% or a flat fee.
- **3d — Payouts, splits, commissions** — only if 3c proves volume.

**Done when (3b):** 30 products live, ≥10 orders/month by month 3, COD refusal <20%. **Kill criterion:** if 3c has <5 active merchants after 60 days of in-person selling, the market is telling you something — stop, listen.

## 8. Phase 4 — The 360° Virtual Tour

**Your "visit it online, even offline" requirement, made concrete.**

- **Capture:** Insta360 X4 / Ricoh Theta (~4,000–6,000 MAD) — but **prototype first with phone panoramas** (50 scenes, free). Nodes: all 13 gates, main intersections, hero merchants, food section. Golden hours, HDR, verbal consent from merchants in frame.
- **Tech:** **Marzipano** (open-source, vanilla JS, self-hosted): hotspot graph scene-to-scene, gyroscope support, fullscreen kiosk mode. Static tiles served by the same PHP host — no SaaS.
- **Offline:** service worker precaches tile pyramids → the tour works with no connection; that's your "offline" requirement. QR codes at each gate: "scan to start the virtual tour."
- **Kiosk mode** for hotels, riads, and the tourism office — same URL, fullscreen. This is a sponsorship product (Phase-5-era revenue).

**NOT building:** drone footage (permits), video production, LiDAR/3D scanning.

**Done when:** 40+ nodes, all gates covered, first pano <3 s on 3G, works in airplane mode.

## 9. Phase 5 — Agadir Memory (the archive)

- **Oral history:** 10–20 recorded interviews with veteran merchants (Tachelhit / Arabic / French) — transcripts + 60-second video cuts. **Nobody else has this. It is your deepest moat and your press story.** Interview kit in Appendix A.
- **Photo archive:** family photos, "Mémoire d'Agadir" (mfd.agadir.free.fr), earthquake literature — properly licensed, credited.
- **Interactive timeline** (expands the Phase 1 page): Portuguese fort → Talborjt Sunday market → 29 Feb 1960 earthquake (~15,000 dead, city destroyed) → reconstruction & the souk's move to Quartier Industriel/Amsernat → growth → 2021 renovation → today.
- **Languages wave 2:** Spanish, German, Italian, Polish (Agadir's 2025 top markets: UK, domestic, FR, DE, PL — 1.5M arrivals, +9%). **Honorific Tachelhit pages** for key content — respect the Souss, and it's a story journalists will write about.

## 10. Architecture

```
Stack: PHP 8.2+ (no framework) · MySQL (from Phase 2) · vanilla CSS (logical properties → RTL for free)
       · ES-module JS · Leaflet (Phase 2) · Marzipano (Phase 4) · no build step, no Composer before Phase 3

public/          document root: front controller, assets, .htaccess
app/lang/        translation dictionaries (en, fr, ar → +es/de/it/pl later)
app/views/       PHP templates (layout + page partials)
data/            field data: POIs, merchants, interviews (Phase 1+)
admin/           CRUD (Phase 2+): articles, POIs, merchants, products, tour nodes
```

- **i18n:** path prefix `/en|fr|ar/`; dictionaries in `app/lang/`; DB entities use per-locale columns (`name_en, name_fr, name_ar`) — simple, fast, no translation tables to over-engineer
- **SEO = the growth engine:** JSON-LD everywhere, per-language sitemaps, hreflang, canonical URLs, image alt discipline, Core Web Vitals budget (<50 KB CSS+JS, LCP <2.5 s on 3G)
- **Caching:** article pages render once to static HTML (PHP output buffering → file cache)
- **Security:** PDO prepared statements only; sessions + Argon2 + CSRF in admin; HTTPS-only; nightly DB dump off-provider + weekly to your laptop
- **Hosting:** any Moroccan shared LAMP (300–500 MAD/yr). Vanilla PHP is an *advantage* here: every host runs it, every local dev knows it, nothing to update but your own code

## 11. Data schemas (v1 sketch)

```
poi(id, zone, gate, category, name_ar, name_fr, name_en, lat, lng, alley_ref, whatsapp, photos_json, featured, status, updated_at)
merchant(id, shop_name, owner, category, gate, alley_ref, phone, whatsapp, photos_json, languages, story_id, status)
article(id, lang, slug, title, body_md, hero, category, status, published_at)
product(id, merchant_id, name_ar/fr/en, price_mad, unit, photos_json, stock_type[consignment|merchant], shipping_class, status)
tour_node(id, scene_id, pano_tiles, lat, lng, hotspots_json, caption_ar/fr/en)
story(id, merchant_id, media_url, lang, transcript, duration, consent_given)
```

## 12. Money

**Year-1 costs:** domain ~120 MAD (paid) · hosting 300–500 MAD · 360 camera 4,000–6,000 MAD (Phase 4, deferrable) · misc 500 MAD → **the entire vision costs under ~7,000 MAD.** The constraint is never money. It's your consistency.

**Revenue, in order of realism:**
1. Shop margin 30–40% on curated products (Phase 3b)
2. Premium merchant listings, sold in person, gate by gate (Phase 3a — first money can arrive before the cart exists)
3. Ads at >10k visits/month
4. Kiosk sponsorship for the 360° tour (hotels, tourism office)
5. Affiliate (tours, transfers, riads) — last, and only if it never rots the manual's credibility

## 13. Risks & kill criteria

| Risk | Counter |
|------|---------|
| `soukelhadagadir.com` accelerates | Their moat is a keyword domain; yours is *physical*: original photos, interviews, merchant relationships, languages, speed. They publish stock photos and a placeholder phone number (`+212 5XX XX XX XX`). |
| Souk authority / municipality builds an official platform | Engage them in Phase 2 — offer the map as the free "official" one. Speed is your protection. |
| **Scope death — the #1 killer (it already ate one year of this project)** | The one rule. Kill criteria below. |
| COD refusal rates | Exact photos/weights/dimensions; phone confirmation before dispatch |
| Solo-founder burnout | Minimum 10 h/week. Under that, cut Phase 5, keep 1–4. Under 6, park it honestly. |

**Kill criteria (if triggered: fix, do not advance):**
- Phase 1: <1,000 organic visits/month 4 months post-launch → content/SEO problem; diagnose before any map work
- Phase 2: map usage <5% of sessions after 8 weeks → surface it harder or simplify
- Phase 3b: <10 orders/month after 3 months → do NOT build 3c
- Phase 3c: <5 active merchants after 60 days of in-person selling → stop, listen

## 14. Decisions I need from you

1. **Hosting** — any shared LAMP with PHP 8.2+ and MySQL. Buy it this week (~300–500 MAD). I'll handle configuration and deploy steps after.
2. **Languages** — confirm EN + FR + AR for wave 1 (recommended). Say otherwise now, not in November.
3. **Camera** — phone panoramas first, buy the 360 camera in Phase 4? (Recommended.)
4. **Hours per week** — write the number down. It determines whether Phase 5 exists at all.

## 15. Session log

- **2026-09-28/29 (sessions 1–5):** plan + Phase 0 skeleton + Phase 1 core (19 articles × 3 languages, 13-gates series complete) + **full-site build pulled forward on founder decision**: modern theme (light/dark), Leaflet map v1 with 13 gates + filters (approx. positions pending field survey), WhatsApp-order shop pilot (products.json, order-list checkout), Marzipano 360° tour v1 (AI preview scenes, real captures pending photo walk), service worker for offline, all coming-soon pages eliminated. Branch pushed to GitHub.
- **Next:** deploy to hosting (DEPLOY.md), photo walk (gates GPS + tour scenes + article photos), set real WhatsApp line, remaining practical guides.

## 16. This week's checklist (week of Sep 29, 2026)

- [ ] Buy hosting, point soukalahad.com, deploy per DEPLOY.md
- [ ] Set the real WhatsApp order line in `public/assets/data/products.json`
- [ ] **Photo walk #1:** all 13 gates, golden hour — verify GPS pins in `gates.json`, capture 360° scenes, fill article photo slots
- [ ] **Two merchant conversations:** one argan/spice seller, one rug seller — test the WhatsApp-directory idea on them (script in Appendix A)
- [ ] Search Console + Bing verified for `/en`, `/fr`, `/ar`; submit `sitemap.xml`

---

## Appendix A — Field kit

**POI capture form (per shop, 60 seconds on your phone):**
shop name · owner (optional) · category (spice/argan/rug/leather/pottery/clothes/jewellery/electronics/food/other) · gate number 1–13 · alley or landmark · WhatsApp number · 3 signature products · photo(s) · wants an online listing? Y/N · photo consent Y/N

**Merchant interview kit (Phase 5, but test 2 now):**
1. Name, trade, how many years? 2. Who started the shop — you, your father, your grandfather? 3. What did the souk look like when you started? 4. The biggest change you've seen? 5. Your best day ever here? 6. What do tourists ask for most? 7. What do locals buy that tourists never notice? 8. One thing you wish visitors knew? 9. What should this souk look like in 20 years? 10. May we photograph you and your shop?

**Photo checklist (Phase 1 walks):**
13 gates (outside + inside) · one hero shot per zone · hands at work (potter, weaver, spice pyramids) · food section · textures (zellige, wood, spice piles) · wide alleys at golden hour · a few empty-morning shots for map calibration

## Appendix B — Phase 1 article list (32)

**The 13 Gates:** 1 Bab Tombouctou (spices) · 2 Bab Taroudant (produce) · 3 Bab Sijilmassa (pottery/wood/iron) · 4 Bab Tamdoult (carpets/textiles) · 5 Bab Igli (leather) · 6 ready-to-wear & djellabas · 7 Bab Oued Noun (silver/jewellery) · 8 Bab Tanger (electronics) · 9 Bab Imouzzar (argan/soap) · 10 Bab Oujda (butcher) · 11 Bab Tiznit (fish) · 12 kitchenware/tools · 13 Bab Demnat (south entrance)

**Practical:** First time at the souk: a 2-hour plan · Bargaining 101 with real numbers · Argan oil: spotting fakes and the price ladder · Amlou: what it is, what it should cost · Spice glossary (40 spices, photographed) · Rugs: materials, origins, prices · What to eat at the souk · Is the souk safe? an honest answer · Getting there: buses, taxis, parking · Hours & why Monday closes · The souk with kids · Sunday vs Tuesday: crowd science · Ramadan at the souk · What things cost: 2027 price list · Etiquette + greetings in Tachelhit & Arabic · One day in Agadir: souk + city itinerary

**History core:** From Talborjt to Amsernat: why the souk moved · The 1960 earthquake in 5 minutes · How Agadir was rebuilt — and why it looks the way it does

## Appendix C — Market context (research summary, 2026-09-28)

- Souk El Had / Souk Al Ahad: Africa's largest urban market; ~6,000 shops (sources vary 3,000–6,000), 13 gates, 11–13 ha, walls 6–8 m; ~10,000 visitors/day, ~30,000 on Sundays; closed Mondays; renovated 2021 (visitagadir.com, safartomorocco.com, TripAdvisor)
- Agadir tourism 2025: 1,502,590 arrivals (+9.07%), 6.3M overnight stays; top markets: domestic 446k, British 352k, French, German, Polish 70k (born2invest.com)
- Moroccan e-commerce: ~22 bn MAD (2023); COD preferred by 84.1% of online buyers; home delivery on 90% of orders; Jumia ~30% + Avito ~25% marketplace share (meatechwatch.com, Jumia VendorHub, easyappsecom.com)
- Competitors: `soukelhadagadir.com` (active, bilingual Next.js, stock photos, placeholder phone, 1 listed merchant) · `soukelhad.ma` (parked "under construction") · `soukelhad.shop` (dead WordPress critical error, yet still listed as the souk's website on Google)
- Domain history: `soukalahad.com` hosted a Lebanese classifieds site 2007–2021 (Wayback Machine, 81 captures) — zero Agadir SEO equity; the brand must earn its traffic through content
