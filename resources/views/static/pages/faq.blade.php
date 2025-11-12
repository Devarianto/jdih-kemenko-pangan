@extends('static.layouts.layout')

@section('content')
<section class="banner-middle">
  <figure>
    <img
      src="{{asset('images/content/banner-peraturan.webp')}}"
      data-img-large="{{ asset('images/content/banner-peraturan.webp') }}"
      data-img-medium="{{ asset('images/content/banner-peraturan.webp') }}"
      data-img-small="{{ asset('images/content/banner-peraturan.webp') }}"
      width="1380" height="400" alt="img">
  </figure>
  <figcaption>
    <!-- <small>FAQ</small> -->
    <h2>FAQ</h2>
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
  <div class="wrapper">
    <div class="accordion" data-type="multiple">
      <div class="accordion__list active">
        <div class="accordion__list--button">
          <h5>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos dicta aliquid repudiandae consequatur officia eius similique perspiciatis voluptatem,</h5>
        </div>
        <div class="accordion__list--content">
          <div class="content-pages">
            <p>lorem ipsum dolor sit amet consectetur adipisicing elit. Quos dicta aliquid repudiandae consequatur officia eius similique perspiciatis voluptatem,</p>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quidem dolorem consectetur molestiae sit laboriosam, error, labore voluptatem, nulla mollitia voluptatibus cumque numquam aut omnis recusandae dolorum culpa aspernatur delectus minima?</p>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quidem dolorem consectetur molestiae sit laboriosam, error, labore voluptatem, nulla mollitia voluptatibus cumque numquam aut omnis recusandae dolorum culpa aspernatur delectus minima?</p>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quidem dolorem consectetur molestiae sit laboriosam, error, labore voluptatem, nulla mollitia voluptatibus cumque numquam aut omnis recusandae dolorum culpa aspernatur delectus minima?</p>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quidem dolorem consectetur molestiae sit laboriosam, error, labore voluptatem, nulla mollitia voluptatibus cumque numquam aut omnis recusandae dolorum culpa aspernatur delectus minima?</p>
          </div>
        </div>
      </div>
      @for ($i = 1; $i <= 5; $i++)
        <div class="accordion__list">
        <div class="accordion__list--button">
          <h5>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos dicta aliquid repudiandae consequatur officia eius similique perspiciatis voluptatem,</h5>
        </div>
        <div class="accordion__list--content">
          <div class="content-pages">
            <p>lorem ipsum dolor sit amet consectetur adipisicing elit. Quos dicta aliquid repudiandae consequatur officia eius similique perspiciatis voluptatem,</p>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quidem dolorem consectetur molestiae sit laboriosam, error, labore voluptatem, nulla mollitia voluptatibus cumque numquam aut omnis recusandae dolorum culpa aspernatur delectus minima?</p>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quidem dolorem consectetur molestiae sit laboriosam, error, labore voluptatem, nulla mollitia voluptatibus cumque numquam aut omnis recusandae dolorum culpa aspernatur delectus minima?</p>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quidem dolorem consectetur molestiae sit laboriosam, error, labore voluptatem, nulla mollitia voluptatibus cumque numquam aut omnis recusandae dolorum culpa aspernatur delectus minima?</p>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quidem dolorem consectetur molestiae sit laboriosam, error, labore voluptatem, nulla mollitia voluptatibus cumque numquam aut omnis recusandae dolorum culpa aspernatur delectus minima?</p>
          </div>
        </div>
    </div>
    @endfor
  </div>
  @include('static.component.pagination')
  </div>
</section>

@push('head')
<link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/document.scss')}}" preload>
@endpush
@push('footer')
<script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/document.js') }}"></script>
@endpush
@endsection