@php($section = widget($menu->id,'menu','section-service-column'))
@if($section->count() >= 1)
<section class="section-service-column">
    <div class="wrapper section-service-column__wrapper">
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
            @foreach($v->childs('section-service-column-buttons') as $button)
            <div class="column column-20">
                <a @if($button->translated('url')) href="{{ url($button->translated('url')) }}" target="_blank" rel="noopener" @endif
                    class="button button-icon button-large @if($button->highlight) button-secondary @else
                    button-outline-secondary
                    @endif">
                    <span>{{ $button->translated('label') }}</span>
                    <i class="button-icon__right wa-ic-chevron-right-solid"></i>
                </a>
            </div>
            @endforeach
        </div>
        @php($list = $v->childs('section-service-column-list'))
        @if($list->count() > 0)
        <div class="thumbnail-column row row-wrap">
            @foreach($list as $l)
            <div class="thumbnail-column__list column column-50">
                <figure>
                    <img src="{{ url()->convert($l->image,'webp') }}" alt="{{ media::initial($l->image)->alt }}">
                </figure>
                <figcaption>
                    @if($l->translated('subtitle'))
                    <h6>{{$l->translated('subtitle') }}</h6>
                    @endif
                    @if($l->translated('title'))
                    <h5>{{$l->translated('title') }}</h5>
                    @endif
                    @if($l->translated('description'))
                    <p>{!! nl2br($l->translated('description')) !!}</p>
                    @endif

                    @if($l->translated('btn-label') && $l->translated('btn-url'))
                    <a href="{{ url($l->translated('btn-url')) }}" class="button button-icon button-link"
                        target="_blank" rel="noopener">
                        <span>{{ $l->translated('btn-label') }}</span>
                        <i class="button-icon__right wa-ic-chevron-right-solid"></i>
                    </a>
                    @endif
                </figcaption>
            </div>
            @endforeach
        </div>
        @endif
        @endforeach
    </div>
</section>
@endif