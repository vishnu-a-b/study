<?php
declare(strict_types=1);
$ctaTagline      = $ctaTagline      ?? 'Ready when you are';
$ctaHeadingDark  = $ctaHeadingDark  ?? 'Ready to';
$ctaHeadingLight = $ctaHeadingLight ?? 'get started?';
$ctaSubtext      = $ctaSubtext      ?? "If you've already decided on your study destination, ignore your hesitations and reach out to us.";
$ctaButtonText   = $ctaButtonText   ?? "Let's get started";
$ctaButtonHref   = $ctaButtonHref   ?? WHATSAPP_URL;
$ctaSecondaryText = $ctaSecondaryText ?? null;
$ctaSecondaryHref = $ctaSecondaryHref ?? null;
?>
<section class="cta-band reveal">
  <div class="cta-band__inner">
    <div>
      <div class="eyebrow-row"><span class="marker"></span><p class="eyebrow"><?= h($ctaTagline) ?></p></div>
      <h2><?= h($ctaHeadingDark) ?><br><span class="text-muted"><?= h($ctaHeadingLight) ?></span></h2>
    </div>
    <div>
      <p class="cta-band__subtext"><?= h($ctaSubtext) ?></p>
      <div class="cta-band__actions">
        <a href="<?= h($ctaButtonHref) ?>" target="_blank" rel="noopener" class="btn-icon-label btn--magnetic">
          <span class="btn-icon-label__box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span>
          <span><?= h($ctaButtonText) ?></span>
        </a>
        <?php if ($ctaSecondaryText): ?>
          <span class="cta-band__divider"></span>
          <a href="<?= h($ctaSecondaryHref) ?>" class="btn-icon-label">
            <span class="btn-icon-label__box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span>
            <span><?= h($ctaSecondaryText) ?></span>
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
<?php $ctaTagline = $ctaHeadingDark = $ctaHeadingLight = $ctaSubtext = $ctaButtonText = $ctaButtonHref = $ctaSecondaryText = $ctaSecondaryHref = null; ?>
