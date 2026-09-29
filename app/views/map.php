<?php /** Map — in scope: $t, $base, $lang, $dir */ ?>

<section class="section-head">
  <h1><?= htmlspecialchars($t['page.map.title']) ?></h1>
  <p><?= htmlspecialchars($t['page.map.body']) ?></p>
</section>

<div class="map-toolbar">
  <input class="map-search" type="search" id="map-search"
         placeholder="<?= htmlspecialchars($t['map.search']) ?>"
         aria-label="<?= htmlspecialchars($t['map.search']) ?>">
  <div class="chips" id="map-filters" role="group" aria-label="Filters">
    <button class="chip" data-cat="all" aria-pressed="true"><?= htmlspecialchars($t['map.filter.all']) ?></button>
    <?php foreach ($t['map.cats'] as $cat => $label): ?>
    <button class="chip" data-cat="<?= htmlspecialchars($cat) ?>" aria-pressed="false"><?= htmlspecialchars($label) ?></button>
    <?php endforeach; ?>
  </div>
</div>

<div id="map" class="map-viewport"
     data-gates="/assets/data/gates.json"
     data-lang="<?= htmlspecialchars($lang) ?>"
     data-read="<?= htmlspecialchars($t['map.read']) ?>"
     data-article-base="<?= $base ?>/visit/"></div>

<p class="map-note"><?= htmlspecialchars($t['map.note']) ?></p>
