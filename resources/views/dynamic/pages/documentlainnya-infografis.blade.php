@extends('dynamic.layouts.layout')

@section('content')
  @include('dynamic.component.banner')
  <section class="middle">
    <div class="wrapper">
      <div class="filter-right">
        <form action="">
          <div class="col">
            <label for="">{{ lang::translate('global.sorting.title') }}</label>
            <select name="sort" id="">
              <option value="latest" @selected(request()->query('sort') == 'latest')>{{ lang::translate('global.sorting.latest') }}</option>
              <option value="oldest" @selected(request()->query('sort') == 'oldest')>{{ lang::translate('global.sorting.oldest') }}</option>
            </select>
          </div>
        </form>
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
          'percepatan-pelaksanaan-penyediaan-infrastruktur-pascapanen' => 'DaebQhEmTzd',
          'piagam-pengawasan-intern-di-kementerian-koordinator-bidang-pangan' => 'DakK8NJlZGN',
          'keterlibatan-tim-koordinasi-penyelenggaraan-program-makan-bergizi-gratis-dalam-pelaksanaan-penyelenggaraan-program-makan-bergizi-gratis' => 'Dawj47SkYob',
          'perubahan-atas-peraturan-pemerintah-nomor-86-tahun-2019-tentang-keamanan-pangan' => 'Da4rL-HEU87',
          'perubahan-pp-86-2019-keamanan-pangan' => 'Da4rL-HEU87',
          'arti-dan-makna-logo-kementerian-koordinator-bidang-pangan' => 'DbAmWAvEd4D',
          'tata-naskah-dinas-kementerian-koordinator-bidang-pangan' => 'DcgA3aAlAyY',
        ];
      ?>
      <style>
        .listing-card.without-box .listing-card__item figure {
          aspect-ratio: 4 / 5;
          height: auto !important;
          background: rgba(15, 23, 42, 0.04);
          border-radius: 12px;
          overflow: hidden;
          display: flex;
          align-items: center;
          justify-content: center;
          position: relative;
        }
        html.dark-mode .listing-card.without-box .listing-card__item figure {
          background: rgba(255, 255, 255, 0.05);
        }
        .listing-card.without-box .listing-card__item figure img {
          width: 100%;
          height: 100%;
          object-fit: contain !important;
          transition: transform 0.25s ease;
        }
        .listing-card.without-box .listing-card__item:hover figure img {
          transform: scale(1.02);
        }
        .infografis-badge-slide {
          position: absolute;
          top: 10px;
          right: 10px;
          background: rgba(15, 23, 42, 0.75);
          color: #fff;
          font-size: 11px;
          font-weight: 600;
          padding: 4px 9px;
          border-radius: 20px;
          display: inline-flex;
          align-items: center;
          gap: 5px;
          backdrop-filter: blur(4px);
          z-index: 2;
        }
        /* Modal Popup Infografis */
        .infografis-modal-overlay {
          position: fixed;
          inset: 0;
          background: rgba(10, 15, 29, 0.85);
          backdrop-filter: blur(6px);
          z-index: 99999;
          display: none;
          align-items: center;
          justify-content: center;
          padding: 20px;
        }
        .infografis-modal-overlay.is-open {
          display: flex;
        }
        .infografis-modal-box {
          background: #ffffff;
          color: #0f172a;
          width: 100%;
          max-width: 960px;
          max-height: 92vh;
          border-radius: 16px;
          overflow: hidden;
          display: flex;
          flex-direction: column;
          box-shadow: 0 25px 60px rgba(0, 0, 0, 0.45);
          position: relative;
        }
        html.dark-mode .infografis-modal-box {
          background: #0f1c2e;
          color: #f1f5f9;
          border: 1px solid rgba(255, 255, 255, 0.12);
        }
        .infografis-modal-header {
          padding: 16px 22px;
          border-bottom: 1px solid rgba(148, 163, 184, 0.22);
          display: flex;
          align-items: center;
          justify-content: space-between;
          gap: 16px;
        }
        .infografis-modal-title {
          font-size: 16px;
          font-weight: 700;
          line-height: 1.4;
          margin: 0;
        }
        .infografis-modal-date {
          font-size: 12px;
          opacity: 0.7;
          display: block;
          margin-bottom: 2px;
        }
        .infografis-modal-close {
          width: 36px;
          height: 36px;
          border-radius: 50%;
          border: 1px solid rgba(148, 163, 184, 0.3);
          background: transparent;
          color: inherit;
          font-size: 20px;
          line-height: 1;
          cursor: pointer;
          flex-shrink: 0;
          display: inline-flex;
          align-items: center;
          justify-content: center;
        }
        .infografis-modal-close:hover {
          background: rgba(239, 68, 68, 0.12);
          color: #ef4444;
          border-color: rgba(239, 68, 68, 0.3);
        }
        .infografis-modal-body {
          overflow-y: auto;
          padding: 20px 24px;
          display: flex;
          flex-direction: column;
          gap: 18px;
        }
        .infografis-viewer-stage {
          position: relative;
          background: #0b1120;
          border-radius: 12px;
          min-height: 420px;
          max-height: 68vh;
          display: flex;
          align-items: center;
          justify-content: center;
          overflow: hidden;
        }
        .infografis-viewer-stage img {
          max-width: 100%;
          max-height: 66vh;
          width: auto;
          height: auto;
          object-fit: contain !important;
          display: block;
          margin: 0 auto;
          user-select: none;
        }
        .infografis-nav-btn {
          position: absolute;
          top: 50%;
          transform: translateY(-50%);
          width: 42px;
          height: 42px;
          border-radius: 50%;
          border: none;
          background: rgba(255, 255, 255, 0.9);
          color: #0f172a;
          font-size: 20px;
          font-weight: 700;
          cursor: pointer;
          display: inline-flex;
          align-items: center;
          justify-content: center;
          box-shadow: 0 4px 14px rgba(0, 0, 0, 0.3);
          z-index: 5;
        }
        .infografis-nav-btn:hover {
          background: #ffffff;
          transform: translateY(-50%) scale(1.06);
        }
        .infografis-nav-btn.prev { left: 14px; }
        .infografis-nav-btn.next { right: 14px; }
        .infografis-slide-counter {
          position: absolute;
          bottom: 12px;
          left: 50%;
          transform: translateX(-50%);
          background: rgba(15, 23, 42, 0.82);
          color: #ffffff;
          font-size: 12px;
          font-weight: 600;
          padding: 4px 12px;
          border-radius: 20px;
          z-index: 5;
        }
        .infografis-thumbs-bar {
          display: flex;
          gap: 8px;
          overflow-x: auto;
          padding-bottom: 4px;
          justify-content: center;
        }
        .infografis-thumb-btn {
          width: 54px;
          height: 64px;
          border-radius: 6px;
          overflow: hidden;
          border: 2px solid transparent;
          padding: 0;
          background: #0b1120;
          cursor: pointer;
          flex-shrink: 0;
          opacity: 0.55;
          transition: all 0.2s ease;
        }
        .infografis-thumb-btn.active {
          border-color: #3b82f6;
          opacity: 1;
        }
        .infografis-thumb-btn img {
          width: 100%;
          height: 100%;
          object-fit: contain;
        }
        .infografis-modal-footer {
          display: flex;
          align-items: center;
          justify-content: space-between;
          flex-wrap: wrap;
          gap: 10px;
          padding-top: 8px;
          border-top: 1px solid rgba(148, 163, 184, 0.2);
        }
        .infografis-modal-desc {
          font-size: 14px;
          line-height: 1.65;
        }
        @media (max-width: 767px) {
          .infografis-viewer-stage { min-height: 300px; }
          .infografis-nav-btn { width: 36px; height: 36px; font-size: 17px; }
        }
      </style>
      <div class="listing-card without-box">
        @foreach ($infografis as $data)
          <?php
            $rawThumb = media::initial($data->thumbnail)->url;
            // Utamakan gambar asli tanpa potongan cover_283_365_ jika ada di source
            $origThumb = str_replace(['/thumbs/', 'cover_283_365_', 'cover_990_1022_'], ['/', '', ''], $rawThumb);
            if (substr($origThumb, -5) === '.webp' && (strpos($origThumb, '.jpg.webp') !== false || strpos($origThumb, '.png.webp') !== false || strpos($origThumb, '.jpeg.webp') !== false)) {
              $origThumb = substr($origThumb, 0, -5);
            }
            $slideUrls = [];
            foreach (widget($data->id, 'information-infografis', 'image') as $imgRow) {
              $u = media::initial($imgRow->image)->url;
              if ($u) {
                $slideUrls[] = $u;
              }
            }
            if (empty($slideUrls) && $rawThumb) {
              $slideUrls[] = $rawThumb;
            }
            $slugKey = trim((string) $data->permalink, '/');
            $slugParts = explode('/', $slugKey);
            $lastSlug = end($slugParts);
            $igCode = isset($igMap[$lastSlug]) ? $igMap[$lastSlug] : null;
            $descHtml = (string) $data->translated('description');
            if (!$igCode && preg_match('/instagram\.com\/(?:p|reel)\/([A-Za-z0-9_-]+)/i', $descHtml, $m)) {
              $igCode = $m[1];
            }
          ?>
          <a href="{{ $data->permalink }}"
             class="listing-card__item js-infografis-popup-trigger"
             data-title="{{ $data->translated('title') }}"
             data-date="{{ date2string($data->date) }}"
             data-permalink="{{ $data->permalink }}"
             data-ig="{{ $igCode }}"
             data-slides="{{ json_encode($slideUrls) }}">
            <template class="js-infografis-desc-tpl">{!! $descHtml !!}</template>
            <figure>
              <span class="infografis-badge-slide">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="3" width="18" height="18" rx="3"/><path d="M8 12h8M12 8v8"/></svg>
                {{ count($slideUrls) > 1 ? count($slideUrls).' Slide' : ($igCode ? 'Carousel IG' : 'Lihat Slide') }}
              </span>
              <img src="{{ $origThumb }}" onerror="if(this.src!=='{{ $rawThumb }}'){this.src='{{ $rawThumb }}';}" alt="{{ media::initial($data->thumbnail)->alt }}">
            </figure>
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
      {{ $infografis->appends(request()->query())->links('dynamic.component.pagination') }}

      <!-- Modal Popup Slide Infografis (Seperti Popup YouTube / Galeri) -->
      <div class="infografis-modal-overlay" id="infografis-popup-modal" aria-hidden="true">
        <div class="infografis-modal-box" role="dialog" aria-modal="true">
          <div class="infografis-modal-header">
            <div>
              <span class="infografis-modal-date" id="ig-modal-date"></span>
              <h4 class="infografis-modal-title" id="ig-modal-title"></h4>
            </div>
            <button type="button" class="infografis-modal-close" id="ig-modal-close" aria-label="Tutup">&times;</button>
          </div>
          <div class="infografis-modal-body">
            <!-- Mode 1: Native Image Slide Viewer (Utuh Tanpa Terpotong) -->
            <div id="ig-modal-native-wrap">
              <div class="infografis-viewer-stage" id="ig-modal-stage">
                <button type="button" class="infografis-nav-btn prev" id="ig-modal-prev" aria-label="Slide Sebelumnya">&#10094;</button>
                <img id="ig-modal-main-img" src="" alt="">
                <button type="button" class="infografis-nav-btn next" id="ig-modal-next" aria-label="Slide Berikutnya">&#10095;</button>
                <div class="infografis-slide-counter" id="ig-modal-counter">1 / 1</div>
              </div>
              <div class="infografis-thumbs-bar" id="ig-modal-thumbs" style="margin-top:12px;"></div>
            </div>

            <!-- Mode 2: Live Instagram Carousel Embed (Lazy Loaded) -->
            <div id="ig-modal-embed-wrap" style="display:none;max-width:540px;width:100%;margin:0 auto;border-radius:12px;overflow:hidden;border:1px solid rgba(148,163,184,0.25);background:#fff;">
              <iframe id="ig-modal-iframe" src="" width="100%" height="640" frameborder="0" scrolling="no" allowtransparency="true" style="display:block;width:100%;border:0;"></iframe>
            </div>

            <div class="infografis-modal-desc" id="ig-modal-desc"></div>

            <div class="infografis-modal-footer">
              <div style="display:flex;gap:8px;flex-wrap:wrap;">
                <button type="button" id="ig-modal-toggle-embed" style="display:none;padding:8px 14px;border-radius:8px;border:1px solid rgba(59,130,246,0.4);background:rgba(59,130,246,0.08);color:inherit;font-size:13px;font-weight:600;cursor:pointer;">Mode Carousel Instagram</button>
                <a id="ig-modal-ig-link" href="#" target="_blank" rel="noopener noreferrer" style="display:none;padding:8px 14px;border-radius:8px;background:linear-gradient(45deg,#f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%);color:#fff;font-size:13px;font-weight:600;text-decoration:none;">Buka di Instagram &nearr;</a>
              </div>
              <a id="ig-modal-detail-link" href="#" style="font-size:13px;font-weight:600;color:#3b82f6;text-decoration:none;">Buka Halaman Penuh &rarr;</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  
  @push('head')
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/document.scss')}}" preload>
  @endpush
  @push('footer')
    {{-- <script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/.js') }}"></script> --}}

    <script>
      document.addEventListener('DOMContentLoaded', function() {
        function sort(){
          const sort = document.querySelector('select[name="sort"]').value;

          const url = new URL(window.location.href);

          if (sort) url.searchParams.set('sort', sort);

          window.location.href = url.toString();
        }

        document.querySelector('select[name="sort"]').addEventListener('change', function() {
          sort();
        });

        // Popup Slide Infografis (Seperti Popup YouTube / Galeri)
        const modal = document.getElementById('infografis-popup-modal');
        const titleEl = document.getElementById('ig-modal-title');
        const dateEl = document.getElementById('ig-modal-date');
        const descEl = document.getElementById('ig-modal-desc');
        const mainImg = document.getElementById('ig-modal-main-img');
        const counterEl = document.getElementById('ig-modal-counter');
        const thumbsEl = document.getElementById('ig-modal-thumbs');
        const prevBtn = document.getElementById('ig-modal-prev');
        const nextBtn = document.getElementById('ig-modal-next');
        const closeBtn = document.getElementById('ig-modal-close');
        const nativeWrap = document.getElementById('ig-modal-native-wrap');
        const embedWrap = document.getElementById('ig-modal-embed-wrap');
        const iframeEl = document.getElementById('ig-modal-iframe');
        const toggleEmbedBtn = document.getElementById('ig-modal-toggle-embed');
        const igLinkEl = document.getElementById('ig-modal-ig-link');
        const detailLinkEl = document.getElementById('ig-modal-detail-link');

        let currentSlides = [];
        let currentIdx = 0;
        let currentIgCode = '';
        let isEmbedMode = false;

        function toUncroppedUrl(rawUrl) {
          if (!rawUrl) return '';
          let u = rawUrl.replace('/thumbs/', '/').replace('cover_990_1022_', '').replace('cover_283_365_', '');
          if (u.endsWith('.webp') && (u.indexOf('.jpg.webp') !== -1 || u.indexOf('.png.webp') !== -1 || u.indexOf('.jpeg.webp') !== -1)) {
            u = u.slice(0, -5);
          }
          return u;
        }

        function renderSlide(idx) {
          if (!currentSlides.length) return;
          currentIdx = (idx + currentSlides.length) % currentSlides.length;
          const rawUrl = currentSlides[currentIdx];
          const uncropped = toUncroppedUrl(rawUrl);
          mainImg.onerror = function() {
            if (mainImg.src !== rawUrl) {
              mainImg.src = rawUrl;
            }
          };
          mainImg.src = uncropped;
          counterEl.textContent = (currentIdx + 1) + ' / ' + currentSlides.length;
          prevBtn.style.display = currentSlides.length > 1 ? 'inline-flex' : 'none';
          nextBtn.style.display = currentSlides.length > 1 ? 'inline-flex' : 'none';
          thumbsEl.style.display = currentSlides.length > 1 ? 'flex' : 'none';
          Array.from(thumbsEl.querySelectorAll('.infografis-thumb-btn')).forEach(function(btn, bIdx) {
            btn.classList.toggle('active', bIdx === currentIdx);
          });
        }

        function setMode(embedMode) {
          isEmbedMode = embedMode;
          if (isEmbedMode && currentIgCode) {
            nativeWrap.style.display = 'none';
            embedWrap.style.display = 'block';
            const targetSrc = 'https://www.instagram.com/p/' + currentIgCode + '/embed/';
            if (iframeEl.src !== targetSrc) {
              iframeEl.src = targetSrc;
            }
            toggleEmbedBtn.textContent = 'Tampilkan Slide Gambar Lokal';
          } else {
            embedWrap.style.display = 'none';
            nativeWrap.style.display = 'block';
            toggleEmbedBtn.textContent = 'Mode Carousel Instagram';
          }
        }

        function openInfografisModal(card) {
          titleEl.textContent = card.getAttribute('data-title') || '';
          dateEl.textContent = card.getAttribute('data-date') || '';
          const descTpl = card.querySelector('.js-infografis-desc-tpl');
          descEl.innerHTML = descTpl ? descTpl.innerHTML : (card.getAttribute('data-desc') || '');
          detailLinkEl.href = card.getAttribute('data-permalink') || '#';
          currentIgCode = card.getAttribute('data-ig') || '';

          try {
            currentSlides = JSON.parse(card.getAttribute('data-slides') || '[]');
          } catch (e) {
            currentSlides = [];
          }

          thumbsEl.innerHTML = '';
          currentSlides.forEach(function(sUrl, idx) {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'infografis-thumb-btn' + (idx === 0 ? ' active' : '');
            const im = document.createElement('img');
            im.src = sUrl;
            im.alt = 'Slide ' + (idx + 1);
            btn.appendChild(im);
            btn.addEventListener('click', function() {
              renderSlide(idx);
            });
            thumbsEl.appendChild(btn);
          });

          if (currentIgCode) {
            igLinkEl.href = 'https://www.instagram.com/p/' + currentIgCode + '/';
            igLinkEl.style.display = 'inline-flex';
            toggleEmbedBtn.style.display = currentSlides.length > 1 ? 'inline-block' : 'none';
          } else {
            igLinkEl.style.display = 'none';
            toggleEmbedBtn.style.display = 'none';
          }

          renderSlide(0);
          // Jika slide lokal hanya 1 (hanya cover) tapi punya kode IG, langsung buka Carousel Instagram!
          if (currentSlides.length <= 1 && currentIgCode) {
            setMode(true);
          } else {
            setMode(false);
          }

          modal.classList.add('is-open');
          modal.setAttribute('aria-hidden', 'false');
          document.body.style.overflow = 'hidden';

          const pLink = (card.getAttribute('data-permalink') || '').replace(/^\/+|\/+$/g, '');
          if (pLink && window.history && window.history.replaceState) {
            const urlObj = new URL(window.location.href);
            urlObj.searchParams.set('open', pLink);
            window.history.replaceState({}, '', urlObj.toString());
          }
        }

        function closeInfografisModal() {
          modal.classList.remove('is-open');
          modal.setAttribute('aria-hidden', 'true');
          iframeEl.src = '';
          document.body.style.overflow = '';
          if (window.history && window.history.replaceState) {
            const urlObj = new URL(window.location.href);
            if (urlObj.searchParams.has('open')) {
              urlObj.searchParams.delete('open');
              window.history.replaceState({}, '', urlObj.toString());
            }
          }
        }

        // Jika halaman di-refresh saat popup terbuka (?open=slug), buka kembali popup yang sama otomatis
        const initialOpenSlug = new URL(window.location.href).searchParams.get('open');
        if (initialOpenSlug) {
          document.querySelectorAll('.js-infografis-popup-trigger').forEach(function(card) {
            const cSlug = (card.getAttribute('data-permalink') || '').replace(/^\/+|\/+$/g, '');
            if (cSlug === initialOpenSlug) {
              openInfografisModal(card);
            }
          });
        }

        document.querySelectorAll('.js-infografis-popup-trigger').forEach(function(card) {
          card.addEventListener('click', function(e) {
            if (e.ctrlKey || e.metaKey || e.shiftKey) return;
            e.preventDefault();
            openInfografisModal(card);
          });
        });

        prevBtn.addEventListener('click', function() { renderSlide(currentIdx - 1); });
        nextBtn.addEventListener('click', function() { renderSlide(currentIdx + 1); });
        closeBtn.addEventListener('click', closeInfografisModal);
        toggleEmbedBtn.addEventListener('click', function() { setMode(!isEmbedMode); });
        modal.addEventListener('click', function(e) {
          if (e.target === modal) closeInfografisModal();
        });
        document.addEventListener('keydown', function(e) {
          if (!modal.classList.contains('is-open')) return;
          if (e.key === 'Escape') closeInfografisModal();
          if (!isEmbedMode && e.key === 'ArrowLeft') renderSlide(currentIdx - 1);
          if (!isEmbedMode && e.key === 'ArrowRight') renderSlide(currentIdx + 1);
        });
      });
    </script>
  @endpush
@endsection
