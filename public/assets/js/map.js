// SoukAlAhad — interactive map (Leaflet + gates.json).
// Data attributes on #map: data-gates, data-lang, data-read, data-article-base.

const el = document.getElementById('map');
if (el && window.L) init();

function init() {
  const lang = el.dataset.lang || 'en';
  const readLabel = el.dataset.read || 'Read';
  const articleBase = el.dataset.articleBase || '/en/visit/';

  fetch(el.dataset.gates)
    .then((r) => r.json())
    .then((data) => render(data.gates))
    .catch(() => { el.textContent = 'Map data unavailable.'; });

  function render(gates) {
    const map = L.map(el, { zoomControl: true, scrollWheelZoom: true }).setView([30.4126, -9.5802], 17);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 20,
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    }).addTo(map);

    const markers = gates.map((g) => {
      const pin = L.divIcon({
        className: '',
        html: `<div class="gate-pin${g.n === 13 ? ' is-main' : ''}"><span>${g.n}</span></div>`,
        iconSize: [30, 30],
        iconAnchor: [15, 30],
        popupAnchor: [0, -30],
      });
      const specialty = (g.specialty && g.specialty[lang]) || g.specialty.en;
      const name = (g.name && g.name[lang]) || g.name.en;
      const m = L.marker([g.lat, g.lng], { icon: pin }).addTo(map);
      m.bindPopup(
        `<div class="gate-popup"><h4>${g.n} · ${name}</h4><p>${specialty}</p>` +
        `<a href="${articleBase}${g.article}">${readLabel} →</a></div>`
      );
      m._gate = g;
      return m;
    });

    // --- Filters ---
    let activeCat = 'all';
    let query = '';
    const search = document.getElementById('map-search');
    const chips = Array.from(document.querySelectorAll('#map-filters .chip'));

    function apply() {
      const q = query.trim().toLowerCase();
      markers.forEach((m) => {
        const g = m._gate;
        const catOk = activeCat === 'all' || g.cat === activeCat || g.n === 13;
        const hay = [g.name.en, g.name.fr, g.name.ar, g.specialty.en, g.specialty.fr, g.specialty.ar, 'gate ' + g.n]
          .join(' ').toLowerCase();
        m.getElement().style.display = (catOk && (q === '' || hay.includes(q))) ? '' : 'none';
      });
    }

    chips.forEach((chip) => chip.addEventListener('click', () => {
      chips.forEach((c) => c.setAttribute('aria-pressed', 'false'));
      chip.setAttribute('aria-pressed', 'true');
      activeCat = chip.dataset.cat;
      apply();
    }));

    if (search) search.addEventListener('input', () => { query = search.value; apply(); });
  }
}
