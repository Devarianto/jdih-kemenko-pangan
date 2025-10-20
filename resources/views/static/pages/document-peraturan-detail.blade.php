@extends('static.layouts.layout')

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
            <a href="" class="back">Kembali Ke Menu Peraturan</a>
            <div class="medsos">
              <label for="">Share:</label>
              <div class="wrap">
                <a href=""><img src="{{ asset('images/material/ic-link.svg') }}" alt=""></a>
                <a href=""><img src="{{ asset('images/material/ic-wa.svg') }}" alt=""></a>
                <a href=""><img src="{{ asset('images/material/ic-x.svg') }}" alt=""></a>
                <a href=""><img src="{{ asset('images/material/ic-fb.svg') }}" alt=""></a>
              </div>
            </div>
          </div>
          <h3>Peraturan Perundang-Undangan Nomor 31 Tahun 2025</h3>
          <p>tentang Persyaratan Tertentu dan Komitmen Pemasukan Ternak dan/atau Produk Hewan dalam Hal Tertentu yang Berasal dari Negara atau Zona dalam suatu Negara Asal Pemasukan</p>
          <a href="" class="button button-outline-secondary button-icon">
            Baca Peraturan
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
        <h5>Deskripsi</h5>
        <table>
          <tr>
            <th>Tipe</th>
            <td>Peraturan Perundang-undangan</td>
          </tr>
          <tr>
            <th>Judul</th>
            <td>Peraturan Menteri Koordinator Bidang Kemaritiman dan Investasi Nomor 6 Tahun 2024 tentang Pelaksanaan Tugas dan Wewenang Tim Koordinasi Peningkatan Peran Aktif Indonesia di Kawasan Dasar Laut Internasional</td>
          </tr>
          <tr>
            <th>T.E.U. Badan / Pengarang</th>
            <td>Indonesia. Kementerian Koordinator Bidang Pangan</td>
          </tr>
          <tr>
            <th>No. Peraturan</th>
            <td>6</td>
          </tr>
          <tr>
            <th>Jenis/Bentuk Peraturan</th>
            <td>Peraturan Menteri</td>
          </tr>
          <tr>
            <th>Singkatan Jenis/ Bentuk Peraturan</th>
            <td>Permen</td>
          </tr>
          <tr>
            <th>Tempat Penetapan</th>
            <td>Jakarta</td>
          </tr>
          <tr>
            <th>Tanggal-Bulan-Tahun Penetapan</th>
            <td>17 Oktober 2024</td>
          </tr>
          <tr>
            <th>Tanggal-Bulan-Tahun Pengundangan</th>
            <td>18 Oktober 2024</td>
          </tr>
          <tr>
            <th>Sumber</th>
            <td>BN 2024 (758): 7 hlm</td>
          </tr>
          <tr>
            <th>Subjek</th>
            <td>INDONESIA - KAWASAN PANGAN NEGARA - TUGAS DAN WEWENANG</td>
          </tr>
          <tr>
            <th>Status Peraturan</th>
            <td>Berlaku</td>
          </tr>
          <tr>
            <th>Bahasa</th>
            <td>Bahasa Indonesia</td>
          </tr>
          <tr>
            <th>Lokasi</th>
            <td>Biro Hukum Kementerian Koordinator Bidang Kemaritiman dan Investasi</td>
          </tr>
          <tr>
            <th>Bidang Hukum</th>
            <td>Hukum Administrasi Negara</td>
          </tr>
          <tr>
            <th>Lampiran</th>
            <td>-</td>
          </tr>
          <tr>
            <th>Jumlah Unduhan</th>
            <td>185 Kali Unduh</td>
          </tr>
          <tr>
            <th>Jumlah Tayang</th>
            <td>2,780 Kali Tayang</td>
          </tr>
        </table>
        <div class="box-detail-page__pdf">
          <div class="box-detail-page__pdf--title">
            <h5>Dokumen</h5>
            <nav>
              <ul>
                <li><a href="" class="active" data-tab="peraturan">Peraturan</a></li>
                <li><a href="" data-tab="abstrak">Abstrak</a></li>
                <li><a href="" data-tab="lampiran">Lampiran</a></li>
              </ul>
            </nav>
          </div>
          <div class="content-tab" data-tab="peraturan">
            <div class="wrap-iframe">
              <iframe src="{{ asset('pdf/sample.pdf') }}#toolbar=1&navpanes=0&scrollbar=1" width="100%" allowfullscreen></iframe>
            </div>
            <section class="list-pdf">
              <div class="list-pdf__item">
                <span class="no-dots">Peraturan dapat diunduh melalui dokumen dibawah ini :</span>
                <div class="inner">
                  <figure>
                    <img src="{{asset('images/material/pdf-icon.svg')}}" alt="pdf icon">
                  </figure>
                  <h6>Undang-Undang Republik Indonesia Nomor 12 Tahun 2011 tentang Pembentukan Peraturan Perundang-undangan</h6>
                  <a href="#" class="button button-outline button-icon" download>
                    Download PDF
                    <i class="wa-icon wa-ic-download-outline"></i>
                  </a>
                </div>
              </div>
            </section>
          </div>
          <div class="content-tab" data-tab="abstrak">
            <div class="wrap-iframe">
              <iframe src="{{ asset('pdf/sample.pdf') }}#toolbar=1&navpanes=0&scrollbar=1" width="100%" allowfullscreen></iframe>
            </div>
          </div>
          <div class="content-tab" data-tab="lampiran">
            <div class="wrap-iframe">
              <iframe src="{{ asset('pdf/sample.pdf') }}#toolbar=1&navpanes=0&scrollbar=1" width="100%"  allowfullscreen></iframe>
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
  @endpush
@endsection
