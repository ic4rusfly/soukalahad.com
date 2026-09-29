// SoukAlAhad — 360° tour (Marzipano, equirectangular scenes).
// Data attributes on #tour: data-scene-*, data-lang, data-hint, data-fullscreen.

const SCENE_NAMES = {
  en: { gate: 'The great gate', spices: 'Spice alley' },
  fr: { gate: 'La grande porte', spices: 'La ruelle des épices' },
  ar: { gate: 'الباب العظيم', spices: 'زقاق التوابل' },
};

const el = document.getElementById('tour');
if (el && window.Marzipano) init();

function init() {
  const lang = el.dataset.lang || 'en';
  const names = SCENE_NAMES[lang] || SCENE_NAMES.en;
  const chipsWrap = document.getElementById('scene-chips');
  const hint = document.getElementById('tour-hint');

  const scenes = [
    { id: 'gate',   url: el.dataset.sceneGate },
    { id: 'spices', url: el.dataset.sceneSpices },
  ];

  const viewer = new Marzipano.Viewer(el, { controls: { mouseViewMode: 'drag' } });
  const built = {};

  function build(scene, cb) {
    const img = new Image();
    img.onload = () => {
      const source = Marzipano.ImageUrlSource.fromString(scene.url);
      const geometry = new Marzipano.EquirectGeometry([{ width: img.naturalWidth }]);
      const limiter = Marzipano.util.compose(
        Marzipano.RectilinearView.limit.vfov(0.6, Math.PI - 0.6),
        Marzipano.RectilinearView.limit.hfov(0.8, 2.6)
      );
      const view = new Marzipano.RectilinearView({ yaw: 0, pitch: 0, fov: 1.4 }, limiter);
      const s = viewer.createScene({ source, geometry, view, pincherId: viewer.controls() });
      built[scene.id] = s;
      cb(s);
    };
    img.src = scene.url;
  }

  function switchTo(id) {
    if (!built[id]) return;
    built[id].switchTo({ transitionDuration: 900 });
    hint.style.display = 'none';
    Array.from(chipsWrap.children).forEach((c) => c.setAttribute('aria-pressed', c.dataset.scene === id ? 'true' : 'false'));
  }

  scenes.forEach((scene, i) => {
    const chip = document.createElement('button');
    chip.className = 'chip';
    chip.dataset.scene = scene.id;
    chip.textContent = names[scene.id] || scene.id;
    chip.setAttribute('aria-pressed', i === 0 ? 'true' : 'false');
    chip.addEventListener('click', () => switchTo(scene.id));
    chipsWrap.appendChild(chip);

    build(scene, (s) => {
      if (i === 0) s.switchTo({ transitionDuration: 0 });
    });
  });

  // Fullscreen
  const fs = document.createElement('button');
  fs.className = 'chip';
  fs.textContent = el.dataset.fullscreen || 'Fullscreen';
  fs.addEventListener('click', () => {
    if (document.fullscreenElement) document.exitFullscreen();
    else el.requestFullscreen().catch(() => {});
  });
  chipsWrap.appendChild(fs);
}
