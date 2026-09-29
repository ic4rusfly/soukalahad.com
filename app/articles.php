<?php
declare(strict_types=1);

/**
 * Article engine — Markdown in, cached HTML out. No dependencies.
 * Articles live in data/articles/{lang}/{slug}.md with "key: value" front matter:
 *   title, description, category (visit|history), published (YYYY-MM-DD)
 * Cache: cache/articles/{lang}/{slug}.html — rebuilt whenever the source is newer.
 * Content is authored by us (trusted), but everything is HTML-escaped before
 * the (very small) Markdown subset is applied.
 */

const ARTICLE_CACHE_DIR = 'cache/articles';

// Guard for direct entry points (e.g. sitemap.php) that skip the front controller.
if (!defined('LANGS')) {
    define('LANGS', ['en', 'fr', 'ar']);
}

function articles_dir(): string
{
    return dirname(__DIR__) . '/data/articles';
}

/** Load one article (meta + cached-rendered HTML), or null. */
function article_load(string $lang, string $slug): ?array
{
    $slug = preg_replace('/[^a-z0-9-]/', '', $slug) ?? '';
    if ($slug === '' || !in_array($lang, LANGS, true)) {
        return null;
    }
    $file = articles_dir() . "/{$lang}/{$slug}.md";
    if (!is_file($file)) {
        return null;
    }

    $raw  = (string) file_get_contents($file);
    $meta = [
        'title'       => $slug,
        'description' => '',
        'category'    => 'history',
        'published'   => '',
    ];
    $body = $raw;

    if (str_starts_with($raw, "---\n")) {
        $end = strpos($raw, "\n---\n", 4);
        if ($end !== false) {
            foreach (explode("\n", substr($raw, 4, $end - 4)) as $line) {
                $pos = strpos($line, ':');
                if ($pos === false) {
                    continue;
                }
                $meta[trim(substr($line, 0, $pos))] = trim(substr($line, $pos + 1));
            }
            $body = substr($raw, $end + 5);
        }
    }

    // Render (or reuse) the cached HTML.
    $cacheFile = dirname(__DIR__) . '/' . ARTICLE_CACHE_DIR . "/{$lang}/{$slug}.html";
    if (!is_file($cacheFile) || filemtime($file) > filemtime($cacheFile)) {
        @mkdir(dirname($cacheFile), 0775, true);
        @file_put_contents($cacheFile, markdown_render($body));
    }
    $html = is_file($cacheFile) ? (string) file_get_contents($cacheFile) : markdown_render($body);

    // Language-agnostic word count (str_word_count fails on Arabic).
    preg_match_all('/[\p{L}\p{N}]+/u', strip_tags($body), $m);

    return [
        'slug'        => $slug,
        'lang'        => $lang,
        'title'       => $meta['title'],
        'description' => $meta['description'],
        'category'    => $meta['category'],
        'published'   => $meta['published'],
        'html'        => $html,
        'words'       => count($m[0] ?? []),
        'minutes'     => max(1, (int) round(count($m[0] ?? []) / 200)),
    ];
}

/** List articles for a language, optionally filtered by section, newest first. */
function article_list(string $lang, string $section = ''): array
{
    $out = [];
    $dir = articles_dir() . "/{$lang}";
    if (!is_dir($dir)) {
        return $out;
    }
    foreach (glob($dir . '/*.md') ?: [] as $file) {
        $a = article_load($lang, basename($file, '.md'));
        if ($a === null) {
            continue;
        }
        if ($section !== '' && $a['category'] !== $section) {
            continue;
        }
        $out[] = $a;
    }
    usort($out, static function (array $x, array $y): int {
        // Newest first; natural-order tiebreak so gate-2 sorts before gate-10.
        return strcmp($y['published'], $x['published'])
            ?: strnatcmp($x['slug'], $y['slug']);
    });
    return $out;
}

/** Human date per language (Moroccan Arabic month names for ar). */
function article_date(string $lang, string $iso): string
{
    $months = [
        'en' => ['', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        'fr' => ['', 'janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'],
        'ar' => ['', 'يناير', 'فبراير', 'مارس', 'أبريل', 'ماي', 'يونيو', 'يوليوز', 'غشت', 'شتنبر', 'أكتوبر', 'نونبر', 'دجنبر'],
    ];
    if (!preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $iso, $r)) {
        return $iso;
    }
    $mon = (int) $r[2];
    if ($mon < 1 || $mon > 12) {
        return $iso;
    }
    $m = $months[$lang] ?? $months['en'];
    $day = ltrim($r[3], '0');
    return $lang === 'en'
        ? $m[$mon] . ' ' . $day . ', ' . $r[1]
        : $day . ' ' . $m[$mon] . ' ' . $r[1];
}

/**
 * Minimal Markdown subset (trusted content, escaped first):
 * ## / ### headings · paragraphs · - lists · > quotes · **bold** · *italic* · [links](url)
 */
function markdown_render(string $md): string
{
    $md  = str_replace(["\r\n", "\r"], "\n", trim($md));
    $out = '';
    $para = [];
    $inList = false;
    $inQuote = false;

    $flushPara = function () use (&$para, &$out): void {
        if ($para !== []) {
            $out .= '<p>' . md_inline(implode(' ', $para)) . "</p>\n";
            $para = [];
        }
    };
    $closeList = function () use (&$inList, &$out): void {
        if ($inList) {
            $out .= "</ul>\n";
            $inList = false;
        }
    };
    $closeQuote = function () use (&$inQuote, &$out): void {
        if ($inQuote) {
            $out .= "</p></blockquote>\n";
            $inQuote = false;
        }
    };

    foreach (explode("\n", $md) as $line) {
        $t = trim($line);
        if ($t === '') {
            $flushPara();
            $closeList();
            $closeQuote();
            continue;
        }
        if (preg_match('/^(#{2,3})\s+(.+)$/', $t, $m) === 1) {
            $flushPara();
            $closeList();
            $closeQuote();
            $tag = strlen($m[1]) === 2 ? 'h2' : 'h3';
            $out .= '<' . $tag . '>' . md_inline($m[2]) . '</' . $tag . ">\n";
            continue;
        }
        if (preg_match('/^-\s+(.+)$/', $t, $m) === 1) {
            $flushPara();
            $closeQuote();
            if (!$inList) {
                $out .= "<ul>\n";
                $inList = true;
            }
            $out .= '<li>' . md_inline($m[1]) . "</li>\n";
            continue;
        }
        if (str_starts_with($t, '> ') || $t === '>') {
            $flushPara();
            $closeList();
            if (!$inQuote) {
                $out .= '<blockquote><p>';
                $inQuote = true;
            }
            if ($t !== '>') {
                $out .= md_inline(substr($t, 2)) . ' ';
            }
            continue;
        }
        $closeList();
        $closeQuote();
        $para[] = $t;
    }
    $flushPara();
    $closeList();
    $closeQuote();
    return $out;
}

function md_inline(string $s): string
{
    $s = htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
    $s = preg_replace('/\[([^\]]+)\]\(([^)\s]+)\)/', '<a href="$2">$1</a>', $s) ?? $s;
    $s = preg_replace('/\*\*([^*]+)\*\*/', '<strong>$1</strong>', $s) ?? $s;
    $s = preg_replace('/\*([^*]+)\*/', '<em>$1</em>', $s) ?? $s;
    return $s;
}
