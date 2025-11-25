<svg viewBox="0 0 300 316" xmlns="http://www.w3.org/2000/svg" {{ $attributes }}>
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 316">
  <defs>
    <!-- Glow gradient for the main orb -->
    <radialGradient id="orb" cx="50%" cy="40%" r="60%">
      <stop offset="0%" stop-color="#66e6ff"/>
      <stop offset="40%" stop-color="#3b82f6"/>
      <stop offset="100%" stop-color="#0b1120"/>
    </radialGradient>

    <!-- Accent gradient for highlight streak -->
    <linearGradient id="streak" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#22c55e"/>
      <stop offset="100%" stop-color="#a855f7"/>
    </linearGradient>
  </defs>

  <!-- Background orb -->
  <circle cx="150" cy="158" r="130" fill="url(#orb)" />

  <!-- Outer rings -->
  <circle cx="150" cy="158" r="120" fill="none" stroke="#38bdf8" stroke-width="2" opacity="0.5"/>
  <circle cx="150" cy="158" r="90" fill="none" stroke="#a855f7" stroke-width="2" opacity="0.35"/>

  <!-- Diagonal streak -->
  <path
    d="M30 210
       Q150 110 270 140
       L270 170
       Q150 135 30 235
       Z"
    fill="url(#streak)"
    opacity="0.75"
  />

  <!-- Inner “core” -->
  <circle cx="150" cy="158" r="45" fill="#020617" />
  <circle cx="150" cy="158" r="35" fill="#0f172a" />
  <circle cx="150" cy="158" r="18" fill="#22c55e" />

  <!-- Small orbiting dots -->
  <circle cx="85" cy="120" r="6" fill="#38bdf8"/>
  <circle cx="215" cy="105" r="5" fill="#a855f7"/>
  <circle cx="230" cy="215" r="4" fill="#22c55e"/>
</svg>

</svg>
