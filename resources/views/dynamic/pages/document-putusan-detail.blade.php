@extends('dynamic.layouts.layout')

@section('content')
  <section class="detail-pages">
    <section class="banner-middle banner-detail">
      <figure>
        <img 
          src="{{asset('images/content/banner-detail-2.webp')}}" 
          data-img-large="{{ asset('images/content/banner-detail-2.webp') }}"
          data-img-medium="{{ asset('images/content/banner-detail-2.webp') }}"
          data-img-small="{{ asset('images/content/banner-detail-2.webp') }}"
          width="1380" height="540" alt="img">
      </figure>
      <div class="banner-detail__caption">
        <div class="wrapper-content">
          <div class="detail-pages--top">
            <a href="{{ $document->court_type === 'MA' ? route('putusan.ma') : ($document->court_type === 'MK' ? route('putusan.mk') : (isset($menu) ? $menu->permalink : route('putusan-hukum'))) }}" class="back">
              {{ lang::translate('document.back.putusan') }}
            </a>
            <div class="medsos">
              <label for="">{{ lang::translate('document.share') }}</label>
              <div class="wrap">
                @include('dynamic.component.share-social', ['model' => $document])
              </div>
            </div>
          </div>
          <div style="margin-bottom: 12px;">
            {!! $document->court_badge !!}
          </div>
          <h3>{{ $document->translated('title') }}</h3>
          <p>{{ $document->translated('intro') ?: $document->translated('pokok_perkara') }}</p>
          <a href="javascript:;" id="scrollBtn" class="button button-outline-secondary button-icon">
            {{ lang::translate('document.read-decision') }}
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
            <td>{{ $document->document_type->label ?? 'Putusan' }}</td>
          </tr>
          <tr>
            <th>Lembaga Peradilan</th>
            <td>
              <div style="display: flex; align-items: center; gap: 8px;">
                {!! $document->court_badge !!}
                <strong>{{ $document->court_label }}</strong>
              </div>
            </td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.judul') }}</th>
            <td>{{ $document->translated('title') }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.no-putusan') }}</th>
            <td style="font-weight: 600;">{{ $document->no_putusan ?: '-' }}</td>
          </tr>
          <tr>
            <th>Tahun</th>
            <td>{{ $document->year ?? ($document->tanggal_dibacakan ? \Carbon\Carbon::parse($document->tanggal_dibacakan)->year : '-') }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.tanggal-dibacakan') }}</th>
            <td>{{ $document->tanggal_dibacakan ? num2string($document->tanggal_dibacakan) : '-' }}</td>
          </tr>
          @if(!empty($document->translated('pemohon')))
          <tr>
            <th>Pemohon / Pihak Pemohon</th>
            <td>{{ $document->translated('pemohon') }}</td>
          </tr>
          @endif
          @if(!empty($document->translated('termohon')))
          <tr>
            <th>Termohon / Pihak Termohon</th>
            <td>{{ $document->translated('termohon') }}</td>
          </tr>
          @endif
          @if(!empty($document->translated('pokok_perkara')))
          <tr>
            <th>Pokok Perkara</th>
            <td>{{ $document->translated('pokok_perkara') }}</td>
          </tr>
          @endif
          @if(!empty($document->translated('amar_putusan')))
          <tr>
            <th>Amar Putusan</th>
            <td>{{ $document->translated('amar_putusan') }}</td>
          </tr>
          @endif
          <tr>
            <th>{{ lang::translate('document.content.teu-badan') }}</th>
            <td>{{ $document->translated('teu') ?: '-' }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.jenis-peradilan') }}</th>
            <td>{{ $document->translated('jenis_peradilan') ?: '-' }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.singkatan-peradilan') }}</th>
            <td>{{ $document->translated('singkatan_peradilan') ?: '-' }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.tempat-peradilan') }}</th>
            <td>{{ $document->tempat_peradilan ?: '-' }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.sumber') }}</th>
            <td>{{ $document->translated('sumber') ?: '-' }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.subjek') }}</th>
            <td>{{ $document->translated('subjek') ?: '-' }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.status-putusan') }}</th>
            <td>
              <span class="category" @if (!$document->status_berlaku) style="background-color: #C25A5A;" @endif>{{ $document->front_status_berlaku }}</span>
            </td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.bahasa') }}</th>
            <td>{{ $document->translated('bahasa') ?: '-' }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.bidang-hukum-perkara') }}</th>
            <td>{{ $document->translated('bidang_hukum') ?: '-' }}</td>
          </tr>
          <tr>
            <th>{{ lang::translate('document.content.lokasi') }}</th>
            <td>{{ $document->lokasi ?: '-' }}</td>
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
                <li><a href="" class="active" data-tab="peraturan">{{ lang::translate('document.file.file') }}</a></li>
                @if($document->attachment)
                <li><a href="" data-tab="lampiran">Lampiran</a></li>
                @endif
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
                  <h6>{{ $document->translated('pdf_name') ?: $document->translated('title') }}</h6>
                  <a href="{{ route('document.download', ['type' => 'pdf', 'id' => $document->id]) }}?token={{ Str::random(15) }}" target="__BLANK" class="button button-outline button-icon">
                    {{ lang::translate('document.file.button.download-pdf') }}
                    <i class="wa-icon wa-ic-download-outline"></i>
                  </a>
                </div>
              </div>
            </section>
          </div>
          @if($document->attachment)
          <div class="content-tab" data-tab="lampiran">
            <div class="wrap-iframe">
              <iframe src="{{ route('document.stream', ['type' => 'attachment', 'id' => $document->id]) }}#toolbar=1&navpanes=0&scrollbar=1" width="100%" allowfullscreen></iframe>
            </div>
            <section class="list-pdf">
              <div class="list-pdf__item">
                <span class="no-dots">Lampiran Berkas Putusan</span>
                <div class="inner">
                  <figure>
                    <img src="{{asset('images/material/pdf-icon.svg')}}" alt="pdf icon">
                  </figure>
                  <h6>{{ $document->translated('attachment_name') ?: 'Lampiran Putusan' }}</h6>
                  <a href="{{ route('document.download', ['type' => 'attachment', 'id' => $document->id]) }}?token={{ Str::random(15) }}" target="__BLANK" class="button button-outline button-icon">
                    Unduh Lampiran
                    <i class="wa-icon wa-ic-download-outline"></i>
                  </a>
                </div>
              </div>
            </section>
          </div>
          @endif
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
              behavior: 'smooth',
              block: 'start'
            });
          });
        }

        // Tab switching for PDF & Lampiran
        const tabLinks = document.querySelectorAll('.box-detail-page__pdf--title nav ul li a');
        const tabContents = document.querySelectorAll('.box-detail-page__pdf .content-tab');

        tabLinks.forEach(link => {
          link.addEventListener('click', function(e) {
            e.preventDefault();
            const tabName = this.getAttribute('data-tab');

            tabLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');

            tabContents.forEach(c => {
              if (c.getAttribute('data-tab') === tabName) {
                c.style.display = 'block';
              } else {
                c.style.display = 'none';
              }
            });
          });
        });
      });
    </script>
  @endpush
@endsection
