// SoukAlAhad — shop (products.json + WhatsApp order list).
// Data attributes on #products: data-products, data-lang, data-currency, data-add.

const I18N = {
  en: { order: 'Hello SoukAlAhad! I would like to order:', name: 'Name:', city: 'City:', items: 'items', total: 'Total', empty: 'Your list is empty — add products, then order everything in one WhatsApp message.' },
  fr: { order: 'Bonjour SoukAlAhad ! Je souhaite commander :', name: 'Nom :', city: 'Ville :', items: 'articles', total: 'Total', empty: 'Votre liste est vide — ajoutez des produits, puis commandez le tout en un seul message WhatsApp.' },
  ar: { order: 'مرحبًا سوق الأحد! أود أن أطلب:', name: 'الاسم:', city: 'المدينة:', items: 'منتجات', total: 'المجموع', empty: 'قائمتك فارغة — أضف منتجات ثم اطلبها كلها برسالة واتساب واحدة.' },
};

const THUMBS = {
  beauty:  ['#7c4a21', '#c4552d'],
  food:    ['#8a5a19', '#e8a33d'],
  crafts:  ['#274e4b', '#1f5f5b'],
  fashion: ['#5a3418', '#9c3f1e'],
};

const el = document.getElementById('products');
if (el) init();

function init() {
  const lang = el.dataset.lang || 'en';
  const currency = el.dataset.currency || 'MAD';
  const addLabel = el.dataset.add || 'Add';
  const dict = I18N[lang] || I18N.en;
  const basketEl = document.getElementById('basket');
  const infoEl = document.getElementById('basket-info');
  let products = [];
  let basket = {};

  try { basket = JSON.parse(localStorage.getItem('soukalahad.basket') || '{}'); } catch (_) { basket = {}; }

  fetch(el.dataset.products)
    .then((r) => r.json())
    .then((data) => {
      products = data.products;
      el.dataset.whatsapp = data.whatsapp;
      renderProducts();
      renderBasket();
    })
    .catch(() => { el.textContent = dict.empty; });

  function renderProducts() {
    el.innerHTML = '';
    for (const p of products) {
      const li = document.createElement('li');
      li.className = 'card product';
      const grad = (THUMBS[p.cat] || THUMBS.crafts).join(', ');
      li.innerHTML =
        `<div class="thumb" style="background:linear-gradient(135deg,${grad})">${(p.name[lang] || p.name.en).trim().charAt(0)}</div>` +
        `<h3>${p.name[lang] || p.name.en}</h3>` +
        `<p>${p.desc[lang] || p.desc.en}</p>` +
        `<div class="price">${p.price} <small>${currency}</small></div>` +
        `<div class="unit">${p.unit[lang] || p.unit.en}</div>`;
      const btn = document.createElement('button');
      btn.className = 'add';
      btn.textContent = addLabel;
      btn.addEventListener('click', () => {
        basket[p.id] = (basket[p.id] || 0) + 1;
        save();
        renderBasket();
      });
      li.appendChild(btn);
      el.appendChild(li);
    }
  }

  function save() {
    try { localStorage.setItem('soukalahad.basket', JSON.stringify(basket)); } catch (_) {}
  }

  function lines() {
    const out = [];
    let count = 0, total = 0;
    for (const p of products) {
      const q = basket[p.id] || 0;
      if (q > 0) {
        out.push(`• ${q} × ${p.name[lang] || p.name.en} — ${q * p.price} ${currency}`);
        count += q;
        total += q * p.price;
      }
    }
    return { out, count, total };
  }

  function renderBasket() {
    const { out, count, total } = lines();
    if (count === 0) {
      basketEl.classList.remove('is-visible');
      infoEl.textContent = dict.empty;
      return;
    }
    basketEl.classList.add('is-visible');
    infoEl.innerHTML = `<b>${count}</b> ${dict.items} · ${dict.total}: <b>${total} ${currency}</b>`;
    window._soukOrder = out;
  }

  document.getElementById('basket-clear').addEventListener('click', () => {
    basket = {};
    save();
    renderBasket();
  });

  document.getElementById('basket-send').addEventListener('click', () => {
    const { out, total } = lines();
    if (out.length === 0) return;
    const msg = `${dict.order}\n${out.join('\n')}\n\n${dict.total}: ${total} ${currency}\n${dict.name} \n${dict.city} `;
    const num = el.dataset.whatsapp || '';
    window.open(`https://wa.me/${num}?text=${encodeURIComponent(msg)}`, '_blank', 'noopener');
  });
}
