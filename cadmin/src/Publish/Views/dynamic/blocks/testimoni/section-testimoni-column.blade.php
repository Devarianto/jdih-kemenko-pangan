@php($column = widget($menu->id,'menu','section-testimoni-column'))
@if($column->count() >= 1)
<section class="section-testimoni">
	<div class="wrapper">
		<!-- list with slide -->
		<div class="section-testimoni__wrap-slide slider-testimoni-2">
			<div class="list-testimoni row row-wrap swiper">
				<div class="swiper-wrapper">
					@foreach ($column as $cl)
					<div class="list-testimoni__item swiper-slide column-type">
            <figure>
              <img src="{{ media::url($cl->image)}}" alt="{{ media::initial($cl->image)->alt }}">
            </figure>
						<figcaption>
							<span class="list-testimoni__item__jobs">{{ $cl->translated('title') }}</span>
							<div class="testimoni-text">
                <h2>{{ $cl->intro }}</h2>
              </div>
							<p>{{ $cl->translated('description') }}</p>
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
	</div>
</section>
<br>
@endif

