<?php
declare(strict_types=1);

/**
 * XML sitemap with hreflang alternates. Served at /sitemap.xml
 * (routed through the front controller; see index.php and .htaccess).
 */

$host     = 'https://soukalahad.com'; // production host
$langs    = defined('LANGS') ? LANGS : ['en', 'fr', 'ar'];
require_once __DIR__ . '/articles.php';
$sections = ['visit', 'history'];
$coming   = ['map', 'shop', 'tour'];

// Collect routes: home, article sections (+ every article slug in any language), coming pages.
$routes = [''];
foreach ($sections as $s) {
    $routes[] = $s;
    foreach ($langs as $l) {
        foreach (article_list($l, $s) as $a) {
            $r = $s . '/' . $a['slug'];
            if (!in_array($r, $routes, true)) {
                $routes[] = $r;
            }
        }
    }
}
foreach ($coming as $c) {
    $routes[] = $c;
}

header('Content-Type: application/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
<?php foreach ($routes as $route): ?>
<url>
  <loc><?= htmlspecialchars($host . '/' . $langs[0] . ($route === '' ? '/' : '/' . $route), ENT_XML1) ?></loc>
<?php foreach ($langs as $l): ?>
  <xhtml:link rel="alternate" hreflang="<?= htmlspecialchars($l, ENT_XML1) ?>" href="<?= htmlspecialchars($host . '/' . $l . ($route === '' ? '/' : '/' . $route), ENT_XML1) ?>"/>
<?php endforeach; ?>
</url>
<?php endforeach; ?>
</urlset>
