@php($double_column = widget($menu->id,'menu','section-feature-double-column'))

@if($double_column->count() >= 1)
<div class="sectionfeatures-doublecolumn">
    <div class="wrapper">
      <div class="row row-wrap">
        @foreach ($double_column as $csf)
        <div class="column column-50">
          <div class="sectionfeatures-doublecolumn__inner">
            <figure>
              <img src="{{ media::url($csf->icon) }}" alt="{{ media::initial($csf->icon)->alt }}">
            </figure>
            <figcaption>
              <h5>{{ $csf->translated('title') }}</h5>
              <p>{{ $csf->translated('intro') }}</p>
            </figcaption>
          </div>
        </div>
        @endforeach
      </div>
    </div>
</div>
@endif
