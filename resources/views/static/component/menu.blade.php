<div class="wrapper">
  <a href="{{ route('front.index') }}" class="logo">
    <img class="white" src="{{asset('images/material/logo.png')}}" width="308" height="58" alt="">
    <img class="black" src="{{asset('images/material/logo-black.png')}}" width="308" height="58" alt="">
  </a>
  <div class="right-header">
@php
  if (!function_exists('getJdihnMenuMetaStatic')) {
    function getJdihnMenuMetaStatic($label) {
      $norm = strtolower(trim($label));
      
      if (str_contains($norm, 'peraturan') && !str_contains($norm, 'terjemahan') && !str_contains($norm, 'program')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m16 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"/><path d="m2 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"/><path d="M7 21h10"/><path d="M12 3v18"/><path d="M3 7h2c2 0 5-1 7-2 2 1 5 2 7 2h2"/></svg>',
          'desc' => 'Peraturan perundang-undangan dan regulasi pemerintah'
        ];
      }
      if (str_contains($norm, 'analisis') || str_contains($norm, 'evaluasi') || str_contains($norm, 'anev')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>',
          'desc' => 'Hasil analisis dan evaluasi peraturan'
        ];
      }
      if (str_contains($norm, 'naskah akademik') || str_contains($norm, 'naskah urgensi') || str_contains($norm, 'akademik')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>',
          'desc' => 'Naskah akademik rancangan peraturan'
        ];
      }
      if (str_contains($norm, 'putusan') || str_contains($norm, 'yurisprudensi')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m14 13-7.5 7.5c-.83.83-2.17.83-3 0 0 0 0 0 0 0a2.12 2.12 0 0 1 0-3L11 10"/><path d="m16 16 6-6"/><path d="m8 8 6-6"/><path d="m9 7 8 8"/><path d="m21 11-8-8"/></svg>',
          'desc' => 'Putusan pengadilan dan yurisprudensi'
        ];
      }
      if (str_contains($norm, 'monografi')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/><path d="M6 6h10"/><path d="M6 10h10"/><path d="M6 14h6"/></svg>',
          'desc' => 'Buku dan karya ilmiah bidang hukum'
        ];
      }
      if (str_contains($norm, 'artikel') || str_contains($norm, 'majalah') || str_contains($norm, 'jurnal')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8V6Z"/></svg>',
          'desc' => 'Artikel dan jurnal ilmiah hukum'
        ];
      }
      if (str_contains($norm, 'kerja sama') || str_contains($norm, 'kerjasama') || str_contains($norm, 'perjanjian')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m11 17 2 2a1 1 0 0 0 1.4 0l6.6-6.6a2 2 0 0 0 0-2.8l-3.6-3.6a2 2 0 0 0-2.8 0L13 7.6"/><path d="m7 7-2 2a1 1 0 0 0 0 1.4l6.6 6.6a2 2 0 0 0 2.8 0l3.6-3.6a2 2 0 0 0 0-2.8L16.4 9"/><path d="M2 13l3.6 3.6a2 2 0 0 0 2.8 0L11 14"/></svg>',
          'desc' => 'Perjanjian kerja sama antar lembaga'
        ];
      }
      if (str_contains($norm, 'kolonial') || str_contains($norm, 'terjemahan')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="21" x2="21" y2="21"/><line x1="6" y1="21" x2="6" y2="10"/><line x1="10" y1="21" x2="10" y2="10"/><line x1="14" y1="21" x2="14" y2="10"/><line x1="18" y1="21" x2="18" y2="10"/><polygon points="12 3 2 9 22 9 12 3"/></svg>',
          'desc' => 'Terjemahan resmi peraturan perundang-undangan'
        ];
      }
      if (str_contains($norm, 'program')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><path d="m9 16 2 2 4-4"/></svg>',
          'desc' => 'Program perencanaan penyusunan PUU'
        ];
      }
      if (str_contains($norm, 'rancangan')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>',
          'desc' => 'Draf rancangan peraturan perundang-undangan'
        ];
      }
      if (str_contains($norm, 'risalah')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/><path d="M9 12h6"/><path d="M9 16h6"/></svg>',
          'desc' => 'Catatan dan risalah rapat pembahasan PUU'
        ];
      }
      if (str_contains($norm, 'kajian')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/><path d="M11 8v6"/><path d="M8 11h6"/></svg>',
          'desc' => 'Hasil telaah dan kajian komprehensif hukum'
        ];
      }
      if (str_contains($norm, 'pengajuan puu') || str_contains($norm, 'e-regulasi') || str_contains($norm, 'puu submission')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h6v6"/><path d="M10 14 21 3"/><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/></svg>',
          'desc' => 'Layanan pengajuan dan penyusunan regulasi (e-Regulasi)'
        ];
      }
      if (str_contains($norm, 'harmonisasi')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m16 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"/><path d="m2 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"/><path d="M7 21h10"/><path d="M12 3v18"/><path d="M3 7h2c2 0 5-1 7-2 2 1 5 2 7 2h2"/></svg>',
          'desc' => 'Prosedur dan pengajuan harmonisasi PUU'
        ];
      }
      if (str_contains($norm, 'pengundangan')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><polyline points="10 9 9 9 8 9"/></svg>',
          'desc' => 'Permohonan dan verifikasi pengundangan PUU'
        ];
      }
      if (str_contains($norm, 'partisipasi')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
          'desc' => 'Konsultasi dan partisipasi publik regulasi'
        ];
      }
      if (str_contains($norm, 'visi')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>',
          'desc' => 'Visi, misi, dan arah strategis Kemenko Pangan'
        ];
      }
      if (str_contains($norm, 'dasar hukum')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>',
          'desc' => 'Landasan regulasi pengelolaan sistem JDIH'
        ];
      }
      if (str_contains($norm, 'struktur')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>',
          'desc' => 'Bagan susunan organisasi dan tim pengelola'
        ];
      }
      if (str_contains($norm, 'sop')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>',
          'desc' => 'Standar operasional prosedur pengelolaan JDIH'
        ];
      }
      if (str_contains($norm, 'statistik')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="20" x2="12" y2="10"/><line x1="18" y1="20" x2="18" y2="4"/><line x1="6" y1="20" x2="6" y2="16"/></svg>',
          'desc' => 'Data statistik dokumen dan kunjungan portal'
        ];
      }
      if (str_contains($norm, 'berita')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v1m2 13a2 2 0 0 1-2-2V7m2 13a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>',
          'desc' => 'Kabar dan dokumentasi kegiatan hukum terbaru'
        ];
      }
      if (str_contains($norm, 'galeri') || str_contains($norm, 'gallery')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>',
          'desc' => 'Dokumentasi foto kegiatan dan koordinasi'
        ];
      }
      if (str_contains($norm, 'infografis')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>',
          'desc' => 'Ringkasan visual peraturan dan kebijakan'
        ];
      }
      if (str_contains($norm, 'videografis') || str_contains($norm, 'video')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>',
          'desc' => 'Media sosialisasi kebijakan dalam bentuk video'
        ];
      }
      if (str_contains($norm, 'aksesibilitas')) {
        return [
          'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="4" r="2"/><path d="m4.5 7.5 7.5 3.5 7.5-3.5"/><path d="M12 11v10"/><path d="m6 21 6-5 6 5"/></svg>',
          'desc' => 'Fitur ramah disabilitas dan kemudahan akses'
        ];
      }
      
      return [
        'icon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>',
        'desc' => 'Dokumentasi dan informasi hukum terkait'
      ];
    }
  }
@endphp

    <nav>
      <ul>
        {{-- 0. Beranda --}}
        <li>
          <a href="{{ lang::url('/') }}" @class(['active' => request()->is('/') || request()->is(lang::active()) || request()->routeIs('home')])>{{ lang::active() == 'en' ? 'Home' : 'Beranda' }}</a>
        </li>

        {{-- 1. Tentang Kami --}}
        <li class="have-child">
          <a href="{{ route('front.about') }}" class="nav-parent-link">
            <span>Tentang Kami</span>
            <svg class="nav-chevron" width="12" height="12" viewBox="0 0 12 12" fill="none">
              <path d="M2.5 4.5L6 8L9.5 4.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </a>
          <div class="child jdihn-mega-menu">
            <div class="jdihn-mega-grid">
              @php
                $tentangItems = [
                  ['label' => 'Visi Misi', 'url' => route('front.about-visimisi')],
                  ['label' => 'Dasar Hukum', 'url' => '#'],
                  ['label' => 'Struktur Organisasi', 'url' => route('front.about-struktur')],
                  ['label' => 'SOP', 'url' => route('front.about-sop')],
                  ['label' => 'Statistik', 'url' => route('front.about-statistik')],
                ];
              @endphp
              @foreach($tentangItems as $item)
                @php
                    $meta = getJdihnMenuMetaStatic($item['label']);
                @endphp
                <a href="{{ $item['url'] }}" class="jdihn-item">
                  <div class="jdihn-item-icon">{!! $meta['icon'] !!}</div>
                  <div class="jdihn-item-content">
                    <div class="jdihn-item-title">{{ $item['label'] }}</div>
                    <div class="jdihn-item-desc">{{ $meta['desc'] }}</div>
                  </div>
                </a>
              @endforeach
            </div>
          </div>
        </li>

        {{-- 2. Jenis Dokumen --}}
        <li class="have-child">
          <a href="#" class="nav-parent-link">
            <span>Jenis Dokumen</span>
            <svg class="nav-chevron" width="12" height="12" viewBox="0 0 12 12" fill="none">
              <path d="M2.5 4.5L6 8L9.5 4.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </a>
          <div class="child jdihn-mega-menu">
            <div class="jdihn-mega-grid">
              @php
                $dokumenItems = [
                  ['label' => 'Peraturan', 'url' => route('front.document-peraturan')],
                  ['label' => 'Monografi', 'url' => route('front.document-monografi')],
                  ['label' => 'Artikel/Majalah Hukum', 'url' => route('front.document-article')],
                  ['label' => 'Peraturan Terjemahan', 'url' => '#'],
                  ['label' => 'Naskah Kerja Sama', 'url' => '#'],
                  ['label' => 'Putusan', 'url' => route('front.document-putusan')],
                ];
              @endphp
              @foreach($dokumenItems as $item)
                @php
                    $meta = getJdihnMenuMetaStatic($item['label']);
                @endphp
                <a href="{{ $item['url'] }}" class="jdihn-item">
                  <div class="jdihn-item-icon">{!! $meta['icon'] !!}</div>
                  <div class="jdihn-item-content">
                    <div class="jdihn-item-title">{{ $item['label'] }}</div>
                    <div class="jdihn-item-desc">{{ $meta['desc'] }}</div>
                  </div>
                </a>
              @endforeach
            </div>
          </div>
        </li>

        {{-- 3. Dokumen Pembentukan PUU --}}
        <li class="have-child">
          <a href="#" class="nav-parent-link">
            <span>Dokumen Pembentukan PUU</span>
            <svg class="nav-chevron" width="12" height="12" viewBox="0 0 12 12" fill="none">
              <path d="M2.5 4.5L6 8L9.5 4.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </a>
          <div class="child jdihn-mega-menu">
            <div class="jdihn-mega-grid">
              @php
                $puuItems = [
                  ['label' => 'Rancangan PUU', 'url' => route('front.informasi-rancangan')],
                  ['label' => 'Naskah Urgensi/Akademik', 'url' => '#'],
                  ['label' => 'Anev PUU', 'url' => '#'],
                  ['label' => 'Risalah Pembahasan', 'url' => '#'],
                  ['label' => 'Kajian Hukum', 'url' => '#'],
                  ['label' => 'Pengajuan Harmonisasi', 'url' => '#'],
                  ['label' => 'Permohonan Pengundangan', 'url' => '#'],
                  ['label' => 'Pengajuan PUU', 'url' => url('/pengajuan-puu')],
                  ['label' => 'Program Penyusunan PUU', 'url' => '#'],
                  ['label' => 'Partisipasi Publik', 'url' => 'https://regulasikemenkopangan.id/'],
                ];
              @endphp
              @foreach($puuItems as $item)
                @php
                    $meta = getJdihnMenuMetaStatic($item['label']);
                @endphp
                @php
                    $isExt = str_starts_with($item['url'], 'http://') || str_starts_with($item['url'], 'https://') || str_contains($item['url'], 'pengajuan-puu');
                @endphp
                <a href="{{ $item['url'] }}" class="jdihn-item" @if($isExt) target="_blank" rel="noopener noreferrer" @endif>
                  <div class="jdihn-item-icon">{!! $meta['icon'] !!}</div>
                  <div class="jdihn-item-content">
                    <div class="jdihn-item-title">{{ $item['label'] }}</div>
                    <div class="jdihn-item-desc">{{ $meta['desc'] }}</div>
                  </div>
                </a>
              @endforeach
            </div>
          </div>
        </li>

        {{-- 4. Informasi --}}
        <li class="have-child">
          <a href="#" class="nav-parent-link">
            <span>Informasi</span>
            <svg class="nav-chevron" width="12" height="12" viewBox="0 0 12 12" fill="none">
              <path d="M2.5 4.5L6 8L9.5 4.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </a>
          <div class="child jdihn-mega-menu">
            <div class="jdihn-mega-grid single-col">
              @php
                $infoItems = [
                  ['label' => 'Berita', 'url' => route('front.documentlainnya-berita'), 'sub' => null],
                  ['label' => 'Gallery', 'url' => route('front.informasi-galeri'), 'sub' => 'Foto dan Video'],
                  ['label' => 'Aksesibilitas', 'url' => '#', 'sub' => 'Videografis'],
                  ['label' => 'Infografis', 'url' => route('front.documentlainnya-infografis'), 'sub' => null],
                ];
              @endphp
              @foreach($infoItems as $item)
                @php
                    $meta = getJdihnMenuMetaStatic($item['label']);
                @endphp
                <a href="{{ $item['url'] }}" class="jdihn-item">
                  <div class="jdihn-item-icon">{!! $meta['icon'] !!}</div>
                  <div class="jdihn-item-content">
                    <div class="jdihn-item-title-row">
                      <div class="jdihn-item-title">{{ $item['label'] }}</div>
                      @if(!empty($item['sub']))
                        <div class="jdihn-subchild-tags">
                          <span class="jdihn-subchild-pill">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                            {{ $item['sub'] }}
                          </span>
                        </div>
                      @endif
                    </div>
                    <div class="jdihn-item-desc">{{ $meta['desc'] }}</div>
                  </div>
                </a>
              @endforeach
            </div>
          </div>
        </li>

        {{-- 5. Kontak --}}
        <li><a href="{{ route('front.about-contactus') }}">Kontak</a></li>
      </ul>
    </nav>
      {{-- <div class="after-login">
        <a href="">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
            <path d="M15.344 15L15.5882 14.7558C15.9137 14.4303 15.9137 13.903 15.5882 13.5774C15.2627 13.2518 14.7354 13.2519 14.4098 13.5774L12.7437 15.2435C12.6666 15.3204 12.6055 15.4128 12.5632 15.5149C12.4789 15.7186 12.4789 15.948 12.5632 16.1516C12.6055 16.2538 12.6665 16.346 12.7437 16.423L14.4098 18.0891C14.5725 18.2519 14.7857 18.3333 14.9989 18.3333C15.2122 18.3333 15.4254 18.2519 15.5881 18.0892C15.9136 17.7637 15.9136 17.2363 15.5881 16.9108L15.344 16.6667H17.4989C17.9595 16.6667 18.3323 16.2935 18.3323 15.8333C18.3323 15.3732 17.9595 15 17.4989 15H15.344Z" fill="white" />
            <path d="M4.30024 14.4678L4.22458 14.7644C4.08708 15.3117 4.19449 15.8952 4.51758 16.3652C4.86183 16.8648 5.41441 17.1944 6.03616 17.2693C7.34474 17.4223 8.67774 17.5 9.99933 17.5C10.3313 17.5 10.6642 17.4918 10.9962 17.4829C11.4561 17.4711 11.8198 17.0883 11.8076 16.628C11.7954 16.1755 11.4251 15.8167 10.9751 15.8167C10.9669 15.8167 10.9596 15.8167 10.9523 15.8171C9.37766 15.8566 7.78666 15.7963 6.23308 15.6144C6.08824 15.5969 5.96374 15.5261 5.89049 15.4199C5.83599 15.3406 5.81966 15.2559 5.84008 15.1738L5.91416 14.8853C6.14608 13.9978 6.81508 13.2666 7.70616 12.9281C9.16124 12.3694 10.7823 12.3601 12.2716 12.9203C12.3033 12.9338 12.3399 12.9488 12.3945 12.9704C12.5068 13.0128 12.6077 13.0664 12.7135 13.1385C13.0943 13.3977 13.6127 13.3 13.8715 12.9196C14.1311 12.5395 14.0327 12.0208 13.6526 11.7616C13.4393 11.6163 13.2221 11.502 13.0642 11.4463C13.0202 11.4243 12.9762 11.4063 12.9641 11.4048C12.9388 11.3922 12.9137 11.3812 12.8876 11.371C11.0004 10.6548 8.96016 10.6613 7.11199 11.371C5.71958 11.8994 4.66891 13.0558 4.30024 14.4678Z" fill="white" />
            <path d="M14.1654 5.83334C14.1654 3.53601 12.296 1.66667 9.9987 1.66667C7.70136 1.66667 5.83203 3.53601 5.83203 5.83334C5.83203 8.13067 7.70136 10 9.9987 10C12.296 10 14.1654 8.13067 14.1654 5.83334ZM7.4987 5.83334C7.4987 4.45476 8.62011 3.33334 9.9987 3.33334C11.3773 3.33334 12.4987 4.45476 12.4987 5.83334C12.4987 7.21192 11.3773 8.33334 9.9987 8.33334C8.62011 8.33334 7.4987 7.21192 7.4987 5.83334Z" fill="white" />
          </svg>
          User
        </a>
        <div class="after-login__drop">
          <ul>
            <li>
              <a href="">
                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="24" viewBox="0 0 23 24" fill="none">
                  <path d="M22.4397 14.6049L21.2603 13.4341C20.9064 13.0829 20.4051 12.878 19.9038 12.878C19.3731 12.878 18.9013 13.0829 18.5474 13.4341L12.0603 19.9024C11.8833 20.078 11.7949 20.2829 11.7949 20.5171V23.122C11.7949 23.6195 12.1782 24 12.6795 24H15.3038C15.5397 24 15.7756 23.9122 15.9231 23.7366L22.4397 17.2976C22.7936 16.9463 23 16.4488 23 15.9512C23 15.4537 22.7936 14.9561 22.4397 14.6049ZM19.9038 14.6341C19.9333 14.6341 19.9923 14.6341 20.0218 14.6927L21.2013 15.8634C21.2308 15.8927 21.2603 15.9512 21.2603 15.9805C21.2603 16.0098 21.2603 16.0683 21.2013 16.0976L20.4641 16.8293L19.0782 15.4537L19.8154 14.722C19.8154 14.6341 19.8744 14.6341 19.9038 14.6341ZM14.95 22.2439H13.5641V20.8683L17.7808 16.6829L19.1667 18.0585L14.95 22.2439ZM9.14103 21.0732H4.42308C2.56538 21.0732 1.76923 20.2829 1.76923 18.439V4.39024C1.76923 2.54634 2.56538 1.7561 4.42308 1.7561H10.6154V4.39024C10.6154 7.22927 12.1782 8.78049 15.0385 8.78049H17.6923V10.2439C17.6923 10.7415 18.0756 11.122 18.5769 11.122C19.0782 11.122 19.4615 10.7415 19.4615 10.2439V7.90244C19.4615 7.66829 19.3731 7.43415 19.1962 7.2878L12.1192 0.263415C11.9718 0.0878049 11.7359 0 11.5 0H4.42308C1.56282 0 0 1.55122 0 4.39024V18.439C0 21.278 1.56282 22.8293 4.42308 22.8293H9.14103C9.64231 22.8293 10.0256 22.4488 10.0256 21.9512C10.0256 21.4537 9.64231 21.0732 9.14103 21.0732ZM12.3846 4.39024V2.98537L16.4538 7.02439H15.0385C13.1808 7.02439 12.3846 6.23415 12.3846 4.39024ZM5.60256 10.5366C5.10128 10.5366 4.71795 10.9171 4.71795 11.4146C4.71795 11.9122 5.10128 12.2927 5.60256 12.2927H13.859C14.3603 12.2927 14.7436 11.9122 14.7436 11.4146C14.7436 10.9171 14.3603 10.5366 13.859 10.5366H5.60256ZM10.3205 15.2195H5.60256C5.10128 15.2195 4.71795 15.6 4.71795 16.0976C4.71795 16.5951 5.10128 16.9756 5.60256 16.9756H10.3205C10.8218 16.9756 11.2051 16.5951 11.2051 16.0976C11.2051 15.6 10.8218 15.2195 10.3205 15.2195Z" fill="#000000"></path>
                </svg>
                Daftar Usulan Project
              </a>
            </li>
            <li>
              <a href="" class="active">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <path d="M10.3902 20.093H5.02439C3.33415 20.093 2.60976 19.3395 2.60976 17.5814V4.18605C2.60976 2.42791 3.33415 1.67442 5.02439 1.67442H10.6585V4.18605C10.6585 6.89302 12.0805 8.37209 14.6829 8.37209H17.0976V10.8837C17.0976 11.3581 17.4463 11.7209 17.9024 11.7209C18.3585 11.7209 18.7073 11.3581 18.7073 10.8837V7.53488C18.7073 7.31163 18.6268 7.08837 18.4659 6.94884L12.0268 0.251163C11.8927 0.0837209 11.678 0 11.4634 0H5.02439C2.42195 0 1 1.47907 1 4.18605V17.5814C1 20.2884 2.42195 21.7674 5.02439 21.7674H10.3902C10.8463 21.7674 11.1951 21.4047 11.1951 20.9302C11.1951 20.4558 10.8463 20.093 10.3902 20.093ZM12.2683 4.18605V2.84651L15.9707 6.69767H14.6829C12.9927 6.69767 12.2683 5.94419 12.2683 4.18605ZM13.6098 10.0465C14.0659 10.0465 14.4146 10.4093 14.4146 10.8837C14.4146 11.3581 14.0659 11.7209 13.6098 11.7209H6.09756C5.64146 11.7209 5.29268 11.3581 5.29268 10.8837C5.29268 10.4093 5.64146 10.0465 6.09756 10.0465H13.6098ZM11.1951 15.3488C11.1951 15.8233 10.8463 16.186 10.3902 16.186H6.09756C5.64146 16.186 5.29268 15.8233 5.29268 15.3488C5.29268 14.8744 5.64146 14.5116 6.09756 14.5116H10.3902C10.8463 14.5116 11.1951 14.8744 11.1951 15.3488ZM17.9024 13.3953C15.0854 13.3953 12.8049 15.7674 12.8049 18.6977C12.8049 21.6279 15.0854 24 17.9024 24C20.7195 24 23 21.6279 23 18.6977C23 15.7674 20.7195 13.3953 17.9024 13.3953ZM17.9024 22.3256C15.9707 22.3256 14.4146 20.707 14.4146 18.6977C14.4146 16.6884 15.9707 15.0698 17.9024 15.0698C19.8341 15.0698 21.3902 16.6884 21.3902 18.6977C21.3902 20.707 19.8341 22.3256 17.9024 22.3256ZM19.8073 17.1628C20.1293 17.4977 20.1293 18.0279 19.8073 18.3349L18.0098 20.2047C17.8488 20.3721 17.661 20.4558 17.4463 20.4558C17.2317 20.4558 17.0171 20.3721 16.8829 20.2047L15.9976 19.2837C15.6756 18.9488 15.6756 18.4186 15.9976 18.1116C16.3195 17.7767 16.8293 17.7767 17.1244 18.1116L17.4463 18.4465L18.6537 17.1907C19.0024 16.8558 19.4854 16.8558 19.8073 17.1628Z" fill="#000000"></path>
                </svg>
                Daftar Project
              </a>
            </li>
            <li>
              <a href="">Logout</a>
            </li>
          </ul>
        </div>
      </div> --}}
      {{-- <a href="javascript:void(0)" class="button-icon">
        <i class="wa-icon wa-ic-logout-outline"></i>
        logout
      </a> --}}
    </div>
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
      <img src="{{asset('images/material/flag-idn.svg')}}" width="40" height="40" alt="">
      <div class="drop-language">
        <a href="" class="active"><img src="{{ asset('images/material/US.webp') }}" width="22" height="20" alt=""></a>
        <a href=""><img src="{{ asset('images/material/IND.webp') }}" width="22" height="20" alt=""></a>
      </div>
    </div>
    <div class="toggle-menu">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
</div>
<div class="header-bot">
  <div class="wrapper">
    <form action="">
      <input type="text" placeholder="Ketik Kata Kunci Pencarian">
    </form>
  </div>
</div>

<div class="popup popup-login" id="popup-login">
  <div class="popup__overlay"></div>
  <div class="popup__box popup__box--large">
    <div class="popup__close">
      <i class="wa-icon wa-ic-close-solid"></i>
    </div>
    <div class="popup__content">
      <figure>
        <img
          src="{{ asset('images/content/content-login.jpg') }}"
          data-img-large="{{ asset('images/content/content-login.jpg') }}"
          data-img-medium="{{ asset('images/content/content-login.jpg') }}"
          data-img-small="{{ asset('images/content/content-login.jpg') }}"
          width="337" height="546" alt="login">
      </figure>
      <figcaption>
        <h5>Masuk Akun </h5>
        <p>Silahkan masukkan username dan password anda untuk melanjutkan ke sistem JDIH Kemenko Pangan Internal</p>
        <form action="">
          <div class="row row-wrap">
            <div class="column column-100">
              <label for="">Email</label>
              <input type="Email" placeholder="Masukan Email">
            </div>
            <div class="column column-100">
              <label for="">Password</label>
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
              <button type="submit" class="button button-gradient button-full">Masuk Sekarang</button>
            </div>
          </div>
        </form>
        <small>©2025 Biro Hukum ⋅ Kementerian Kordinator Bidang Pangan</small>
      </figcaption>
    </div>
  </div>
</div>

<section class="menu-mobile">
  <nav>
    <ul>
      <li>
        <a href="{{ lang::url('/') }}" @class(['active' => request()->is('/') || request()->is(lang::active()) || request()->routeIs('home')])>{{ lang::active() == 'en' ? 'Home' : 'Beranda' }}</a>
      </li>
      <li>
        <a href="{{ route('front.about') }}">Tentang Kami</a>
        <i class="wa-icon wa-ic-chevron-down-solid"></i>
        <div class="child">
          <a href="{{ route('front.about-visimisi') }}">Visi Misi</a>
          <a href="#">Dasar Hukum</a>
          <a href="{{ route('front.about-struktur') }}">Struktur Organisasi</a>
          <a href="{{ route('front.about-sop') }}">SOP</a>
          <a href="{{ route('front.about-statistik') }}">Statistik</a>
        </div>
      </li>
      <li>
        <a href="#">Jenis Dokumen</a>
        <i class="wa-icon wa-ic-chevron-down-solid"></i>
        <div class="child">
          <a href="{{ route('front.document-peraturan') }}">Peraturan</a>
          <a href="{{ route('front.document-monografi') }}">Monografi</a>
          <a href="{{ route('front.document-article') }}">Artikel/Majalah Hukum</a>
          <a href="#">Peraturan Terjemahan</a>
          <a href="#">Naskah Kerja Sama</a>
          <a href="{{ route('front.document-putusan') }}">Putusan</a>
        </div>
      </li>
      <li>
        <a href="#">Dokumen Pembentukan PUU</a>
        <i class="wa-icon wa-ic-chevron-down-solid"></i>
        <div class="child">
          <a href="{{ route('front.informasi-rancangan') }}">Rancangan PUU</a>
          <a href="#">Naskah Urgensi/Akademik</a>
          <a href="#">Anev PUU</a>
          <a href="#">Risalah Pembahasan</a>
          <a href="#">Kajian Hukum</a>
          <a href="#">Pengajuan Harmonisasi</a>
          <a href="#">Permohonan Pengundangan</a>
          <a href="{{ url('/pengajuan-puu') }}" target="_blank" rel="noopener noreferrer">Pengajuan PUU (e-Regulasi)</a>
          <a href="#">Program Penyusunan PUU</a>
          <a href="https://regulasikemenkopangan.id/" target="_blank" rel="noopener noreferrer">Partisipasi Publik</a>
        </div>
      </li>
      <li>
        <a href="#">Informasi</a>
        <i class="wa-icon wa-ic-chevron-down-solid"></i>
        <div class="child">
          <a href="{{ route('front.documentlainnya-berita') }}">Berita</a>
          <a href="{{ route('front.informasi-galeri') }}">Gallery</a>
          <a href="{{ route('front.informasi-galeri') }}" style="padding-left: 28px !important; font-size: 13px !important; opacity: 0.88 !important;">↳ Foto dan Video</a>
          <a href="#">Aksesibilitas</a>
          <a href="#" style="padding-left: 28px !important; font-size: 13px !important; opacity: 0.88 !important;">↳ Videografis</a>
          <a href="{{ route('front.documentlainnya-infografis') }}">Infografis</a>
        </div>
      </li>
      <li><a href="{{ route('front.about-contactus') }}">Kontak</a></li>
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
      <select name="" id="">
        <option value="">EN</option>
        <option value="">ID</option>
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
  header .wrapper {
    max-width: 100% !important;
    width: 100% !important;
    margin: 0 !important;
    padding: 0 clamp(16px, 2.5vw, 48px) !important;
    box-sizing: border-box !important;
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
  }
  header .logo {
    flex-shrink: 0 !important;
    display: inline-flex !important;
    align-items: center !important;
    margin-right: auto !important;
    padding: 10px 0 !important;
  }
  header .logo img {
    height: auto !important;
    max-height: 48px !important;
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
    margin-left: auto !important;
    display: flex !important;
    align-items: center !important;
    gap: clamp(14px, 1.8vw, 24px) !important;
    min-width: 0 !important;
  }
  header nav > ul {
    gap: clamp(14px, 1.5vw, 28px) !important;
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
    font-weight: 500 !important;
    border: 1px solid rgba(255, 255, 255, 0.3) !important;
    background: rgba(255, 255, 255, 0.1) !important;
    color: #ffffff !important;
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
    min-width: 580px !important;
    max-width: 680px !important;
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
  [data-theme="dark"] body {
    background-color: #0b1120 !important;
    color: #cbd5e1 !important;
    transition: background-color 0.3s ease, color 0.3s ease;
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
        const trigger = li.querySelector('.nav-parent-link, > a');
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
    }

    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', initAll);
    } else {
      initAll();
    }
  })();
</script>