<?php /** 404 — in scope: $t, $base */ ?>

<section class="coming">
  <p class="badge">404</p>
  <h1><?= htmlspecialchars($t['page.not-found.title']) ?></h1>
  <p class="lead"><?= htmlspecialchars($t['page.not-found.body']) ?></p>
  <p><a class="btn btn-primary" href="<?= $base ?>/"><?= htmlspecialchars($t['breadcrumb.home']) ?></a></p>
</section>
