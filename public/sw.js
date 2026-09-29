// SoukAlAhad service worker — offline support for the manual, map, shop and tour.
// Strategy: precache the shell, then stale-while-revalidate for same-origin GETs.

const CACHE = 'soukalahad-v2';

self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE).then((cache) => cache.addAll([
      '/assets/css/main.css',
      '/assets/js/app.js',
      '/assets/js/map.js',
      '/assets/js/shop.js',
      '/assets/js/tour.js',
      '/assets/data/gates.json',
      '/assets/data/products.json',
    ]).catch(() => {}))
  );
  self.skipWaiting();
});

self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((keys) =>
      Promise.all(keys.filter((k) => k !== CACHE).map((k) => caches.delete(k)))
    ).then(() => self.clients.claim())
  );
});

self.addEventListener('fetch', (event) => {
  const req = event.request;
  if (req.method !== 'GET') return;

  const url = new URL(req.url);
  if (url.origin !== location.origin) return;          // let CDNs (Leaflet, tiles) hit the network
  if (url.pathname === '/sitemap.xml') return;         // always fresh

  event.respondWith(
    caches.open(CACHE).then(async (cache) => {
      const cached = await cache.match(req);
      const network = fetch(req).then((res) => {
        if (res && res.ok) cache.put(req, res.clone());
        return res;
      }).catch(() => cached);
      return cached || network;
    })
  );
});
