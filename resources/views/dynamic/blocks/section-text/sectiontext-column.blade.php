@php($section = widget($menu->id,'menu','section-text-column'))
@if($section->count() >= 1)
<div class="sectiontext-column">
    <div class="wrapper sectiontext-column__wrapper">

        @foreach($section as $v)
        <div class="sectiontext-column__text sectiontext">
            <h6>{{$v->translated('subtitle') }}</h6>
            <h2>{{$v->translated('title') }}</h2>
            <h5>{{$v->translated('intro') }}</h5>
            <p>{!! nl2br($v->translated('description')) !!}</p>

            @foreach($v->childs('section-text-column-buttons') as $button)
            <a href="{{ $button->translated('url') }}" target="_blank" rel="noopener"
                class="button button-icon @if($button->highlight) button-secondary @else button-outline-secondary @endif">
                <i class="button-icon__left wa-ic-plus-circle-outline"></i>
                <span>{{ $button->translated('label') }}</span>
            </a>
            @endforeach
        </div>

        @php($dataList = $v->childs('section-text-column-data-list'))
        @if($dataList->count() > 0)
        <div class="sectiontext-column__data">
            @foreach( $dataList as $dl)
            <div class="sectiontext-column__data--list">
                @if($dl->translated('title'))
                <h2>{{$dl->translated('title') }}</h2>
                @endif
                @if($dl->translated('description'))
                <p>{{$dl->translated('description') }}</p>
                @endif
            </div>
            @endforeach
        </div>
        @endif
        @endforeach

    </div>
</div>
@endif