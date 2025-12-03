@extends('dynamic.layouts.layout')

@section('content')
  <section class="detail-pages no-banner">
    <div class="wrapper-content">
      <div class="detail-pages--top">
        <a href="{{ $menu->permalink }}" class="back">{{ lang::translate('document.back.jurnal') }}</a>
        <div class="medsos">
          <label for="">{{ lang::translate('document.share') }}</label>
          <div class="wrap">
            <a href="{{ $document->share('link') }}" target="__BLANK"><img src="{{ asset('images/material/ic-link.svg') }}" alt=""></a>
            <a href="{{ $document->share('wa') }}" target="__BLANK"><img src="{{ asset('images/material/ic-wa.svg') }}" alt=""></a>
            <a href="{{ $document->share('twitter') }}" target="__BLANK"><img src="{{ asset('images/material/ic-x.svg') }}" alt=""></a>
            <a href="{{ $document->share('tw') }}" target="__BLANK"><img src="{{ asset('images/material/ic-fb.svg') }}" alt=""></a>
          </div>
        </div>
      </div>
      <section class="text-images">
        <figure><img src="{{ media::initial($document->image)->url }}" alt="{{ media::initial($document->image)->alt }}"></figure>
        <figcaption>
          <span class="categ-grey" @if (!$document->status_tersedia) style="background-color: #C25A5A; color: #FFF3F3;" @endif>{{ $document->front_status_tersedia }}</span>
          <h3>{{ $document->translated('title') }}</h3>
          <p>{{ $document->translated('intro') }}</p>
          <a href="javascript:;" id="scrollBtn" class="button button-icon">
            {{ lang::translate('document.read-more') }}
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
              <path d="M10.2352 18.1456C10.1869 18.1456 10.1385 18.1351 10.0938 18.1137L3.18651 14.8245C3.07204 14.7699 2.99902 14.6545 2.99902 14.5275V4.33103C2.99902 4.21821 3.05691 4.11328 3.1523 4.05276C3.24736 3.99257 3.36741 3.98566 3.46938 4.03402L10.2352 7.25578L17.0011 4.03369C17.1031 3.98566 17.2225 3.99224 17.3178 4.05276C17.4136 4.11328 17.4715 4.21821 17.4715 4.33103V14.5275C17.4715 14.6545 17.3984 14.7699 17.284 14.8245L10.3767 18.1137C10.3319 18.1351 10.2836 18.1456 10.2352 18.1456ZM3.65686 14.3196L10.2352 17.4523L16.8136 14.3196V4.85204L10.3767 7.91723C10.2875 7.95966 10.1833 7.95966 10.0941 7.91723L3.65686 4.85204V14.3196Z" fill="white" stroke="white" stroke-width="0.5"/>
              <path d="M10.2351 5.3562L4.50103 2.62584C4.3369 2.54756 4.2675 2.3512 4.34546 2.1874C4.42374 2.02327 4.61977 1.95452 4.7839 2.03149L10.2351 4.62765L15.6862 2.03149C15.8507 1.95452 16.0464 2.02327 16.1247 2.1874C16.2027 2.3512 16.1332 2.54756 15.9691 2.62584L10.2351 5.3562Z" fill="white" stroke="white" stroke-width="0.5"/>
              <path d="M10.5641 7.62109H9.90625V17.8176H10.5641V7.62109Z" fill="white" stroke="white" stroke-width="0.5"/>
            </svg>
          </a>
        </figcaption>
      </section>
    </div>
    <section class="box-detail-page with-border">
      <div class="wrapper-content">
        <hr>
        <h5>{{ lang::translate('document.description') }}</h5>
        <table>
          <tr>
            <th>{{ lang::translate('document.content.tipe-dokumen') }}</th>
            <td>{{ $document->document_type->label }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.teu-orang') }}</th>
            <td>{{ $document->translated('teu') }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.no-panggil') }}</th>
            <td>{{ $document->no_panggil }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.edisi') }}</th>
            <td>{{ $document->translated('edisi') }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.tempat-terbit') }}</th>
            <td>{{ $document->tempat_terbit }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.penerbit') }}</th>
            <td>{{ $document->penerbit }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.tahun-terbit') }}</th>
            <td>{{ $document->tahun_terbit }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.subjek') }}</th>
            <td>{{ $document->translated('subjek') }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.isbn') }}</th>
            <td>{{ $document->isbn }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.bahasa') }}</th>
            <td>{{ $document->translated('bahasa') }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.bidang-hukum') }}</th>
            <td>{{ $document->translated('bidang_hukum') }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.nomor-induk-buku') }}</th>
            <td>{{ $document->nomor_induk_buku }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.lokasi') }}</th>
            <td>{{ $document->lokasi }}</td>
          </tr>
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
                <li><a href="" class="active" data-tab="peraturan">{{ lang::translate('document.file.file') }}</a></li>
                <li><a href="" data-tab="abstrak">{{ lang::translate('document.file.abstrak') }}</a></li>
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
      document.addEventListener('DOMContentLoaded', function() {
        const button = document.getElementById('scrollBtn');
        const target = document.querySelector('.box-detail-page__pdf');

        if (button && target) {
          button.addEventListener('click', function() {
            target.scrollIntoView({
              behavior: 'smooth', // efek scroll halus
              block: 'start'      // posisi elemen di atas layar
            });
          });
        }
      });
    </script>
  @endpush
@endsection
