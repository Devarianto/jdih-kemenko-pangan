<section class="section-content">
    <div class="wrapper-content content-pages">
        <div class="image-text-list">
            @forelse($lists as $item)
            <div class="image-text-list__item">
                <figure>
                    {!! media::initial($item->thumb)->html !!}
                </figure>
                <figcaption>
                    <h4>{{ $item->label }}</h4>
                    <p>{{ $item->intro }}</p>
                    <a href="{{ url($item->permalink) }}" class="readmore">{{ lang::translate('blocks.zigzag-list.see-more') }}<i class="wa-ic-chevron-right-solid"></i></a>
                </figcaption>
            </div>
			@empty
			<p>{{ lang::translate('blocks.zigzag-list.empty-data') }}</p>
            @endforelse
        </div>
		{!! $lists->appends(request()->query())->render('dynamic.components.pagination',['class'=>'pagination pagination__large center']) !!}
    </div>
</section>
