<footer class="wa-footer-complex">
    <div class="wa-footer-complex__top">
        <div class="wrapper">
           <a class="wa-footer-menu__logo" href="{{ url()->lang('/') }}">
			<img src="{{ media::initial($webConfig->logo)->url }}" alt="{{ media::initial($webConfig->logo)->alt }}" style="filter: invert(100%) sepia(100%) saturate(0%) hue-rotate(75deg) brightness(106%) contrast(102%);">
			</a>
            <div class="wa-footer-complex__top--wrapper">
                <div class="wa-footer-complex__top--left">
					@if(isset($address))
                    <address>
                        <i class="wa-ic-location-marker-solid"></i>
                        <p>
                            {!! nl2br($address) !!}
                        </p>
                    </address>
					@endif
                </div>
                <div class="wa-footer-complex__top--right">
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
                </div>
            </div>
            <div class="wa-footer-complex__top--nav">
				@foreach(\Cactuar\Admin\Models\Menu::position('footer') as $footermenu)
                <div class="wa-footer-complex__top--nav__box">
                    <h6><a href="{{ $footermenu->fullUrl }}">{{ $footermenu->label }}</a></h6>
					@if($footermenu->childs()->fe()->count() >= 1)
					<nav>
						@foreach($footermenu->childs()->fe()->get() as $footerchildmenu)
						<a href="{{ $footerchildmenu->fullUrl }}">{{ $footerchildmenu->label }}</a>
						@endforeach
                    </nav>
					@endif
                </div>
				@endforeach
            </div>
        </div>
    </div>
    <div class="wa-footer-complex__bottom">
        <div class="wrapper wa-footer-complex__bottom--wrapper">
            <div class="wa-footer-complex__copyright">
               {!! og::copyright() !!}
            </div>
            <div class="wa-footer-complex__nav-right">
				@if(isset($socmeds) && count($socmeds) >= 1)
                <div class="wa-footer-complex__socmed">
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