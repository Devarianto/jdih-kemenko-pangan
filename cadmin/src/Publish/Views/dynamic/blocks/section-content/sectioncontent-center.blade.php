@php($section = widget($menu->id,'menu','section-content-center'))
@if($section->count() >= 1)

@foreach($section as $key => $v)

@php($vd = "")
@foreach($v->childs('iframe') as $video)
@php($vd = helper::youtubeEmbedURL($video->value('url')))
@endforeach
<section class="sectioncontent-center @if($vd != '') with-video @endif">
    <figure>
        <img src="{{ url()->convert($v->image,'webp') }}" alt="{{ media::initial($v->image)->alt }}">
    </figure>
    <div class="wrapper">
        <figcaption>
            @if($v->translated('subtitle'))
            <h6>{{$v->translated('subtitle') }}</h6>
            @endif
            @if($v->translated('title'))
            <h2>{{$v->translated('title') }}</h2>
            @endif
            @if($v->translated('intro'))
            <h5>{{$v->translated('intro') }}</h5>
            @endif
            @if($v->translated('description'))
            <p>{!! nl2br($v->translated('description')) !!}</p>
            @endif

            @php($buttons = $v->childs('section-content-center-buttons'))
            @if($buttons->count() > 0 || $vd != '')
            <div class="btn-group">
                @if($vd == '')
                @foreach($buttons as $button)
                <button class="button-icon @if($button->highlight) button-secondary @else button-outline @endif"
                    onclick="window.location.href='{{ url($button->translated('url')) }}'">
                    <i class="button-icon__left wa-ic-plus-circle-outline"></i>
                    <span>{{ $button->translated('label') }}</span>
                </button>
                @endforeach
                @else
                <a href="" class="play-video">
                    <i class="wa-ic-play-outline ico"></i>
                    <span>{{ lang::translate('blocks.section-content.Play Video') }}</span>
                </a>
                @endif
            </div>
            @endif
        </figcaption>
    </div>
    @if($vd != '')
    <iframe class="iframe-video" width="100%" height="auto" src="{{$vd}}" title="YouTube video player" frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
        allowfullscreen></iframe>
    @endif
</section>
@endforeach
@endif