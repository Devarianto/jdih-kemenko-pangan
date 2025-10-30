@php($section = widget($menu->id,'menu','section-service-aside'))
@if($section->count() >= 1)
<section class="section-service-aside">
    <div class="wrapper section-service-aside__wrapper">
        @foreach($section as $v)
        <figcaption class="section-service-aside__text">
            @if($v->translated('subtitle'))
            <h6>{{$v->translated('subtitle') }}</h6>
            @endif
            @if($v->translated('title'))
            <h2>{{$v->translated('title') }}</h2>
            @endif
            @if($v->translated('intro'))
            <p>{!! nl2br($v->translated('intro')) !!}</p>
            @endif

            @foreach($v->childs('section-service-aside-buttons') as $button)
            <a @if($button->translated('url')) href="{{ url($button->translated('url')) }}" target="_blank" @endif
                class="button button-icon @if($button->highlight) button-secondary @else button-outline-secondary
                @endif">
                <span>{{ $button->translated('label') }}</span>
                <i class="button-icon__right wa-ic-chevron-right-solid"></i>
            </a>
            @endforeach

        </figcaption>
        @php($list = $v->childs('section-service-aside-list'))
        @if($list->count() > 0)
        <div class="section-service-aside__thumbnail">
            <div class="thumbnail-slider swiper">
                <div class="swiper-wrapper">
                    @foreach($list as $l)
                    <a class="thumbnail-slider__list swiper-slide" @if($l->translated('url'))
                        href="{{ url($l->translated('url')) }}" target="_blank" @endif>
                        <figcaption>
                            <h5>{{$l->translated('title')}}</h5>
                            <p>{!! nl2br($l->translated('description')) !!}</p>
                        </figcaption>
                        <figure>
                            <img src="{{ url()->convert($l->image,'webp') }}"
                                alt="{{ media::initial($l->image)->alt }}">
                        </figure>
                    </a>
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
        @endif
        @endforeach

    </div>
</section>
@endif