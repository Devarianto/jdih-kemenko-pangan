{{-- ========================================================================= --}}
{{-- ACCESSIBILITY TOOLS WIDGET (USERWAY SUITE IN JDIH KEMENKUMHAM DESIGN)     --}}
{{-- JDIH Kementerian Koordinator Bidang Pangan Republik Indonesia          --}}
{{-- Memadukan Fitur Lengkap UserWay dengan Model Tampilan JDIH Kemenkumham  --}}
{{-- Kepatuhan: WCAG 2.1 (Level AA), PermenpanRB 59/2020, SPBE               --}}
{{-- ========================================================================= --}}

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
  /* ------------------------------------------------------------- */
  /* 1. Global Accessibility Modifier Classes Applied to <html>    */
  /* ------------------------------------------------------------- */
  html.a11y-text-scale-1 { font-size: 112% !important; }
  html.a11y-text-scale-2 { font-size: 124% !important; }
  html.a11y-text-scale-3 { font-size: 136% !important; }
  html.a11y-text-scale-4 { font-size: 148% !important; }
  html.a11y-text-scale-min { font-size: 90% !important; }

  html.a11y-font-dyslexic,
  html.a11y-font-dyslexic * {
    font-family: 'Lexend', 'Comic Sans MS', sans-serif !important;
    letter-spacing: 0.02em !important;
  }

  /* Spasi Teks (Line Height & Letter Spacing) */
  html.a11y-spacing * {
    letter-spacing: 0.08em !important;
    word-spacing: 0.16em !important;
    line-height: 1.85 !important;
  }

  /* Rata Kiri Alami */
  html.a11y-align-left * {
    text-align: left !important;
  }

  /* Kontras Tinggi Gelap */
  html.a11y-contrast-dark,
  html.a11y-contrast-dark body {
    background-color: #0b0f19 !important;
    color: #f8fafc !important;
  }
  html.a11y-contrast-dark header,
  html.a11y-contrast-dark footer,
  html.a11y-contrast-dark .card,
  html.a11y-contrast-dark .box,
  html.a11y-contrast-dark table,
  html.a11y-contrast-dark .table {
    background-color: #111827 !important;
    color: #f9fafb !important;
    border-color: #374151 !important;
  }
  html.a11y-contrast-dark a {
    color: #93c5fd !important;
  }

  /* Kontras Terang */
  html.a11y-contrast-light,
  html.a11y-contrast-light body {
    background-color: #ffffff !important;
    color: #000000 !important;
  }
  html.a11y-contrast-light a {
    color: #0000ee !important;
    text-decoration: underline !important;
  }

  /* Mode Abu-Abu (Grayscale) */
  html.a11y-monochrome {
    filter: grayscale(100%) !important;
  }

  /* Inversi Warna (Invert Colors) */
  html.a11y-invert {
    filter: invert(100%) hue-rotate(180deg) !important;
  }
  html.a11y-invert img,
  html.a11y-invert video,
  html.a11y-invert iframe {
    filter: invert(100%) hue-rotate(180deg) !important;
  }

  /* Sorot Tautan */
  html.a11y-highlight-links a,
  html.a11y-highlight-links button[href],
  html.a11y-highlight-links [role="link"] {
    background-color: #fef08a !important;
    color: #854d0e !important;
    text-decoration: underline !important;
    text-decoration-thickness: 2px !important;
    outline: 2px dashed #ca8a04 !important;
    outline-offset: 2px !important;
    font-weight: 700 !important;
  }

  /* Sorot Judul (Heading Highlight) */
  html.a11y-highlight-headings h1,
  html.a11y-highlight-headings h2,
  html.a11y-highlight-headings h3,
  html.a11y-highlight-headings h4,
  html.a11y-highlight-headings h5,
  html.a11y-highlight-headings h6 {
    background-color: #e0f2fe !important;
    color: #0369a1 !important;
    outline: 2px solid #0284c7 !important;
    padding-left: 6px !important;
    border-radius: 4px !important;
  }

  /* Kursor Besar */
  html.a11y-big-cursor,
  html.a11y-big-cursor * {
    cursor: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='44' height='44' viewBox='0 0 24 24' fill='%231a263f' stroke='%23ffffff' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M3 3l7 18 3-7 7-3L3 3z'/%3E%3C/svg%3E"), auto !important;
  }

  /* Hentikan Animasi */
  html.a11y-stop-animations *,
  html.a11y-stop-animations *::before,
  html.a11y-stop-animations *::after {
    animation-duration: 0.001s !important;
    animation-iteration-count: 1 !important;
    transition-duration: 0.001s !important;
    scroll-behavior: auto !important;
  }

  /* Sembunyikan Gambar */
  html.a11y-hide-images img,
  html.a11y-hide-images [style*="background-image"] {
    opacity: 0.05 !important;
    filter: blur(2px) !important;
  }

  /* ------------------------------------------------------------- */
  /* 2. Reading Guide & Reading Mask Overlays                      */
  /* ------------------------------------------------------------- */
  #a11y-reading-guide {
    display: none;
    position: fixed;
    left: 0;
    width: 100vw;
    height: 12px;
    background: rgba(234, 179, 8, 0.45);
    border-top: 2px solid #ca8a04;
    border-bottom: 2px solid #ca8a04;
    pointer-events: none;
    z-index: 999998;
    transform: translateY(-50%);
    box-shadow: 0 0 16px rgba(234, 179, 8, 0.5);
  }
  html.a11y-guide-active #a11y-reading-guide {
    display: block;
  }

  #a11y-mask-top, #a11y-mask-bottom {
    display: none;
    position: fixed;
    left: 0;
    width: 100vw;
    background: rgba(15, 23, 42, 0.72);
    pointer-events: none;
    z-index: 999997;
    backdrop-filter: blur(1.5px);
  }
  html.a11y-mask-active #a11y-mask-top,
  html.a11y-mask-active #a11y-mask-bottom {
    display: block;
  }

  /* Mini status bar for Text-to-Speech */
  #a11y-speech-indicator {
    display: none;
    position: fixed;
    bottom: 24px;
    left: 88px;
    background: #1a263f;
    color: #ffffff;
    padding: 10px 18px;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 600;
    box-shadow: 0 6px 20px rgba(0,0,0,0.25);
    z-index: 999995;
    align-items: center;
    gap: 10px;
    animation: a11yFadeIn 0.2s ease;
  }
  #a11y-speech-indicator.visible {
    display: flex;
  }
  #a11y-speech-indicator button {
    background: rgba(255,255,255,0.2);
    border: none;
    color: #ffffff;
    padding: 3px 8px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 11px;
    font-weight: 700;
  }
  #a11y-speech-indicator button:hover {
    background: rgba(255,255,255,0.35);
  }

  /* ------------------------------------------------------------- */
  /* 3. Floating Trigger Button (Bottom-Left)                      */
  /* ------------------------------------------------------------- */
  #a11y-kemenkum-trigger {
    position: fixed;
    bottom: 24px;
    left: 24px;
    width: 52px !important;
    height: 52px !important;
    min-width: 52px !important;
    min-height: 52px !important;
    padding: 0 !important;
    margin: 0 !important;
    line-height: 1 !important;
    background: #1a263f;
    color: #ffffff;
    border-radius: 50%;
    border: none;
    box-shadow: 0 4px 16px rgba(15, 23, 42, 0.35);
    cursor: pointer;
    z-index: 999995;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    outline: none;
  }
  #a11y-kemenkum-trigger:hover {
    transform: scale(1.08);
    box-shadow: 0 6px 20px rgba(15, 23, 42, 0.5);
  }
  #a11y-kemenkum-trigger:focus-visible {
    outline: 3px solid #38bdf8;
    outline-offset: 3px;
  }
  #a11y-kemenkum-trigger svg {
    width: 30px !important;
    height: 30px !important;
    min-width: 30px !important;
    min-height: 30px !important;
    flex-shrink: 0 !important;
    display: block !important;
    fill: currentColor;
  }
  #a11y-kemenkum-trigger .active-dot {
    position: absolute;
    top: 2px;
    right: 2px;
    width: 12px;
    height: 12px;
    background: #10b981;
    border: 2px solid #ffffff;
    border-radius: 50%;
    display: none;
  }
  #a11y-kemenkum-trigger .active-dot.visible {
    display: block;
  }

  /* ------------------------------------------------------------- */
  /* 4. Popup Modal Card (Persis Model JDIH Kemenkumham)          */
  /* ------------------------------------------------------------- */
  #a11y-kemenkum-card {
    display: none;
    position: fixed;
    bottom: 86px;
    left: 24px;
    width: 310px;
    max-width: calc(100vw - 48px);
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 14px 40px rgba(15, 23, 42, 0.24), 0 2px 8px rgba(15, 23, 42, 0.08);
    border: 1px solid rgba(226, 232, 240, 0.9);
    z-index: 999996;
    overflow: hidden;
    font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    transform-origin: bottom left;
    animation: a11yFadeIn 0.22s cubic-bezier(0.16, 1, 0.3, 1) forwards;
  }
  #a11y-kemenkum-card.open {
    display: block;
  }

  @keyframes a11yFadeIn {
    from {
      opacity: 0;
      transform: translateY(8px) scale(0.97);
    }
    to {
      opacity: 1;
      transform: translateY(0) scale(1);
    }
  }

  /* Card Header */
  .a11y-km-header {
    background: #1a263f;
    color: #ffffff;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-top-left-radius: 16px;
    border-top-right-radius: 16px;
  }
  .a11y-km-title {
    font-size: 17px;
    font-weight: 700;
    margin: 0;
    color: #ffffff;
    letter-spacing: -0.01em;
  }
  .a11y-km-close {
    background: transparent;
    border: none;
    color: #ffffff;
    cursor: pointer;
    width: 28px !important;
    height: 28px !important;
    min-width: 28px !important;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    padding: 0 !important;
    margin: 0 !important;
    line-height: 1 !important;
    transition: background 0.15s ease;
  }
  .a11y-km-close:hover {
    background: rgba(255, 255, 255, 0.15);
  }
  .a11y-km-close svg {
    width: 18px !important;
    height: 18px !important;
    min-width: 18px !important;
    flex-shrink: 0 !important;
    stroke: currentColor;
    stroke-width: 2.2;
    fill: none;
  }

  /* Card Body - Scrollable list with Arrows */
  .a11y-km-body {
    max-height: 400px;
    overflow-y: auto;
    background: #ffffff;
    padding: 6px 0;
  }
  .a11y-km-body::-webkit-scrollbar {
    width: 10px;
  }
  .a11y-km-body::-webkit-scrollbar-track {
    background: #f8fafc;
    border-left: 1px solid #f1f5f9;
  }
  .a11y-km-body::-webkit-scrollbar-thumb {
    background: #94a3b8;
    border-radius: 5px;
    border: 2px solid #f8fafc;
  }
  .a11y-km-body::-webkit-scrollbar-button:single-button:vertical:decrement {
    height: 12px;
    width: 10px;
    background-position: center;
    background-repeat: no-repeat;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8' viewBox='0 0 24 24' fill='%2364748b'%3E%3Cpolygon points='12 5 2 19 22 19'/%3E%3C/svg%3E");
  }
  .a11y-km-body::-webkit-scrollbar-button:single-button:vertical:increment {
    height: 12px;
    width: 10px;
    background-position: center;
    background-repeat: no-repeat;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8' viewBox='0 0 24 24' fill='%2364748b'%3E%3Cpolygon points='12 19 2 5 22 5'/%3E%3C/svg%3E");
  }

  /* Menu Items */
  .a11y-km-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 12px 20px !important;
    margin: 0 !important;
    height: auto !important;
    line-height: 1.35 !important;
    letter-spacing: normal !important;
    text-transform: none !important;
    color: #1e293b;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.15s ease, color 0.15s ease;
    user-select: none;
    border: none;
    background: transparent;
    width: 100%;
    text-align: left;
  }
  .a11y-km-item:hover {
    background: #f1f5f9;
    color: #0f172a;
  }
  .a11y-km-item:focus-visible {
    outline: 2px solid #2563eb;
    outline-offset: -2px;
  }
  .a11y-km-item.active {
    background: #eff6ff;
    color: #1d4ed8;
    font-weight: 600;
  }

  .a11y-km-icon {
    width: 22px;
    height: 22px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: #1e293b;
  }
  .a11y-km-item.active .a11y-km-icon {
    color: #1d4ed8;
  }
  .a11y-km-label {
    flex: 1;
    line-height: 1.35;
  }

  .a11y-km-indicator {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: transparent;
    transition: background 0.15s ease;
  }
  .a11y-km-item.active .a11y-km-indicator {
    background: #10b981;
    box-shadow: 0 0 6px rgba(16, 185, 129, 0.6);
  }

  /* Divider */
  .a11y-km-divider {
    height: 1px;
    background: #e2e8f0;
    margin: 6px 16px;
  }

  @media (max-width: 480px) {
    #a11y-kemenkum-trigger {
      bottom: 20px;
      left: 20px;
      width: 48px;
      height: 48px;
    }
    #a11y-kemenkum-card {
      bottom: 78px;
      left: 16px;
      width: calc(100vw - 32px);
    }
  }
</style>

{{-- ------------------------------------------------------------------------- --}}
{{-- Overlays: Reading Guide & Reading Mask                                    --}}
{{-- ------------------------------------------------------------------------- --}}
<div id="a11y-reading-guide" aria-hidden="true"></div>
<div id="a11y-mask-top" aria-hidden="true"></div>
<div id="a11y-mask-bottom" aria-hidden="true"></div>

{{-- ------------------------------------------------------------------------- --}}
{{-- 1. Floating Launcher Button (Bottom-Left)                                 --}}
{{-- ------------------------------------------------------------------------- --}}
<button type="button" id="a11y-kemenkum-trigger" aria-haspopup="dialog" aria-expanded="false" aria-label="Menu Aksesibilitas (Alt+A)" title="Aksesibilitas (Alt + A)">
  <svg width="30" height="30" viewBox="0 0 24 24" aria-hidden="true">
    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.8" fill="none"/>
    <circle cx="12" cy="6.8" r="1.8" fill="currentColor"/>
    <path d="M12 9.5c-2.8 0-4.8.8-5.3 1.1-.3.1-.4.5-.3.8.1.3.5.4.8.3.1 0 1.9-.7 4.8-.7s4.7.7 4.8.7c.3.1.7 0 .8-.3.1-.3 0-.7-.3-.8-.5-.3-2.5-1.1-5.3-1.1zm-1.8 3l.6 6.8c0 .3.3.6.6.6h1.2c.3 0 .6-.3.6-.6l.6-6.8h-3z" fill="currentColor"/>
  </svg>
  <span class="active-dot" id="a11y-km-badge"></span>
</button>

{{-- ------------------------------------------------------------------------- --}}
{{-- 2. Popup Modal Card (Model JDIH Kemenkumham dengan Fitur Lengkap UserWay) --}}
{{-- ------------------------------------------------------------------------- --}}
<div id="a11y-kemenkum-card" role="dialog" aria-modal="false" aria-label="Pengaturan Aksesibilitas">
  {{-- Header --}}
  <div class="a11y-km-header">
    <h3 class="a11y-km-title">Aksesibilitas</h3>
    <button type="button" class="a11y-km-close" onclick="window.a11yKM.close()" aria-label="Tutup panel aksesibilitas">
      <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
    </button>
  </div>

  {{-- Scrollable Body Item List --}}
  <div class="a11y-km-body">
    
    {{-- 1. Kontras Tinggi (Dark High Contrast) --}}
    <button type="button" class="a11y-km-item" data-action="contrast-high" onclick="window.a11yKM.toggle('contrast-high')">
      <span class="a11y-km-icon">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="9"/>
          <path d="M12 3a9 9 0 0 1 0 18V3z" fill="currentColor"/>
        </svg>
      </span>
      <span class="a11y-km-label">Kontras tinggi</span>
      <span class="a11y-km-indicator"></span>
    </button>

    {{-- 2. Kontras Terang (Light High Contrast) --}}
    <button type="button" class="a11y-km-item" data-action="contrast-light" onclick="window.a11yKM.toggle('contrast-light')">
      <span class="a11y-km-icon">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="4"/>
          <path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/>
          <path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/>
        </svg>
      </span>
      <span class="a11y-km-label">Kontras terang</span>
      <span class="a11y-km-indicator"></span>
    </button>

    {{-- 3. Mode Abu-abu (Monochrome/Grayscale) --}}
    <button type="button" class="a11y-km-item" data-action="monochrome" onclick="window.a11yKM.toggle('monochrome')">
      <span class="a11y-km-icon">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="13.5" cy="6.5" r=".5" fill="currentColor"/>
          <circle cx="17.5" cy="10.5" r=".5" fill="currentColor"/>
          <circle cx="8.5" cy="7.5" r=".5" fill="currentColor"/>
          <circle cx="6.5" cy="12.5" r=".5" fill="currentColor"/>
          <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/>
        </svg>
      </span>
      <span class="a11y-km-label">Mode abu-abu</span>
      <span class="a11y-km-indicator"></span>
    </button>

    {{-- 4. Inversi Warna (Invert Colors) --}}
    <button type="button" class="a11y-km-item" data-action="invert" onclick="window.a11yKM.toggle('invert')">
      <span class="a11y-km-icon">
        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
          <path d="M3 3v5h5"/><path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"/><path d="M16 21h5v-5"/>
        </svg>
      </span>
      <span class="a11y-km-label">Inversi warna</span>
      <span class="a11y-km-indicator"></span>
    </button>

    {{-- 5. Sorot Tautan (Highlight Links) --}}
    <button type="button" class="a11y-km-item" data-action="highlight-links" onclick="window.a11yKM.toggle('highlight-links')">
      <span class="a11y-km-icon">
        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
          <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
        </svg>
      </span>
      <span class="a11y-km-label">Sorot tautan</span>
      <span class="a11y-km-indicator"></span>
    </button>

    {{-- 6. Sorot Judul (Highlight Headings) --}}
    <button type="button" class="a11y-km-item" data-action="highlight-headings" onclick="window.a11yKM.toggle('highlight-headings')">
      <span class="a11y-km-icon">
        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M4 12h16"/><path d="M4 6h16"/><path d="M4 18h10"/>
        </svg>
      </span>
      <span class="a11y-km-label">Sorot judul</span>
      <span class="a11y-km-indicator"></span>
    </button>

    {{-- 7. Font Mudah Dibaca (Dyslexia Friendly Font) --}}
    <button type="button" class="a11y-km-item" data-action="readable-font" onclick="window.a11yKM.toggle('readable-font')">
      <span class="a11y-km-icon" style="font-size: 15px; font-weight: 700; font-family: 'Lexend', sans-serif;">
        Aa
      </span>
      <span class="a11y-km-label">Font mudah dibaca</span>
      <span class="a11y-km-indicator"></span>
    </button>

    {{-- 8. Perbesar Teks (Bigger Text) --}}
    <button type="button" class="a11y-km-item" data-action="text-larger" onclick="window.a11yKM.stepFontSize(1)">
      <span class="a11y-km-icon" style="font-size: 15px; font-weight: 700;">
        A+
      </span>
      <span class="a11y-km-label">Perbesar teks <small id="a11y-font-badge" style="font-size: 11px; color:#64748b; font-weight:600;"></small></span>
      <span class="a11y-km-indicator"></span>
    </button>

    {{-- 9. Perkecil Teks (Smaller Text) --}}
    <button type="button" class="a11y-km-item" data-action="text-smaller" onclick="window.a11yKM.stepFontSize(-1)">
      <span class="a11y-km-icon" style="font-size: 15px; font-weight: 700;">
        A-
      </span>
      <span class="a11y-km-label">Perkecil teks</span>
    </button>

    {{-- 10. Spasi Teks (Text Spacing) --}}
    <button type="button" class="a11y-km-item" data-action="text-spacing" onclick="window.a11yKM.toggle('text-spacing')">
      <span class="a11y-km-icon">
        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="7 8 3 12 7 16"/><polyline points="17 8 21 12 17 16"/><line x1="3" y1="12" x2="21" y2="12"/>
        </svg>
      </span>
      <span class="a11y-km-label">Spasi teks</span>
      <span class="a11y-km-indicator"></span>
    </button>

    {{-- 11. Rata Kiri Teks (Align Left) --}}
    <button type="button" class="a11y-km-item" data-action="align-left" onclick="window.a11yKM.toggle('align-left')">
      <span class="a11y-km-icon">
        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="21" y1="6" x2="3" y2="6"/><line x1="15" y1="12" x2="3" y2="12"/><line x1="17" y1="18" x2="3" y2="18"/>
        </svg>
      </span>
      <span class="a11y-km-label">Rata kiri teks</span>
      <span class="a11y-km-indicator"></span>
    </button>

    {{-- 12. Kursor Besar (Big Cursor) --}}
    <button type="button" class="a11y-km-item" data-action="big-cursor" onclick="window.a11yKM.toggle('big-cursor')">
      <span class="a11y-km-icon">
        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="m3 3 7.07 16.97 2.51-7.39 7.39-2.51L3 3z"/><path d="m13 13 6 6"/>
        </svg>
      </span>
      <span class="a11y-km-label">Kursor besar</span>
      <span class="a11y-km-indicator"></span>
    </button>

    {{-- 13. Panduan Membaca (Reading Guide / Ruler) --}}
    <button type="button" class="a11y-km-item" data-action="reading-guide" onclick="window.a11yKM.toggle('reading-guide')">
      <span class="a11y-km-icon">
        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M21.3 15.3a2.4 2.4 0 0 1 0 3.4l-2.6 2.6a2.4 2.4 0 0 1-3.4 0L2.7 8.7a2.41 2.41 0 0 1 0-3.4l2.6-2.6a2.41 2.41 0 0 1 3.4 0Z"/>
          <path d="m14.5 12.5 2-2"/><path d="m11.5 9.5 2-2"/><path d="m8.5 6.5 2-2"/>
        </svg>
      </span>
      <span class="a11y-km-label">Panduan membaca</span>
      <span class="a11y-km-indicator"></span>
    </button>

    {{-- 14. Masker Fokus Baca (Reading Mask) --}}
    <button type="button" class="a11y-km-item" data-action="reading-mask" onclick="window.a11yKM.toggle('reading-mask')">
      <span class="a11y-km-icon">
        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M18 6 6 18"/><path d="m6 6 12 12"/><circle cx="12" cy="12" r="10"/>
        </svg>
      </span>
      <span class="a11y-km-label">Masker fokus baca</span>
      <span class="a11y-km-indicator"></span>
    </button>

    {{-- 15. Hentikan Animasi (Pause Motion / Animations) --}}
    <button type="button" class="a11y-km-item" data-action="stop-animations" onclick="window.a11yKM.toggle('stop-animations')">
      <span class="a11y-km-icon">
        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="6" y="4" width="4" height="16"/><rect x="14" y="4" width="4" height="16"/>
        </svg>
      </span>
      <span class="a11y-km-label">Hentikan animasi</span>
      <span class="a11y-km-indicator"></span>
    </button>

    {{-- 16. Sembunyikan Gambar (Hide Images) --}}
    <button type="button" class="a11y-km-item" data-action="hide-images" onclick="window.a11yKM.toggle('hide-images')">
      <span class="a11y-km-icon">
        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
          <circle cx="8.5" cy="8.5" r="1.5"/>
          <polyline points="21 15 16 10 5 21"/>
          <line x1="2" y1="2" x2="22" y2="22"/>
        </svg>
      </span>
      <span class="a11y-km-label">Sembunyikan gambar</span>
      <span class="a11y-km-indicator"></span>
    </button>

    {{-- 17. Baca Layar (Screen Reader / Text-to-Speech) --}}
    <button type="button" class="a11y-km-item" data-action="read-screen" onclick="window.a11yKM.startScreenReader()">
      <span class="a11y-km-icon">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/>
          <path d="M15.54 8.46a5 5 0 0 1 0 7.07"/>
          <path d="M19.07 4.93a10 10 0 0 1 0 14.14"/>
        </svg>
      </span>
      <span class="a11y-km-label">Baca layar</span>
      <span class="a11y-km-indicator"></span>
    </button>

    {{-- 18. Hentikan Bacaan --}}
    <button type="button" class="a11y-km-item" data-action="stop-reading" onclick="window.a11yKM.stopReading()">
      <span class="a11y-km-icon">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="10"/>
          <rect x="9" y="9" width="6" height="6" fill="currentColor"/>
        </svg>
      </span>
      <span class="a11y-km-label">Hentikan bacaan</span>
    </button>

    {{-- Separator --}}
    <div class="a11y-km-divider"></div>

    {{-- 19. Atur Ulang (Reset All) --}}
    <button type="button" class="a11y-km-item" onclick="window.a11yKM.reset()">
      <span class="a11y-km-icon">
        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
          <path d="M3 3v5h5"/>
        </svg>
      </span>
      <span class="a11y-km-label">Atur ulang</span>
    </button>

  </div>
</div>

{{-- ------------------------------------------------------------------------- --}}
{{-- Floating Speech Indicator Bar                                             --}}
{{-- ------------------------------------------------------------------------- --}}
<div id="a11y-speech-indicator">
  <span>🔊 Sedang membacakan...</span>
  <button type="button" onclick="window.a11yKM.stopReading()">Hentikan</button>
</div>

{{-- ------------------------------------------------------------------------- --}}
{{-- 5. Controller JavaScript (Pure Native, Zero Lag, State Persistent)        --}}
{{-- ------------------------------------------------------------------------- --}}
<script>
(function() {
  'use strict';

  const STORAGE_KEY = 'jdih_kemenkum_a11y_v2';
  const defaultState = {
    'contrast-high': false,
    'contrast-light': false,
    'monochrome': false,
    'invert': false,
    'highlight-links': false,
    'highlight-headings': false,
    'readable-font': false,
    'fontSizeLevel': 0, // -1 (min), 0 (normal), 1 (+12%), 2 (+24%), 3 (+36%), 4 (+48%)
    'text-spacing': false,
    'align-left': false,
    'big-cursor': false,
    'reading-guide': false,
    'reading-mask': false,
    'stop-animations': false,
    'hide-images': false,
    'reading-active': false
  };

  let state = Object.assign({}, defaultState);

  try {
    const saved = localStorage.getItem(STORAGE_KEY);
    if (saved) {
      state = Object.assign({}, defaultState, JSON.parse(saved));
    }
  } catch(e) {}

  const classMap = {
    'contrast-high': 'a11y-contrast-dark',
    'contrast-light': 'a11y-contrast-light',
    'monochrome': 'a11y-monochrome',
    'invert': 'a11y-invert',
    'highlight-links': 'a11y-highlight-links',
    'highlight-headings': 'a11y-highlight-headings',
    'readable-font': 'a11y-font-dyslexic',
    'text-spacing': 'a11y-spacing',
    'align-left': 'a11y-align-left',
    'big-cursor': 'a11y-big-cursor',
    'reading-guide': 'a11y-guide-active',
    'reading-mask': 'a11y-mask-active',
    'stop-animations': 'a11y-stop-animations',
    'hide-images': 'a11y-hide-images'
  };

  let synth = window.speechSynthesis;
  let clickSpeechHandler = null;

  function save() {
    try {
      localStorage.setItem(STORAGE_KEY, JSON.stringify(state));
    } catch(e) {}
    updateBadge();
  }

  function apply() {
    const html = document.documentElement;

    // Apply font size scale
    html.classList.remove('a11y-text-scale-1', 'a11y-text-scale-2', 'a11y-text-scale-3', 'a11y-text-scale-4', 'a11y-text-scale-min');
    if (state.fontSizeLevel > 0) {
      html.classList.add('a11y-text-scale-' + state.fontSizeLevel);
    } else if (state.fontSizeLevel < 0) {
      html.classList.add('a11y-text-scale-min');
    }

    const fontBadge = document.getElementById('a11y-font-badge');
    if (fontBadge) {
      if (state.fontSizeLevel > 0) {
        const labels = ['', '+12%', '+24%', '+36%', '+48%'];
        fontBadge.textContent = `(${labels[state.fontSizeLevel] || ''})`;
      } else if (state.fontSizeLevel < 0) {
        fontBadge.textContent = '(-10%)';
      } else {
        fontBadge.textContent = '';
      }
    }

    const largerItem = document.querySelector('.a11y-km-item[data-action="text-larger"]');
    if (largerItem) {
      if (state.fontSizeLevel > 0) {
        largerItem.classList.add('active');
      } else {
        largerItem.classList.remove('active');
      }
    }

    // Apply toggle classes
    for (const [key, cls] of Object.entries(classMap)) {
      if (state[key]) {
        html.classList.add(cls);
      } else {
        html.classList.remove(cls);
      }

      const item = document.querySelector(`.a11y-km-item[data-action="${key}"]`);
      if (item) {
        if (state[key]) {
          item.classList.add('active');
        } else {
          item.classList.remove('active');
        }
      }
    }

    const readItem = document.querySelector('.a11y-km-item[data-action="read-screen"]');
    if (readItem) {
      if (state['reading-active']) {
        readItem.classList.add('active');
      } else {
        readItem.classList.remove('active');
      }
    }

    updateBadge();
  }

  function updateBadge() {
    let activeCount = 0;
    if (state.fontSizeLevel !== 0) activeCount++;
    for (const [k, val] of Object.entries(state)) {
      if (k !== 'fontSizeLevel' && val) activeCount++;
    }
    const badge = document.getElementById('a11y-km-badge');
    if (badge) {
      if (activeCount > 0) {
        badge.classList.add('visible');
      } else {
        badge.classList.remove('visible');
      }
    }
  }

  // Mouse tracker for reading guide & mask
  const guideEl = document.getElementById('a11y-reading-guide');
  const maskTop = document.getElementById('a11y-mask-top');
  const maskBottom = document.getElementById('a11y-mask-bottom');

  window.addEventListener('mousemove', function(e) {
    if (state['reading-guide'] && guideEl) {
      guideEl.style.top = e.clientY + 'px';
    }
    if (state['reading-mask'] && maskTop && maskBottom) {
      const slitHeight = 110;
      const topHeight = Math.max(0, e.clientY - (slitHeight / 2));
      const bottomTop = e.clientY + (slitHeight / 2);
      maskTop.style.top = '0px';
      maskTop.style.height = topHeight + 'px';
      maskBottom.style.top = bottomTop + 'px';
      maskBottom.style.height = (window.innerHeight - bottomTop) + 'px';
    }
  });

  // --- Web Speech API (Text-to-Speech) ---
  function speak(text) {
    if (!synth) return;
    synth.cancel();
    if (!text || !text.trim()) return;

    const utter = new SpeechSynthesisUtterance(text.trim());
    utter.lang = 'id-ID';
    utter.rate = 0.95;

    const bar = document.getElementById('a11y-speech-indicator');
    if (bar) bar.classList.add('visible');

    utter.onend = function() {
      if (bar) bar.classList.remove('visible');
    };
    utter.onerror = function() {
      if (bar) bar.classList.remove('visible');
    };

    synth.speak(utter);
  }

  function handlePageClickToRead(e) {
    if (!state['reading-active']) return;
    if (e.target.closest('#a11y-kemenkum-card') || e.target.closest('#a11y-kemenkum-trigger') || e.target.closest('#a11y-speech-indicator')) {
      return;
    }

    const sel = window.getSelection() ? window.getSelection().toString() : '';
    if (sel && sel.trim().length > 0) {
      speak(sel);
      return;
    }

    const target = e.target.closest('h1, h2, h3, h4, h5, h6, p, td, th, li, a');
    if (target) {
      speak(target.innerText || target.textContent);
    }
  }

  window.a11yKM = {
    open: function() {
      const card = document.getElementById('a11y-kemenkum-card');
      const btn = document.getElementById('a11y-kemenkum-trigger');
      if (card) card.classList.add('open');
      if (btn) btn.setAttribute('aria-expanded', 'true');
    },

    close: function() {
      const card = document.getElementById('a11y-kemenkum-card');
      const btn = document.getElementById('a11y-kemenkum-trigger');
      if (card) card.classList.remove('open');
      if (btn) btn.setAttribute('aria-expanded', 'false');
    },

    toggleCard: function() {
      const card = document.getElementById('a11y-kemenkum-card');
      if (card && card.classList.contains('open')) {
        this.close();
      } else {
        this.open();
      }
    },

    stepFontSize: function(delta) {
      state.fontSizeLevel = Math.max(-1, Math.min(4, state.fontSizeLevel + delta));
      apply();
      save();
    },

    toggle: function(action) {
      // Mutual exclusion for contrast modes
      if (action === 'contrast-high' && !state['contrast-high']) {
        state['contrast-light'] = false;
        state['monochrome'] = false;
        state['invert'] = false;
      } else if (action === 'contrast-light' && !state['contrast-light']) {
        state['contrast-high'] = false;
        state['monochrome'] = false;
        state['invert'] = false;
      } else if (action === 'monochrome' && !state['monochrome']) {
        state['contrast-high'] = false;
        state['contrast-light'] = false;
      } else if (action === 'invert' && !state['invert']) {
        state['contrast-high'] = false;
        state['contrast-light'] = false;
      }

      state[action] = !state[action];
      apply();
      save();
    },

    startScreenReader: function() {
      state['reading-active'] = true;
      apply();
      save();

      if (!clickSpeechHandler) {
        clickSpeechHandler = handlePageClickToRead;
        document.addEventListener('mouseup', clickSpeechHandler);
      }

      speak('Mode baca layar aktif. Silakan klik teks atau judul yang ingin didengarkan.');
    },

    stopReading: function() {
      if (synth) synth.cancel();
      state['reading-active'] = false;
      const bar = document.getElementById('a11y-speech-indicator');
      if (bar) bar.classList.remove('visible');
      apply();
      save();
    },

    reset: function() {
      state = Object.assign({}, defaultState);
      this.stopReading();
      apply();
      save();
    }
  };

  // Keyboard shortcut Alt+A & Escape
  window.addEventListener('keydown', function(e) {
    if (e.altKey && (e.key === 'a' || e.key === 'A')) {
      e.preventDefault();
      window.a11yKM.toggleCard();
    } else if (e.key === 'Escape') {
      window.a11yKM.close();
    }
  });

  // Close when clicking outside
  document.addEventListener('click', function(e) {
    const card = document.getElementById('a11y-kemenkum-card');
    const trigger = document.getElementById('a11y-kemenkum-trigger');
    if (card && card.classList.contains('open')) {
      if (!card.contains(e.target) && !trigger.contains(e.target)) {
        window.a11yKM.close();
      }
    }
  });

  // Setup click trigger
  document.addEventListener('DOMContentLoaded', function() {
    const trigger = document.getElementById('a11y-kemenkum-trigger');
    if (trigger) {
      trigger.addEventListener('click', function(e) {
        e.stopPropagation();
        window.a11yKM.toggleCard();
      });
    }
    apply();
  });

  // Apply immediately to avoid FOUC
  apply();
})();
</script>
