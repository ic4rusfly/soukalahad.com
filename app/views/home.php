<?php /** Home — in scope: $t, $base, $lang */ ?>
<?php
$explore = [
    ['visit',   'visit',   'M12 21s-7-4.6-9.3-9A5.4 5.4 0 0 1 12 6.3 5.4 5.4 0 0 1 21.3 12C19 16.4 12 21 12 21Z'],
    ['history', 'history', 'M12 8v5l3.5 2M21 12a9 9 0 1 1-9-9 9 9 0 0 1 9 9Z'],
    ['map',     'map',     'M9 4 3 6v14l6-2 6 2 6-2V4l-6 2-6-2Zm0 0v14m6-12v14'],
    ['shop',    'shop',    'M4 8h16l-1.5 12h-13L4 8Zm4 0a4 4 0 0 1 8 0'],
    ['tour',    'tour',    'M2 12s3.5-6.5 10-6.5S22 12 22 12s-3.5 6.5-10 6.5S2 12 2 12Zm10 3a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z'],
];
?>
<section class="hero">
  <svg class="arches" viewBox="0 0 400 300" fill="none" aria-hidden="true" preserveAspectRatio="xMaxYMid slice">
    <?php for ($i = 0; $i < 5; $i++): $x = 40 + $i * 78; ?>
    <path d="M<?= $x ?> 300V130c0-26 18-44 39-44s39 18 39 44v170" stroke="currentColor" stroke-width="7" opacity="<?= 0.55 - $i * 0.07 ?>"/>
    <?php endfor; ?>
  </svg>
  <p class="eyebrow"><?= htmlspecialchars($t['hero.eyebrow']) ?></p>
  <h1><?= htmlspecialchars($t['hero.title']) ?></h1>
  <p class="lead"><?= htmlspecialchars($t['hero.lead']) ?></p>
  <p class="hero-actions">
    <a class="btn btn-primary" href="<?= $base ?>/map"><?= htmlspecialchars($t['hero.cta.map']) ?></a>
    <a class="btn btn-ghost" href="<?= $base ?>/tour"><?= htmlspecialchars($t['hero.cta.tour']) ?></a>
  </p>
</section>

<ul class="stats">
  <?php foreach ($t['stats'] as $s): ?>
  <li class="stat"><b><?= htmlspecialchars($s['v']) ?></b><span><?= htmlspecialchars($s['l']) ?></span></li>
  <?php endforeach; ?>
</ul>

<section class="section">
  <div class="section-head"><h2><?= htmlspecialchars($t['explore.title']) ?></h2></div>
  <div class="cards">
    <?php foreach ($explore as [$key, $page, $path]): ?>
    <div class="card">
      <span class="icon-chip" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none"><path d="<?= $path ?>" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
      <h3><a href="<?= $base ?>/<?= $page ?>"><?= htmlspecialchars($t['nav'][$key]) ?></a></h3>
      <p><?= htmlspecialchars($t["explore.{$key}"]) ?></p>
      <a class="feature-link" href="<?= $base ?>/<?= $page ?>">→</a>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<?php
$latest = array_slice(article_list($lang), 0, 3);
if ($latest !== []):
?>
<section class="section">
  <div class="section-head"><h2><?= htmlspecialchars($t['home.latest.title']) ?></h2></div>
  <ol class="cards">
    <?php foreach ($latest as $a): ?>
      <li class="card">
        <span class="badge<?= $a['category'] === 'history' ? '' : ' is-warm' ?>"><?= htmlspecialchars($a['category'] === 'history' ? $t['nav.history'] : $t['nav.visit']) ?></span>
        <h3><a href="<?= $base ?>/<?= $a['category'] ?>/<?= $a['slug'] ?>"><?= htmlspecialchars($a['title']) ?></a></h3>
        <p><?= htmlspecialchars($a['description']) ?></p>
      </li>
    <?php endforeach; ?>
  </ol>
</section>
<?php endif; ?>
