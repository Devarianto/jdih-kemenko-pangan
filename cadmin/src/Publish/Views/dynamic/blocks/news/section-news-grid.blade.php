<section class="sectionnews-grid">
    <div class="wrapper">
        <div class="row sectionnews-grid__head">
            <div class="column">
				@foreach($widget as $w)
                <h5 class="sectionnews-grid__head--subtitle">{{ $w->translated('subtitle') }}</h5>
                <h1 class="sectionnews-grid__head--title">{{ $w->translated('title') }}</h1>
				@endforeach
            </div>
            <div class="column sectionnews-grid__head--action">
				@if($menunews)
                <button class="button-icon button-link button-secondary" onclick="window.location.href='{{ $menunews->fullUrl }}'">
                    <span>{{ lang::translate('blocks.section-news-grid.see-other') }}</span>
                    <i class="button-icon__right wa-ic-chevron-right-solid"></i>
                </button>
				@endif
            </div>
        </div>

        <div class="sectionnews-grid__list">
            <div class="swiper sectionnews-grid__list--swiper-3">
                <div class="swiper-wrapper">
                    @foreach($news as $item)
                    <div class="swiper-slide sectionnews-grid__list--item" style="cursor:pointer;" onClick="window.location.href='{{ url($item->permalink) }}'">
                        <figure>
                            <img src="{{ media::initial($item->thumb)->url }}" alt="{{ media::initial($item->thumb)->alt }}" >
                        </figure>
                        <div class="sectionnews-grid__list--item__category">
                            {{--<i class="wa-ic-plus-circle-outline"></i>
                            <span>Categori</span>--}}
                        </div>
                        <h5 class="sectionnews-grid__list--item__title">{{ $item->label }}</h5>
                        <p>{{ $item->intro }}</p>
                        <div class="sectionnews-grid__list--item__meta">
                            @if($item->author)
							<span>{{ $item->author }}</span>
							@endif
							<span>{{ date2string($item->date,'d F Y') }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="sectionnews-grid__list--nav-prev">
                <i class="wa-ic-chevron-left-solid"></i>
            </div>
            <div class="sectionnews-grid__list--nav-next">
                <i class="wa-ic-chevron-right-solid"></i>
            </div>
        </div>
    </div>
</section>
