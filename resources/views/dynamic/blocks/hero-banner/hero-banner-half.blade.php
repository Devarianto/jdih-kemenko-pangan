@php($banner = widget($menu->id,'menu','hero-banner-half-banner'))
@if($banner->count() >= 1)
<section class="herobanner-full half swiper-half swiper responsive">
    <div class="swiper-wrapper">
        @foreach($banner as $w)
            <div class="herobanner-full__list swiper-slide">
               <figure class="herobanner-full__list__image">
                  <img src="{{ url()->convert($w->imageLarge,'webp') }}" 
                     data-img-large="{{ url()->convert($w->imageLarge,'webp') }}" 
                     data-img-medium="{{ url()->convert($w->imageMedium,'webp') }}" 
                     data-img-small="{{ url()->convert($w->imageSmall,'webp') }}" width="1440" height="600" alt="{{ media::initial($w->imageLarge)->alt }}">
               </figure>
               <div class="wrapper">      
                  <figcaption class="herobanner-full__list__text">
                     <h6>{{ $w->translated('subtitle') }}</h6>
                     <h2 class="title-large">
                        {{ $w->translated('title') }}
                     </h2>
                     <p>
                        {{ $w->translated('intro') }}
                     </p>
                     <div class="button-group">
                        @foreach($w->childs('hero-banner-half-buttons') as $button)
                           <a href="{{ $button->translated('url') }}" target="_blank" rel="noopener" class="button button-large @if($button->highlight) button-secondary @else button-outline @endif">{{ $button->translated('label') }}</a>
                        @endforeach
                     </div>
                  </figcaption>
               </div>
            </div>
         @endforeach
    </div>
    <div class="swiper-pagination"></div>
    <div class="swiper-arrow swiper-button-prev">
        <i class="wa-ic-chevron-left-outline"></i>
    </div>
    <div class="swiper-arrow swiper-button-next">
        <i class="wa-ic-chevron-right-outline"></i>
    </div>
</section>
@endif
