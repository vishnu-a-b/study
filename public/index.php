<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/functions.php';

$pageTitle       = 'Best Education Consultancy in Malappuram, Kerala';
$pageDescription = 'Studwise International is the best study abroad consultants in Kerala, relaying quality education equivalence to the dreams of students.';
$activeNav       = 'home';
$navOnDark       = true;
require __DIR__ . '/../includes/header.php';

$mainStats  = get_stats('main');
$services   = get_services(true);
$countries  = get_partner_logos();
$studyDestinations = get_study_destinations();
$includeStudyGlobeJs = true;
$includeHeroStoryJs  = true;

$heroStory = [
  [
    'tag'     => 'Malappuram · Kerala',
    'heading' => 'Best education consultancy in Malappuram, Kerala.',
    'subtext' => SITE_NAME . ' is the best study abroad consultants in Kerala, relaying quality education equivalence to the dreams of students.',
    'image'   => 'images/hero/hero-main.webp',
    'alt'     => 'Studwise International team assisting students',
  ],
  [
    'tag'     => 'Since 2019',
    'heading' => 'Guiding students since 2019.',
    'subtext' => 'A dedicated team of counselors helping you navigate applications, visas, and admissions — start to finish.',
    'image'   => 'images/hero/hero-study-abroad.webp',
    'alt'     => 'A student preparing study abroad documents with a Studwise counselor',
  ],
  [
    'tag'     => '150+ universities',
    'heading' => 'Access to 150+ universities across 8 countries.',
    'subtext' => 'UK, USA, Canada, Australia, Malta, Singapore, Dubai and Malaysia — with offices in Manjeri, Valanchery and Calicut.',
    'image'   => 'images/hero/overseas-education-consultants-malappuram.webp',
    'alt'     => 'Studwise counselors supporting students with overseas education',
  ],
  [
    'tag'     => 'Ready when you are',
    'heading' => 'Your future starts with one conversation.',
    'subtext' => "Book a free appointment and let's plan your study abroad journey together.",
    'image'   => 'images/hero/educational-consultants-kerala.webp',
    'alt'     => 'A Studwise education consultant meeting with a student in Kerala',
  ],
];
?>

<section class="hero" data-hero>
  <div class="hero__pin" data-hero-pin>
    <div class="hero__media">
      <?php foreach ($heroStory as $i => $beat): ?>
        <img class="hero__media-img<?= $i === 0 ? ' is-active' : '' ?>" data-hero-media src="<?= asset($beat['image']) ?>" alt="<?= h($beat['alt']) ?>">
      <?php endforeach; ?>
    </div>
    <div class="hero__content">
      <div class="hero__text" data-hero-text>
        <div class="hero__tag reveal"><span class="marker"></span><span data-hero-tag><?= h($heroStory[0]['tag']) ?></span></div>
        <h1 class="reveal" data-hero-heading><?= h($heroStory[0]['heading']) ?></h1>
        <p class="hero__subtext reveal" data-hero-subtext><?= h($heroStory[0]['subtext']) ?></p>
      </div>
      <div class="hero__actions" data-hero-actions>
        <a href="about.php" class="btn btn--pill btn--magnetic"><span aria-hidden="true">&rarr;</span><span>Learn More</span></a>
        <a href="<?= h(WHATSAPP_URL) ?>" target="_blank" rel="noopener" class="btn btn--pill btn--outline"><span>Book Appointment</span></a>
      </div>
    </div>
    <div class="hero__progress" data-hero-progress>
      <?php foreach ($heroStory as $i => $beat): ?>
        <span class="hero__progress-dot<?= $i === 0 ? ' is-active' : '' ?>" data-hero-progress-dot="<?= $i ?>"></span>
      <?php endforeach; ?>
    </div>
    <div class="hero__scroll-hint" data-hero-scroll-hint><span class="line"></span> Scroll</div>
  </div>

  <script type="application/json" id="heroStoryData"><?= json_encode(array_map(function ($b) {
    return ['tag' => $b['tag'], 'heading' => $b['heading'], 'subtext' => $b['subtext']];
  }, $heroStory), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
</section>

<section class="section">
  <div class="wrap two-col">
    <div class="reveal">
      <img src="<?= asset('images/office/study-abroad-students.webp') ?>" alt="Studwise students preparing to study abroad">
    </div>
    <div>
      <div class="eyebrow-row reveal"><span class="marker"></span><p class="eyebrow">Who we are</p></div>
      <h2 class="reveal">One of the best education<br><span class="text-muted">consultancies since 2019.</span></h2>
      <p class="reveal"><?= h(SITE_NAME) ?> is one of the best education consultancy in Malappuram since 2019, a team of professionals to assist you in making your dream a reality.</p>
      <p class="reveal">Aligning with countries like the UK, USA, Canada, Australia, Malta, Singapore, Dubai, and Malaysia, an authorized representative of 150+ universities across the globe with branches and associate offices in Manjeri, Valanchery, and Calicut.</p>
      <p class="reveal">We are relaying quality education equivalence to the dreams of students.</p>

      <div class="stats-row reveal-stagger">
        <?php foreach ($mainStats as $stat): ?>
          <div class="stat-item">
            <div class="stat-item__value"><span class="js-count" data-target="<?= (int) $stat['value_number'] ?>" data-prefix="<?= h($stat['value_prefix']) ?>" data-suffix="<?= h($stat['value_suffix']) ?>">0</span></div>
            <p class="stat-item__label"><?= h($stat['label']) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0;">
  <div class="wrap">
    <div class="section-head section-head--center">
      <div class="eyebrow-row reveal" style="justify-content:center;"><span class="marker"></span><p class="eyebrow">What we do</p></div>
      <h2 class="reveal">Our Services</h2>
      <p class="reveal">As a leading study abroad education consultancy, we ensure our services cover every nook and hiccup.</p>
    </div>

    <div class="cards-grid reveal-stagger">
      <?php foreach ($services as $svc): ?>
        <article class="service-card">
          <div class="service-card__icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><?= service_icon($svc['icon_key']) ?></svg>
          </div>
          <h3><?= h($svc['title']) ?></h3>
          <p><?= h($svc['summary']) ?></p>
          <a class="learn-more" href="services/<?= h($svc['slug']) ?>.php">Learn More &rarr;</a>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<div class="stat-band reveal">
  <div class="stat-band__media">
    <img src="<?= asset('images/hero/overseas-education-consultants-malappuram.webp') ?>" alt="Studwise counselors supporting students">
  </div>
  <div class="stat-band__inner">
    <div class="eyebrow-row"><span class="marker"></span><p class="eyebrow">Why choose us</p></div>
    <h2 style="max-width:22ch;">A full range of services, start to finish.</h2>
    <p style="max-width:60ch;"><?= h(SITE_NAME) ?> is one of the leading overseas educational consultants in Kerala that aims to provide each student with a full range of services like TOEFL, IELTS, and EPT support other than career counseling sessions and course selection and choosing the best university for students, facilitating student loans, and successfully processing visas.</p>
    <a href="<?= h(WHATSAPP_URL) ?>" target="_blank" rel="noopener" class="btn-icon-label btn--magnetic" style="margin-top:20px;">
      <span class="btn-icon-label__box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span>
      <span>Book appointment</span>
    </a>
  </div>
</div>

<section class="study-globe" id="studyGlobe" data-study-globe>
  <script type="application/json" id="studyDestinationsData"><?= json_encode($studyDestinations, JSON_UNESCAPED_SLASHES) ?></script>

  <div class="study-globe__pin" data-globe-pin>
    <div class="study-globe__canvas-wrap">
      <canvas class="study-globe__canvas" data-globe-canvas data-earth-texture="<?= asset('images/space/earth-daymap.jpg') ?>"></canvas>
    </div>

    <div class="study-globe__overlay">
      <div class="study-globe__intro" data-globe-intro>
        <div class="eyebrow-row"><span class="marker"></span><p class="eyebrow">Global reach</p></div>
        <h2>Explore your future<br><span class="study-globe__accent">across the world.</span></h2>
        <p>Discover world-class education opportunities across our leading study destinations, guided every step of the way by our counselors in Manjeri, Valanchery, and Calicut.</p>
        <div class="study-globe__scroll-hint"><span class="line"></span> Scroll to explore</div>
      </div>

      <div class="study-globe__stage" data-globe-stage>
        <p class="study-globe__stage-eyebrow" data-stage-eyebrow></p>
        <h3 class="study-globe__stage-name" data-stage-name></h3>
      </div>

      <aside class="study-globe__card" data-globe-card>
        <span class="study-globe__card-flag" data-card-flag></span>
        <h4 data-card-name></h4>
        <p data-card-desc></p>
        <ul class="study-globe__card-stats" data-card-stats></ul>
        <a href="contact.php" class="btn btn--pill btn--outline" data-card-cta>
          <span data-card-cta-label></span> <span aria-hidden="true">&rarr;</span>
        </a>
      </aside>

      <div class="study-globe__final" data-globe-final>
        <h2>The world is waiting<br><span class="study-globe__accent">for you.</span></h2>
        <p>Choose your destination. Find your university. Start your journey.</p>
        <a href="contact.php" class="btn btn--pill">Start Your Study Abroad Journey</a>
      </div>

      <div class="study-globe__progress" data-globe-progress>
        <?php foreach ($studyDestinations as $i => $d): ?>
          <span class="study-globe__progress-dot" data-progress-dot="<?= $i ?>"></span>
        <?php endforeach; ?>
      </div>

      <!-- No-JS / reduced-motion / mobile fallback: real content, no animation dependency -->
      <div class="study-globe__mobile-list">
        <?php foreach ($studyDestinations as $d): ?>
          <div class="study-globe__mobile-card">
            <span class="study-globe__card-flag"><?= h($d['flag']) ?></span>
            <h4><?= h($d['name']) ?></h4>
            <p><?= h($d['description']) ?></p>
            <ul class="study-globe__card-stats">
              <?php foreach ($d['stats'] as $stat): ?>
                <li><?= h($stat) ?></li>
              <?php endforeach; ?>
            </ul>
            <a href="contact.php" class="btn btn--pill btn--outline">Explore <?= h($d['name']) ?> <span aria-hidden="true">&rarr;</span></a>
          </div>
        <?php endforeach; ?>
        <div class="study-globe__mobile-final">
          <h2>The world is waiting<br><span class="study-globe__accent">for you.</span></h2>
          <p>Choose your destination. Find your university. Start your journey.</p>
          <a href="contact.php" class="btn btn--pill">Start Your Study Abroad Journey</a>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0;">
  <div class="wrap">
    <div class="section-head section-head--center">
      <div class="eyebrow-row reveal" style="justify-content:center;"><span class="marker"></span><p class="eyebrow">Countries we work with</p></div>
      <h2 class="reveal">Partnered with 150+ universities worldwide</h2>
      <p class="reveal">Adding to our reputation, we have partnered with top-notch universities across the globe for delivering high-quality abroad education.</p>
    </div>
    <div class="marquee reveal">
      <div class="marquee__track">
        <?php foreach ($countries as $c): ?>
          <div class="marquee__item">
            <img src="<?= asset('images/partners/globe-icon.svg') ?>" alt="" width="20" height="20">
            <span><?= h($c['name']) ?></span>
          </div>
        <?php endforeach; ?>
      </div>
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
