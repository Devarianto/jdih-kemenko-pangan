@php($section = widget($menu->id,'menu','section-service-grid'))
@if($section->count() >= 1)
<section class="section-service-grid">
    <div class="wrapper section-service-grid__wrapper">
        @foreach($section as $v)
        <div class="text-title row row-wrap">
            <div class="column column-80">
                @if($v->translated('subtitle'))
                <h6>{{$v->translated('subtitle') }}</h6>
                @endif
                @if($v->translated('title'))
                <h2>{{$v->translated('title') }}</h2>
                @endif
                @if($v->translated('intro'))
                <p>{!! nl2br($v->translated('intro')) !!}</p>
                @endif
            </div>
            @foreach($v->childs('section-service-grid-buttons') as $button)
            <div class="column column-20">
                <a @if($button->translated('url')) href="{{ url($button->translated('url')) }}" target="_blank" @endif
                    class="button button-icon button-large @if($button->highlight) button-secondary @else
                    button-outline-secondary
                    @endif">
                    <span>{{ $button->translated('label') }}</span>
                    <i class="button-icon__right wa-ic-chevron-right-solid"></i>
                </a>
            </div>
            @endforeach
        </div>

        @php($list = $v->childs('section-service-grid-list'))
        @if($list->count() > 0)
        @if($v->value('is_slider') == 0)
        <!-- list not slide -->
        <div class="thumbnail-grid row row-wrap">

            @else
            <!-- list with slide -->
            <div class="section-service-grid__wrap-thumb">
                <div class="thumbnail-grid row row-wrap swiper">
                    <div class="swiper-wrapper">
                        @endif
                        @foreach($list as $l)
                        <a class="thumbnail-grid__list column column-33 @if($v->value('is_slider') == 1) swiper-slide @endif"
                            @if($l->translated('url'))
                            href="{{ url($l->translated('url')) }}" target="_blank" @endif>
                            <figcaption>
                                @if($l->translated('title'))
                                <h5>{{$l->translated('title')}}</h5>
                                @endif
                                @if($l->translated('description'))
                                <p>{!! nl2br($l->translated('description')) !!}</p>
                                @endif
                            </figcaption>
                            <figure>
                                <img src="{{ url()->convert($l->image,'webp') }}"
                                    alt="{{ media::initial($l->image)->alt }}">
                            </figure>
                        </a>
                        @endforeach

                        @if($v->value('is_slider') == 0)
                    </div>
                    @else
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
        @endif

        @endforeach
    </div>
</section>
@endif