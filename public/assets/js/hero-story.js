(function () {
  var pin = document.querySelector('[data-hero-pin]');
  if (!pin) return;

  var dataEl = document.getElementById('heroStoryData');
  var beats = [];
  try { beats = JSON.parse((dataEl && dataEl.textContent) || '[]'); } catch (e) { beats = []; }

  var mediaEls = Array.prototype.slice.call(pin.querySelectorAll('[data-hero-media]'));
  var textEl = pin.querySelector('[data-hero-text]');
  var tagEl = pin.querySelector('[data-hero-tag]');
  var headingEl = pin.querySelector('[data-hero-heading]');
  var subtextEl = pin.querySelector('[data-hero-subtext]');
  var actionsEl = pin.querySelector('[data-hero-actions]');
  var scrollHintEl = pin.querySelector('[data-hero-scroll-hint]');
  var progressEl = pin.querySelector('[data-hero-progress]');
  var progressDots = Array.prototype.slice.call(pin.querySelectorAll('[data-hero-progress-dot]'));

  var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var isMobile = window.matchMedia('(max-width: 860px)').matches;
  var hasGsap = typeof window.gsap !== 'undefined' && typeof window.ScrollTrigger !== 'undefined';

  // Reduced motion / mobile / missing GSAP / not enough beats: leave the
  // server-rendered first beat exactly as-is — no pin, no scroll-jack.
  // Same fallback contract as study-globe.js elsewhere on this page.
  if (reduceMotion || isMobile || !hasGsap || beats.length < 2 || mediaEls.length < beats.length) return;

  gsap.registerPlugin(ScrollTrigger);

  function applyBeat(i) {
    var b = beats[i];
    tagEl.textContent = b.tag;
    headingEl.textContent = b.heading;
    subtextEl.textContent = b.subtext;
    progressDots.forEach(function (dot, idx) { dot.classList.toggle('is-active', idx === i); });
  }

  gsap.set(actionsEl, { opacity: 0, y: 14, pointerEvents: 'none' });
  gsap.to(progressEl, { opacity: 1, duration: 0.6, delay: 0.5 });

  var STAGE_DUR = 1;
  var totalDuration = beats.length * STAGE_DUR;
  var pxPerUnit = window.innerHeight * 0.75;

  var tl = gsap.timeline({
    scrollTrigger: {
      trigger: pin,
      start: 'top top',
      end: '+=' + Math.round(totalDuration * pxPerUnit),
      pin: true,
      scrub: 1,
      anticipatePin: 1
    }
  });

  var t = 0;
  beats.forEach(function (beat, i) {
    var stageStart = t;
    var isLast = i === beats.length - 1;

    if (i === 0) {
      tl.to(scrollHintEl, { opacity: 0, duration: STAGE_DUR * 0.25 }, stageStart + STAGE_DUR * 0.35);
    } else {
      var transitionStart = stageStart - STAGE_DUR * 0.4;
      tl.to(mediaEls[i - 1], { opacity: 0, duration: STAGE_DUR * 0.5, ease: 'power1.inOut' }, transitionStart);
      tl.to(mediaEls[i], { opacity: 1, duration: STAGE_DUR * 0.5, ease: 'power1.inOut' }, transitionStart);
      tl.to(textEl, { opacity: 0, y: -16, duration: STAGE_DUR * 0.22, ease: 'power1.in' }, transitionStart);
      tl.call(applyBeat, [i], transitionStart + STAGE_DUR * 0.22);
      tl.fromTo(textEl, { opacity: 0, y: 16 }, { opacity: 1, y: 0, duration: STAGE_DUR * 0.25, ease: 'power1.out', immediateRender: false }, transitionStart + STAGE_DUR * 0.25);
    }

    if (isLast) {
      tl.set(actionsEl, { pointerEvents: 'auto' }, stageStart + STAGE_DUR * 0.45);
      tl.to(actionsEl, { opacity: 1, y: 0, duration: STAGE_DUR * 0.35 }, stageStart + STAGE_DUR * 0.45);
    }

    t += STAGE_DUR;
  });

  window.addEventListener('pagehide', function () {
    if (tl.scrollTrigger) tl.scrollTrigger.kill();
    tl.kill();
  });
})();
