@if($paginator->lastPage() > 1)
<div class="@if(isset($class)) {{ $class }} @else pagination pagination__large @endif">
	@if($paginator->currentPage() > 1)
	<a href="{{ $paginator->url(1) }}" class="prev"></a>
	@endif
	@foreach($elements as $element)
			@if(is_array($element))
				@foreach($element as $page => $url)
					<a href="{{ $url }}" @if($paginator->currentPage() == $page) class="active" @endif>{{ $page }}</a>
				@endforeach
			@else
				<a>...</a>
			@endif
	@endforeach
	@if($paginator->currentPage() < $paginator->lastPage())
	<a href="{{ $paginator->url($paginator->lastPage()) }}" class="next"></a>
	@endif
</div>
@endif