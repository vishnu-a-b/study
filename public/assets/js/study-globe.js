(function () {
  var section = document.querySelector('[data-study-globe]');
  if (!section) return;

  var dataEl = document.getElementById('studyDestinationsData');
  var countries = [];
  try { countries = JSON.parse((dataEl && dataEl.textContent) || '[]'); } catch (e) { countries = []; }
  // No data / no WebGL support / three.js CDN failed to load: the PHP-rendered
  // .study-globe__mobile-list is already real content in the DOM, so just leave it.
  if (!countries.length || typeof THREE === 'undefined') return;

  var canvas = section.querySelector('[data-globe-canvas]');
  var canvasWrap = canvas.parentElement;
  var pinEl = section.querySelector('[data-globe-pin]');
  var introEl = section.querySelector('[data-globe-intro]');
  var stageEl = section.querySelector('[data-globe-stage]');
  var stageEyebrowEl = section.querySelector('[data-stage-eyebrow]');
  var stageNameEl = section.querySelector('[data-stage-name]');
  var cardEl = section.querySelector('[data-globe-card]');
  var cardFlagEl = section.querySelector('[data-card-flag]');
  var cardNameEl = section.querySelector('[data-card-name]');
  var cardDescEl = section.querySelector('[data-card-desc]');
  var cardStatsEl = section.querySelector('[data-card-stats]');
  var cardCtaLabelEl = section.querySelector('[data-card-cta-label]');
  var finalEl = section.querySelector('[data-globe-final]');
  var progressEl = section.querySelector('[data-globe-progress]');
  var progressDots = Array.prototype.slice.call(section.querySelectorAll('[data-progress-dot]'));

  var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var isMobile = window.matchMedia('(max-width: 860px)').matches;
  var hasGsap = typeof window.gsap !== 'undefined' && typeof window.ScrollTrigger !== 'undefined';

  var ORIGIN = { lat: 11.048, lng: 76.081 }; // Malappuram, Kerala — Studwise HQ
  var GLOBE_R = 2;

  // ---------------- Three.js scene (kept low-poly: one sphere pair, sprites, thin line arcs, a point cloud) ----------------
  var renderer = new THREE.WebGLRenderer({ canvas: canvas, antialias: true, alpha: false });
  renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
  renderer.setClearColor(0x0d163c, 1);

  var Z_START = 7, Z_NEAR = 4.6, Z_FAR = 7.4;

  var scene = new THREE.Scene();
  var camera = new THREE.PerspectiveCamera(45, 1, 0.1, 100);
  camera.position.set(0, 0.55, Z_START);

  var globe = new THREE.Group();
  scene.add(globe);

  // Sun-style key light + a dim navy ambient fill so the night side reads as
  // "dark planet" rather than pure black — this is what makes the globe look
  // like a real lit sphere instead of a flat wireframe.
  scene.add(new THREE.AmbientLight(0x1c3a6e, 1.6));
  var sunLight = new THREE.DirectionalLight(0xffffff, 2.2);
  sunLight.position.set(-4, 2.5, 4);
  scene.add(sunLight);

  var earthTexture = new THREE.TextureLoader().load(canvas.getAttribute('data-earth-texture') || '');
  if ('colorSpace' in earthTexture) earthTexture.colorSpace = THREE.SRGBColorSpace;
  var earthMat = new THREE.MeshPhongMaterial({ map: earthTexture, shininess: 6, specular: 0x1a2c55 });
  globe.add(new THREE.Mesh(new THREE.SphereGeometry(GLOBE_R, 64, 48), earthMat));

  var glowMat = new THREE.MeshBasicMaterial({
    color: 0x0099d8, transparent: true, opacity: 0.12,
    side: THREE.BackSide, blending: THREE.AdditiveBlending, depthWrite: false
  });
  scene.add(new THREE.Mesh(new THREE.SphereGeometry(GLOBE_R * 1.15, 32, 24), glowMat));

  var starCount = isMobile ? 400 : 1200;
  var starPos = new Float32Array(starCount * 3);
  for (var si = 0; si < starCount; si++) {
    var r = 18 + Math.random() * 22;
    var theta = Math.random() * Math.PI * 2;
    var phi = Math.acos((Math.random() * 2) - 1);
    starPos[si * 3] = r * Math.sin(phi) * Math.cos(theta);
    starPos[si * 3 + 1] = r * Math.sin(phi) * Math.sin(theta);
    starPos[si * 3 + 2] = r * Math.cos(phi);
  }
  var starGeo = new THREE.BufferGeometry();
  starGeo.setAttribute('position', new THREE.BufferAttribute(starPos, 3));
  var stars = new THREE.Points(starGeo, new THREE.PointsMaterial({
    color: 0xbfe0ff, size: 0.035, transparent: true, opacity: 0.6, sizeAttenuation: true
  }));
  scene.add(stars);

  var markerTexture = (function () {
    var c = document.createElement('canvas');
    c.width = c.height = 64;
    var ctx = c.getContext('2d');
    var grad = ctx.createRadialGradient(32, 32, 0, 32, 32, 32);
    grad.addColorStop(0, 'rgba(255,255,255,1)');
    grad.addColorStop(0.25, 'rgba(0,153,216,1)');
    grad.addColorStop(1, 'rgba(0,153,216,0)');
    ctx.fillStyle = grad;
    ctx.fillRect(0, 0, 64, 64);
    return new THREE.CanvasTexture(c);
  })();

  function latLngToVec3(lat, lng, radius) {
    var phiA = (90 - lat) * Math.PI / 180;
    var thetaA = (lng + 180) * Math.PI / 180;
    return new THREE.Vector3(
      -radius * Math.sin(phiA) * Math.cos(thetaA),
      radius * Math.cos(phiA),
      radius * Math.sin(phiA) * Math.sin(thetaA)
    );
  }

  var originVec = latLngToVec3(ORIGIN.lat, ORIGIN.lng, 1);
  var originQuat = new THREE.Quaternion().setFromUnitVectors(originVec.clone().normalize(), new THREE.Vector3(0, 0, 1));
  var introQuat = new THREE.Quaternion();

  function buildArc(fromVec, toVec, radius) {
    var start = fromVec.clone().multiplyScalar(radius);
    var end = toVec.clone().multiplyScalar(radius);
    var mid = start.clone().add(end).multiplyScalar(0.5);
    var dist = start.distanceTo(end);
    mid.setLength(radius * 1.28 + dist * 0.16);
    var curve = new THREE.QuadraticBezierCurve3(start, mid, end);
    var points = curve.getPoints(48);
    var geometry = new THREE.BufferGeometry().setFromPoints(points);
    geometry.setDrawRange(0, 0);
    return { geometry: geometry, total: points.length };
  }

  function setArcProgress(entry, t) {
    var count = Math.max(0, Math.round(entry.arcTotal * t));
    entry.arcLine.geometry.setDrawRange(0, count);
  }

  var entries = countries.map(function (c) {
    var vec = latLngToVec3(c.lat, c.lng, 1);

    var markerMat = new THREE.SpriteMaterial({
      map: markerTexture, transparent: true, opacity: 0, depthWrite: false, blending: THREE.AdditiveBlending
    });
    var marker = new THREE.Sprite(markerMat);
    marker.scale.set(0.32, 0.32, 1);
    marker.position.copy(vec.clone().multiplyScalar(GLOBE_R * 1.01));
    globe.add(marker);

    var arc = buildArc(originVec, vec, GLOBE_R);
    var arcMat = new THREE.LineBasicMaterial({ color: 0x6fd6ff, transparent: true, opacity: 0 });
    var arcLine = new THREE.Line(arc.geometry, arcMat);
    globe.add(arcLine);

    return {
      data: c,
      vec: vec,
      quat: new THREE.Quaternion().setFromUnitVectors(vec.clone().normalize(), new THREE.Vector3(0, 0, 1)),
      marker: marker,
      markerMat: markerMat,
      arcLine: arcLine,
      arcMat: arcMat,
      arcTotal: arc.total
    };
  });

  function resize() {
    var w = canvasWrap.clientWidth, h = canvasWrap.clientHeight;
    if (!w || !h) return;
    camera.aspect = w / h;
    camera.updateProjectionMatrix();
    renderer.setSize(w, h, false);
  }
  resize();
  window.addEventListener('resize', resize);

  function render() {
    camera.lookAt(0, 0, 0);
    renderer.render(scene, camera);
  }

  // ---------------- perf gating: only render while the section is actually on screen ----------------
  var isVisible = true;
  var idleRotate = false;
  var rafId = null;
  var clock = new THREE.Clock();

  function loop() {
    if (!isVisible || document.hidden) { rafId = null; return; }
    rafId = requestAnimationFrame(loop);
    var dt = clock.getDelta();
    stars.rotation.y += dt * 0.008;
    if (idleRotate) globe.rotation.y += dt * 0.06;
    render();
  }
  function wake() { if (!rafId) loop(); }

  if ('IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (list) {
      isVisible = list[0].isIntersecting;
      if (isVisible) wake();
    }, { threshold: 0.01 });
    io.observe(section);
  }
  document.addEventListener('visibilitychange', function () { if (!document.hidden) wake(); });

  // ---------------- content helpers ----------------
  function updateCard(e) {
    var c = e.data;
    cardFlagEl.textContent = c.flag;
    cardNameEl.textContent = c.name;
    cardDescEl.textContent = c.description;
    cardStatsEl.innerHTML = '';
    (c.stats || []).forEach(function (stat) {
      var li = document.createElement('li');
      li.textContent = stat;
      cardStatsEl.appendChild(li);
    });
    if (cardCtaLabelEl) cardCtaLabelEl.textContent = 'Explore ' + c.name;
    if (stageEyebrowEl) stageEyebrowEl.textContent = 'Destination ' + (entries.indexOf(e) + 1) + ' / ' + entries.length;
    if (stageNameEl) stageNameEl.textContent = c.name;
  }
  function setActiveDot(i) {
    progressDots.forEach(function (dot, idx) { dot.classList.toggle('is-active', idx === i); });
  }

  // ================= reduced motion: one static frame, no scroll hijack, no RAF loop =================
  if (reduceMotion) {
    globe.quaternion.copy(originQuat);
    entries.forEach(function (e) { e.markerMat.opacity = 0.9; e.arcMat.opacity = 0.35; setArcProgress(e, 1); });
    render();
    return;
  }

  // ================= mobile / no-GSAP: gently idle-rotating globe, all destinations shown, cards live in the static list below =================
  if (isMobile || !hasGsap) {
    globe.quaternion.copy(introQuat);
    entries.forEach(function (e) { e.markerMat.opacity = 0.85; e.arcMat.opacity = 0.3; setArcProgress(e, 1); });
    idleRotate = true;
    loop();
    return;
  }

  // ================= desktop: pinned, scroll-scrubbed cinematic sequence =================
  gsap.registerPlugin(ScrollTrigger);
  idleRotate = false;
  loop();

  gsap.set(cardEl, { opacity: 0 });
  gsap.set(stageEl, { opacity: 0 });
  gsap.set(finalEl, { opacity: 0, scale: 0.94 });
  gsap.set(progressEl, { opacity: 0 });

  var INTRO_DUR = 0.8;
  var STAGE_DUR = 0.9;
  var FINAL_DUR = 0.9;
  var totalDuration = INTRO_DUR + entries.length * STAGE_DUR + FINAL_DUR;
  var pxPerUnit = window.innerHeight * 0.65;

  var tl = gsap.timeline({
    scrollTrigger: {
      trigger: pinEl,
      start: 'top top',
      end: '+=' + Math.round(totalDuration * pxPerUnit),
      pin: true,
      scrub: 1,
      anticipatePin: 1
    }
  });

  var t = 0;

  // --- intro: fade heading, dolly in ---
  tl.to(introEl, { opacity: 0, y: -30, duration: INTRO_DUR * 0.55, ease: 'power1.out' }, t + INTRO_DUR * 0.3);
  tl.to(camera.position, { z: Z_NEAR, duration: INTRO_DUR, ease: 'power2.inOut' }, t);
  tl.to(progressEl, { opacity: 1, duration: 0.3 }, t + INTRO_DUR - 0.2);
  t += INTRO_DUR;

  // --- one stage per country: rotate globe to face it, reveal marker + arc + card, then hand off to the next ---
  var prevQuat = introQuat;
  entries.forEach(function (e, i) {
    var stageStart = t;
    var fadeOutStart = stageStart + STAGE_DUR - STAGE_DUR * 0.22;
    var fromQuat = prevQuat, toQuat = e.quat;
    var rotProxy = { v: 0 };

    tl.call(updateCard, [e], stageStart);
    tl.call(setActiveDot, [i], stageStart);

    tl.to(rotProxy, {
      v: 1, duration: STAGE_DUR, ease: 'power2.inOut',
      onUpdate: function () { globe.quaternion.slerpQuaternions(fromQuat, toQuat, rotProxy.v); }
    }, stageStart);

    tl.fromTo(cardEl, { opacity: 0, x: 30 }, { opacity: 1, x: 0, duration: STAGE_DUR * 0.3, ease: 'power2.out' }, stageStart);
    tl.fromTo(stageEl, { opacity: 0 }, { opacity: 1, duration: STAGE_DUR * 0.3 }, stageStart);
    tl.to(e.markerMat, { opacity: 0.95, duration: STAGE_DUR * 0.3 }, stageStart);
    tl.to(e.arcMat, { opacity: 0.4, duration: STAGE_DUR * 0.3 }, stageStart);
    tl.to({}, {
      duration: STAGE_DUR * 0.35,
      onUpdate: function () { setArcProgress(e, this.progress()); }
    }, stageStart);

    tl.to(cardEl, { opacity: 0, x: -20, duration: STAGE_DUR * 0.2, ease: 'power1.in' }, fadeOutStart);
    tl.to(stageEl, { opacity: 0, duration: STAGE_DUR * 0.2 }, fadeOutStart);
    tl.to(e.markerMat, { opacity: 0, duration: STAGE_DUR * 0.2 }, fadeOutStart);
    tl.to(e.arcMat, { opacity: 0, duration: STAGE_DUR * 0.2 }, fadeOutStart);

    prevQuat = toQuat;
    t += STAGE_DUR;
  });

  // --- final overview: pull back, show every marker + arc together, closing CTA ---
  var finalStart = t;
  var finalProxy = { v: 0 };
  var finalFromQuat = prevQuat;

  tl.to(finalProxy, {
    v: 1, duration: FINAL_DUR, ease: 'power2.inOut',
    onUpdate: function () { globe.quaternion.slerpQuaternions(finalFromQuat, originQuat, finalProxy.v); }
  }, finalStart);
  tl.to(camera.position, { z: Z_FAR, y: 0.95, duration: FINAL_DUR, ease: 'power2.inOut' }, finalStart);
  tl.call(function () { entries.forEach(function (e) { setArcProgress(e, 1); }); }, null, finalStart);
  tl.to(entries.map(function (e) { return e.markerMat; }), { opacity: 0.85, duration: FINAL_DUR * 0.6 }, finalStart + FINAL_DUR * 0.2);
  tl.to(entries.map(function (e) { return e.arcMat; }), { opacity: 0.32, duration: FINAL_DUR * 0.6 }, finalStart + FINAL_DUR * 0.2);
  tl.to(progressEl, { opacity: 0, duration: 0.3 }, finalStart);
  tl.fromTo(finalEl, { opacity: 0, y: 20, scale: 0.94 }, { opacity: 1, y: 0, scale: 1, duration: FINAL_DUR * 0.5, ease: 'power2.out' }, finalStart + FINAL_DUR * 0.45);

  // Belt-and-braces cleanup if this ever runs inside something that tears sections down.
  window.addEventListener('pagehide', function () {
    if (rafId) cancelAnimationFrame(rafId);
    if (tl.scrollTrigger) tl.scrollTrigger.kill();
    tl.kill();
  });
})();
