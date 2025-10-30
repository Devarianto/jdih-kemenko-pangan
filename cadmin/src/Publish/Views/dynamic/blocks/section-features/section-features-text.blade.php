@php($text = widget($menu->id,'menu','section-feature-text'))

@if($text->count() >= 1)
<div class="sectionfeatures-text">
    <div class="wrapper">
      <div class="row row-wrap">
        @php($num=0)
        @foreach ($text as $csf)
        <div class="column column-33">
          <div class="sectionfeatures-text__inner">
            <h5 class="sectionfeatures-text__inner--number">0{{ $num+1 }}</h5>
            <h5 class="sectionfeatures-text__inner--title">{{ $csf->translated('title') }}</h5>
            <p>{{ $csf->translated('intro') }}</p>
            @foreach($csf->childs('section-feature-text-buttons') as $child)
            <a class="button button-icon button-link" href="{{ $child->translated('url') }}" target="_blank" rel="noopener">
              <i class="button-icon__left wa-ic-plus-circle-outline"></i>
              <span>{{ $child->translated('label') }}</span>
            </a>
            @endforeach
          </div>
        </div>
        @php($num++)
        @endforeach
      </div>
    </div>
</div>
@endif
