<section class="section-content sectionnews-grid">
    <div class="wrapper-content">
        <div class="sectionnews-grid__list">
            <div class="filter">
                <div class="filter__result">
					@if(request()->get('sort') == 'asc')
						<p>{{ lang::translate('blocks.news-grid.show-data-asc',['count'=>$lists->count(),'total'=>$lists->total()]) }}</p>
					@else
						<p>{{ lang::translate('blocks.news-grid.show-data-desc',['count'=>$lists->count(),'total'=>$lists->total()]) }}</p>
					@endif
                </div>
                <form class="filter__sortby">
                    <label for="">{{ lang::translate('blocks.news-grid.sort-by') }}</label>
                    <select name="sort" onchange="$(this).parent().trigger('submit');">
						@foreach(['desc','asc'] as $v)
						<option value="{{ $v }}" @if(request()->get('sort') == $v) selected @endif>{{ lang::translate('blocks.news-grid.'.$v) }}</option>
						@endforeach
                    </select>
                </form>
            </div>

            <div class="row row-wrap">
				@forelse($lists as $item)
                <div class="column column-33">
                    <a class="sectionnews-grid__list--item" href="{{ url($item->permalink) }}">
                        <figure>
							{!! media::initial($item->thumb)->html !!}
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
                    </a>
                </div>
				@empty
				<p>{{ lang::translate('blocks.news-grid.empty-data') }}</p>
				@endforelse
            </div>
        </div>

		{!! $lists->appends(request()->query())->render('dynamic.components.pagination') !!}
    </div>
</section>
