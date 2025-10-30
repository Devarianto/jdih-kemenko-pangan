<section class="section-content publication mt-60">
    <div class="wrapper-content">
		@if($highlight)
			@php($item = $highlight)
			<div class="publication__hero">
				<figure>
					{!! media::initial($highlight->thumb)->html !!}
				</figure>
				<div class="publication__hero--content">
					<h4 class="publication__hero--content__title">{{ $item->label }}</h4>
					<p>
						{{ $item->intro }}
					</p>
					<a href="{{ media::initial($item->doc)->url }}" target="_blank" rel="noopener" class="button button-icon button-link">
						<span>{{ lang::translate('blocks.publication-grid.download') }}</span>
						<i class="wa-ic-download-solid"></i>
					</a>
				</div>
			</div>
		@endif

        <div class="publication__list">
            <div class="filter">
                <div class="filter__result">
                    @if(request()->get('sort') == 'asc')
						<p>{{ lang::translate('blocks.publication-grid.show-data-asc',['count'=>$lists->count(),'total'=>$lists->total()]) }}</p>
					@else
						<p>{{ lang::translate('blocks.publication-grid.show-data-desc',['count'=>$lists->count(),'total'=>$lists->total()]) }}</p>
					@endif
                </div>
                <form class="filter__sortby">
                    <label for="">{{ lang::translate('blocks.publication-grid.sort-by') }}</label>
                    <select name="sort" onchange="$(this).parent().trigger('submit');">
						@foreach(['desc','asc'] as $v)
						<option value="{{ $v }}" @if(request()->get('sort') == $v) selected @endif>{{ lang::translate('blocks.publication-grid.'.$v) }}</option>
						@endforeach
                    </select>
                </form>
            </div>

            <div class="row row-wrap">
				@forelse($lists as $item)
				<div class="column column-33">
                    <div class="publication__list--item">
                        <figure>
							{!! media::initial($item->thumb)->html !!}
                        </figure>
                        <h5 class="publication__list--item__title">{{ $item->label }}</h5>
                        <a href="{{ media::initial($item->doc)->url }}" target="_blank" rel="noopener" class="button button-icon button-link">
							<span>{{ lang::translate('blocks.publication-grid.download') }}</span>
							<i class="wa-ic-download-solid"></i>
						</a>
                    </div>
                </div>
				@empty
				<p>{{ lang::translate('blocks.publication-grid.empty-data') }}</p>
				@endforelse
            </div>
			
			{!! $lists->appends(request()->query())->render('dynamic.components.pagination',['class'=>'pagination pagination__large center mt-20']) !!}
        </div>
    </div>
</section>
