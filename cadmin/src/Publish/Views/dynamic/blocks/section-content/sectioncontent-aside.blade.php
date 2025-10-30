@php($section = widget($menu->id,'menu','section-content-aside'))
@if($section->count() >= 1)

@foreach($section as $key => $v)

@php($background = ($v->value('background') == 1 ? 'aside__background' : 'aside__content') )
@php($position = ($v->value('position') == 'left' ? '' : 'reverse'))

@php($vd = false)
@foreach($v->childs('iframe') as $video)
@php($vd = true)
<div class="popup" id="popup-video-{{$key}}">
    <div class="popup__overlay"></div>
    <div class="popup__box">
        <div class="popup__content">
            <iframe width="100%" height="315" src="{{helper::youtubeEmbedURL($video->value('url'))}}"
                title="YouTube video player" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen></iframe>
        </div>
    </div>
</div>
@endforeach

<section class="sectioncontent-aside @if($vd != false) with-video @endif">
    <div class="sectioncontent-{{$background}} {{$position}}">
    </div>
    <div class="sectioncontent-aside__content">
        <div class="wrapper">
            <div class="row {{$position}}">
                <div class="column column-40 @if($vd != false) column-offset-10 @endif">
                    <figure>
                        <img src="{{ url()->convert($v->image,'webp') }}" alt="{{ media::initial($v->image)->alt }}">
                        @if($vd != false)
                        <a onclick="openPopup('#popup-video-{{$key}}')" class="play">
                            <i class="wa-ic-play-outline ico"></i>
                            <span>{{ lang::translate('blocks.section-content.Play Video') }}</span>
                        </a>
                        @endif
                    </figure>
                </div>
                <div class="column column-50 @if($vd != false) column-offset-10 @endif">
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

                        @foreach($v->childs('section-content-aside-buttons') as $button)
                        <button class="button-icon @if($button->highlight) button-secondary @else button-outline @endif"
                            onclick="window.location.href='{{ url($button->translated('url')) }}'">
                            <i class="button-icon__left wa-ic-plus-circle-outline"></i>
                            <span>{{ $button->translated('label') }}</span>
                        </button>
                        @endforeach

                    </figcaption>
                </div>
            </div>

        </div>
    </div>
</section>
@endforeach
@endif