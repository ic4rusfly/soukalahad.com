<?php
declare(strict_types=1);

/**
 * SoukAlAhad — front controller.
 * All six sections are live: manual (visit/history articles), map, shop, tour.
 */

const DEFAULT_LANG = 'en';
const LANGS        = ['en', 'fr', 'ar']; // Wave 1. Wave 2 (Phase 5): es, de, it, pl. Honorific: Tachelhit.
const RTL_LANGS    = ['ar'];

$uri      = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$segments = array_values(array_filter(
    explode('/', trim($uri, '/')),
    static fn (string $s): bool => $s !== '' && $s !== 'index.php'
));

// /sitemap.xml — outside the language prefixes.
if (($segments[0] ?? '') === 'sitemap.xml') {
    require dirname(__DIR__) . '/app/sitemap.php';
    exit;
}

require_once dirname(__DIR__) . '/app/articles.php';

// 1) Language: explicit /{lang}/... prefix wins; otherwise negotiate and redirect.
$lang     = DEFAULT_LANG;
$explicit = false;
if ($segments !== [] && in_array($segments[0], LANGS, true)) {
    $lang = array_shift($segments);
    $explicit = true;
}
if (!$explicit) {
    $accept = strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '');
    foreach (['ar', 'fr'] as $candidate) {
        if (str_contains($accept, $candidate)) {
            $lang = $candidate;
            break;
        }
    }
    $suffix = $segments === [] ? '' : implode('/', $segments);
    header('Location: /' . $lang . ($suffix === '' ? '/' : '/' . $suffix), true, 302);
    exit;
}

// 2) Routing.
$SECTIONS = ['visit', 'history'];           // article-backed sections of the manual
$PAGES    = ['map' => 'map', 'shop' => 'shop', 'tour' => 'tour']; // standalone pages
$section  = null;
$article  = null;
$articles = [];

if ($segments === []) {
    $page = 'home';
    $view = 'home';
} elseif (in_array($segments[0], $SECTIONS, true)) {
    $page    = $segments[0];
    $section = $segments[0];
    if (isset($segments[1]) && !isset($segments[2])) {
        $article = article_load($lang, $segments[1]);
        if ($article === null) {
            $page = 'not-found';
            $view = 'not-found';
            $section = null;
            http_response_code(404);
        } else {
            $view = 'article';
        }
    } elseif (!isset($segments[1])) {
        $view     = 'section';
        $articles = article_list($lang, $section);
    } else {
        $page = 'not-found';
        $view = 'not-found';
        $section = null;
        http_response_code(404);
    }
} elseif (isset($PAGES[$segments[0]]) && !isset($segments[1])) {
    $page = $segments[0];
    $view = $PAGES[$page];
} else {
    $page = 'not-found';
    $view = 'not-found';
    http_response_code(404);
}

// Relative path inside the language prefix — canonicals, hreflang, language switcher.
$pathRel = ($view === 'article' && $section !== null)
    ? $section . '/' . $article['slug']
    : ($page === 'home' ? '' : $page);

// 3) Translations, direction, page metadata, render.
$t = require dirname(__DIR__) . "/app/lang/{$lang}.php";

if ($view === 'article') {
    $pageTitle = $article['title'] . ' · ' . $t['site.title'];
    $pageDesc  = $article['description'];
} elseif ($page === 'home') {
    $pageTitle = $t['site.title'];
    $pageDesc  = $t['site.description'];
} else {
    $pageTitle = ($t["page.{$page}.title"] ?? $page) . ' · ' . $t['site.title'];
    $pageDesc  = $t['site.description'];
}

$dir  = in_array($lang, RTL_LANGS, true) ? 'rtl' : 'ltr';
$base = '/' . $lang;

require dirname(__DIR__) . '/app/views/layout.php';
