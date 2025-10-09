@extends('static.layouts.layout')

@section('content')
  <!-- middle -->
  <section class="herobanner-full swiper-full swiper responsive">
    <div class="swiper-wrapper">
      <div class="herobanner-full__list swiper-slide">
        <figure class="herobanner-full__list__image">
          <img src="{{ asset('images/herobanner-full.jpg') }}"
            data-img-large="{{ asset('images/herobanner-full.jpg') }}"
            data-img-medium="{{ asset('images/herobanner-full-medium.jpg') }}"
            data-img-small="{{ asset('images/herobanner-full-small.jpg') }}" width="1440" height="820" alt="img">
        </figure>
        <div class="wrapper">
          <figcaption class="herobanner-full__list__text">
            <h6>LOREM IPSUM DOLOR</h6>
            <h2 class="title-large">
              Financial infrastructure for the internet
            </h2>
            <p>
              Lorem ipsum is placeholder text commonly used in the graphic, print, and publishing industries for previewing
            </p>
            <div class="button-group">
              <a class="button button-large button-secondary">CTA BUTTON</a>
              <a class="button button-large button-outline">CTA BUTTON</a>
            </div>
          </figcaption>
        </div>
      </div>
      <!-- <div class="herobanner-full__list swiper-slide video">
        <figure class="herobanner-full__list__image">
          <video width="100%" height="auto" autoplay muted loop>
            <source src="{{ asset('videos/test-video.mp4') }}" type="video/mp4">
          </video>
        </figure>
      </div> -->
      <div class="herobanner-full__list swiper-slide">
        <figure class="herobanner-full__list__image">
          <img src="{{ asset('images/herobanner-full.jpg') }}"
            data-img-large="{{ asset('images/herobanner-full.jpg') }}"
            data-img-medium="{{ asset('images/herobanner-full-medium.jpg') }}"
            data-img-small="{{ asset('images/herobanner-full-small.jpg') }}" width="1440" height="820" alt="img">
        </figure>
        <div class="wrapper">
          <figcaption class="herobanner-full__list__text">
            <h6>2 LOREM IPSUM DOLOR</h6>
            <h2 class="title-large">
              2 Financial infrastructure
            </h2>
            <p>
              Lorem ipsum is placeholder text commonly used in the graphic, print
            </p>
            <div class="button-group">
              <a class="button button-large button-secondary">CTA BUTTON 2</a>
              <a class="button button-large button-outline">CTA BUTTON 2</a>
            </div>
          </figcaption>
        </div>
      </div>

    </div>
    <div class="swiper-pagination"></div>
    <div class="swiper-arrow swiper-button-prev">
      <i class="wa-ic-chevron-left-outline"></i>
    </div>
    <div class="swiper-arrow swiper-button-next">
      <i class="wa-ic-chevron-right-outline"></i>
    </div>
  </section>

  <section class="sectioncontent-history-year">
    <figure class="sectioncontent-history-year__img">
      <img src="{{ asset('images/img-history-year.jpg') }}" alt="">
    </figure>
    <div class="wrapper">
      <div class="sectioncontent-history-year__text">
        <h6>HISTORY</h6>
        <h3>Our Milestone</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</p>
        <div class="sectioncontent-history-year__text--action">
          <a href="#" class="button button-icon">
            <i class=" button-icon__left wa-ic-plus-circle-outline"></i>
            Button
            <i class="wa-ic-chevron-right-solid"></i>
          </a>
          <a href="#" class="button button-outline  button-icon">
            <i class=" button-icon__left wa-ic-plus-circle-outline"></i>
            Button
            <i class=" button-icon__right wa-ic-chevron-right-solid"></i>
          </a>
        </div>
      </div>
      <div class="sectioncontent-history-year__slider">
        <ul class="slider-year">
          <li class="active" id="slide-2023">
            <span>
              2023
              <small>year</small>
            </span>
          </li>
          @for ($i=22; $i > 12; $i--)
          <li id="slide-20{{ ($i < 10) ? '0'.$i : $i }}">
            <span>
              20{{ ($i < 10) ? "0".$i : $i }}
              <small>year</small>
            </span>
          </li>
          @endfor
        </ul>
        <div class="slider-inyear">
          <div class="slider-inyear__slider active" data-slide="slide-2023">
            <div class="slider-inyear__slider--list">
              <div class="slider-inyear__slider--list-item">
                <h5>15 June 2023</h5>
                <p>Lorem ipsum dolor sit amet, consetur adipiscing elit. Nunc vulputate libero et velit interdum, ac aliquet odio mattis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p>
                <a onclick="openPopup('#popup-image')">Read More</a>
              </div>
              <div class="slider-inyear__slider--list-item">
                <h5>14 June 2023</h5>
                <p>Lorem ipsum dolor sit amet, consetur adipiscing elit. Nunc vulputate libero et velit interdum, ac aliquet odio mattis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p>
                <a onclick="openPopup('#popup-image')">Read More</a>
              </div>
              <div class="slider-inyear__slider--list-item">
                <h5>13 June 2023</h5>
                <p>Lorem ipsum dolor sit amet, consetur adipiscing elit. Nunc vulputate libero et velit interdum, ac aliquet odio mattis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p>
                <a onclick="openPopup('#popup-image')">Read More</a>
              </div>
              <div class="slider-inyear__slider--list-item">
                <h5>15 June 2023</h5>
                <p>Lorem ipsum dolor sit amet, consetur adipiscing elit. Nunc vulputate libero et velit interdum, ac aliquet odio mattis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p>
                <a onclick="openPopup('#popup-image')">Read More</a>
              </div>
              <div class="slider-inyear__slider--list-item">
                <h5>14 June 2023</h5>
                <p>Lorem ipsum dolor sit amet, consetur adipiscing elit. Nunc vulputate libero et velit interdum, ac aliquet odio mattis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p>
                <a onclick="openPopup('#popup-image')">Read More</a>
              </div>
              <div class="slider-inyear__slider--list-item">
                <h5>13 June 2023</h5>
                <p>Lorem ipsum dolor sit amet, consetur adipiscing elit. Nunc vulputate libero et velit interdum, ac aliquet odio mattis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p>
                <a onclick="openPopup('#popup-image')">Read More</a>
              </div>
            </div>
          </div>
          @for ($slide=22; $slide > 12; $slide--)
          <div class="slider-inyear__slider" data-slide="slide-20{{ ($slide < 10) ? '0'.$slide : $slide }}">
            <div class="slider-inyear__slider--list">
              <div class="slider-inyear__slider--list-item">
                <h5>15 June 2023</h5>
                <p>Lorem ipsum dolor sit amet, consetur adipiscing elit. Nunc vulputate libero et velit interdum, ac aliquet odio mattis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p>
                <a onclick="openPopup('#popup-image')">Read More</a>
              </div>
              <div class="slider-inyear__slider--list-item">
                <h5>14 June 2023</h5>
                <p>Lorem ipsum dolor sit amet, consetur adipiscing elit. Nunc vulputate libero et velit interdum, ac aliquet odio mattis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p>
                <a onclick="openPopup('#popup-image')">Read More</a>
              </div>
              <div class="slider-inyear__slider--list-item">
                <h5>13 June 2023</h5>
                <p>Lorem ipsum dolor sit amet, consetur adipiscing elit. Nunc vulputate libero et velit interdum, ac aliquet odio mattis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p>
                <a onclick="openPopup('#popup-image')">Read More</a>
              </div>
              <div class="slider-inyear__slider--list-item">
                <h5>15 June 2023</h5>
                <p>Lorem ipsum dolor sit amet, consetur adipiscing elit. Nunc vulputate libero et velit interdum, ac aliquet odio mattis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p>
                <a onclick="openPopup('#popup-image')">Read More</a>
              </div>
              <div class="slider-inyear__slider--list-item">
                <h5>14 June 2023</h5>
                <p>Lorem ipsum dolor sit amet, consetur adipiscing elit. Nunc vulputate libero et velit interdum, ac aliquet odio mattis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p>
                <a onclick="openPopup('#popup-image')">Read More</a>
              </div>
              <div class="slider-inyear__slider--list-item">
                <h5>13 June 2023</h5>
                <p>Lorem ipsum dolor sit amet, consetur adipiscing elit. Nunc vulputate libero et velit interdum, ac aliquet odio mattis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p>
                <a onclick="openPopup('#popup-image')">Read More</a>
              </div>
            </div>
          </div>
          @endfor
        </div>
      </div>
    </div>
  </section>
  <div class="popup" id="popup-image">
    <div class="popup__overlay"></div>
    <div class="popup__box">
      <div class="popup__close">
        <i class="wa-ic-close-solid"></i>
      </div>
      <div class="popup__content">
        <h6>Title Here</h6>
        <div class="popup__overflow">
          <img src="{{ asset('images/img-success.png') }}" alt="">
          <h5>Lorem ipsum dolor sit amet, consectetur adipiscing elit, dummy text goes here lorem</h5>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
            ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
            laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor </p>
        </div>
      </div>
    </div>
  </div>

  <div class="test" style="padding: 40px 0;">
    <div class="wrapper">
      <h3>Test Select 2</h3>
      <select name="" class="select2">
        <option value="">Test select 1</option>
        <option value="">Test select 2</option>
        <option value="">Test select 3</option>
        <option value="">Test select 4</option>
      </select>
    </div>
  </div>

  <div class="test" style="padding: 40px 0;">
    <div class="wrapper">
      <h3>Test Datepicker-UI</h3>
      <input type="text" class="datepicker">
    </div>
  </div>

  <!-- end of middle -->
  @push('head')
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/sample.scss')}}" preload>
  @endpush
  @push('footer')
    <script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/sample.js') }}"></script>
    <script type="module">
      window.addEventListener('load', function() {
      $('.select2').select2({
        width: '100%'
      });
      $('.datepicker').datepicker({
          autoclose: true
      });
    })
  </script>
  @endpush
@endsection
