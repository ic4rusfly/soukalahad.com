<?php /** 360° Tour — in scope: $t, $base, $lang */ ?>

<section class="section-head">
  <h1><?= htmlspecialchars($t['page.tour.title']) ?></h1>
  <p><?= htmlspecialchars($t['page.tour.body']) ?></p>
</section>

<div id="tour" class="tour-viewport"
     data-scene-gate="/assets/tour/scene-gate.jpg"
     data-scene-spices="/assets/tour/scene-spices.jpg"
     data-lang="<?= htmlspecialchars($lang) ?>"
     data-hint="<?= htmlspecialchars($t['tour.hint']) ?>"
     data-fullscreen="<?= htmlspecialchars($t['tour.fullscreen']) ?>">
  <div class="controls">
    <div class="scene-chips" id="scene-chips"></div>
    <span class="tour-hint" id="tour-hint"><?= htmlspecialchars($t['tour.hint']) ?></span>
  </div>
</div>

<p class="tour-caption"><?= htmlspecialchars($t['tour.caption']) ?></p>
