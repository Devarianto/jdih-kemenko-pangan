@extends('static.layouts.layout')

@section('content')
  <section class="banner-middle">
    <figure>
      <img 
        src="{{asset('images/content/banner-about.webp')}}" 
        data-img-large="{{ asset('images/content/banner-about.webp') }}"
        data-img-medium="{{ asset('images/content/banner-about.webp') }}"
        data-img-small="{{ asset('images/content/banner-about.webp') }}"
        width="1380" height="400" alt="img">
    </figure>
    <figcaption>
      <small>TENTANG KAMI</small>
      <h2>Kontak Kami</h2>
    </figcaption>
     <div class="wave">
      <svg xmlns="http://www.w3.org/2000/svg"
        width="100%" height="140"
        viewBox="0 180 2500 200"
        fill="#F8F8F8"
        preserveAspectRatio="none">
        <path class="st1"
          d="M 0 250 C 1200 320 1200 100 3000 250 L 3000 550 L 0 550 L 0 250">
          <animate attributeName="d" dur="5s"
            values="M 0 250 C 1200 320 1200 100 3000 250 L 3000 550 L 0 550 L 0 250;
                    M 0 250 C 400 100 400 320 3000 250 L 3000 550 L 0 550 L 0 250;
                    M 0 250 C 1200 280 1200 100 3000 250 L 3000 550 L 0 550 L 0 250"
            repeatCount="indefinite" />
        </path>
      </svg>
    </div>
  </section>
  <section class="middle">
    <div class="wrapper-content">
      <div class="middle__title">
        <h4>Jika anda mengalami kesulitan dalam mencari dokumentasi dan informasi hukum yang dibutuhkan dan saran anda yang positif sangat bermanfaat bagi perubahan dan kemajuan kami</h4>
        <p>Ada pertanyaan seputar JDIH Kementerian Kordinator Bidang Pangan ? Kirim pesan kepada kami!</p>
      </div>
      <div class="contact-highlight">
        <figure class="bg">
          <img 
          src="{{ asset('images/content/bg-contactus.png') }}" 
          data-img-large="{{ asset('images/content/bg-contactus.png') }}"
          data-img-medium="{{ asset('images/content/bg-contactus-medium.png') }}"
          data-img-small="{{ asset('images/content/bg-contactus-s.png') }}"
          width="996" height="288" alt="img">
        </figure>
        <div class="contact-highlight__left">
          <p>KANTOR KAMI</p>
          <div class="wrap-col">
            <div class="col">
              <p>Graha Mandiri, Jl. Imam Bonjol, No. 61, Menteng, Kec. Menteng, Jakarta Pusat, Jakarta, 10310</p>
              <a href="" class="external-link">
                Petunjuk Arah
              </a>
            </div>
            <div class="col">
              <a href="">
                <i class="wa-icon wa-ic-phone-solid"></i>
                (021) 319 36802
              </a>
              <a href="">
                <i class="wa-icon wa-ic-mail-solid"></i>
                jdih@kemenkopangan.go.id
              </a>
            </div>
          </div>
        
        </div>
      </div>
      <div class="box-form">
        <h5>HUBUNGI KAMI</h5>
        <form >
          <div class="row row-wrap">
            <div class="column column-100">
              <label for="">Nama</label>
              <input type="text" placeholder="Masukan Nama Lengkap">
            </div>
            <div class="column column-50">
              <label for="">Email</label>
              <input type="email" placeholder="Masukan Email">
            </div>
            <div class="column column-50">
              <label for="">Nomor Telepon</label>
              <input type="number" placeholder="Nomor Telepon">
            </div>
             <div class="column column-100">
              <label for="">Pesan</label>
              <textarea name="" id="" placeholder="Tuliskan Pesan Anda"></textarea>
            </div>
            <div class="column">
               <div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>
               <script src="https://www.google.com/recaptcha/api.js" async defer></script>
            </div>
            <div class="column column-100">
              <button type="button" class="button button-gradient" onclick="openPopup('#popup-center')">Kirim Pesan</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
  <div class="popup" id="popup-center">
    <div class="popup__overlay"></div>
    <div class="popup__box">
      <div class="popup__close">
        <i class="wa-icon wa-ic-close-solid"></i>
      </div>
      <div class="popup__content popup__content--center">
        <img src="{{asset('images/material/checklist-bullet.svg')}}" alt="">
        <h3>Thank You!</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam </p>
        <a href="" class="button button-gradient">Kembali ke Beranda</a>
      </div>
    </div>
  </div>
  @push('head')
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/about.scss')}}" preload>
  @endpush
  @push('footer')
    {{-- <script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/.js') }}"></script> --}}
  @endpush
@endsection
