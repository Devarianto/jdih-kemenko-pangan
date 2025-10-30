@php($grid = widget($menu->id,'menu','section-testimoni-grid'))
@if($grid->count() >= 1)
<section class="section-testimoni">
	<div class="wrapper">
        @foreach ($grid as $gd)
		<div class="text-title tablet-direction-row row row-wrap">
			<div class="column column-80">
				<h6>{{ $gd->translated('title') }}</h6>
				<h2>{{ $gd->translated('intro') }}</h2>
			</div>
			@if($gd->translated('label-button') && $gd->translated('url-button'))
			<div class="column column-20">
				<a href="{{ $gd->translated('url-button') }}" class="readmore">
					<span>{{ $gd->translated('label-button') }}</span>
					<i class="wa-ic-chevron-right-solid"></i>
				</a>
			</div>
			@endif
		</div>

		<!-- list with slide -->
		<div class="section-testimoni__wrap-slide slider-testimoni-1">
			<div class="list-testimoni row row-wrap swiper">
				<div class="swiper-wrapper">
					@foreach($gd->childs('section-testimoni-grid-content') as $gdc)
					<div class="list-testimoni__item swiper-slide">
                        <figure>
                            <img src="{{ media::url($gdc->image) }}" alt="{{ media::initial($gdc->image)->alt }}">
                        </figure>
						<figcaption>
							<span class="list-testimoni__item__jobs">{{ $gdc->translated('title') }}</span>
							<h5>{{ $gdc->name }}</h5>
							<p>{{ $gdc->translated('description') }}</p>
						</figcaption>
					</div>
					@endforeach
				</div>
			</div>
			<div class="swiper-arrow swiper-button-prev">
				<i class="wa-ic-chevron-left-solid"></i>
			</div>
			<div class="swiper-arrow swiper-button-next">
				<i class="wa-ic-chevron-right-solid"></i>
			</div>
		</div>
        @endforeach
	</div>
</section>
@endif

