@extends('dynamic.layouts.layout')

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
            <a href="{{ $menu->permalink }}" class="back">{{ lang::translate('document.back.naskah') }}</a>
            <div class="medsos">
              <label for="">{{ lang::translate('document.share') }}</label>
              <div class="wrap">
                @include('dynamic.component.share-social', ['model' => $document])
              </div>
            </div>
          </div>
          <h3>{{ $document->translated('title') }}</h3>
          <p>{{ $document->translated('intro') }}</p>
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
            <td>{{ $document->translated('title') }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.pihak-internal') }}</th>
            <td>{{ $document->pihak_internal }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.pihak-eksternal') }}</th>
            <td>{{ $document->pihak_eksternal }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.nomor-perjanjian') }}</th>
            <td>{{ $document->nomor_perjanjian }}</td>
          </tr>
          <th>{{ lang::translate('document.content.tempat-penandatanganan') }}</th>
            <td>{{ $document->tempat_penandatanganan }}</td>
          <tr>
            <th>{{ lang::translate('document.content.tanggal-berlaku') }}</th>
            <td>{{ date2string($document->tanggal_berlaku) }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.tanggal-berakhir') }}</th>
            <td>{{ date2string($document->tanggal_berakhir) }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.jangka-waktu') }}</th>
            <td>{{ $document->translated('jangka_waktu') }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.status-berlaku') }}</th>
            <td>{{ $document->front_status_berlaku }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.bahasa') }}</th>
            <td>{{ $document->translated('bahasa') }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.lampiran') }}</th>
            <td>{!! nl2br($document->translated('lampiran')) !!}</td>
          </tr>
          @if (!is_null($document->pdf))
          <tr>
            <th>{{ lang::translate('document.content.jumlah-unduh') }}</th>
            <td>{{ lang::translate('document.content.count.download', ['count' => num2string($document->download_pdf_count)]) }}</td>
          </tr>
          @endif
          <tr>
            <th>{{ lang::translate('document.content.jumlah-tayang') }}</th>
            <td>{{ lang::translate('document.content.count.view', ['count' => num2string($document->view_count)]) }}</td>
          </tr>
        </table>
        @if (!is_null($document->pdf))
        <div class="box-detail-page__pdf">
          <div class="box-detail-page__pdf--title">
            <h5>{{ lang::translate('document.file.title') }}</h5>
            <nav>
              <ul>
                <li><a href="" class="active" data-tab="peraturan">{{ lang::translate('document.file.file') }}</a></li>
              </ul>
            </nav>
          </div>
          <div class="content-tab" data-tab="peraturan">
            <div class="wrap-iframe">
              <iframe src="{{ route('document.stream', ['type' => 'pdf', 'id' => $document->id]) }}#toolbar=1&navpanes=0&scrollbar=1" width="100%" allowfullscreen></iframe>
            </div>
            <section class="list-pdf">
              <div class="list-pdf__item">
                <span class="no-dots">{{ lang::translate('document.file.info-file') }}</span>
                <div class="inner">
                  <figure>
                    <img src="{{asset('images/material/pdf-icon.svg')}}" alt="pdf icon">
                  </figure>
                  <h6>{{ $document->translated('pdf_name') }}</h6>
                  <a href="{{ route('document.download', ['type' => 'pdf', 'id' => $document->id]) }}?token={{ Str::random(15) }}" class="button button-outline button-icon" target="__BLANK">
                    {{ lang::translate('document.file.button.download-pdf') }}
                    <i class="wa-icon wa-ic-download-outline"></i>
                  </a>
                </div>
              </div>
            </section>
          </div>
        </div>
        @endif
      </div>
    </section>
  </section>
  @push('head')
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/document.scss')}}" preload>
  @endpush
  @push('footer')
    <script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/document.js') }}"></script>
  @endpush
@endsection
