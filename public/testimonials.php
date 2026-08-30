<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/functions.php';

$pageTitle       = 'Testimonials';
$pageDescription = 'Real reviews from Studwise International students placed in universities across the UK and beyond.';
$activeNav       = 'testimonials';
require __DIR__ . '/../includes/header.php';

$testimonials = get_testimonials();
$team = array_filter(get_team_members(), fn ($m) => $m['category'] !== 'founder');
?>

<section class="page-hero">
  <div class="wrap section-head section-head--center">
    <div class="eyebrow-row reveal" style="justify-content:center;"><span class="marker"></span><p class="eyebrow">Check out what clients say</p></div>
    <h1 class="reveal">Testimonials</h1>
    <p class="reveal">Collecting the trust and commitment of our happy students.</p>
  </div>
</section>

<section class="section" style="padding-top:0;">
  <div class="wrap">
    <div class="cards-grid reveal-stagger">
      <?php foreach ($testimonials as $t): ?>
        <div class="testimonial-card">
          <p class="testimonial-card__quote"><?= h($t['quote']) ?></p>
          <div class="testimonial-card__meta">
            <p class="testimonial-card__name"><?= h($t['student_name']) ?></p>
            <p class="testimonial-card__course"><?= h($t['course']) ?> &middot; <?= h($t['university']) ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section--navy">
  <div class="wrap">
    <div class="section-head section-head--center">
      <div class="eyebrow-row" style="justify-content:center;"><span class="marker"></span><p class="eyebrow">Meet Our Most Trusted</p></div>
      <h2>Branch Heads &amp; Team</h2>
    </div>
    <div class="cards-grid reveal-stagger" style="grid-template-columns: repeat(4, 1fr);">
      <?php foreach ($team as $member): ?>
        <div class="team-card">
          <div class="team-card__photo">
            <?php if (!empty($member['photo_path']) && file_exists(__DIR__ . '/assets/images/' . $member['photo_path'])): ?>
              <img src="<?= asset('images/' . $member['photo_path']) ?>" alt="<?= h($member['name']) ?>">
            <?php else: ?>
              <span class="team-card__initials"><?= h(initials($member['name'])) ?></span>
            <?php endif; ?>
          </div>
          <p class="team-card__name"><?= h($member['name']) ?></p>
          <p class="team-card__role"><?= h($member['role']) ?><?= $member['branch_name'] ? ', ' . h($member['branch_name']) : '' ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php
$ctaTagline = 'Ready when you are';
$ctaHeadingDark = 'Planning to study';
$ctaHeadingLight = 'abroad?';
$ctaSubtext = "If you've already decided on your study destination, ignore your hesitations and reach out to us.";
$ctaButtonText = "Let's get started";
$ctaSecondaryText = 'Our Services';
$ctaSecondaryHref = 'services.php';
require __DIR__ . '/../includes/cta-band.php';

require __DIR__ . '/../includes/footer.php';
?>
