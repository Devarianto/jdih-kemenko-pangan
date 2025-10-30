@foreach(widget($menu->id,'menu','component-banner-banner') as $w)
<section class="banner-content">
    <figure>
		<img src="{{ url()->convert($w->image,'webp') }}" alt="{{ media::initial($w->image)->alt }}">
    </figure>
    <div class="banner-content__caption">
        <div class="wrapper-content">
            <h6>{{ $w->translated('subtitle') }}</h6>
            <h2 class="title-medium">{{ $w->translated('title') }}</h2>
        </div>
    </div>
</section>
@endforeach