<?php
declare(strict_types=1);
require_once __DIR__ . '/functions.php';

// Expects $slug to be set by the including router file (public/services/<slug>.php).
$service = isset($slug) ? get_service_by_slug($slug) : null;

if (!$service) {
    http_response_code(404);
    $pageTitle = 'Service Not Found';
    $pageDescription = 'This service page could not be found.';
    require __DIR__ . '/header.php';
    echo '<section class="section" style="padding-top:160px;"><div class="wrap"><h1>Service not found</h1><p><a href="' . h(BASE_URL) . 'services.php">Back to all services</a></p></div></section>';
    require __DIR__ . '/footer.php';
    return;
}

$next = get_next_service($service['slug']);

$pageTitle       = $service['title'];
$pageDescription = $service['summary'];
$activeNav       = 'services';
require __DIR__ . '/header.php';
?>

<section class="page-hero">
  <div class="wrap">
    <div class="eyebrow-row reveal"><span class="marker"></span><p class="eyebrow">Services</p></div>
    <h1 class="reveal" style="max-width:20ch;"><?= h($service['title']) ?></h1>
  </div>
</section>

<section class="section" style="padding-top:0;">
  <div class="wrap two-col">
    <div class="reveal">
      <?php render_paragraphs($service['detail_body'] ?: $service['body']); ?>
      <a href="<?= h(WHATSAPP_URL) ?>" target="_blank" rel="noopener" class="btn-icon-label btn--magnetic" style="margin-top:10px;">
        <span class="btn-icon-label__box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span>
        <span>Book your free counseling session</span>
      </a>
    </div>
    <div class="reveal">
      <img src="<?= asset('images/' . $service['detail_image']) ?>" alt="<?= h($service['title']) ?>">
    </div>
  </div>
</section>

<?php if ($next): ?>
<section class="section" style="padding-top:0;">
  <div class="wrap">
    <a href="<?= h(BASE_URL) ?>services/<?= h($next['slug']) ?>.php" class="btn-icon-label reveal">
      <span class="btn-icon-label__box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span>
      <span>Related: <?= h($next['title']) ?></span>
    </a>
  </div>
</section>
<?php endif; ?>

<?php
$ctaTagline = 'Ready when you are';
$ctaHeadingDark = 'Planning to study';
$ctaHeadingLight = 'abroad?';
$ctaSubtext = "If you've already decided on your study destination, ignore your hesitations and reach out to us.";
$ctaButtonText = "Let's get started";
$ctaSecondaryText = 'All Services';
$ctaSecondaryHref = BASE_URL . 'services.php';
require __DIR__ . '/cta-band.php';

require __DIR__ . '/footer.php';
?>
