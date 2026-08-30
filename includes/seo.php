<?php
declare(strict_types=1);

/**
 * Renders <title> + meta description. Expects $pageTitle / $pageDescription
 * to already be set by the calling page before header.php is required.
 */
function render_seo(string $pageTitle, string $pageDescription): void
{
    $fullTitle = $pageTitle === SITE_NAME ? SITE_NAME : $pageTitle . ' — ' . SITE_NAME;
    echo '<title>' . h($fullTitle) . "</title>\n";
    echo '<meta name="description" content="' . h($pageDescription) . "\">\n";
    echo '<meta property="og:title" content="' . h($fullTitle) . "\">\n";
    echo '<meta property="og:description" content="' . h($pageDescription) . "\">\n";
    echo '<meta property="og:type" content="website">' . "\n";
}
