<div class="wrapper">
  <div class="logo logo-multi">
    <img class="white" src="{{ media::initial(conf('site-setting')->value('logo'))->url }}" alt="{{ media::initial(conf('site-setting')->value('logo'))->alt }}">
    <img class="black" src="{{ media::initial(conf('site-setting')->value('logo-floating'))->url }}" alt="{{ media::initial(conf('site-setting')->value('logo-floating'))->alt }}">
    @include('dynamic.component.logo-links', ['homeUrl' => lang::url('/')])
  </div>
  <div class="right-header">
@php
  if (!function_exists('getJdihnMenuMeta')) {
    function getJdihnMenuMeta($label, $permalink = '') {
      $norm = strtolower(trim($label));
      
      // 1. Peraturan
      if (str_contains($norm, 'peraturan') && !str_contains($norm, 'terjemahan') && !str_contains($norm, 'program')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m16 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"/><path d="m2 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"/><path d="M7 21h10"/><path d="M12 3v18"/><path d="M3 7h2c2 0 5-1 7-2 2 1 5 2 7 2h2"/></svg>',
          'desc' => 'Peraturan perundang-undangan dan regulasi pemerintah'
        ];
      }
      
      // 2. Hasil Analisis Evaluasi / Analisis Evaluasi PUU / Anev
      if (str_contains($norm, 'analisis') || str_contains($norm, 'evaluasi') || str_contains($norm, 'anev')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>',
          'desc' => 'Hasil analisis dan evaluasi peraturan'
        ];
      }
      
      // 3. Naskah Akademik / Naskah Urgensi
      if (str_contains($norm, 'naskah akademik') || str_contains($norm, 'naskah urgensi') || str_contains($norm, 'akademik')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>',
          'desc' => 'Naskah akademik rancangan peraturan'
        ];
      }
      
      // 4. Putusan / Yurisprudensi
      if (str_contains($norm, 'putusan') || str_contains($norm, 'yurisprudensi')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m14 13-7.5 7.5c-.83.83-2.17.83-3 0 0 0 0 0 0 0a2.12 2.12 0 0 1 0-3L11 10"/><path d="m16 16 6-6"/><path d="m8 8 6-6"/><path d="m9 7 8 8"/><path d="m21 11-8-8"/></svg>',
          'desc' => 'Putusan pengadilan dan yurisprudensi'
        ];
      }
      
      // 5. Monografi
      if (str_contains($norm, 'monografi')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/><path d="M6 6h10"/><path d="M6 10h10"/><path d="M6 14h6"/></svg>',
          'desc' => 'Buku dan karya ilmiah bidang hukum'
        ];
      }
      
      // 6. Artikel / Majalah / Jurnal
      if (str_contains($norm, 'artikel') || str_contains($norm, 'majalah') || str_contains($norm, 'jurnal')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8V6Z"/></svg>',
          'desc' => 'Artikel dan jurnal ilmiah hukum'
        ];
      }
      
      // 7. Perjanjian Kerja Sama / Naskah Kerja Sama
      if (str_contains($norm, 'kerja sama') || str_contains($norm, 'kerjasama') || str_contains($norm, 'perjanjian')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m11 17 2 2a1 1 0 0 0 1.4 0l6.6-6.6a2 2 0 0 0 0-2.8l-3.6-3.6a2 2 0 0 0-2.8 0L13 7.6"/><path d="m7 7-2 2a1 1 0 0 0 0 1.4l6.6 6.6a2 2 0 0 0 2.8 0l3.6-3.6a2 2 0 0 0 0-2.8L16.4 9"/><path d="M2 13l3.6 3.6a2 2 0 0 0 2.8 0L11 14"/></svg>',
          'desc' => 'Perjanjian kerja sama antar lembaga'
        ];
      }
      
      // 8. Era Kolonial / Peraturan Terjemahan
      if (str_contains($norm, 'kolonial') || str_contains($norm, 'terjemahan')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="21" x2="21" y2="21"/><line x1="6" y1="21" x2="6" y2="10"/><line x1="10" y1="21" x2="10" y2="10"/><line x1="14" y1="21" x2="14" y2="10"/><line x1="18" y1="21" x2="18" y2="10"/><polygon points="12 3 2 9 22 9 12 3"/></svg>',
          'desc' => str_contains($norm, 'kolonial') ? 'Era Kolonial' : 'Terjemahan resmi peraturan perundang-undangan'
        ];
      }
      
      // 9. Program Penyusunan PUU
      if (str_contains($norm, 'program penyusunan') || str_contains($norm, 'program')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><path d="m9 16 2 2 4-4"/></svg>',
          'desc' => 'Program perencanaan penyusunan PUU'
        ];
      }
      
      // 10. Rancangan PUU
      if (str_contains($norm, 'rancangan')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>',
          'desc' => 'Draf rancangan peraturan perundang-undangan'
        ];
      }
      
      // 11. Risalah Pembahasan
      if (str_contains($norm, 'risalah')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/><path d="M9 12h6"/><path d="M9 16h6"/></svg>',
          'desc' => 'Catatan dan risalah rapat pembahasan PUU'
        ];
      }
      
      // 12. Kajian Hukum
      if (str_contains($norm, 'kajian')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/><path d="M11 8v6"/><path d="M8 11h6"/></svg>',
          'desc' => 'Hasil telaah dan kajian komprehensif hukum'
        ];
      }

      // 12a. Pengajuan PUU (e-Regulasi)
      if (str_contains($norm, 'pengajuan puu') || str_contains($norm, 'e-regulasi') || str_contains($norm, 'puu submission')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h6v6"/><path d="M10 14 21 3"/><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/></svg>',
          'desc' => 'Layanan pengajuan dan penyusunan regulasi (e-Regulasi)'
        ];
      }

      // 12b. Pengajuan Harmonisasi
      if (str_contains($norm, 'harmonisasi')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m16 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"/><path d="m2 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"/><path d="M7 21h10"/><path d="M12 3v18"/><path d="M3 7h2c2 0 5-1 7-2 2 1 5 2 7 2h2"/></svg>',
          'desc' => 'Prosedur dan pengajuan harmonisasi PUU'
        ];
      }

      // 12c. Permohonan Pengundangan
      if (str_contains($norm, 'pengundangan')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><polyline points="10 9 9 9 8 9"/></svg>',
          'desc' => 'Permohonan dan verifikasi pengundangan PUU'
        ];
      }
      
      // 13. Partisipasi Publik
      if (str_contains($norm, 'partisipasi')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
          'desc' => 'Konsultasi dan partisipasi publik regulasi'
        ];
      }
      
      // 14. Visi Misi
      if (str_contains($norm, 'visi')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>',
          'desc' => 'Visi, misi, dan arah strategis Kemenko Pangan'
        ];
      }
      
      // 15. Dasar Hukum
      if (str_contains($norm, 'dasar hukum')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>',
          'desc' => 'Landasan regulasi pengelolaan sistem JDIH'
        ];
      }
      
      // 16. Struktur Organisasi
      if (str_contains($norm, 'struktur')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>',
          'desc' => 'Bagan susunan organisasi dan tim pengelola'
        ];
      }
      
      // 17. SOP
      if (str_contains($norm, 'sop')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>',
          'desc' => 'Standar operasional prosedur pengelolaan JDIH'
        ];
      }
      
      // 18. Statistik
      if (str_contains($norm, 'statistik')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="20" x2="12" y2="10"/><line x1="18" y1="20" x2="18" y2="4"/><line x1="6" y1="20" x2="6" y2="16"/></svg>',
          'desc' => 'Data statistik dokumen dan kunjungan portal'
        ];
      }
      
      // 19. Berita
      if (str_contains($norm, 'berita')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v1m2 13a2 2 0 0 1-2-2V7m2 13a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>',
          'desc' => 'Kabar dan dokumentasi kegiatan hukum terbaru'
        ];
      }
      
      // 20. Galeri / Gallery
      if (str_contains($norm, 'galeri') || str_contains($norm, 'gallery')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>',
          'desc' => 'Dokumentasi foto kegiatan dan koordinasi'
        ];
      }
      
      // 21. Infografis
      if (str_contains($norm, 'infografis')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>',
          'desc' => 'Ringkasan visual peraturan dan kebijakan'
        ];
      }
      
      // 22. Videografis
      if (str_contains($norm, 'videografis') || str_contains($norm, 'video')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>',
          'desc' => 'Media sosialisasi kebijakan dalam bentuk video'
        ];
      }
      
      // 23. Aksesibilitas
      if (str_contains($norm, 'aksesibilitas')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="4" r="2"/><path d="m4.5 7.5 7.5 3.5 7.5-3.5"/><path d="M12 11v10"/><path d="m6 21 6-5 6 5"/></svg>',
          'desc' => 'Kemudahan akses'
        ];
      }
      
      // 24. Foto dan Video
      if (str_contains($norm, 'foto')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>',
          'desc' => 'Dokumentasi foto dan video kegiatan Kemenko Pangan'
        ];
      }
      
      // Default fallback
      return [
        'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>',
        'desc' => 'Dokumentasi dan informasi hukum terkait'
      ];
    }
  }
@endphp

    <nav>
      <ul>
        @if(!collect($mainMenu)->contains('type', 'home'))
        <li>
          <a href="{{ lang::url('/') }}" @class(['active' => request()->is('/') || request()->is(lang::active()) || (isset($home) && !isset($menu)) || request()->routeIs('home')])>{{ lang::active() == 'en' ? 'Home' : 'Beranda' }}</a>
        </li>
        @endif
        @foreach($mainMenu as $main)
        @php
          $childs = $main->childs()->fe()->get()->unique('label');
        @endphp
        @if($childs->count() > 0)
        <li class="have-child">
          <a href="{{ $main->fullUrl }}" class="nav-parent-link @if(isset($menu) && in_array($main->id, $menu->activeIds)) active @endif">
            <span>{{ $main->label }}</span>
            <svg class="nav-chevron" width="12" height="12" viewBox="0 0 12 12" fill="none">
              <path d="M2.5 4.5L6 8L9.5 4.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </a>
          <div class="child jdihn-mega-menu">
            <div class="jdihn-mega-grid @if($childs->count() <= 3) single-col @endif">
              @foreach($childs as $child)
              @php
                $meta = getJdihnMenuMeta($child->label, $child->fullUrl);
                $subchilds = $child->childs()->fe()->get();
                $itemHost = parse_url($child->fullUrl, PHP_URL_HOST);
                $appHost = request()->getHost();
                $isExternal = ($itemHost && $itemHost !== $appHost && !in_array($itemHost, ['localhost', '127.0.0.1', 'jdih.kemenkopangan.go.id'])) || str_contains($child->fullUrl, 'regulasikemenkopangan.id');
              @endphp
              @if($subchilds->count() > 0)
              <div class="jdihn-item jdihn-item-has-children @if(isset($menu) && (in_array($child->id, $menu->activeIds) || $subchilds->pluck('id')->intersect($menu->activeIds ?? [])->isNotEmpty())) active @endif" data-href="{{ $child->fullUrl }}" data-external="{{ $isExternal ? '1' : '0' }}" role="link" tabindex="0">
                <a href="{{ $child->fullUrl }}" class="jdihn-item-icon-link" @if($isExternal) target="_blank" rel="noopener noreferrer" @endif>
                  <div class="jdihn-item-icon">
                    {!! $meta['icon'] !!}
                  </div>
                </a>
                <div class="jdihn-item-content">
                  <div class="jdihn-item-title-row">
                    <a href="{{ $child->fullUrl }}" class="jdihn-item-title" style="text-decoration: none;" @if($isExternal) target="_blank" rel="noopener noreferrer" @endif>{{ $child->label }}</a>
                  </div>
                  @if(!empty($meta['desc']))
                  <a href="{{ $child->fullUrl }}" class="jdihn-item-desc" style="text-decoration: none;" @if($isExternal) target="_blank" rel="noopener noreferrer" @endif>{{ $meta['desc'] }}</a>
                  @endif
                  <div class="jdihn-subchild-links">
                    @foreach($subchilds as $sc)
                      @php
                        $scHost = parse_url($sc->fullUrl, PHP_URL_HOST);
                        $scIsExt = ($scHost && $scHost !== $appHost && !in_array($scHost, ['localhost', '127.0.0.1', 'jdih.kemenkopangan.go.id'])) || str_contains($sc->fullUrl, 'regulasikemenkopangan.id');
                        $scIsActive = isset($menu) && in_array($sc->id, $menu->activeIds ?? []);
                        $urlOrLabel = strtoupper($sc->fullUrl . ' ' . $sc->label);
                        $isCourtDecision = str_contains(strtoupper($child->label), 'PUTUSAN');
                        $isMk = str_contains($urlOrLabel, 'KONSTITUSI') || str_contains($urlOrLabel, 'CONSTITUTIONAL') || str_contains($urlOrLabel, '(MK)') || str_contains($urlOrLabel, 'MAHKAMAH-KONSTITUSI');
                        $code = $isMk ? 'MK' : 'MA';
                        $shortLabel = $isCourtDecision ? ($isMk ? 'Mahkamah Konstitusi' : 'Mahkamah Agung') : $sc->label;
                      @endphp
                      @php
                        $rawScUrl = $sc->fullUrl;
                        if (str_contains(strtolower($sc->label ?? ''), 'videografis') || str_contains(strtolower((string)$rawScUrl), '/videografis')) {
                          $rawScUrl = lang::url('/aksesibilitas');
                        }
                      @endphp
                      <a href="{{ $rawScUrl }}" class="jdihn-subchild-chip @if($scIsActive) active @endif @if($isCourtDecision) @if($isMk) is-mk @else is-ma @endif @endif" @if($scIsExt) target="_blank" rel="noopener noreferrer" @endif>
                        @if($isCourtDecision)
                          <span class="chip-code">{{ $code }}</span>
                        @endif
                        <span class="chip-label">{{ $shortLabel }}</span>
                        <svg class="chip-arrow" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                      </a>
                    @endforeach
                  </div>
                </div>
              </div>
              @else
              <a href="{{ $child->fullUrl }}" class="jdihn-item @if(isset($menu) && in_array($child->id, $menu->activeIds)) active @endif" @if($isExternal) target="_blank" rel="noopener noreferrer" @endif>
                <div class="jdihn-item-icon">
                  {!! $meta['icon'] !!}
                </div>
                <div class="jdihn-item-content">
                  <div class="jdihn-item-title-row">
                    <div class="jdihn-item-title">{{ $child->label }}</div>
                  </div>
                  <div class="jdihn-item-desc">{{ $meta['desc'] }}</div>
                </div>
              </a>
              @endif
              @endforeach
            </div>
          </div>
        </li>
        @else
        @php($isKemenkoPangan = str_contains(strtolower($main->label ?? ''), 'kemenko pangan'))
        <li>
          @if($isKemenkoPangan)
          <a href="{{ $main->fullUrl ?: 'https://kemenkopangan.go.id/' }}" class="nav-kemenko-btn" target="_blank" rel="noopener noreferrer" title="Website Resmi Kementerian Koordinator Bidang Pangan">
            <span class="nav-kemenko-btn__text">
              <span>Kemenko</span>
              <span>Pangan</span>
            </span>
            <svg class="nav-kemenko-btn__arrow" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <line x1="7" y1="17" x2="17" y2="7"></line>
              <polyline points="7 7 17 7 17 17"></polyline>
            </svg>
          </a>
          @else
          <a href="{{ $main->fullUrl }}" @class(['active' => (isset($menu) && in_array($main->id, $menu->activeIds)) || ($main->type == 'home' && (request()->is('/') || request()->is(lang::active()) || (isset($home) && !isset($menu)) || request()->routeIs('home')))])>{{ $main->label }}</a>
          @endif
        </li>
        @endif
        @endforeach
        @if(!collect($mainMenu)->contains(fn($m) => str_contains(strtolower($m->label ?? ''), 'kemenko pangan')))
        <li>
          <a href="https://kemenkopangan.go.id/" class="nav-kemenko-btn" target="_blank" rel="noopener noreferrer" title="Website Resmi Kementerian Koordinator Bidang Pangan">
            <span class="nav-kemenko-btn__text">
              <span>Kemenko</span>
              <span>Pangan</span>
            </span>
            <svg class="nav-kemenko-btn__arrow" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <line x1="7" y1="17" x2="17" y2="7"></line>
              <polyline points="7 7 17 7 17 17"></polyline>
            </svg>
          </a>
        </li>
        @endif
      </ul>
    </nav>
    <div class="right-header__theme">
      <button type="button" class="theme-toggle-btn" aria-label="Toggle Dark Mode" title="Ganti Mode Gelap / Terang">
        <span class="theme-toggle-icon">
          <!-- Sun icon (visible in dark mode to switch to light) -->
          <svg class="icon-sun" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="5"></circle>
            <line x1="12" y1="1" x2="12" y2="3"></line>
            <line x1="12" y1="21" x2="12" y2="23"></line>
            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
            <line x1="1" y1="12" x2="3" y2="12"></line>
            <line x1="21" y1="12" x2="23" y2="12"></line>
            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
          </svg>
          <!-- Moon icon (visible in light mode to switch to dark) -->
          <svg class="icon-moon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
          </svg>
        </span>
      </button>
    </div>
    <div class="right-header__lang">
      @if (lang::active() == 'en')
      <img src="{{asset('images/material/US.svg')}}" alt="" width="30" height="30" style="border: 0px solid transparent; border-radius: 50%">
      @else
      <img src="{{asset('images/material/IND.svg')}}" alt="" width="30" height="30" style="border: 0px solid transparent; border-radius: 50%">
      @endif
      <div class="drop-language">
        <a href="{{ url()->lang('id') }}"><img src="{{ asset('images/material/IND.svg') }}" width="22" height="20" alt=""></a>
        <a href="{{ url()->lang('en') }}"><img src="{{ asset('images/material/US.svg') }}" width="22" height="20" alt=""></a>
      </div>
    </div>
    <div class="toggle-menu">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
</div>
@if (!is_null($menu_peraturan_front))
<div class="header-bot">
  <div class="wrapper">
    <form action="{{ $menu_peraturan_front->permalink }}" id="frm-search-global">
      <input type="text" name="search" placeholder="{{ lang::translate('global.search') }}">
    </form>
  </div>
</div>
@endif

<div class="popup popup-login" id="popup-login">
  <div class="popup__overlay"></div>
  <div class="popup__box popup__box--large">
    <div class="popup__content">
      <figure>
        <img 
        src="{{ media::initial(conf('site-setting')->value('login-image'))->url }}"
        data-img-large="{{ media::initial(conf('site-setting')->value('login-image'))->url }}"
        data-img-medium="{{ media::initial(conf('site-setting')->value('login-image-medium'))->url }}"
        data-img-small="{{ media::initial(conf('site-setting')->value('login-image-small'))->url }}" alt="{{ media::initial(conf('site-setting')->value('login-image'))->alt }}">
      </figure>
      <figcaption>
        <h5> {{ lang::translate('dashboard.form-login.title-form-login') }} </h5>
        <p>{{ lang::translate('dashboard.form-login.intro-form-login') }}</p>
        <form method="POST" action="{{ route('login') }}">
          @csrf
          <div class="row row-wrap">
            <div class="column column-100">
              <label for="">{{ lang::translate('dashboard.form-login.label-email') }}</label>
              <input type="email" name="email" placeholder="{{ lang::translate('dashboard.form-login.placeholder-email') }}" value="{{ old('email') }}">
            </div>
            <div class="column column-100">
              <label for="">{{ lang::translate('dashboard.form-login.label-password') }}</label>
              <div class="password">
                <input type="password" name="password" id="password" placeholder="Password" class="textfield-large">
                <div class="icon">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M2.28282 9.27342C4.69299 5.94267 8.19618 3.96997 12.0001 3.96997C13.3516 3.96997 14.6696 4.21968 15.9155 4.69366C16.3027 4.84093 16.4971 5.27417 16.3498 5.66131C16.2026 6.04846 15.7693 6.24292 15.3822 6.09564C14.3025 5.68491 13.165 5.46997 12.0001 5.46997C8.74418 5.46997 5.66753 7.15436 3.49771 10.1532L3.49699 10.1542C3.15906 10.6197 2.96509 11.2866 2.96509 11.995C2.96509 12.7033 3.15906 13.3703 3.49699 13.8357L3.49771 13.8367C3.92875 14.4325 4.39582 14.9764 4.89281 15.4654C5.18805 15.7559 5.19187 16.2308 4.90134 16.526C4.61081 16.8213 4.13596 16.8251 3.84072 16.5346C3.28231 15.9851 2.76097 15.3774 2.28246 14.716C1.72089 13.942 1.46509 12.9478 1.46509 11.995C1.46509 11.0419 1.721 10.0475 2.28282 9.27342ZM18.773 7.18838C19.0535 6.88361 19.528 6.86393 19.8328 7.14444C20.5155 7.77278 21.147 8.48525 21.7177 9.27392C22.2793 10.0479 22.5351 11.0421 22.5351 11.995C22.5351 12.948 22.2791 13.9424 21.7173 14.7165C19.3072 18.0473 15.804 20.02 12.0001 20.02C10.5115 20.02 9.06389 19.717 7.70857 19.1455C7.32691 18.9846 7.14798 18.5447 7.30893 18.163C7.46988 17.7813 7.90976 17.6024 8.29142 17.7634C9.46758 18.2594 10.7173 18.52 12.0001 18.52C15.256 18.52 18.3326 16.8356 20.5024 13.8367L20.5032 13.8357C20.8411 13.3703 21.0351 12.7033 21.0351 11.995C21.0351 11.2866 20.8411 10.6197 20.5032 10.1542L20.5024 10.1532C19.9884 9.44277 19.4231 8.80602 18.817 8.24813C18.5122 7.96762 18.4925 7.49316 18.773 7.18838Z" fill="black"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 9.75C10.755 9.75 9.75 10.755 9.75 12C9.75 12.5484 9.94405 13.0481 10.2674 13.4375C10.532 13.7562 10.4881 14.229 10.1694 14.4936C9.85076 14.7582 9.37792 14.7144 9.11332 14.3957C8.57407 13.7462 8.25 12.9102 8.25 12C8.25 9.92657 9.92657 8.25 12 8.25C13.0215 8.25 13.9486 8.658 14.6243 9.31951C14.9203 9.60929 14.9253 10.0841 14.6355 10.3801C14.3457 10.6761 13.8709 10.6811 13.5749 10.3913C13.1691 9.99399 12.6147 9.75 12 9.75ZM15 11.25C15.4142 11.25 15.75 11.5858 15.75 12C15.75 14.0734 14.0734 15.75 12 15.75C11.5858 15.75 11.25 15.4142 11.25 15C11.25 14.5858 11.5858 14.25 12 14.25C13.245 14.25 14.25 13.245 14.25 12C14.25 11.5858 14.5858 11.25 15 11.25Z" fill="black"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M22.5533 2.19366C22.8329 2.49926 22.8119 2.97366 22.5063 3.25328L2.5063 21.5533C2.2007 21.8329 1.7263 21.8118 1.44668 21.5062C1.16706 21.2006 1.18812 20.7262 1.49371 20.4466L21.4937 2.14663C21.7993 1.86701 22.2737 1.88807 22.5533 2.19366Z" fill="black"/>
                  </svg>
                </div>
              </div>
            </div>
            <div class="column column-100">
              <div class="recaptcha-container"></div>
              <div class="supporting-text">@error('g-recaptcha-response'){{ $message }}@enderror</div>
            </div>
            <div class="column column-100">
              <button type="submit" class="button button-gradient button-full">{{ lang::translate('dashboard.form-login.button-submit-login') }}</button>
            </div>
            <div class="column column-100">
              <div id="login-error" style="color:#ffdddd; background:#7f1d1d; padding:8px 12px; border-radius:6px; display:none;"></div>
            </div>
          </div>
        </form>
        <small>{!! og::copyright() !!}</small>
      </figcaption>
    </div>
  </div>
</div>

@if (Auth::guard('account')->check())
<form method="POST" id="form-logout" action="{{ route('logout') }}">
  @csrf
</form>
@endif
@push('footer')
<script>
  (function() {
    const popup = document.getElementById('popup-login');
    if (!popup) return;
    const form = popup.querySelector('form');
    const errorBox = document.getElementById('login-error');
    if (!form) return;
    let successLogin = false;
    form.addEventListener('submit', async function(e) {
      e.preventDefault();
      if (errorBox) {
        errorBox.style.display = 'none';
        errorBox.textContent = '';
      }
      const submitBtn = form.querySelector('button[type="submit"]');
      const originalText = submitBtn ? submitBtn.textContent : '';
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.style.background = "grey";
        submitBtn.textContent = "{{ lang::translate('dashboard.form-login.process') }}";
      }
      try {
        const formData = new FormData(form);
        const res = await fetch(form.action, {
          method: 'POST',
          headers: { 'Accept': 'application/json' },
          body: formData,
          credentials: 'same-origin'
        });
        if (res.ok) {
          const data = await res.json();
          if (data && data.redirect) {
            window.location.href = data.redirect;
          } else {
            window.location.href = "{{ route('dashboard') }}";
          }

          successLogin = true;
          return;
        }
        // handle validation/auth errors
        let msg = "{{ lang::translate('dashboard.form-login.unknown-user') }}";
        try {
          const data = await res.json();
          if (data && (data.message || data.errors)) {
            if (data.errors != undefined) {
              msg = '';
              for (const key in data.errors) {
                if (data.errors.hasOwnProperty(key)) {
                  const value = data.errors[key]
                  msg += value[0]+'<br>';
                }
              }
            } else {
              msg = data.message;
            }
          }
        } catch (_) {}
        if (errorBox) {
          errorBox.innerHTML = msg;
          errorBox.style.display = 'block';
        } else {
          alert(msg);
        }
      } catch (err) {
        if (errorBox) {
          errorBox.textContent = "{{ lang::translate('dashboard.form-login.failed-network') }}";
          errorBox.style.display = 'block';
        } else {
          alert("{{ lang::translate('dashboard.form-login.failed-network') }}");
        }
      } finally {
        resetRecaptcha('.recaptcha-container');
        if (submitBtn && successLogin == false) {
          submitBtn.disabled = false;
          submitBtn.style.background = "";
          submitBtn.textContent = originalText;
        }
      }
    });
  })();
  </script>
@endpush

<section class="menu-mobile">
  <nav>
    <ul>
      @if(!collect($mainMenu)->contains('type', 'home'))
      <li>
        <a href="{{ lang::url('/') }}" @class(['active' => request()->is('/') || request()->is(lang::active()) || (isset($home) && !isset($menu)) || request()->routeIs('home')])>{{ lang::active() == 'en' ? 'Home' : 'Beranda' }}</a>
      </li>
      @endif
      @foreach($mainMenu as $main)
      @php($childs = $main->childs()->fe()->get())
      @if($childs->count() > 0)
      <li>
        <a href="{{ $main->fullUrl }}" @class(['active' => isset($menu) && in_array($main->id, $menu->activeIds)])>{{ $main->label }}</a>
        <i class="wa-icon wa-ic-chevron-down-solid"></i>
        <div class="child">
          @foreach($childs as $child)
          @php($isChildExt = $child->type == 'url' || str_starts_with($child->fullUrl, 'http://') || str_starts_with($child->fullUrl, 'https://') || str_contains($child->fullUrl, 'pengajuan-puu'))
          <a href="{{ $child->fullUrl }}" @class(['active' => isset($menu) && in_array($child->id, $menu->activeIds)]) @if($isChildExt) target="_blank" rel="noopener noreferrer" @endif>{{ $child->label }}</a>
          @php($subchilds = $child->childs()->fe()->get())
          @foreach($subchilds as $sc)
          @php($scMobUrl = (str_contains(strtolower($sc->label ?? ''), 'videografis') || str_contains(strtolower((string)$sc->fullUrl), '/videografis')) ? lang::url('/aksesibilitas') : $sc->fullUrl)
          <a href="{{ $scMobUrl }}" class="subchild-item" style="padding-left: 28px !important; font-size: 13px !important; opacity: 0.88 !important;">↳ {{ $sc->label }}</a>
          @endforeach
          @endforeach
        </div>
      </li>
      @else
      @php($isKemenkoPangan = str_contains(strtolower($main->label ?? ''), 'kemenko pangan'))
      <li>
        @if($isKemenkoPangan)
        <a href="{{ $main->fullUrl ?: 'https://kemenkopangan.go.id/' }}" class="nav-kemenko-btn nav-kemenko-btn--mobile" target="_blank" rel="noopener noreferrer" title="Website Resmi Kementerian Koordinator Bidang Pangan">
          <span class="nav-kemenko-btn__text">
            <span>Kemenko</span>
            <span>Pangan</span>
          </span>
          <svg class="nav-kemenko-btn__arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <line x1="7" y1="17" x2="17" y2="7"></line>
            <polyline points="7 7 17 7 17 17"></polyline>
          </svg>
        </a>
        @else
        <a href="{{ $main->fullUrl }}" @class(['active' => (isset($menu) && in_array($main->id, $menu->activeIds)) || ($main->type == 'home' && (request()->is('/') || request()->is(lang::active()) || (isset($home) && !isset($menu)) || request()->routeIs('home')))])>{{ $main->label }}</a>
        @endif
      </li>
      @endif
      @endforeach
      @if(!collect($mainMenu)->contains(fn($m) => str_contains(strtolower($m->label ?? ''), 'kemenko pangan')))
      <li>
        <a href="https://kemenkopangan.go.id/" class="nav-kemenko-btn nav-kemenko-btn--mobile" target="_blank" rel="noopener noreferrer" title="Website Resmi Kementerian Koordinator Bidang Pangan">
          <span class="nav-kemenko-btn__text">
            <span>Kemenko</span>
            <span>Pangan</span>
          </span>
          <svg class="nav-kemenko-btn__arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <line x1="7" y1="17" x2="17" y2="7"></line>
            <polyline points="7 7 17 7 17 17"></polyline>
          </svg>
        </a>
      </li>
      @endif
    </ul>
  </nav>
  <div class="menu-mobile__bottom">
    <div class="theme-mobile">
      <button type="button" class="theme-toggle-btn theme-toggle-btn--mobile" aria-label="Toggle Dark Mode">
        <span class="theme-toggle-icon">
          <svg class="icon-sun" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="5"></circle>
            <line x1="12" y1="1" x2="12" y2="3"></line>
            <line x1="12" y1="21" x2="12" y2="23"></line>
            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
            <line x1="1" y1="12" x2="3" y2="12"></line>
            <line x1="21" y1="12" x2="23" y2="12"></line>
            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
          </svg>
          <svg class="icon-moon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
          </svg>
        </span>
        <span class="theme-text-light">Mode Gelap</span>
        <span class="theme-text-dark">Mode Terang</span>
      </button>
    </div>
    <div class="lang">
      <select name="change_lang_mobile" id="" onchange="if(this.value) window.location.href=this.value;">
        @foreach(lang::codes() as $lang)
        <option value="{{ url()->lang($lang) }}" @selected($lang == lang::active())>{{ config('cadmin.lang.labels-fe.'.$lang) }}</option>
        @endforeach
      </select>
    </div>
    <form action="" class="search">
      <input type="text" placeholder="Search">
      <button type="submit">
        <i class="wa-icon wa-ic-search-outline"></i>
      </button>
    </form>
  </div>
</section>

<style>
  /* ==========================================================================
     HEADER FULL WIDTH & LOGO FAR LEFT CORNER ALIGNMENT
     ========================================================================== */
  header {
    z-index: 5000 !important;
  }
  header .menu-mobile {
    z-index: 5000 !important;
  }
  .popup {
    z-index: 99990 !important;
  }
  header .wrapper {
    max-width: 100% !important;
    width: 100% !important;
    margin: 0 !important;
    padding: 0 clamp(18px, 2.2vw, 40px) !important;
    box-sizing: border-box !important;
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    gap: clamp(14px, 1.8vw, 28px) !important;
  }
  header .logo {
    flex-shrink: 0 !important;
    display: inline-flex !important;
    align-items: center !important;
    margin-right: 0 !important;
    padding: 8px 0 !important;
  }
  header .logo img {
    height: auto !important;
    max-height: clamp(34px, 3vw, 46px) !important;
    width: auto !important;
  }
  /* Default Transparent Header: Show White logo, Hide Black logo */
  header .logo .white {
    display: block !important;
  }
  header .logo .black {
    display: none !important;
  }
  /* Floating / White Header: Show Black logo, Hide White logo */
  header.floating .logo .white,
  header.white .logo .white {
    display: none !important;
  }
  header.floating .logo .black,
  header.white .logo .black {
    display: block !important;
  }
  /* Dark Mode: ALWAYS show White logo, Hide Black logo */
  [data-theme="dark"] header .logo .white,
  [data-theme="dark"] header.floating .logo .white,
  [data-theme="dark"] header.white .logo .white {
    display: block !important;
  }
  [data-theme="dark"] header .logo .black,
  [data-theme="dark"] header.floating .logo .black,
  [data-theme="dark"] header.white .logo .black {
    display: none !important;
  }
  /* Remove Login tab from header */
  header .right-header__login {
    display: none !important;
  }
  header .right-header {
    margin-left: 0 !important;
    flex: 1 1 auto !important;
    display: flex !important;
    align-items: center !important;
    justify-content: flex-end !important;
    gap: clamp(14px, 1.4vw, 22px) !important;
    min-width: 0 !important;
  }
  @media (min-width: 1200px) {
    header .right-header > nav {
      flex: 1 1 auto !important;
      display: flex !important;
      justify-content: center !important;
      margin: 0 clamp(10px, 1.2vw, 22px) !important;
      min-width: 0 !important;
    }
    header nav > ul {
      display: flex !important;
      align-items: center !important;
      justify-content: center !important;
      flex-wrap: nowrap !important;
      gap: clamp(14px, 1.45vw, 24px) !important;
    }
    header .right-header__theme {
      margin-left: clamp(8px, 1vw, 18px) !important;
      flex-shrink: 0 !important;
    }
    header .right-header__lang {
      flex-shrink: 0 !important;
    }
  }
  header nav > ul > li {
    flex-shrink: 0 !important;
  }
  header nav > ul > li > a:not(.nav-kemenko-btn) {
    white-space: nowrap !important;
    font-size: clamp(13px, 0.98vw, 14.5px) !important;
    letter-spacing: -0.01em !important;
  }
  header nav > ul > li > a.nav-kemenko-btn,
  .nav-kemenko-btn {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 6px !important;
    padding: 6px 12px !important;
    border-radius: 8px !important;
    border: 1px solid rgba(255, 255, 255, 0.38) !important;
    background: rgba(255, 255, 255, 0.14) !important;
    color: #ffffff !important;
    text-decoration: none !important;
    white-space: nowrap !important;
    transition: background 0.2s ease, border-color 0.2s ease, transform 0.2s ease, color 0.2s ease !important;
    box-sizing: border-box !important;
  }
  .nav-kemenko-btn__text {
    display: inline-flex !important;
    flex-direction: row !important;
    align-items: center !important;
    gap: 4px !important;
    line-height: 1.1 !important;
    font-size: clamp(12.5px, 0.95vw, 14px) !important;
    font-weight: 600 !important;
    letter-spacing: -0.01em !important;
  }
  .nav-kemenko-btn__arrow {
    flex-shrink: 0 !important;
    transition: transform 0.2s ease !important;
  }
  .nav-kemenko-btn:hover {
    background: rgba(245, 158, 11, 0.22) !important;
    border-color: #f59e0b !important;
    color: #ffffff !important;
    transform: translateY(-1px);
  }
  .nav-kemenko-btn:hover .nav-kemenko-btn__arrow {
    transform: translate(1.5px, -1.5px);
  }
  header.floating .nav-kemenko-btn,
  header.white .nav-kemenko-btn {
    background: #eff6ff !important;
    border-color: #bfdbfe !important;
    color: #003580 !important;
  }
  header.floating .nav-kemenko-btn:hover,
  header.white .nav-kemenko-btn:hover {
    background: #dbeafe !important;
    border-color: #003580 !important;
    color: #002766 !important;
  }
  [data-theme="dark"] .nav-kemenko-btn,
  [data-theme="dark"] header.floating .nav-kemenko-btn,
  [data-theme="dark"] header.white .nav-kemenko-btn {
    background: rgba(255, 255, 255, 0.1) !important;
    border-color: rgba(255, 255, 255, 0.28) !important;
    color: #f8fafc !important;
  }
  [data-theme="dark"] .nav-kemenko-btn:hover,
  [data-theme="dark"] header.floating .nav-kemenko-btn:hover,
  [data-theme="dark"] header.white .nav-kemenko-btn:hover {
    background: rgba(251, 191, 36, 0.2) !important;
    border-color: #fbbf24 !important;
    color: #fde68a !important;
  }
  .nav-kemenko-btn--mobile {
    width: fit-content !important;
    margin-top: 6px !important;
    padding: 8px 14px !important;
  }

  /* Kontras Menu Aktif pada Header Putih (.floating / .white) */
  header.floating nav > ul > li > a.active,
  header.white nav > ul > li > a.active,
  header.floating nav > ul > li.active > a,
  header.white nav > ul > li.active > a {
    color: #003580 !important;
    font-weight: 700 !important;
  }
  [data-theme="dark"] header.floating nav > ul > li > a.active,
  [data-theme="dark"] header.white nav > ul > li > a.active,
  [data-theme="dark"] header.floating nav > ul > li.active > a,
  [data-theme="dark"] header.white nav > ul > li.active > a {
    color: #fbbf24 !important;
  }

  /* Penyesuaian Warna Tombol Aksesibilitas agar Senada dengan Tombol Cari */
  #a11y-kemenkum-trigger {
    background: linear-gradient(94deg, #1840aa 3.44%, #091d77 100.03%) !important;
    box-shadow: 0 4px 16px rgba(24, 64, 170, 0.42) !important;
  }
  #a11y-kemenkum-trigger:hover {
    background: linear-gradient(94deg, #1e4ed8 0%, #0d268f 100%) !important;
    box-shadow: 0 6px 22px rgba(24, 64, 170, 0.56) !important;
  }

  /* ==========================================================================
     THEME TOGGLE BUTTON STYLES
     ========================================================================== */
  .right-header__theme {
    display: flex;
    align-items: center;
  }
  .theme-toggle-btn {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    border: 1px solid rgba(255, 255, 255, 0.4);
    background: rgba(255, 255, 255, 0.12);
    color: #ffffff;
    padding: 0;
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    outline: none;
    box-sizing: border-box;
  }
  .theme-toggle-btn:hover {
    background: rgba(255, 255, 255, 0.25);
    border-color: rgba(255, 255, 255, 0.8);
    transform: scale(1.06);
  }
  .theme-toggle-btn .theme-toggle-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.3s ease;
  }
  .theme-toggle-btn:hover .theme-toggle-icon {
    transform: rotate(15deg);
  }

  /* Default (Light Mode): Show Moon icon, hide Sun icon */
  .theme-toggle-btn .icon-sun {
    display: none !important;
  }
  .theme-toggle-btn .icon-moon {
    display: block !important;
    stroke: currentColor;
  }

  /* In Dark Mode: Show Sun icon with warm glow, hide Moon icon */
  [data-theme="dark"] .theme-toggle-btn .icon-sun {
    display: block !important;
    stroke: #fbbf24 !important;
    color: #fbbf24 !important;
    filter: drop-shadow(0 0 6px rgba(251, 191, 36, 0.5));
  }
  [data-theme="dark"] .theme-toggle-btn .icon-moon {
    display: none !important;
  }

  /* Floating header Light Mode */
  header.floating .theme-toggle-btn,
  header.white .theme-toggle-btn {
    border-color: #cbd5e1;
    background: #f1f5f9;
    color: #0f172a;
  }
  header.floating .theme-toggle-btn:hover,
  header.white .theme-toggle-btn:hover {
    background: #e2e8f0;
    color: #0284c7;
    border-color: #94a3b8;
  }

  /* Dark mode header (both transparent and floating) */
  [data-theme="dark"] .theme-toggle-btn {
    border-color: rgba(255, 255, 255, 0.2);
    background: rgba(255, 255, 255, 0.08);
    color: #fbbf24;
  }
  [data-theme="dark"] .theme-toggle-btn:hover {
    background: rgba(255, 255, 255, 0.16);
    border-color: #fbbf24;
  }
  [data-theme="dark"] header.floating .theme-toggle-btn,
  [data-theme="dark"] header.white .theme-toggle-btn {
    border-color: rgba(255, 255, 255, 0.2);
    background: #1e293b;
    color: #fbbf24;
  }

  /* Mobile theme button */
  .theme-mobile {
    margin-right: 12px;
  }
  .theme-toggle-btn--mobile {
    width: auto !important;
    height: auto !important;
    border-radius: 30px !important;
    padding: 8px 16px !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 8px !important;
    font-size: 13px !important;
    font-weight: 600 !important;
    border: 1px solid #cbd5e1 !important;
    background: #f1f5f9 !important;
    color: #0f172a !important;
  }
  [data-theme="dark"] .theme-toggle-btn--mobile {
    border-color: #334155 !important;
    background: #1e293b !important;
    color: #fbbf24 !important;
  }

  /* ==========================================================================
     MOBILE & TABLET RESPONSIVENESS OPTIMIZATIONS (Strictly max-width: 1199px)
     ========================================================================== */
  @media (max-width: 1199px) {
    html, body {
      overflow-x: clip !important;
      max-width: 100% !important;
    }
    header,
    header.floating,
    header.white {
      background: #ffffff !important;
      box-shadow: 0 4px 16px rgba(15, 23, 42, 0.08) !important;
    }
    header::before {
      display: none !important;
    }
    header .logo .white,
    header.show-burger .logo .white {
      display: none !important;
    }
    header .logo .black,
    header.show-burger .logo .black {
      display: block !important;
    }
    header .toggle-menu {
      margin-left: 0 !important;
      flex-shrink: 0 !important;
    }
    header .toggle-menu span,
    header.floating .toggle-menu span,
    header.white .toggle-menu span {
      background-color: #1440a4 !important;
    }
    header .theme-toggle-btn,
    header.floating .theme-toggle-btn,
    header.white .theme-toggle-btn {
      border-color: #cbd5e1 !important;
      background: #f1f5f9 !important;
      color: #0f172a !important;
    }
    [data-theme="dark"] header,
    [data-theme="dark"] header.floating,
    [data-theme="dark"] header.white {
      background: #0f172a !important;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.6) !important;
    }
    [data-theme="dark"] header .logo .white,
    [data-theme="dark"] header.show-burger .logo .white {
      display: block !important;
    }
    [data-theme="dark"] header .logo .black,
    [data-theme="dark"] header.show-burger .logo .black {
      display: none !important;
    }
    [data-theme="dark"] header .toggle-menu span,
    [data-theme="dark"] header.floating .toggle-menu span,
    [data-theme="dark"] header.white .toggle-menu span {
      background-color: #f8fafc !important;
    }
    [data-theme="dark"] header .theme-toggle-btn,
    [data-theme="dark"] header.floating .theme-toggle-btn,
    [data-theme="dark"] header.white .theme-toggle-btn {
      border-color: rgba(255, 255, 255, 0.2) !important;
      background: #1e293b !important;
      color: #fbbf24 !important;
    }
    header .wrapper {
      padding: 0 16px !important;
      gap: 10px !important;
      min-height: 58px !important;
    }
    header .logo {
      padding: 8px 0 !important;
      width: auto !important;
      max-width: calc(100% - 104px) !important;
    }
    header .logo img {
      max-height: 36px !important;
      width: auto !important;
    }
    header .right-header {
      flex: 0 0 auto !important;
      width: auto !important;
      gap: 12px !important;
      justify-content: flex-end !important;
      margin-left: auto !important;
    }
    header .right-header__theme {
      margin-left: 0 !important;
      flex-shrink: 0 !important;
    }
    .menu-mobile {
      top: 58px !important;
      height: calc(100dvh - 58px) !important;
      padding-bottom: 24px !important;
    }
    header.floating.show-burger .header-bot,
    header.white.show-burger .header-bot,
    header:not(.floating):not(.white) .header-bot {
      padding: 0 !important;
      height: 0 !important;
      overflow: hidden !important;
      display: none !important;
    }
    .menu-mobile nav > ul > li > a {
      padding: 11px 0 !important;
      font-size: 15px !important;
    }
    .menu-mobile nav > ul > li > a.active,
    .menu-mobile nav > ul > li.show > a,
    .menu-mobile nav > ul > li .child a.active {
      color: #003580 !important;
      font-weight: 700 !important;
    }
    .menu-mobile__bottom {
      margin-top: 16px !important;
      padding-top: 16px !important;
      border-top: 1px solid #e2e8f0 !important;
      gap: 12px !important;
    }
    .menu-mobile__bottom .lang select {
      appearance: none !important;
      -webkit-appearance: none !important;
      background-repeat: no-repeat !important;
      background-size: 11px auto !important;
      background-position: right 2px center !important;
      padding-right: 20px !important;
    }
    .wrap-filter .filter select,
    .middle__search select {
      appearance: none !important;
      -webkit-appearance: none !important;
      background-repeat: no-repeat !important;
      padding-right: 34px !important;
    }
    .document__listing.swiper {
      width: 100% !important;
      max-width: 100% !important;
      overflow: hidden !important;
      box-sizing: border-box !important;
    }
    .animating-scroll {
      opacity: 1 !important;
      transform: none !important;
      visibility: visible !important;
    }
  }
  @media (min-width: 768px) and (max-width: 1023px) {
    .banner-homepage__caption {
      left: 0 !important;
      right: 0 !important;
      width: 100% !important;
      max-width: 720px !important;
      margin: 0 auto !important;
      padding: 80px 32px 60px !important;
      box-sizing: border-box !important;
    }
  }
  @media (max-width: 767px) {
    .banner-homepage {
      min-height: 520px !important;
      overflow: hidden !important;
    }
    .banner-homepage > figure {
      height: 100% !important;
      min-height: 520px !important;
    }
    .banner-homepage > figure img {
      height: 100% !important;
      min-height: 520px !important;
      object-fit: cover !important;
      object-position: center !important;
    }
    [data-theme="dark"] .banner-homepage,
    [data-theme="dark"] .banner-homepage > figure {
      min-height: 520px !important;
    }
    .banner-homepage__caption {
      left: 0 !important;
      right: 0 !important;
      top: 0 !important;
      bottom: 0 !important;
      width: 100% !important;
      max-width: 100% !important;
      margin: 0 !important;
      padding: 88px 18px 54px !important;
      box-sizing: border-box !important;
      display: flex !important;
      flex-direction: column !important;
      align-items: center !important;
      justify-content: center !important;
      text-align: center !important;
    }
    .banner-homepage__caption h3 {
      width: 100% !important;
      text-align: center !important;
      font-size: 21px !important;
      line-height: 1.3 !important;
      margin: 0 0 6px !important;
    }
    .banner-homepage__caption h1 {
      width: 100% !important;
      text-align: center !important;
      font-size: 15px !important;
      margin: 0 0 18px !important;
      line-height: 1.4 !important;
    }
    .banner-homepage__caption form,
    .banner-homepage__caption #frm-search {
      width: 100% !important;
      max-width: 100% !important;
      margin: 0 !important;
    }
    .banner-homepage__caption .wrap-input {
      width: 100% !important;
      max-width: 100% !important;
      height: 48px !important;
      padding: 4px 4px 4px 16px !important;
      box-sizing: border-box !important;
      display: flex !important;
      align-items: center !important;
    }
    .banner-homepage__caption .wrap-input input {
      flex: 1 1 auto !important;
      min-width: 0 !important;
      width: auto !important;
      padding: 6px 6px 6px 0 !important;
      font-size: 13.5px !important;
    }
    .banner-homepage__caption .wrap-input .voice {
      flex: 0 0 auto !important;
      margin-right: 8px !important;
    }
    .banner-homepage__caption .wrap-input .search {
      flex: 0 0 40px !important;
      width: 40px !important;
      height: 40px !important;
      min-width: 40px !important;
      padding: 0 !important;
      border-radius: 50% !important;
    }
    .banner-homepage__caption .wrap-filter {
      width: 100% !important;
      display: flex !important;
      flex-direction: column !important;
      align-items: center !important;
      text-align: center !important;
      margin-top: 12px !important;
    }
    .banner-homepage__caption .wrap-filter .filter {
      width: 100% !important;
      max-width: 100% !important;
      left: 0 !important;
      right: 0 !important;
      margin: 10px 0 0 !important;
      transform: none !important;
      box-sizing: border-box !important;
      text-align: left !important;
    }
    .banner-homepage__caption .banner-stats {
      width: 100% !important;
      align-items: center !important;
      justify-content: center !important;
    }
    .banner-homepage__caption .banner-stats__row {
      width: 100% !important;
      justify-content: center !important;
    }
    .tema {
      height: auto !important;
      min-height: 0 !important;
      padding: 52px 0 44px !important;
    }
    .list-title {
      gap: 10px !important;
      align-items: center !important;
    }
    .list-title h5 {
      font-size: 15.5px !important;
      line-height: 1.3 !important;
    }
    .list-title .readmore {
      white-space: nowrap !important;
      flex-shrink: 0 !important;
      font-size: 13px !important;
    }
    #a11y-kemenkum-trigger {
      width: 44px !important;
      height: 44px !important;
      bottom: 16px !important;
      left: 14px !important;
    }
    #a11y-kemenkum-trigger svg {
      width: 24px !important;
      height: 24px !important;
      min-width: 24px !important;
      min-height: 24px !important;
    }
    footer {
      padding-bottom: 72px !important;
    }
  }
  .theme-toggle-btn--mobile .theme-text-dark {
    display: none;
  }
  .theme-toggle-btn--mobile .theme-text-light {
    display: inline;
  }
  [data-theme="dark"] .theme-toggle-btn--mobile .theme-text-dark {
    display: inline;
  }
  [data-theme="dark"] .theme-toggle-btn--mobile .theme-text-light {
    display: none;
  }

  /* ==========================================================================
     MEGA DROPDOWN - LIGHT MODE (Default: Clean Pure White)
     ========================================================================== */
  header nav > ul > li.have-child {
    position: relative;
  }
  header nav > ul > li.have-child > a.nav-parent-link,
  header nav > ul > li.have-child > a {
    display: inline-flex !important;
    align-items: center !important;
    gap: 6px !important;
    cursor: pointer !important;
    user-select: none !important;
    transition: color 0.2s ease !important;
  }
  header nav > ul > li.have-child > a .nav-chevron {
    display: inline-block !important;
    width: 12px !important;
    height: 12px !important;
    stroke: currentColor !important;
    transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), stroke 0.2s ease !important;
  }
  /* Active / Open state: Golden yellow */
  header nav > ul > li.have-child.is-open > a.nav-parent-link,
  header nav > ul > li.have-child.is-open > a,
  header.floating nav > ul > li.have-child.is-open > a.nav-parent-link,
  header.floating nav > ul > li.have-child.is-open > a {
    color: #f59e0b !important;
  }
  header nav > ul > li.have-child.is-open > a .nav-chevron,
  header.floating nav > ul > li.have-child.is-open > a .nav-chevron {
    transform: rotate(180deg) !important;
    stroke: #f59e0b !important;
  }

  /* Dropdown Card: PURE WHITE IN LIGHT MODE */
  header .child.jdihn-mega-menu {
    position: absolute !important;
    top: calc(100% - 10px) !important;
    left: 50% !important;
    transform: translateX(-50%) translateY(-10px) !important;
    z-index: 9999 !important;
    min-width: min(580px, calc(100vw - 32px)) !important;
    max-width: min(680px, calc(100vw - 32px)) !important;
    width: max-content !important;
    padding: 22px 26px !important;
    background: #ffffff !important;
    border: 1px solid #e2e8f0 !important;
    border-radius: 18px !important;
    box-shadow: 0 20px 45px -10px rgba(15, 23, 42, 0.16), 0 8px 16px -6px rgba(15, 23, 42, 0.08), 0 0 0 1px rgba(15, 23, 42, 0.04) !important;
    opacity: 0 !important;
    visibility: hidden !important;
    pointer-events: none !important;
    transition: opacity 0.22s cubic-bezier(0.16, 1, 0.3, 1),
                transform 0.22s cubic-bezier(0.16, 1, 0.3, 1),
                visibility 0.22s,
                background 0.3s ease,
                border-color 0.3s ease !important;
  }
  @media (max-width: 680px) {
    .jdihn-mega-grid {
      grid-template-columns: 1fr !important;
    }
  }
  header .child.jdihn-mega-menu::before,
  header .child.jdihn-mega-menu::after {
    display: none !important;
  }
  header nav > ul > li.have-child.is-open .child.jdihn-mega-menu {
    opacity: 1 !important;
    visibility: visible !important;
    transform: translateX(-50%) translateY(0) !important;
    pointer-events: auto !important;
  }
  header nav > ul > li.have-child.align-left .child.jdihn-mega-menu {
    left: 0 !important;
    transform: translateX(0) translateY(-10px) !important;
  }
  header nav > ul > li.have-child.align-left.is-open .child.jdihn-mega-menu {
    transform: translateX(0) translateY(0) !important;
  }
  header nav > ul > li.have-child.align-right .child.jdihn-mega-menu {
    left: auto !important;
    right: 0 !important;
    transform: translateX(0) translateY(-10px) !important;
  }
  header nav > ul > li.have-child.align-right.is-open .child.jdihn-mega-menu {
    transform: translateX(0) translateY(0) !important;
  }

  /* Desktop hover peek */
  @media (min-width: 1200px) {
    header nav > ul > li.have-child:hover > a.nav-parent-link,
    header nav > ul > li.have-child:hover > a,
    header.floating nav > ul > li.have-child:hover > a.nav-parent-link,
    header.floating nav > ul > li.have-child:hover > a {
      color: #f59e0b !important;
    }
    header nav > ul > li.have-child:hover > a .nav-chevron {
      transform: rotate(180deg) !important;
      stroke: #f59e0b !important;
    }
    header nav > ul > li.have-child:hover .child.jdihn-mega-menu {
      opacity: 1 !important;
      visibility: visible !important;
      transform: translateX(-50%) translateY(0) !important;
      pointer-events: auto !important;
    }
    header nav > ul > li.have-child.align-left:hover .child.jdihn-mega-menu {
      transform: translateX(0) translateY(0) !important;
    }
    header nav > ul > li.have-child.align-right:hover .child.jdihn-mega-menu {
      transform: translateX(0) translateY(0) !important;
    }
  }

  /* Grid layout */
  .jdihn-mega-grid {
    display: grid !important;
    grid-template-columns: repeat(2, minmax(260px, 1fr)) !important;
    gap: 14px 22px !important;
    margin: 0 !important;
    padding: 0 !important;
    list-style: none !important;
  }
  .jdihn-mega-grid.single-col {
    grid-template-columns: 1fr !important;
    min-width: 300px !important;
  }

  /* Item cards - Light Mode */
  .jdihn-item {
    display: flex !important;
    flex-direction: column !important;
    align-items: flex-start !important;
    padding: 12px 14px !important;
    border-radius: 12px !important;
    text-decoration: none !important;
    background: transparent !important;
    border: 1px solid transparent !important;
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1) !important;
    cursor: pointer !important;
    box-sizing: border-box !important;
  }
  .jdihn-item:hover {
    background: #f1f5f9 !important;
    border-color: #e2e8f0 !important;
    transform: translateY(-2px) !important;
  }
  .jdihn-item-icon {
    display: flex !important;
    align-items: center !important;
    justify-content: flex-start !important;
    margin-bottom: 8px !important;
    color: #0284c7 !important;
    transition: all 0.2s ease !important;
  }
  .jdihn-item-icon svg {
    width: 22px !important;
    height: 22px !important;
    stroke: #0284c7 !important;
    transition: all 0.2s ease !important;
  }
  .jdihn-item:hover .jdihn-item-icon svg {
    stroke: #d97706 !important;
    color: #d97706 !important;
  }
  .jdihn-item-content {
    width: 100% !important;
    text-align: left !important;
  }
  .jdihn-item-title {
    font-size: 14.5px !important;
    font-weight: 600 !important;
    color: #0f172a !important; /* Dark Slate in Light Mode */
    line-height: 1.35 !important;
    margin-bottom: 4px !important;
    letter-spacing: -0.01em !important;
    display: block !important;
    white-space: normal !important;
    transition: color 0.2s ease !important;
  }
  .jdihn-item:hover .jdihn-item-title {
    color: #0284c7 !important;
  }
  .jdihn-item-title-row {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    gap: 8px !important;
    flex-wrap: wrap !important;
    margin-bottom: 4px !important;
  }
  .jdihn-item-title-row .jdihn-item-title {
    margin-bottom: 0 !important;
  }
  .jdihn-subchild-links {
    display: flex !important;
    gap: 7px !important;
    margin-top: 9px !important;
    flex-wrap: wrap !important;
  }
  .jdihn-subchild-chip {
    display: inline-flex !important;
    align-items: center !important;
    gap: 6px !important;
    padding: 4px 10px 4px 6px !important;
    border-radius: 6px !important;
    background: #f8fafc !important;
    border: 1px solid #e2e8f0 !important;
    text-decoration: none !important;
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1) !important;
    cursor: pointer !important;
  }
  .jdihn-subchild-chip .chip-code {
    font-size: 10px !important;
    font-weight: 800 !important;
    padding: 2px 6px !important;
    border-radius: 4px !important;
    letter-spacing: 0.5px !important;
    line-height: 1 !important;
  }
  .jdihn-subchild-chip.is-ma .chip-code {
    background: #dbeafe !important;
    color: #1e40af !important;
  }
  .jdihn-subchild-chip.is-mk .chip-code {
    background: #fee2e2 !important;
    color: #991b1b !important;
  }
  .jdihn-subchild-chip .chip-label {
    font-size: 11.5px !important;
    font-weight: 600 !important;
    color: #334155 !important;
    line-height: 1.2 !important;
    white-space: nowrap !important;
  }
  .jdihn-subchild-chip .chip-arrow {
    color: #94a3b8 !important;
    transition: transform 0.2s ease, color 0.2s ease !important;
  }
  .jdihn-subchild-chip:hover {
    background: #ffffff !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
    transform: translateY(-1px) !important;
  }
  .jdihn-subchild-chip.is-ma:hover {
    border-color: #3b82f6 !important;
  }
  .jdihn-subchild-chip.is-mk:hover {
    border-color: #ef4444 !important;
  }
  .jdihn-subchild-chip:hover .chip-arrow {
    transform: translateX(2px) !important;
    color: #0f172a !important;
  }
  .jdihn-subchild-chip.active {
    background: #eff6ff !important;
    border-color: #3b82f6 !important;
  }
  .jdihn-subchild-chip.is-mk.active {
    background: #fef2f2 !important;
    border-color: #ef4444 !important;
  }
  [data-theme="dark"] .jdihn-subchild-chip {
    background: rgba(255, 255, 255, 0.05) !important;
    border-color: rgba(255, 255, 255, 0.1) !important;
  }
  [data-theme="dark"] .jdihn-subchild-chip .chip-label {
    color: #e2e8f0 !important;
  }
  [data-theme="dark"] .jdihn-subchild-chip:hover {
    background: rgba(255, 255, 255, 0.1) !important;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.4) !important;
  }
  [data-theme="dark"] .jdihn-subchild-chip.is-ma .chip-code {
    background: rgba(59, 130, 246, 0.22) !important;
    color: #93c5fd !important;
  }
  [data-theme="dark"] .jdihn-subchild-chip.is-mk .chip-code {
    background: rgba(239, 68, 68, 0.22) !important;
    color: #fca5a5 !important;
  }
  .jdihn-item-desc {
    font-size: 12px !important;
    font-weight: 400 !important;
    color: #64748b !important; /* Slate-500 in Light Mode */
    line-height: 1.4 !important;
    display: block !important;
    white-space: normal !important;
    transition: color 0.2s ease !important;
  }
  .jdihn-item:hover .jdihn-item-desc {
    color: #334155 !important;
  }

  /* ==========================================================================
     MEGA DROPDOWN - DARK MODE OVERRIDES
     ========================================================================== */
  [data-theme="dark"] header .child.jdihn-mega-menu {
    background: #18181b !important;
    border-color: rgba(255, 255, 255, 0.12) !important;
    box-shadow: 0 24px 50px -10px rgba(0, 0, 0, 0.75), 0 0 1px 1px rgba(255, 255, 255, 0.05) !important;
  }
  [data-theme="dark"] .jdihn-item:hover {
    background: rgba(255, 255, 255, 0.08) !important;
    border-color: rgba(255, 255, 255, 0.1) !important;
  }
  [data-theme="dark"] .jdihn-item-icon {
    color: #94a3b8 !important;
  }
  [data-theme="dark"] .jdihn-item-icon svg {
    stroke: #94a3b8 !important;
  }
  [data-theme="dark"] .jdihn-item:hover .jdihn-item-icon svg {
    stroke: #f59e0b !important;
    color: #f59e0b !important;
  }
  [data-theme="dark"] .jdihn-item-title {
    color: #ffffff !important;
  }
  [data-theme="dark"] .jdihn-item:hover .jdihn-item-title {
    color: #ffffff !important;
  }
  [data-theme="dark"] .jdihn-item-desc {
    color: #94a3b8 !important;
  }
  [data-theme="dark"] .jdihn-item:hover .jdihn-item-desc {
    color: #e2e8f0 !important;
  }

  /* ==========================================================================
     GLOBAL WEBSITE DARK MODE STYLES
     ========================================================================== */
  [data-theme="dark"] body,
  [data-theme="dark"] section.middle {
    background-color: #0b1120 !important;
    color: #cbd5e1 !important;
    transition: background-color 0.3s ease, color 0.3s ease;
  }

  /* Hero Sections in Dark Mode: No Hero Image, Rich Dark Palette */
  [data-theme="dark"] .banner-homepage {
    min-height: clamp(500px, 68vh, 660px) !important;
    background: radial-gradient(circle at 78% 22%, rgba(16, 185, 129, 0.16), transparent 48%),
                radial-gradient(circle at 18% 80%, rgba(37, 99, 235, 0.18), transparent 52%),
                linear-gradient(135deg, #040914 0%, #0b192c 52%, #09261d 100%) !important;
    border-bottom: 1px solid rgba(56, 189, 248, 0.1) !important;
  }
  [data-theme="dark"] .banner-middle,
  [data-theme="dark"] .banner-middle.pub-hero-banner {
    background: radial-gradient(circle at 82% 20%, rgba(16, 185, 129, 0.15), transparent 46%),
                radial-gradient(circle at 14% 75%, rgba(37, 99, 235, 0.16), transparent 50%),
                linear-gradient(135deg, #040914 0%, #0d1f36 55%, #09261d 100%) !important;
  }
  [data-theme="dark"] .banner-homepage > figure img,
  [data-theme="dark"] .banner-middle > figure img,
  [data-theme="dark"] .tema .bg img {
    opacity: 0 !important;
    visibility: hidden !important;
  }
  [data-theme="dark"] .banner-homepage > figure {
    min-height: clamp(500px, 68vh, 660px) !important;
  }
  [data-theme="dark"] .tema {
    background: radial-gradient(circle at 20% 30%, rgba(16, 185, 129, 0.14), transparent 50%),
                linear-gradient(135deg, #061021 0%, #0d2138 55%, #08231c 100%) !important;
  }
  [data-theme="dark"] .tema::after {
    background: linear-gradient(180deg, #0b1120 0%, rgba(11, 17, 32, 0.85) 55%, rgba(11, 17, 32, 0) 100%) !important;
  }
  [data-theme="dark"] .banner-homepage .wave svg,
  [data-theme="dark"] .banner-homepage .wave path,
  [data-theme="dark"] .banner-middle .wave svg,
  [data-theme="dark"] .banner-middle .wave path,
  [data-theme="dark"] .tema .wave svg,
  [data-theme="dark"] .tema .wave path,
  [data-theme="dark"] footer .wave svg,
  [data-theme="dark"] footer .wave path {
    fill: #0b1120 !important;
  }
  [data-theme="dark"] section.document,
  [data-theme="dark"] .document,
  [data-theme="dark"] section.artikel,
  [data-theme="dark"] .artikel,
  [data-theme="dark"] section.news,
  [data-theme="dark"] .news {
    background: #0b1120 !important;
    background-image: none !important;
  }
  [data-theme="dark"] .document__title .arrow .swiper-arrow {
    filter: brightness(0) invert(1) !important;
  }
  [data-theme="dark"] header.floating,
  [data-theme="dark"] header.white {
    background: #0f172a !important;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.6) !important;
  }
  [data-theme="dark"] .document__title h4,
  [data-theme="dark"] .artikel__right-title h5,
  [data-theme="dark"] .list-title h5,
  [data-theme="dark"] .tema__title h3 {
    color: #f8fafc !important;
  }
  [data-theme="dark"] .tema__title p {
    color: #94a3b8 !important;
  }
  [data-theme="dark"] .document__listing--item {
    background: #111c2d !important;
    border: 1px solid #243247 !important;
  }
  [data-theme="dark"] .document__listing--item:hover {
    border-color: #38bdf8 !important;
  }
  [data-theme="dark"] .document__listing--item p,
  [data-theme="dark"] .document__listing--item figcaption p {
    color: #f1f5f9 !important;
  }
  [data-theme="dark"] .document__listing--item small,
  [data-theme="dark"] .listing-card__item small {
    color: #94a3b8 !important;
  }
  [data-theme="dark"] .tema__listing--item figcaption {
    background: rgba(15, 23, 42, 0.9) !important;
  }
  [data-theme="dark"] .tema__listing--item figcaption h6 {
    color: #f8fafc !important;
  }
  [data-theme="dark"] .news .grid__item {
    background: #111c2d !important;
    border-color: #243247 !important;
  }
  [data-theme="dark"] .news .highlight-item {
    background: #0f172a !important;
    border-color: #243247 !important;
  }
  [data-theme="dark"] .news .grid__item h4,
  [data-theme="dark"] .news .grid__item p,
  [data-theme="dark"] .news .highlight-item p {
    color: #f1f5f9 !important;
  }
  [data-theme="dark"] .news .date {
    color: #94a3b8 !important;
  }
  [data-theme="dark"] .banner-homepage__caption h3,
  [data-theme="dark"] .banner-middle figcaption small {
    color: #93c5fd !important;
  }
  [data-theme="dark"] .banner-homepage__caption h1,
  [data-theme="dark"] .banner-middle figcaption h2 {
    color: #f8fafc !important;
    text-shadow: 0 2px 14px rgba(0, 0, 0, 0.35);
  }
  [data-theme="dark"] .banner-homepage__caption .wrap-input {
    background: #111c2d !important;
    border: 1px solid #2b3b55 !important;
    box-shadow: 0 12px 32px rgba(0, 0, 0, 0.45) !important;
  }
  [data-theme="dark"] .banner-homepage__caption .wrap-input input {
    background: transparent !important;
    color: #f8fafc !important;
  }
  [data-theme="dark"] .banner-homepage__caption .wrap-input input::placeholder {
    color: #94a3b8 !important;
  }
  [data-theme="dark"] .banner-stats a {
    background: rgba(15, 23, 42, 0.78) !important;
    border: 1px solid rgba(148, 163, 184, 0.25) !important;
    color: #e2e8f0 !important;
  }
  [data-theme="dark"] .banner-stats a:hover {
    background: rgba(30, 41, 59, 0.95) !important;
    border-color: #38bdf8 !important;
  }
  [data-theme="dark"] .middle__search,
  [data-theme="dark"] .listing-rules__item,
  [data-theme="dark"] .listing-rules__item figcaption,
  [data-theme="dark"] .content-pages {
    background-color: #111c2d !important;
    color: #cbd5e1 !important;
    border-color: #243247 !important;
  }
  [data-theme="dark"] .middle__search input,
  [data-theme="dark"] .middle__search select,
  [data-theme="dark"] section.middle input[type="text"],
  [data-theme="dark"] section.middle input[type="email"],
  [data-theme="dark"] section.middle select,
  [data-theme="dark"] section.middle textarea {
    background-color: #0f172a !important;
    border-color: #334155 !important;
    color: #f1f5f9 !important;
  }
  [data-theme="dark"] .middle__search label {
    color: #94a3b8 !important;
  }
  [data-theme="dark"] .listing-rules__item p,
  [data-theme="dark"] .listing-rules__item a:not(.button) {
    color: #f1f5f9 !important;
  }
  [data-theme="dark"] .listing-rules__item small,
  [data-theme="dark"] .listing-rules__item .bottom {
    color: #94a3b8 !important;
    border-color: #243247 !important;
  }
  [data-theme="dark"] .button.button-outline {
    border-color: #38bdf8 !important;
    color: #7dd3fc !important;
  }
  [data-theme="dark"] .button.button-outline:hover {
    background-color: #0284c7 !important;
    color: #ffffff !important;
  }
  [data-theme="dark"] footer {
    background: linear-gradient(180deg, #081226 0%, #050b18 100%) !important;
  }

  /* Floating Header in Dark Mode */
  [data-theme="dark"] header.floating::before,
  [data-theme="dark"] header.white::before {
    background-color: #0f172a !important;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.6) !important;
  }
  [data-theme="dark"] header.floating .logo .white,
  [data-theme="dark"] header.white .logo .white {
    display: block !important;
  }
  [data-theme="dark"] header.floating .logo .black,
  [data-theme="dark"] header.white .logo .black {
    display: none !important;
  }
  [data-theme="dark"] header.floating nav > ul > li > a,
  [data-theme="dark"] header.white nav > ul > li > a {
    color: #f1f5f9 !important;
  }
  [data-theme="dark"] header.floating nav > ul > li:hover > a,
  [data-theme="dark"] header.white nav > ul > li:hover > a {
    color: #f59e0b !important;
  }
  [data-theme="dark"] header.floating .right-header__lang::before,
  [data-theme="dark"] header.white .right-header__lang::before {
    background-color: rgba(255, 255, 255, 0.2) !important;
  }
  [data-theme="dark"] .right-header__lang .drop-language {
    background-color: #1e293b !important;
    border: 1px solid rgba(255, 255, 255, 0.1) !important;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.6) !important;
  }
  [data-theme="dark"] header.floating .header-bot {
    background-color: #0f172a !important;
  }
  [data-theme="dark"] header.floating .header-bot::before {
    background-color: #1e293b !important;
  }
  [data-theme="dark"] header.floating .header-bot input {
    color: #f8fafc !important;
  }

  /* Cards & Lists in Dark Mode */
  [data-theme="dark"] .listing-card__item {
    background: #1e293b !important;
    border: 1px solid #334155 !important;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.3) !important;
  }
  [data-theme="dark"] .listing-card__item:hover {
    background: #243046 !important;
    border-color: #475569 !important;
    transform: translateY(-2px);
  }
  [data-theme="dark"] .listing-card__item p {
    color: #f1f5f9 !important;
  }
  [data-theme="dark"] .listing-card__item span {
    color: #94a3b8 !important;
  }
  [data-theme="dark"] .list-title h5,
  [data-theme="dark"] .list-title h4,
  [data-theme="dark"] .list-title h6,
  [data-theme="dark"] h1, [data-theme="dark"] h2, [data-theme="dark"] h3, [data-theme="dark"] h4, [data-theme="dark"] h5, [data-theme="dark"] h6 {
    color: #ffffff !important;
  }
  [data-theme="dark"] .readmore {
    color: #60a5fa !important;
  }

  /* Filter in Dark Mode */
  [data-theme="dark"] .filter {
    background-color: #1e293b !important;
    border: 1px solid #334155 !important;
    color: #f8fafc !important;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6) !important;
  }
  [data-theme="dark"] .filter__title h6 {
    color: #ffffff !important;
  }
  [data-theme="dark"] .filter label {
    color: #94a3b8 !important;
  }
  [data-theme="dark"] .filter select,
  [data-theme="dark"] .filter input {
    background-color: #0f172a !important;
    color: #f8fafc !important;
    border-color: #334155 !important;
  }

  /* Statistic Section in Dark Mode */
  [data-theme="dark"] .statistic {
    background-color: #0b1120 !important;
  }
  [data-theme="dark"] .statistic__item {
    background: #1e293b !important;
    border: 1px solid #334155 !important;
  }
  [data-theme="dark"] .statistic__item h3,
  [data-theme="dark"] .statistic__item p {
    color: #ffffff !important;
  }

  /* News / Galeri / Infografis in Dark Mode */
  [data-theme="dark"] .news-highlight__item,
  [data-theme="dark"] .infografis__item,
  [data-theme="dark"] .galeri__item,
  [data-theme="dark"] .article-item {
    background: #1e293b !important;
    border-color: #334155 !important;
  }

  /* Popups in Dark Mode */
  [data-theme="dark"] .popup__box {
    background-color: #1e293b !important;
    color: #f8fafc !important;
    border: 1px solid #334155 !important;
  }
  [data-theme="dark"] .popup__box figcaption h5 {
    color: #ffffff !important;
  }
  [data-theme="dark"] .popup__box figcaption p {
    color: #94a3b8 !important;
  }
  [data-theme="dark"] .popup__box input {
    background-color: #0f172a !important;
    color: #f8fafc !important;
    border-color: #334155 !important;
  }
  [data-theme="dark"] .popup__box label {
    color: #e2e8f0 !important;
  }

  /* Mobile menu in Dark Mode */
  [data-theme="dark"] .menu-mobile {
    background-color: #0b1120 !important;
    color: #f8fafc !important;
  }
  [data-theme="dark"] .menu-mobile nav ul li a {
    color: #f1f5f9 !important;
  }
  [data-theme="dark"] .menu-mobile nav ul li .child {
    background-color: #1e293b !important;
  }
  [data-theme="dark"] .menu-mobile__bottom .lang select {
    background-color: #1e293b !important;
    color: #ffffff !important;
    border-color: #334155 !important;
  }
  [data-theme="dark"] .menu-mobile__bottom .search input {
    background-color: #1e293b !important;
    color: #ffffff !important;
    border-color: #334155 !important;
  }
  [data-theme="dark"] .after-login__drop {
    background: #1e293b !important;
    border: 1px solid #334155 !important;
  }
  [data-theme="dark"] .after-login__drop a {
    color: #f1f5f9 !important;
  }
</style>

<script>
  (function() {
    // 1. Dark Mode Toggle System
    function initThemeToggle() {
      function applyTheme(theme) {
        document.documentElement.setAttribute('data-theme', theme);
        try {
          localStorage.setItem('jdih_theme', theme);
        } catch(e) {}
      }

      window.toggleJdihTheme = function() {
        const current = document.documentElement.getAttribute('data-theme') || 'light';
        const next = current === 'dark' ? 'light' : 'dark';
        applyTheme(next);
      };

      document.querySelectorAll('.theme-toggle-btn').forEach(btn => {
        if (btn.dataset.themeBound) return;
        btn.dataset.themeBound = 'true';
        btn.addEventListener('click', function(e) {
          e.preventDefault();
          window.toggleJdihTheme();
        });
      });
    }

    // 2. JDIHN Dropdowns
    function initJdihnDropdowns() {
      const items = document.querySelectorAll('header nav ul > li.have-child');
      
      const checkAlign = (li) => {
        li.classList.remove('align-left', 'align-right');
        const rect = li.getBoundingClientRect();
        const dropdownHalf = 330;
        const triggerCenter = rect.left + (rect.width / 2);
        if (triggerCenter + dropdownHalf > window.innerWidth - 20) {
          li.classList.add('align-right');
        } else if (triggerCenter - dropdownHalf < 20) {
          li.classList.add('align-left');
        }
      };

      items.forEach(li => {
        checkAlign(li);
        const trigger = li.querySelector('.nav-parent-link') || li.querySelector(':scope > a');
        if (!trigger) return;

        if (trigger.dataset.jdihnBound) return;
        trigger.dataset.jdihnBound = 'true';

        trigger.addEventListener('click', function(e) {
          if (window.innerWidth >= 1200) {
            e.preventDefault();
            e.stopPropagation();
            const isOpen = li.classList.contains('is-open');

            items.forEach(other => {
              if (other !== li) other.classList.remove('is-open');
            });

            if (isOpen) {
              li.classList.remove('is-open');
            } else {
              checkAlign(li);
              li.classList.add('is-open');
            }
          }
        });
      });

      window.addEventListener('resize', () => {
        items.forEach(li => checkAlign(li));
      });

      document.querySelectorAll('header .child').forEach(child => {
        if (!child.dataset.jdihnBound) {
          child.dataset.jdihnBound = 'true';
          child.addEventListener('click', function(e) {
            e.stopPropagation();
          });
        }
      });

      // Pastikan seluruh kartu .jdihn-item-has-children dapat diklik secara responsif
      document.querySelectorAll('.jdihn-item-has-children[data-href]').forEach(card => {
        if (card.dataset.cardBound) return;
        card.dataset.cardBound = 'true';
        card.addEventListener('click', function(e) {
          if (e.target.closest('a')) return;
          const url = card.getAttribute('data-href');
          const isExt = card.getAttribute('data-external') === '1';
          if (url) {
            if (isExt) {
              window.open(url, '_blank', 'noopener,noreferrer');
            } else {
              window.location.href = url;
            }
          }
        });
        card.addEventListener('keydown', function(e) {
          if ((e.key === 'Enter' || e.key === ' ') && !e.target.closest('a')) {
            e.preventDefault();
            card.click();
          }
        });
      });

      // Pada menu mobile (.menu-mobile), klik pada menu induk yang memiliki submenu membuka akordeon submenu
      document.querySelectorAll('.menu-mobile nav ul > li').forEach(li => {
        const childBox = li.querySelector('.child');
        const mainLink = li.querySelector(':scope > a');
        const chevron = li.querySelector(':scope > i');
        if (childBox && mainLink && !mainLink.dataset.mobileSubBound) {
          mainLink.dataset.mobileSubBound = 'true';
          mainLink.addEventListener('click', function(e) {
            e.preventDefault();
            if (chevron) {
              chevron.click();
            } else {
              const isShown = li.classList.toggle('show');
              childBox.style.display = isShown ? 'block' : 'none';
            }
          });
        }
      });

      if (!window._jdihnGlobalClickBound) {
        window._jdihnGlobalClickBound = true;
        document.addEventListener('click', function() {
          items.forEach(li => li.classList.remove('is-open'));
        });
        document.addEventListener('keydown', function(e) {
          if (e.key === 'Escape') {
            items.forEach(li => li.classList.remove('is-open'));
          }
        });
      }
    }

    function initAll() {
      initThemeToggle();
      initJdihnDropdowns();

      const burgerBtn = document.querySelector('header .toggle-menu');
      if (burgerBtn && !burgerBtn.dataset.scrollSyncBound) {
        burgerBtn.dataset.scrollSyncBound = 'true';
        burgerBtn.addEventListener('click', function() {
          setTimeout(() => {
            if (!burgerBtn.classList.contains('active') && window.scrollY <= 0) {
              window.dispatchEvent(new Event('scroll'));
            }
          }, 50);
        });
      }
    }

    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', initAll);
    } else {
      initAll();
    }
  })();
</script>

