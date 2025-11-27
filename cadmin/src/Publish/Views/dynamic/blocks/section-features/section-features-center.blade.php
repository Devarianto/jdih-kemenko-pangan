@php($center = widget($menu->id,'menu','section-feature-center'))

@if ($center->count() >= 1)
<div class="sectionfeatures-center">
  <!-- with slider -->
  <div class="sectionfeatures-center__wrap-thumb">
    <div class="wrapper">
      <div class="features-center row row-wrap swiper">
        <div class="swiper-wrapper">
        @foreach ($center as $csf)
          <div class="features-center__list column column-25 swiper-slide">
            <div class="sectionfeatures-center__inner">
              <figure>
                <div class="sectionfeatures-center__inner--ico">
                  <i class="{{ $csf->icon }}"></i>
                </div>
              </figure>
              <figcaption>
                <h5>{{ $csf->translated('title') }}</h5>
                <p>{{ $csf->translated('intro') }}</p>
              </figcaption>
            </div>
          </div>
        @endforeach
        </div>
      </div>
      <div class="swiper-arrow swiper-button-prev">
        <i class="wa-ic-chevron-left-solid"></i>
      </div>
      <div class="swiper-arrow swiper-button-next">
        <i class="wa-ic-chevron-right-solid"></i>
      </div>
    </div>
  </div>
</div>
@endif
