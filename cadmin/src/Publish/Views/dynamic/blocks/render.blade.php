@foreach($blocks as $block)
{!! $block::render($menu) !!}
@endforeach

@push('head')
	@foreach($appendhead as $v)
	{!! $v !!}
	@endforeach
@endpush

@push('footer')
	@foreach($appendfooter as $v)
	{!! $v !!}
	@endforeach
@endpush