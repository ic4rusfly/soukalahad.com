<?php
/** Article — in scope: $t, $base, $lang, $section, $article */
$min     = str_replace('{n}', (string) $article['minutes'], $t['article.min']);
$dateTxt = article_date($lang, $article['published']);

$jsonLd = json_encode([
    '@context'          => 'https://schema.org',
    '@type'             => 'Article',
    'headline'          => $article['title'],
    'description'       => $article['description'],
    'inLanguage'        => $lang,
    'datePublished'     => $article['published'],
    'author'            => ['@type' => 'Organization', 'name' => 'SoukAlAhad'],
    'publisher'         => ['@type' => 'Organization', 'name' => 'SoukAlAhad'],
    'mainEntityOfPage'  => $base . '/' . $section . '/' . $article['slug'],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
<nav class="breadcrumb" aria-label="Breadcrumb">
  <a href="<?= $base ?>/"><?= htmlspecialchars($t['breadcrumb.home']) ?></a>
  <span aria-hidden="true">›</span>
  <a href="<?= $base ?>/<?= $section ?>"><?= htmlspecialchars($t['nav'][$section]) ?></a>
  <span aria-hidden="true">›</span>
  <span aria-current="page"><?= htmlspecialchars($article['title']) ?></span>
</nav>

<article class="article">
  <header class="article-head">
    <h1><?= htmlspecialchars($article['title']) ?></h1>
    <p class="article-meta"><?= htmlspecialchars($dateTxt) ?> · <?= htmlspecialchars($min) ?></p>
  </header>
  <div class="prose"><?= $article['html'] ?></div>
</article>

<script type="application/ld+json"><?= $jsonLd ?></script>
