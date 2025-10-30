<section class="herobanner-full half swiper-half swiper responsive">	
	<div class="swiper-wrapper">
		@foreach(widget($menu->id,'menu','test-banner-banner') as $w)
		<div class="herobanner-full__list swiper-slide">
			<figure class="herobanner-full__list__image">
				<img src="{{ media::initial($w->banner)->url }}" 
					data-img-large="{{ media::initial($w->banner)->url }}" 
					data-img-medium="{{ media::initial($w->banner)->url }}" 
					data-img-small="{{ media::initial($w->banner)->url }}" width="1440" height="600" alt="img">
			</figure>
			<div class="wrapper">      
				<figcaption class="herobanner-full__list__text">
					<h6>{{ lang::translate('blocks.test-banner.subtitle') }}</h6>
					<h2 class="title-large">
					{{ $w->translated('title') }}
					</h2>
					<p>
						Lorem ipsum is placeholder text commonly used in the graphic, print, and publishing industries for previewing
					</p>
					<div class="button-group">
						@foreach($w->childs('test-banner-buttons') as $ww)
						<a class="button button-large button-secondary">{{ $ww->translated('button') }}</a>
						@endforeach
					</div>
				</figcaption>
			</div>
		</div>
		@endforeach
	</div>
	<div class="swiper-pagination"></div>	
	<div class="swiper-arrow swiper-button-prev">
		<i class="wa-ic-chevron-left-outline"></i>
	</div>
	<div class="swiper-arrow swiper-button-next">
		<i class="wa-ic-chevron-right-outline"></i>
	</div>
</section>