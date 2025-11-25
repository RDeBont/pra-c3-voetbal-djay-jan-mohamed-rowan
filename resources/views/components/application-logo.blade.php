<svg viewBox="0 0 300 316" xmlns="http://www.w3.org/2000/svg" {{ $attributes }}>
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 316">
  <defs>
    <!-- Neon green corona -->
    <radialGradient id="corona" cx="50%" cy="50%" r="60%">
      <stop offset="40%" stop-color="#00ff6a" stop-opacity="0"/>
      <stop offset="75%" stop-color="#00ff44" stop-opacity="0.85"/>
      <stop offset="100%" stop-color="#00ffcc" stop-opacity="0.9"/>
    </radialGradient>

    <!-- Outer glow ring -->
    <radialGradient id="ringGlow" cx="50%" cy="50%" r="80%">
      <stop offset="65%" stop-color="rgba(0,0,0,0)" />
      <stop offset="100%" stop-color="rgba(0,255,102,0.4)" />
    </radialGradient>
  </defs>

  <!-- Neon green corona -->
  <circle cx="150" cy="158" r="120" fill="url(#corona)" />

  <!-- Soft outer glow -->
  <circle cx="150" cy="158" r="140" fill="url(#ringGlow)" />

  <!-- Eclipse disc -->
  <circle cx="150" cy="158" r="80" fill="#000d06" />

  <!-- Bright green rim -->
  <circle cx="150" cy="158" r="82" fill="none" stroke="#00ff66" stroke-width="3" opacity="0.9" />
  <circle cx="150" cy="158" r="86" fill="none" stroke="#00ffaa" stroke-width="2" opacity="0.6" />

  <!-- Bottom-right flare -->
  <path
    d="M195 215
       A80 80 0 0 0 222 170"
    fill="none"
    stroke="#00ff77"
    stroke-width="5"
    stroke-linecap="round"
    opacity="0.9"
  />

  <!-- Diamond-ring flashes -->
  <circle cx="222" cy="170" r="6" fill="#ccff00" />
  <circle cx="80" cy="130" r="3" fill="#00ffcc" />
  <circle cx="230" cy="110" r="3" fill="#00ff77" />
</svg>


</svg>
