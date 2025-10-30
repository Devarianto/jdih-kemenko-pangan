@php($section = widget($menu->id,'menu','section-text-center'))
@if($section->count() >= 1)
<div class="sectiontext text-center">
    <div class="wrapper">
        @foreach($section as $v)
        <h6>{{$v->translated('subtitle') }}</h6>
        <h2>{{$v->translated('title') }}</h2>
        <h5>{{$v->translated('intro') }}</h5>
        <p>{!! nl2br($v->translated('description')) !!}</p>

        @foreach($v->childs('section-text-center-buttons') as $button)
        <a href="{{ $button->translated('url') }}" target="_blank" rel="noopener"
            class="button button-icon @if($button->highlight) button-secondary @else button-outline-secondary @endif">
            <i class="button-icon__left wa-ic-plus-circle-outline"></i>
            <span>{{ $button->translated('label') }}</span>
        </a>
        @endforeach
        @endforeach
    </div>
</div>
@endif