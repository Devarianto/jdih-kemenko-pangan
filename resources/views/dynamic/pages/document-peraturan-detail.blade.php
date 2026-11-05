@extends('dynamic.layouts.layout')

@php
  $hasEnTranslation = !empty($document->has_translation) || !empty($document->translation_pdf) || !empty($document->translation_title);
  $idTitle = $document->translated('title');
  $enTitle = $document->translation_title ?: $document->translated('title');
  $idIntro = $document->translated('intro');
  $enIntro = $document->translation_intro ?: $document->translated('intro');
  $idNoPeraturan = $document->no_peraturan;
  $enNoPeraturan = $document->translation_no_peraturan ?: $document->no_peraturan;
  $hasTranslationPdf = !empty($document->translation_pdf) && \Storage::exists($document->translation_pdf);
@endphp

@section('content')
  <section class="detail-pages">
    <section class="banner-middle banner-detail">
      <figure>
        <img 
          src="{{asset('images/content/banner-hukum.webp')}}" 
          data-img-large="{{ asset('images/content/banner-hukum.webp') }}"
          data-img-medium="{{ asset('images/content/banner-hukum.webp') }}"
          data-img-small="{{ asset('images/content/banner-hukum.webp') }}"
          width="1380" height="540" alt="img">
      </figure>
      <div class="banner-detail__caption">
        <div class="wrapper-content">
          <div class="detail-pages--top">
            <a href="{{ $menu->permalink }}" class="back">{{ lang::translate('document.back.peraturan') }}</a>
            <div class="medsos">
              <label for="">{{ lang::translate('document.share') }}</label>
              <div class="wrap">
                @include('dynamic.component.share-social', ['model' => $document])
              </div>
            </div>
          </div>

          @if($hasEnTranslation)
            <div class="doc-lang-switcher" style="display: inline-flex; align-items: center; background: rgba(0, 0, 0, 0.45); backdrop-filter: blur(8px); padding: 5px 8px; border-radius: 30px; margin-bottom: 18px; border: 1px solid rgba(255, 255, 255, 0.25);">
              <span style="color: #fff; font-size: 13px; font-weight: 500; margin-right: 8px; margin-left: 6px;">
                <i class="fa fa-globe"></i> Bahasa:
              </span>
              <button type="button" class="btn-lang-toggle active" id="btn-lang-id" onclick="setDocumentLanguage('id')" style="border: none; background: #fff; color: #0d47a1; font-weight: 700; font-size: 13px; padding: 6px 14px; border-radius: 20px; cursor: pointer; transition: all 0.2s ease;">
                Bahasa Indonesia
              </button>
              <button type="button" class="btn-lang-toggle" id="btn-lang-en" onclick="setDocumentLanguage('en')" style="border: none; background: transparent; color: #fff; font-weight: 600; font-size: 13px; padding: 6px 14px; border-radius: 20px; cursor: pointer; transition: all 0.2s ease;">
                English Version
              </button>
            </div>
          @endif

          <h3 id="display-doc-title">{{ $idTitle }}</h3>
          <p id="display-doc-intro">{{ $idIntro }}</p>
          <a href="javascript:;" id="scrollBtn" class="button button-outline-secondary button-icon">
            <span id="label-btn-read">{{ lang::translate('document.read-rule') }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
              <path d="M10.2362 18.1466C10.1879 18.1466 10.1395 18.1361 10.0948 18.1147L3.18748 14.8255C3.07302 14.7709 3 14.6555 3 14.5285V4.33201C3 4.21919 3.05789 4.11426 3.15328 4.05374C3.24833 3.99355 3.36839 3.98664 3.47035 4.03499L10.2362 7.25675L17.0021 4.03466C17.104 3.98664 17.2234 3.99322 17.3188 4.05374C17.4145 4.11426 17.4724 4.21919 17.4724 4.33201V14.5285C17.4724 14.6555 17.3994 14.7709 17.2849 14.8255L10.3777 18.1147C10.3329 18.1361 10.2846 18.1466 10.2362 18.1466ZM3.65784 14.3206L10.2362 17.4532L16.8146 14.3206V4.85301L10.3777 7.91821C10.2885 7.96064 10.1842 7.96064 10.0951 7.91821L3.65784 4.85301V14.3206Z" fill="white" stroke="white" stroke-width="0.5"/>
              <path d="M10.2361 5.3562L4.50201 2.62584C4.33788 2.54756 4.26848 2.3512 4.34643 2.1874C4.42472 2.02327 4.62075 1.95452 4.78488 2.03149L10.2361 4.62765L15.6872 2.03149C15.8517 1.95452 16.0474 2.02327 16.1257 2.1874C16.2036 2.3512 16.1342 2.54756 15.9701 2.62584L10.2361 5.3562Z" fill="white" stroke="white" stroke-width="0.5"/>
              <path d="M10.5651 7.62109H9.90723V17.8176H10.5651V7.62109Z" fill="white" stroke="white" stroke-width="0.5"/>
            </svg>
          </a>
        </div>
      </div>
      <div class="wave">
        <svg xmlns="http://www.w3.org/2000/svg" widht="3000" height="180" viewBox="0 180 2500 200" fill="#F8F8F8">
          <path class="st1" d="M 0 250 C 1200 400 1200 50 3000 250 L 3000 550 L 0 550 L 0 250">
              <animate attributeName="d" dur="5s" values="M 0 250 C 1200 400 1200 50 3000 250 L 3000 550 L 0 550 L 0 250;
              M 0 250 C 400 50 400 400 3000 250 L 3000 550 L 0 550 L 0 250;
              M 0 250 C 1200 400 1200 50 3000 250 L 3000 550 L 0 550 L 0 250" repeatCount="indefinite"></animate>
          </path>
        </svg>
      </div>
    </section>
    <section class="box-detail-page">
      <div class="wrapper-content">
        <h5>{{ lang::translate('document.description') }}</h5>
        <table>
          <tr>
            <th>{{ lang::translate('document.content.tipe-dokumen') }}</th>
            <td>{{ $document->document_type->label ?? '' }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.judul') }}</th>
            <td id="meta-doc-title">{{ $idTitle }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.teu-badan') }}</th>
            <td>{{ $document->translated('teu') }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.no-peraturan') }}</th>
            <td id="meta-doc-no">{{ $idNoPeraturan }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.jenis-bentuk-peraturan') }}</th>
            <td>{{ $document->translated('jenis_bentuk_peraturan') }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.singkatan-bentuk-peraturan') }}</th>
            <td>{{ $document->translated('singkatan_bentuk_peraturan') }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.tempat-penetapan') }}</th>
            <td>{{ $document->tempat_penetapan }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.tanggal-penetapan') }}</th>
            <td>{{ date2string($document->tanggal_penetapan) }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.tanggal-pengundangan') }}</th>
            <td>{{ date2string($document->tanggal_pengundangan) }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.sumber') }}</th>
            <td>{{ $document->translated('sumber') }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.subjek') }}</th>
            <td>{{ $document->translated('subjek') }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.status-peraturan') }}</th>
            <td>
              {{ $document->front_status_berlaku }} <br>
              {!! $document->translated('status_peraturan') !!}
            </td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.bahasa') }}</th>
            <td id="meta-doc-bahasa">{{ $document->translated('bahasa') ?: 'Indonesia' }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.lokasi') }}</th>
            <td>{{ $document->lokasi }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.bidang-hukum') }}</th>
            <td>{{ $document->translated('bidang_hukum') }}</td>
          </tr>
          @include('dynamic.component.document-bapanas-rows')
          <tr>
            <th>{{ lang::translate('document.content.jumlah-unduh') }}</th>
            <td>{{ lang::translate('document.content.count.download', ['count' => num2string($document->download_pdf_count)]) }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.jumlah-tayang') }}</th>
            <td>{{ lang::translate('document.content.count.view', ['count' => num2string($document->view_count)]) }}</td>
          </tr>
        </table>

        <div class="box-detail-page__pdf">
          <div class="box-detail-page__pdf--title">
            <h5>{{ lang::translate('document.file.title') }}</h5>
            <nav>
              <ul>
                <li><a href="" class="active" data-tab="peraturan" id="tab-nav-peraturan">{{ lang::translate('document.file.peraturan') }}</a></li>
                <li><a href="" data-tab="abstrak">{{ lang::translate('document.file.abstrak') }}</a></li>
              </ul>
            </nav>
          </div>
          <div class="content-tab" data-tab="peraturan">
            <div class="wrap-iframe">
              <iframe id="doc-iframe-pdf" src="{{ route('document.stream', ['type' => 'pdf', 'id' => $document->id]) }}#toolbar=1&navpanes=0&scrollbar=1" width="100%" allowfullscreen></iframe>
            </div>
            <section class="list-pdf">
              <div class="list-pdf__item">
                <span class="no-dots" id="info-pdf-version">{{ lang::translate('document.file.info-peraturan') }}</span>
                <div class="inner">
                  <figure>
                    <img src="{{asset('images/material/pdf-icon.svg')}}" alt="pdf icon">
                  </figure>
                  <h6 id="display-pdf-filename">{{ $document->translated('pdf_name') ?: ($document->no_peraturan . '.pdf') }}</h6>
                  <a id="btn-download-pdf" href="{{ route('document.download', ['type' => 'pdf', 'id' => $document->id]) }}?token={{ Str::random(15) }}" class="button button-outline button-icon" target="__BLANK">
                    <span id="label-download-pdf">{{ lang::translate('document.file.button.download-pdf') }}</span>
                    <i class="wa-icon wa-ic-download-outline"></i>
                  </a>
                </div>
              </div>
            </section>
          </div>
          <div class="content-tab" data-tab="abstrak">
            <div class="wrap-iframe">
              <iframe src="{{ route('document.stream', ['type' => 'abstract', 'id' => $document->id]) }}#toolbar=1&navpanes=0&scrollbar=1" width="100%" allowfullscreen></iframe>
            </div>
          </div>
        </div>
      </div>
    </section>
  </section>
  @push('head')
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/document.scss')}}" preload>
  @endpush
  @push('footer')
    <script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/document.js') }}"></script>
    <script>
      const docLangData = {
        id: {
          title: @json($idTitle),
          intro: @json($idIntro),
          no_peraturan: @json($idNoPeraturan),
          bahasa: @json($document->translated('bahasa') ?: 'Indonesia'),
          pdf_stream: "{{ route('document.stream', ['type' => 'pdf', 'id' => $document->id]) }}#toolbar=1&navpanes=0&scrollbar=1",
          pdf_download: "{{ route('document.download', ['type' => 'pdf', 'id' => $document->id]) }}?token={{ Str::random(15) }}",
          pdf_name: @json($document->translated('pdf_name') ?: ($document->no_peraturan . '.pdf')),
          pdf_label: "Unduh Dokumen PDF (Bahasa Indonesia)",
          read_label: "Baca Peraturan",
          info_version: "Dokumen Naskah Asli Bahasa Indonesia"
        },
        en: {
          title: @json($enTitle),
          intro: @json($enIntro),
          no_peraturan: @json($enNoPeraturan),
          bahasa: "English (Terjemahan Resmi)",
          pdf_stream: "{{ $hasTranslationPdf ? route('document.stream', ['type' => 'translation_pdf', 'id' => $document->id]) . '#toolbar=1&navpanes=0&scrollbar=1' : route('document.stream', ['type' => 'pdf', 'id' => $document->id]) . '#toolbar=1&navpanes=0&scrollbar=1' }}",
          pdf_download: "{{ $hasTranslationPdf ? route('document.download', ['type' => 'translation_pdf', 'id' => $document->id]) . '?token=' . Str::random(15) : route('document.download', ['type' => 'pdf', 'id' => $document->id]) . '?token=' . Str::random(15) }}",
          pdf_name: @json($hasTranslationPdf ? basename($document->translation_pdf) : ($document->no_peraturan . '_EN.pdf')),
          pdf_label: "Download English Version PDF",
          read_label: "Read English Regulation",
          info_version: "{{ $hasTranslationPdf ? 'Official English Translation Document' : 'Original Indonesian Document (English Translation in process)' }}"
        }
      };

      function setDocumentLanguage(lang) {
        if (!docLangData[lang]) return;
        const d = docLangData[lang];

        // Toggle buttons
        const btnId = document.getElementById('btn-lang-id');
        const btnEn = document.getElementById('btn-lang-en');
        if (btnId && btnEn) {
          if (lang === 'en') {
            btnEn.style.background = '#fff';
            btnEn.style.color = '#0d47a1';
            btnEn.style.fontWeight = '700';
            btnId.style.background = 'transparent';
            btnId.style.color = '#fff';
            btnId.style.fontWeight = '600';
          } else {
            btnId.style.background = '#fff';
            btnId.style.color = '#0d47a1';
            btnId.style.fontWeight = '700';
            btnEn.style.background = 'transparent';
            btnEn.style.color = '#fff';
            btnEn.style.fontWeight = '600';
          }
        }

        // Update elements
        const titleEl = document.getElementById('display-doc-title');
        if (titleEl) titleEl.innerText = d.title;

        const introEl = document.getElementById('display-doc-intro');
        if (introEl) introEl.innerText = d.intro;

        const metaTitleEl = document.getElementById('meta-doc-title');
        if (metaTitleEl) metaTitleEl.innerText = d.title;

        const metaNoEl = document.getElementById('meta-doc-no');
        if (metaNoEl) metaNoEl.innerText = d.no_peraturan;

        const metaBahasaEl = document.getElementById('meta-doc-bahasa');
        if (metaBahasaEl) metaBahasaEl.innerText = d.bahasa;

        const iframeEl = document.getElementById('doc-iframe-pdf');
        if (iframeEl) iframeEl.src = d.pdf_stream;

        const dlEl = document.getElementById('btn-download-pdf');
        if (dlEl) dlEl.href = d.pdf_download;

        const dlLabelEl = document.getElementById('label-download-pdf');
        if (dlLabelEl) dlLabelEl.innerText = d.pdf_label;

        const pdfNameEl = document.getElementById('display-pdf-filename');
        if (pdfNameEl) pdfNameEl.innerText = d.pdf_name;

        const readLabelEl = document.getElementById('label-btn-read');
        if (readLabelEl) readLabelEl.innerText = d.read_label;

        const infoVerEl = document.getElementById('info-pdf-version');
        if (infoVerEl) infoVerEl.innerText = d.info_version;
      }

      document.addEventListener('DOMContentLoaded', function() {
        const button = document.getElementById('scrollBtn');
        const target = document.querySelector('.box-detail-page__pdf');

        if (button && target) {
          button.addEventListener('click', function() {
            target.scrollIntoView({
              behavior: 'smooth',
              block: 'start'
            });
          });
        }
      });
    </script>
  @endpush
@endsection
