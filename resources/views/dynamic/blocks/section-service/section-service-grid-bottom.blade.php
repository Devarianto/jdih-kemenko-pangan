@php($section = widget($menu->id,'menu','section-service-grid-bottom'))
@if($section->count() >= 1)
<section class="section-service-grid-bottom">
    <div class="wrapper section-service-grid-bottom__wrapper">
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
            @foreach($v->childs('section-service-grid-bottom-buttons') as $button)
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

        @php($list = $v->childs('section-service-grid-bottom-list'))
        @if($list->count() > 0)
        @if($v->value('is_slider') == 0)
        <div class="thumbnail-grid-bottom row row-wrap">
            @else
            <div class="section-service-grid-bottom__wrap-thumb">
                <div class="thumbnail-grid-bottom row row-wrap swiper">
                    <div class="swiper-wrapper">
                        @endif
                        @foreach($list as $l)
                        <div class="thumbnail-grid-bottom__list column column-33 swiper-slide">
                            <figure>
                                <img src="{{ url()->convert($l->image,'webp') }}"
                                    alt="{{ media::initial($l->image)->alt }}">
                            </figure>
                            <figcaption>
                                @if($l->translated('title'))
                                <h5>{{$l->translated('title')}}</h5>
                                @endif
                                @if($l->translated('description'))
                                <p>{!! nl2br($l->translated('description')) !!}</p>
                                @endif

                                @if($l->translated('url') && $l->translated('btn-label'))
                                <a class="button button-icon button-link" @if($l->translated('url'))
                                    href="{{ url($l->translated('url')) }}" target="_blank" @endif>
                                    <span>{{$l->translated('btn-label')}}</span>
                                    <i class="button-icon__right wa-ic-chevron-right-solid"></i>
                                </a>
                                @endif
                            </figcaption>
                        </div>
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