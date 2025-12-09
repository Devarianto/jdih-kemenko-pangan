<div class="popup scroll-out" id="popup-home">
  <div class="wrap-popup">
    <div class="wrap-popup__main">
      <div class="popup__overlay"></div>
      <div class="popup__box">
        <div class="popup__content home-popup">
          <figure>
            <img src="{{media::url($popup->image)}}" loading="lazy" decoding="async" alt="{{media::initial($popup->image)->alt}}">
          </figure>
          <figcaption class="content-pages">
            <h4>{{ $popup->translated('title') }}</h4>
            <p>{{ $popup->translated('description') }}</p>
            @php($cta = $popup->widget('cta', false))
            @if ($cta)
            <a href="{{ url($cta->translated('url')) }}" target="{{ $cta->target }}" class="button button-outline">
              <span>{{ $cta->translated('label') }}</span>
              <div class="wave"></div>
            </a>
            @endif
          </figcaption>
        </div>
      </div>
    </div>
  </div>
</div>