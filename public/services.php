<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/functions.php';

$pageTitle       = 'Our Services';
$pageDescription = 'Career counseling, university registration, visa processing, IELTS/TOEFL/EPT prep, pre & post-landing support, internships, accommodation, and scholarship assistance — all in one place.';
$activeNav       = 'services';
require __DIR__ . '/../includes/header.php';

$allServices = get_services();
$mainStats   = get_stats('main');

$features = [
    ['Top-notch universities', 'Authorized representative of 150+ universities across the globe.'],
    ['Experienced Counselors', '5+ years of industry experience at our disposal.'],
    ['Budget-friendly', 'Strives to make studying as cheap as feasible.'],
    ['Efficient service', 'Delivering quick and quality service on time.'],
    ['Free Counseling & 24/7 Support', 'Welcoming consultants, always reachable.'],
    ['3 Branches Overall Kerala', 'Manjeri, Valanchery, and Calicut.'],
    ['Exciting Packages', 'Academic packages tailored to your goals.'],
];

$processSteps = [
    ['Free Counseling', 'A one-on-one session to understand your goals, budget, and academic background.'],
    ['Course & University Selection', 'We shortlist the best-fit universities and courses for your profile.'],
    ['Application & Documentation', 'Our team handles registration, paperwork, and scholarship applications.'],
    ['Visa & Pre-Departure', 'Visa filing, pre-landing briefing, and support right up to your flight.'],
];
?>

<section class="page-hero">
  <div class="wrap">
    <div class="section-head">
      <div class="eyebrow-row reveal"><span class="marker"></span><p class="eyebrow">Study Abroad With Us</p></div>
      <h1 class="reveal" style="max-width:20ch;">&ldquo;Setting you a platform to realize your long-desired dream.&rdquo;</h1>
      <p class="reveal" style="font-weight:700;">&mdash; P S Mahmood, Founder and CEO</p>
    </div>
    <p class="reveal" style="max-width:70ch;">Studying abroad is always exhilarating, but you might not know where to start. With Studwise, the best overseas education consultants in Malappuram, start your overseas journey guided to a wonderful future abroad. At Studwise, student satisfaction is our top priority.</p>
  </div>
</section>

<section class="section" style="padding-top:0;">
  <div class="wrap tab-list-section">
    <div class="tab-list-section__intro">
      <div class="eyebrow-row reveal"><span class="marker"></span><p class="eyebrow">Featured Services</p></div>
      <h2 class="reveal" id="tabListHeading"><?= h($allServices[0]['title']) ?></h2>
      <p class="reveal" id="tabListBody"><?= h($allServices[0]['body']) ?></p>
      <a href="<?= h(BASE_URL) ?>services/<?= h($allServices[0]['slug']) ?>.php" class="btn-icon-label reveal" id="tabListLink" style="margin-bottom:8px;">
        <span class="btn-icon-label__box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span>
        <span>View full details</span>
      </a>

      <div class="tab-list reveal" id="serviceTabList">
        <?php foreach ($allServices as $i => $svc): ?>
          <button type="button" class="tab-list__item<?= $i === 0 ? ' is-active' : '' ?>" id="<?= h($svc['slug']) ?>" data-index="<?= $i ?>" data-title="<?= h($svc['title']) ?>" data-body="<?= h($svc['body']) ?>" data-href="<?= h(BASE_URL) ?>services/<?= h($svc['slug']) ?>.php">
            <?= h($svc['title']) ?>
          </button>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="tab-list-media reveal">
      <?php foreach ($allServices as $i => $svc): ?>
        <img src="<?= asset('images/' . $svc['detail_image']) ?>" class="tab-list-media__img<?= $i === 0 ? ' is-active' : '' ?>" data-index="<?= $i ?>" alt="<?= h($svc['title']) ?>">
      <?php endforeach; ?>
    </div>
  </div>
</section>

<div class="stat-band reveal">
  <div class="stat-band__media">
    <img src="<?= asset('images/office/gallery-4.jpeg') ?>" alt="Studwise counseling session">
  </div>
  <div class="stat-band__inner">
    <div class="eyebrow-row"><span class="marker"></span><p class="eyebrow">Why choose us</p></div>
    <h2 style="max-width:24ch; color:#fff;">5+ years, 200+ universities, one mission.</h2>
    <div class="stats-row reveal-stagger">
      <?php foreach ($mainStats as $stat): ?>
        <div class="stat-item">
          <div class="stat-item__value"><span class="js-count" data-target="<?= (int) $stat['value_number'] ?>" data-prefix="<?= h($stat['value_prefix']) ?>" data-suffix="<?= h($stat['value_suffix']) ?>">0</span></div>
          <p class="stat-item__label"><?= h($stat['label']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="reveal" style="margin-top:60px; max-width:640px;">
      <p style="color:var(--lime); font-weight:700;">&#9733;&#9733;&#9733;&#9733;&#9733; Rated 5 out of 5</p>
      <p style="font-size:1.3rem; color:#fff;">&ldquo;The Studwise will gives you the best and amazing assistance for your career on abroad study, which any others can offer.&rdquo;</p>
      <p style="font-weight:700; color:rgba(255,255,255,.75);">Mahmood P S &mdash; Founder &amp; CEO of Studwise Pvt Ltd.</p>
    </div>
  </div>
</div>

<section class="section">
  <div class="wrap">
    <div class="section-head section-head--center">
      <div class="eyebrow-row reveal" style="justify-content:center;"><span class="marker"></span><p class="eyebrow">Delivering Industry's Best Service</p></div>
      <h2 class="reveal">Since the very beginning</h2>
      <p class="reveal">Studwise closely collaborates with several groups and renowned global organizations in various countries.</p>
    </div>
    <div class="cards-grid reveal-stagger">
      <?php foreach ($features as $f): ?>
        <div class="service-card">
          <h3><?= h($f[0]) ?></h3>
          <p><?= h($f[1]) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0;">
  <div class="wrap">
    <div class="section-head section-head--center">
      <div class="eyebrow-row reveal" style="justify-content:center;"><span class="marker"></span><p class="eyebrow">Work Process</p></div>
      <h2 class="reveal">Starting off from career counseling</h2>
      <p class="reveal">We ride through different stages of process before setting off for your journey.</p>
    </div>
    <div class="process-steps reveal">
      <div class="process-line"><div class="process-line__fill"></div></div>
      <?php foreach ($processSteps as $i => $step): ?>
        <div class="process-step">
          <div class="process-step__num"><?= $i + 1 ?></div>
          <h3><?= h($step[0]) ?></h3>
          <p><?= h($step[1]) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php
$ctaTagline = 'Ready when you are';
$ctaHeadingDark = 'Make your overseas';
$ctaHeadingLight = 'journey with us.';
$ctaSubtext = 'We offer an array of academic packages aimed to boost your professional quality, at any college or university of your preference.';
$ctaButtonText = "Let's get started";
$ctaSecondaryText = 'Contact Us';
$ctaSecondaryHref = 'contact.php';
require __DIR__ . '/../includes/cta-band.php';

require __DIR__ . '/../includes/footer.php';
?>
