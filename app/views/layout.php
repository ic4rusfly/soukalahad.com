<?php
/**
 * Layout — in scope:
 *   $pageTitle, $pageDesc, $pathRel, $page, $view, $lang, $dir, $base, $t
 * Per-page asset bundles are computed from $page below.
 */
$navOrder  = ['home', 'visit', 'history', 'map', 'shop', 'tour'];
$glyph = '<svg class="glyph" viewBox="0 0 32 32" fill="none" aria-hidden="true"><path d="M4 30V14C4 8 9 3 16 3s12 5 12 11v16h-7V15c0-3-2-5-5-5s-5 2-5 5v15H4Z" fill="currentColor" opacity=".18"/><path d="M4 30V14C4 8 9 3 16 3s12 5 12 11v16M4 30h7V15c0-3 2-5 5-5s5 2 5 5v15h7M4 30h24" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/></svg>';

// Per-page asset bundles.
$extraHead = '';
$extraFoot = '';
if ($page === 'map') {
    $extraHead = '<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">';
    $extraFoot = '<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" defer></script>';
} elseif ($page === 'tour') {
    $extraFoot = '<script src="https://cdn.marzipano.net/media/latest/marzipano.js" defer></script>';
}
$pageModule = match ($page) {
    'map'  => '/assets/js/map.js',
    'shop' => '/assets/js/shop.js',
    'tour' => '/assets/js/tour.js',
    default => '/assets/js/app.js',
};
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang) ?>" dir="<?= $dir ?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= htmlspecialchars($pageTitle) ?></title>
<meta name="description" content="<?= htmlspecialchars($pageDesc) ?>">
<meta name="theme-color" content="#c4552d">
<link rel="canonical" href="<?= htmlspecialchars($base . '/' . $pathRel) ?>">
<?php foreach (LANGS as $alt): ?>
<link rel="alternate" hreflang="<?= $alt ?>" href="/<?= $alt ?>/<?= $pathRel ?>">
<?php endforeach; ?>
<link rel="icon" href="data:,">
<link rel="stylesheet" href="/assets/css/main.css">
<?= $extraHead ?>
</head>
<body class="page-<?= htmlspecialchars($page) ?>">
<a class="skip-link" href="#main">↓</a>
<div class="gate-strip" aria-hidden="true"></div>

<header class="site-header">
  <a class="brand" href="<?= $base ?>/"><?= $glyph ?> <span>سوق الأحد · <b>SoukAlAhad</b></span></a>
  <nav class="site-nav" aria-label="Main">
    <?php foreach ($navOrder as $key): ?>
      <a href="<?= $base ?>/<?= $key === 'home' ? '' : $key ?>"<?= $key === $page ? ' aria-current="page"' : '' ?>><?= htmlspecialchars($t['nav'][$key]) ?></a>
    <?php endforeach; ?>
  </nav>
  <div class="langs" aria-label="Languages">
    <?php foreach (LANGS as $alt): ?>
      <a href="/<?= $alt ?>/<?= $pathRel ?>"<?= $alt === $lang ? ' aria-current="true"' : '' ?>><?= strtoupper($alt) ?></a>
    <?php endforeach; ?>
  </div>
</header>

<main id="main">
<?php require __DIR__ . '/' . $view . '.php'; ?>
</main>

<footer class="site-footer">
  <div class="footer-grid">
    <div>
      <h4><?= htmlspecialchars($t['footer.explore']) ?></h4>
      <ul>
        <?php foreach (['visit', 'history', 'map', 'shop', 'tour'] as $key): ?>
        <li><a href="<?= $base ?>/<?= $key ?>"><?= htmlspecialchars($t['nav'][$key]) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div>
      <h4><?= htmlspecialchars($t['footer.project']) ?></h4>
      <ul>
        <li><a href="https://github.com/ic4rusfly/soukalahad.com" target="_blank" rel="noopener">GitHub</a></li>
        <li><a href="https://github.com/ic4rusfly/soukalahad.com/blob/main/PLAN.md" target="_blank" rel="noopener"><?= htmlspecialchars($t['footer.roadmap']) ?></a></li>
      </ul>
    </div>
    <div>
      <h4><?= htmlspecialchars($t['footer.languages']) ?></h4>
      <ul>
        <?php foreach (LANGS as $alt): ?>
        <li><a href="/<?= $alt ?>/<?= $pathRel ?>" hreflang="<?= $alt ?>"><?= strtoupper($alt) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
  <p class="footer-tag"><?= htmlspecialchars(str_replace(':year', (string) date('Y'), $t['footer.license'])) ?> · <?= htmlspecialchars($t['footer.tagline']) ?></p>
</footer>

<?= $extraFoot ?>
<script type="module" src="<?= $pageModule ?>"></script>
</body>
</html>
