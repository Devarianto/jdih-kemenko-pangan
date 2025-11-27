<footer class="wa-footer">
    <div class="wrapper wa-footer__wrapper">
        <div class="wa-footer__copyright">
            {!! og::copyright() !!}
        </div>
        <div class="wa-footer__nav-right">
            <nav>
                @foreach(\Cactuar\Admin\Models\Menu::position('footer') as $footermenu)
                <a href="{{ $footermenu->fullUrl }}">{{ $footermenu->label }}</a>
                @endforeach
            </nav>
			@if(isset($socmeds) && count($socmeds) >= 1)
			<div class="wa-footer__socmed">
				@foreach($socmeds as $socmed)
				<a href="{{ array_get($socmed,'url') }}" target="_blank" rel="noopener">
                	<img src="{{ array_get($socmed,'image') }}" alt="{{ array_get($socmed,'url') }}">
                </a>
				@endforeach
            </div>
			@endif
        </div>
    </div>
</footer>