// SoukAlAhad — base front-end module (all pages except map/shop/tour).

document.documentElement.classList.add('js');

// Remember the visitor's chosen language.
try {
  localStorage.setItem('soukalahad.lang', document.documentElement.lang);
} catch (_) { /* private mode */ }

// Offline support: cache-first for assets, network-first for pages.
// Registered only where it can work (https, or localhost for dev).
if ('serviceWorker' in navigator) {
  window.addEventListener('load', () => {
    navigator.serviceWorker.register('/sw.js').catch(() => { /* dev preview / unsupported */ });
  });
}
