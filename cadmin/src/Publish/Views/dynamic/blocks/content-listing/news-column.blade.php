<section class="section-content sectionnews-column">
    <div class="wrapper-content">
        <div class="sectionnews-column__list">
            <div class="filter">
                <div class="filter__result">
                    @if(request()->get('sort') == 'asc')
						<p>{{ lang::translate('blocks.news-column.show-data-asc',['count'=>$lists->count(),'total'=>$lists->total()]) }}</p>
					@else
						<p>{{ lang::translate('blocks.news-column.show-data-desc',['count'=>$lists->count(),'total'=>$lists->total()]) }}</p>
					@endif
                </div>
                <form class="filter__sortby">
                    <label for="">{{ lang::translate('blocks.news-column.sort-by') }}</label>
                    <select name="sort" onchange="$(this).parent().trigger('submit');">
						@foreach(['desc','asc'] as $v)
						<option value="{{ $v }}" @if(request()->get('sort') == $v) selected @endif>{{ lang::translate('blocks.news-column.'.$v) }}</option>
						@endforeach
                    </select>
                </form>
            </div>
            @forelse($lists as $item)
            <div class="sectionnews-column__list--item">
                <figure>
                    {!! media::initial($item->thumb)->html !!}
                </figure>
                <div class="sectionnews-column__list--item__content">
                    <div class="sectionnews-column__list--item__content--meta">
                        @if($item->author)
						<span>{{ $item->author }}</span>
						@endif
						<span>{{ date2string($item->date,'d F Y') }}</span>
                    </div>
                    <h5 class="sectionnews-column__list--item__content--title">{{ $item->label }}</h5>
                    <p>
						{{ $item->intro }}
                    </p>
                    <a href="{{ url($item->permalink) }}" class="button button-icon button-link">
                        <span>{{ lang::translate('blocks.news-column.see-more') }}</span>
                        <i class="button-icon__right wa-ic-chevron-right-outline"></i>
                    </a>
                </div>
            </div>
			@empty
			<p>{{ lang::translate('blocks.news-column.empty-data') }}</p>
            @endforelse
        </div>

        {!! $lists->appends(request()->query())->render('dynamic.components.pagination',['class'=>'pagination pagination__large mt-48']) !!}
    </div>
</section>
