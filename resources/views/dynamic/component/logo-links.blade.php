@once
<style>
  .logo-multi {
    position: relative !important;
    display: inline-flex !important;
    align-items: center;
    line-height: 0;
    max-width: 100%;
  }
  .logo-multi img {
    max-width: 100%;
  }
  .logo-multi .logo-hotspot,
  header .logo-multi a.logo-hotspot,
  footer .top .box .logo-multi a.logo-hotspot {
    position: absolute !important;
    top: 0 !important;
    bottom: 0 !important;
    z-index: 5 !important;
    display: block !important;
    margin: 0 !important;
    padding: 0 !important;
    opacity: 1 !important;
    background: transparent !important;
    border: none !important;
    text-decoration: none !important;
    cursor: pointer !important;
  }
  .logo-multi .logo-hotspot:focus-visible {
    outline: 2px solid #fbbf24 !important;
    outline-offset: -2px !important;
    border-radius: 6px;
  }
  .logo-multi .logo-hotspot--jdihn {
    left: 0 !important;
    width: 22% !important;
  }
  .logo-multi .logo-hotspot--kemenko {
    left: 22% !important;
    width: 24% !important;
  }
  .logo-multi .logo-hotspot--jdih {
    left: 46% !important;
    width: 54% !important;
  }
</style>
@endonce
@php($jdihHomeUrl = $homeUrl ?? url('/'))
<a href="https://jdihn.go.id/"
   class="logo-hotspot logo-hotspot--jdihn"
   target="_blank"
   rel="noopener noreferrer"
   title="Website Resmi JDIHN"
   aria-label="Website Resmi JDIHN"></a>
<a href="https://kemenkopangan.go.id/"
   class="logo-hotspot logo-hotspot--kemenko"
   target="_blank"
   rel="noopener noreferrer"
   title="Website Resmi Kementerian Koordinator Bidang Pangan"
   aria-label="Website Resmi Kementerian Koordinator Bidang Pangan"></a>
<a href="{{ $jdihHomeUrl }}"
   class="logo-hotspot logo-hotspot--jdih"
   title="Beranda JDIH Kementerian Koordinator Bidang Pangan"
   aria-label="Beranda JDIH Kementerian Koordinator Bidang Pangan"></a>
