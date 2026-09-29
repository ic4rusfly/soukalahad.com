<?php /** Section index — in scope: $t, $base, $lang, $section, $articles */ ?>

<section class="section-head">
  <h1><?= htmlspecialchars($t["page.{$section}.title"]) ?></h1>
  <p class="lead"><?= htmlspecialchars($t["page.{$section}.body"]) ?></p>
</section>

<?php if ($articles === []): ?>
  <p class="section-empty"><?= htmlspecialchars($t['section.empty']) ?></p>
<?php else: ?>
  <ol class="cards articles">
    <?php foreach ($articles as $a): ?>
      <li class="card">
        <span class="badge"><?= htmlspecialchars(str_replace('{n}', (string) $a['minutes'], $t['article.min'])) ?></span>
        <h3><a href="<?= $base ?>/<?= $section ?>/<?= $a['slug'] ?>"><?= htmlspecialchars($a['title']) ?></a></h3>
        <p><?= htmlspecialchars($a['description']) ?></p>
      </li>
    <?php endforeach; ?>
  </ol>
<?php endif; ?>
