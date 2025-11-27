<footer class="wa-footer-menu">
    <div class="wa-footer-menu__top">
        <div class="wrapper wa-footer-menu__top--wrapper">
            <div class="wa-footer-menu__top--left">
                <a class="wa-footer-menu__logo" href="{{ url()->lang('/') }}">
                <img src="{{ media::initial($webConfig->logo)->url }}" alt="{{ media::initial($webConfig->logo)->alt }}" style="filter: invert(100%) sepia(100%) saturate(0%) hue-rotate(75deg) brightness(106%) contrast(102%);">
                </a>
                <address>
					@if(isset($phone))
                    <a href="tel:{{ str_replace(' ','',$phone) }}" target="_blank" rel="noopener">
                    <i class="wa-ic-phone-solid"></i>
                    <span>{{ $phone }}</span>
                    </a>
					@endif
					@if(isset($email))
                    <a href="mailto:{{ str_replace(' ','',$email) }}" target="_blank" rel="noopener">
                    <i class="wa-ic-mail-solid"></i>
                    <span>{{ $email }}</span>
                    </a>
					@endif
                </address>
            </div>
            <div class="wa-footer-menu__top--right">
				<nav>
					@foreach(\Cactuar\Admin\Models\Menu::position('footer') as $footermenu)
					<a href="{{ $footermenu->fullUrl }}">{{ $footermenu->label }}</a>
					@endforeach
				</nav>
            </div>
        </div>
    </div>
    <div class="wa-footer-menu__bottom">
        <div class="wrapper wa-footer-menu__bottom--wrapper">
            <div class="wa-footer-menu__copyright">
                {!! og::copyright() !!}
            </div>
            <div class="wa-footer-menu__nav-right">
                @if(isset($socmeds) && count($socmeds) >= 1)
				<div class="wa-footer-menu__socmed">
					@foreach($socmeds as $socmed)
					<a href="{{ array_get($socmed,'url') }}" target="_blank" rel="noopener">
						<img src="{{ array_get($socmed,'image') }}" alt="{{ array_get($socmed,'url') }}">
					</a>
					@endforeach
				</div>
				@endif
            </div>
        </div>
    </div>
</footer>