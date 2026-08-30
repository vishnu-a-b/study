<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/functions.php';

$pageTitle       = 'About Us';
$pageDescription = 'Studwise is the best education consultancy in Malappuram, founded in 2019 and headquartered in Manjeri, with centres in Valanchery and Calicut.';
$activeNav       = 'about';
require __DIR__ . '/../includes/header.php';

$aboutChips = get_stats('about_chips');
?>

<section class="page-hero">
  <div class="wrap">
    <div class="eyebrow-row reveal"><span class="marker"></span><p class="eyebrow">Education Consulting</p></div>
    <h1 class="reveal" style="max-width: 18ch;">Where ambitions<br><span class="text-muted">take off.</span></h1>
    <p class="hero__subtext reveal" style="font-size:1.2rem; color:var(--gray-600); max-width:60ch;">Your study abroad journey starts here. Paving the path and shedding light along your way — we lend a helping hand to finally realize your dream of studying abroad.</p>
  </div>
</section>

<section class="section" style="padding-top:0;">
  <div class="wrap two-col">
    <div class="diptych reveal">
      <div class="diptych__item">
        <img src="<?= asset('images/office/valanchery-office.webp') ?>" alt="Studwise Valanchery office">
        <p class="diptych__caption">Valanchery Office</p>
      </div>
      <div class="diptych__item">
        <img src="<?= asset('images/office/study-abroad-students.webp') ?>" alt="Students preparing to study abroad">
        <p class="diptych__caption">Our Students</p>
      </div>
    </div>
    <div>
      <div class="eyebrow-row reveal"><span class="marker"></span><p class="eyebrow">Who we are</p></div>
      <h2 class="reveal">Founded in 2019,<br><span class="text-muted">headquartered in Manjeri.</span></h2>
      <p class="reveal">Studwise is the best education consultancy in Malappuram founded in 2019 and headquartered in Manjeri, with its centres in Valanchery and Calicut.</p>
      <p class="reveal">With over 5+ years of experience, Studwise has successfully placed 1000+ students in different countries. We align with countries like the UK, USA, Canada, Australia, Malta, Singapore, Dubai, and Malaysia. Studwise represents 150+ universities across the globe. We provide courses like TOEFL, IELTS, and EPT support with career counselling and proper guidance in course selection.</p>
      <p class="reveal">Studwise's comprehensive support services and experienced team of experts help students find the best courses, scholarship assistance, colleges, and universities that perfectly meet their career expectations, and academic and financial background needs on a global scale.</p>
    </div>
  </div>
</section>

<section class="section section--navy">
  <div class="wrap">
    <div class="grid" style="grid-template-columns: repeat(3, 1fr);">
      <div class="reveal">
        <div class="eyebrow-row"><span class="marker"></span><p class="eyebrow">Vision</p></div>
        <p>Studwise International is the best study abroad consultant in Kerala, Malappuram which laid the foundation for elevating overseas education through personal, professional, and academic progress. Our vision is to provide a complete solution for all your overseas education.</p>
      </div>
      <div class="reveal">
        <div class="eyebrow-row"><span class="marker"></span><p class="eyebrow">Mission</p></div>
        <p>Our mission is to help students achieve their dream abroad by understanding their dreams during counseling sessions. Our career guidance is unbiased and authentic, ensuring a seamless study abroad experience from registration to departure.</p>
      </div>
      <div class="reveal">
        <div class="eyebrow-row"><span class="marker"></span><p class="eyebrow">Values</p></div>
        <p>Since the very beginning, Studwise closely collaborated with several groups and renowned global organizations in various countries. Our Core Values represent our Consultancy.</p>
        <p style="color:var(--lime); font-weight:700;">Excellence &middot; Honesty &middot; Dedication &middot; Transparency &middot; Services &middot; Experience</p>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="wrap two-col">
    <div class="reveal">
      <div class="eyebrow-row"><span class="marker"></span><p class="eyebrow">A comprehensive solution for your dreams</p></div>
      <h2>Led by a<br><span class="text-muted">visionary founder.</span></h2>
      <p>Studwise closely collaborates with several groups and renowned global organizations in various countries. Our professional team can proceed to secure admissions to excellent universities.</p>
      <p>We provide each student with a complete focus, and our deliberate strategy guarantees that students have the chance to attain their goals. All of this has been made possible by <strong>Mr. P S Mahmood</strong>, the company's <strong>Founder and CEO</strong>, and his visionary leadership.</p>
      <a href="services.php" class="btn btn--pill btn--outline"><span>Learn More</span></a>
    </div>
    <div class="reveal">
      <img src="<?= asset('images/office/gallery-1.jpeg') ?>" alt="Studwise team at work">
    </div>
  </div>
</section>

<section class="section" style="padding-top:0;">
  <div class="wrap">
    <div class="section-head section-head--center">
      <div class="eyebrow-row reveal" style="justify-content:center;"><span class="marker"></span><p class="eyebrow">Why choose us</p></div>
      <h2 class="reveal">A hassle-free journey, backed by experience</h2>
      <p class="reveal">With 5+ years of experience in our bag, Studwise represents 150+ universities across the globe. With top-notch and experienced counsellors, Studwise makes sure the journey is a hassle-free ride.</p>
    </div>
    <div class="grid reveal-stagger" style="grid-template-columns: repeat(3, 1fr);">
      <?php foreach ($aboutChips as $chip): ?>
        <div class="stat-chip">
          <div class="stat-chip__value"><span class="js-count" data-target="<?= (int) $chip['value_number'] ?>" data-prefix="<?= h($chip['value_prefix']) ?>" data-suffix="<?= h($chip['value_suffix']) ?>">0</span></div>
          <p class="stat-chip__label"><?= h($chip['label']) ?></p>
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
