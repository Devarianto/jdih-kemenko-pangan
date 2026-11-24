@extends('dynamic.layouts.layout')

@section('content')
  <section class="detail-pages no-banner no-pad-bot with-other">
    <div class="wrapper-content">
      <div class="detail-pages--title">
        <span class="date">{{ date2string($infografis->date) }}</span>
        <h3>{{ $infografis->translated('title') }}</h3>
      </div>
      @php($total_slide = widget($infografis->id, 'information-infografis', 'image')->count())
      @if($total_slide > 0)
      <div class="slider-caption with-pagination swiper">
        <div class="swiper-wrapper">
          @foreach(widget($infografis->id, 'information-infografis', 'image') as $image)
            <div class="swiper-slide">
              <figure><img src="{{ media::initial($image->image)->url }}" alt="{{ media::initial($image->image)->alt }}"></figure>
            </div>
          @endforeach
        </div>
        <div class="custom-pagination">
          <span class="current-slide">1</span>/
          <span class="total-slide">{{ $total_slide }}</span>
        </div>
        @if ($total_slide > 1)
        <div class="slider-caption__utils">
          <div class="swiper-arrow swiper-prev"></div>
          <div class="swiper-pagination"></div>
          <div class="swiper-arrow swiper-next"></div>
        </div>
        @endif
      </div>
      @endif
      <div class="content-pages">
        {!! $infografis->translated('description') !!}
      </div>
      <?php
        $igMap = [
          'rencana-strategis-kementerian-koordinator-bidang-pangan-tahun-2025-2029' => 'DTRpxvIEWYx',
          'pedoman-pelaksanaan-neraca-komoditas-pangan' => 'DTRrNEIEVWb',
          'pedoman-pemantauan-dan-evaluasi-serta-penyesuaian-rencana-aksi-percepatan-pembangunan-pergaraman-nasional-' => 'DTRrzgbEegn',
          'pelaksanaan-pemberian-tunjangan-kinerja-bagi-pegawai-di-lingkungan-kementerian-koordinator-bidang-pangan-' => 'DTRsdxPEf3J',
          'organisasi-dan-tata-kerja-kementerian-koordinator-bidang-pangan' => 'DTSfCL3kYkF',
          'tata-kerja-tim-terpadu-pengendalian-alih-fungsi-lahan-sawah-dan-tim-pelaksana-pengendalian-alih-fungsi-lahan-sawah' => 'DXwHaflkf78',
          'percepatan-pelaksanaan-penyediaan-infrastruktur-pascapanen-dalam-rangka-ketahanan-pangan-nasional' => 'DaebQhEmTzd',
          'piagam-pengawasan-intern-di-kementerian-koordinator-bidang-pangan' => 'DakK8NJlZGN',
          'keterlibatan-tim-koordinasi-penyelenggaraan-program-makan-bergizi-gratis-dalam-pelaksanaan-penyelenggaraan-program-makan-bergizi-gratis' => 'Dawj47SkYob',
          'perubahan-atas-peraturan-pemerintah-nomor-86-tahun-2019-tentang-keamanan-pangan' => 'Da4rL-HEU87',
          'arti-dan-makna-logo-kementerian-koordinator-bidang-pangan' => 'DbAmWAvEd4D',
        ];
        $currentSlug = trim(request()->path(), '/');
        $igCode = isset($igMap[$currentSlug]) ? $igMap[$currentSlug] : null;
        if (!$igCode && preg_match('/instagram\.com\/(?:p|reel)\/([A-Za-z0-9_-]+)/i', (string) $infografis->translated('description'), $m)) {
          $igCode = $m[1];
        }
      ?>
      @if($igCode)
      <div class="ig-source-card" style="margin-top:20px;padding:14px 18px;border-radius:12px;border:1px solid rgba(30,58,138,0.18);background:rgba(30,58,138,0.04);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
        <div style="display:flex;align-items:center;gap:10px;font-size:14px;font-weight:500;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#E1306C;flex-shrink:0;"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
          <span>Infografis ini juga dipublikasikan di Instagram resmi <strong>{{ '@'.'jdih.kemenkopangan' }}</strong></span>
        </div>
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
          <button type="button" onclick="var box=document.getElementById('ig-embed-box-{{ $igCode }}');var frame=document.getElementById('ig-embed-frame-{{ $igCode }}');if(box.style.display==='none'){box.style.display='block';if(!frame.src){frame.src=frame.getAttribute('data-src');}this.innerText='Sembunyikan Embed Instagram';}else{box.style.display='none';this.innerText='Tampilkan Postingan Instagram';}" style="padding:8px 14px;border-radius:8px;border:1px solid rgba(30,58,138,0.3);background:transparent;color:inherit;font-size:13px;font-weight:600;cursor:pointer;">Tampilkan Postingan Instagram</button>
          <a href="https://www.instagram.com/p/{{ $igCode }}/" target="_blank" rel="noopener noreferrer" style="padding:8px 14px;border-radius:8px;background:linear-gradient(45deg,#f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%);color:#fff;font-size:13px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:6px;">Buka di Instagram &nearr;</a>
        </div>
      </div>
      <div id="ig-embed-box-{{ $igCode }}" style="display:none;margin-top:16px;max-width:540px;margin-left:auto;margin-right:auto;border-radius:12px;overflow:hidden;border:1px solid rgba(148,163,184,0.25);background:#fff;">
        <iframe id="ig-embed-frame-{{ $igCode }}" data-src="https://www.instagram.com/p/{{ $igCode }}/embed/captioned/" width="100%" height="680" frameborder="0" scrolling="no" allowtransparency="true" loading="lazy" style="display:block;width:100%;border:0;"></iframe>
      </div>
      @endif
      <div class="detail-pages--top bottom-version">
        <a href="{{ $menu->permalink }}" class="back">{{ lang::translate('infografis.back-to-infografis') }}</a>
        <div class="medsos">
          <label for="">{{ lang::translate('infografis.share') }}</label>
          <div class="wrap">
            <a href="javascript:;" data-url="{{ url()->current() }}" onclick="navigator.clipboard.writeText(this.dataset.url).then(()=>{ alert('{{ lang::translate('global.url-copy') }}'); });"><img src="{{ asset('images/material/ic-link.svg') }}" alt=""></a>
            <a href="{{ $infografis->share('wa') }}" target="__BLANK"><img src="{{ asset('images/material/ic-wa.svg') }}" alt=""></a>
            <a href="{{ $infografis->share('tw') }}" target="__BLANK"><img src="{{ asset('images/material/ic-x.svg') }}" alt=""></a>
            <a href="{{ $infografis->share('fb') }}" target="__BLANK"><img src="{{ asset('images/material/ic-fb.svg') }}" alt=""></a>
          </div>
        </div>
      </div>  
    </div>
    @if (!$others->isEmpty())
    <div class="other-listing">
      <div class="wrapper">
        <h4>{{ lang::translate('infografis.other-infografis') }}</h4>
        <div class="listing-card without-box">
          @foreach ($others as $data)
          <a href="{{ $data->permalink }}" class="listing-card__item">
            <figure><img src="{{ media::initial($data->thumbnail)->url }}" alt="{{ media::initial($data->thumbnail)->alt }}"></figure>
            <figcaption>
              <p>{{ $data->translated('title') }}</p>
              <small class="visited">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                  <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                {{ lang::translate('global.view', ['count' => $data->view_count]) }}
              </small>
            </figcaption>
          </a>
          @endforeach
        </div>
      </div>
    </div>
    @endif
  </section>
  @push('head')
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/document.scss')}}" preload>
  @endpush
  @push('footer')
    <script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/document.js') }}"></script>
  @endpush
@endsection
