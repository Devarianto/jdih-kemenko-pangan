@foreach(widget($menu->id, 'menu', 'banner') as $banner)
<section class="banner-middle">
    <figure>
        <img src="{{ media::initial($banner->image)->url }}" 
            data-img-large="{{ media::initial($banner->image)->url }}" 
            data-img-medium="{{ media::initial($banner->value('image-medium'))->url }}" 
            data-img-small="{{ media::initial($banner->value('image-small'))->url }}" alt="{{ media::initial($banner->image)->alt }}">
    </figure>
    <figcaption>
        <small>{{ $banner->translated('subtitle') }}</small>
        <h2>{{ $banner->translated('title') }}</h2>
    </figcaption>
    <div class="wave">
        <svg xmlns="http://www.w3.org/2000/svg"
            width="100%" height="140"
            viewBox="0 180 2500 200"
            fill="#F8F8F8"
            preserveAspectRatio="none">
            <path class="st1"
            d="M 0 250 C 1200 320 1200 100 3000 250 L 3000 550 L 0 550 L 0 250">
            <animate attributeName="d" dur="5s"
                values="M 0 250 C 1200 320 1200 100 3000 250 L 3000 550 L 0 550 L 0 250;
                        M 0 250 C 400 100 400 320 3000 250 L 3000 550 L 0 550 L 0 250;
                        M 0 250 C 1200 280 1200 100 3000 250 L 3000 550 L 0 550 L 0 250"
                repeatCount="indefinite" />
            </path>
        </svg>
    </div>
</section>
@endforeach
