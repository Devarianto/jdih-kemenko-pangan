@if($news->count() >= 1)
<section class="sectionnews-highlight">
    <div class="wrapper">
        <div class="row sectionnews-highlight__head">
            <div class="column">
				@foreach($widget as $w)
                <h5 class="sectionnews-highlight__head--subtitle">{{ $w->translated('subtitle') }}</h5>
                <h1 class="sectionnews-highlight__head--title">{{ $w->translated('title') }}</h1>
				@endforeach
			</div>
            <div class="column sectionnews-highlight__head--action">
				@if($menunews)
                <button class="button-icon button-link button-secondary" onclick="window.location.href='{{ $menunews->fullUrl }}'">
                    <span>{{ lang::translate('blocks.section-news-highlight.see-other') }}</span>
                    <i class="button-icon__right wa-ic-chevron-right-solid"></i>
                </button>
				@endif
            </div>
        </div>

        <div class="sectionnews-highlight__list mt-48">
			@php($idx=1)
			@foreach($news as $item)
            <div class="sectionnews-highlight__list--item" style="cursor:pointer;" onClick="window.location.href='{{ url($item->permalink) }}'">
                <figure>
					<img src="{{ media::initial($item->thumb)->url }}" alt="{{ media::initial($item->thumb)->alt }}" 
						@if($idx != 1)
							style="max-width:240px;"
						@endif
					>
                </figure>
                <div class="sectionnews-highlight__list--item__content">
                    <div class="sectionnews-highlight__list--item__content--category">
                        {{--<i class="wa-ic-plus-circle-outline"></i>
                        <span>Categori</span>--}}
                    </div>
                    <h5 class="sectionnews-highlight__list--item__content--title">
						{{ $item->label }}
                    </h5>
                    <div class="sectionnews-highlight__list--item__content--meta">
                        @if($item->author)
						<span>{{ $item->author }}</span>
						@endif
						<span>{{ date2string($item->date,'d F Y') }}</span>
                    </div>
                    <p>
						{{ $item->intro }}
					</p>
                </div>
            </div>
			@php($idx++)
            @endforeach
        </div>
    </div>
</section>
@endif
