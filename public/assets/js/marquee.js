(function () {
  document.querySelectorAll('.marquee__track').forEach(function (track) {
    // Duplicate the track content once so the CSS keyframe (translateX -50%)
    // creates a seamless, endless loop regardless of how many items were rendered.
    var clone = track.cloneNode(true);
    clone.setAttribute('aria-hidden', 'true');
    track.parentNode.appendChild(clone);
    track.parentNode.style.display = 'flex';
  });
})();
