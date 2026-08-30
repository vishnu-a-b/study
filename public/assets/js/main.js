(function () {
  var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var hasGsap = typeof window.gsap !== 'undefined' && typeof window.ScrollTrigger !== 'undefined';

  // ---- Page loader (always runs) ----
  window.addEventListener('load', function () {
    var loader = document.getElementById('pageLoader');
    if (!loader) return;
    if (hasGsap && !reduceMotion) {
      gsap.to(loader, {
        opacity: 0, duration: 0.6, delay: 0.3,
        onComplete: function () { loader.style.display = 'none'; }
      });
    } else {
      loader.style.display = 'none';
    }
  });

  // ---- FAQ accordion (no animation library needed) ----
  document.querySelectorAll('.faq-item').forEach(function (item) {
    var btn = item.querySelector('.faq-item__question');
    var answer = item.querySelector('.faq-item__answer');
    if (!btn || !answer) return;
    btn.addEventListener('click', function () {
      var isOpen = item.getAttribute('data-open') === 'true';
      document.querySelectorAll('.faq-item[data-open="true"]').forEach(function (openItem) {
        if (openItem !== item) {
          openItem.setAttribute('data-open', 'false');
          openItem.querySelector('.faq-item__answer').style.maxHeight = null;
        }
      });
      item.setAttribute('data-open', isOpen ? 'false' : 'true');
      answer.style.maxHeight = isOpen ? null : answer.scrollHeight + 'px';
    });
  });

  if (!hasGsap) {
    document.documentElement.classList.add('no-gsap');
  }

  if (reduceMotion) {
    document.querySelectorAll('.reveal, .reveal-stagger').forEach(function (el) {
      el.classList.add('is-visible');
    });
  }

  // Reduced motion or missing GSAP: skip smooth scroll / scroll-driven animation entirely.
  if (!hasGsap || reduceMotion) {
    return;
  }

  gsap.registerPlugin(ScrollTrigger);

  // ---- Lenis smooth (inertial) scroll ----
  if (typeof window.Lenis !== 'undefined') {
    var lenis = new Lenis({ duration: 1.1, smoothWheel: true });
    lenis.on('scroll', ScrollTrigger.update);
    gsap.ticker.add(function (time) { lenis.raf(time * 1000); });
    gsap.ticker.lagSmoothing(0);
  }

  // ---- Reveal on scroll ----
  document.querySelectorAll('.reveal').forEach(function (el) {
    ScrollTrigger.create({
      trigger: el,
      start: 'top 85%',
      onEnter: function () {
        el.classList.add('is-visible');
        gsap.fromTo(el, { opacity: 0, y: 28 }, { opacity: 1, y: 0, duration: 1, ease: 'power3.out' });
      },
      once: true
    });
  });

  document.querySelectorAll('.reveal-stagger').forEach(function (el) {
    ScrollTrigger.create({
      trigger: el,
      start: 'top 85%',
      onEnter: function () {
        el.classList.add('is-visible');
        gsap.fromTo(el.children, { opacity: 0, y: 24 }, { opacity: 1, y: 0, duration: 0.9, ease: 'power3.out', stagger: 0.1 });
      },
      once: true
    });
  });

  // ---- Parallax on hero / feature media ----
  document.querySelectorAll('[data-parallax]').forEach(function (el) {
    var speed = parseFloat(el.getAttribute('data-parallax')) || 0.15;
    var trigger = el.closest('.hero, .parallax-wrap') || el;
    var isHero = trigger.classList.contains('hero');
    gsap.to(el, {
      yPercent: speed * 100,
      ease: 'none',
      scrollTrigger: {
        trigger: trigger,
        // Full-bleed hero sections start already in view at top top;
        // 'top bottom' would treat them as already halfway scrolled on load.
        start: isHero ? 'top top' : 'top bottom',
        end: 'bottom top',
        scrub: true
      }
    });
  });

  // ---- Work Process scroll-scrubbed line fill ----
  var processFill = document.querySelector('.process-line__fill');
  if (processFill) {
    gsap.to(processFill, {
      scaleX: 1,
      ease: 'none',
      scrollTrigger: {
        trigger: '.process-steps',
        start: 'top 75%',
        end: 'bottom 65%',
        scrub: true
      }
    });
  }

  // ---- Custom cursor dot (pointer devices only) ----
  var cursor = document.getElementById('cursorDot');
  if (cursor && window.matchMedia('(pointer: fine)').matches) {
    document.documentElement.classList.add('has-custom-cursor');

    // Bakes the tip-alignment offset into GSAP's own transform cache so the
    // rotation/scale tweens below can update independently without wiping it.
    // scaleX/scaleY (not the bare "scale" shorthand) avoids GSAP 3.12 warning
    // about the native CSS `scale` property being ambiguous with transform-scale.
    gsap.set(cursor, { x: -2, y: -2, rotation: 0, scaleX: 1, scaleY: 1 });
    var moveX = gsap.quickTo(cursor, 'left', { duration: 0.15, ease: 'power2.out' });
    var moveY = gsap.quickTo(cursor, 'top', { duration: 0.15, ease: 'power2.out' });
    var bankTo = gsap.quickTo(cursor, 'rotation', { duration: 0.2, ease: 'power2.out' });
    var swoopToX = gsap.quickTo(cursor, 'scaleX', { duration: 0.2, ease: 'power2.out' });
    var swoopToY = gsap.quickTo(cursor, 'scaleY', { duration: 0.2, ease: 'power2.out' });

    var lastX = null, lastY = null, lastT = null, settleTimer = null;

    window.addEventListener('mousemove', function (e) {
      cursor.classList.add('is-active');
      moveX(e.clientX);
      moveY(e.clientY);

      var now = performance.now();
      if (lastX !== null) {
        var dx = e.clientX - lastX, dy = e.clientY - lastY;
        var dt = Math.max(now - lastT, 1);
        var dist = Math.sqrt(dx * dx + dy * dy);
        if (dist > 2) {
          // Icon's nose rests pointing up-left (-135deg); rotate it onto the
          // direction of travel so the plane always noses into its heading.
          var heading = Math.atan2(dy, dx) * 180 / Math.PI + 135;
          var speed = dist / dt; // px per ms — higher on fast flicks
          var swoop = Math.min(1 + speed * 0.5, 1.6);
          bankTo(heading);
          swoopToX(swoop);
          swoopToY(swoop);

          clearTimeout(settleTimer);
          settleTimer = setTimeout(function () {
            bankTo(0);
            swoopToX(1);
            swoopToY(1);
          }, 140);
        }
      }
      lastX = e.clientX; lastY = e.clientY; lastT = now;
    });
    document.querySelectorAll('a, button').forEach(function (el) {
      el.addEventListener('mouseenter', function () { cursor.classList.add('is-hover'); });
      el.addEventListener('mouseleave', function () { cursor.classList.remove('is-hover'); });
    });
  }
})();
