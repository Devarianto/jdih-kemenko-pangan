<header class="wa-header">
    <div class="wrapper wa-header__wrapper">
        <a href="{{ lang::url('/') }}" class="wa-header__logo">
            {!! media::initial($webConfig->logo)->html !!}
        </a>
        <div class="wa-header__right">
            <ul class="wa-header__nav">
				@foreach(\Cactuar\Admin\Models\Menu::position('main') as $mainmenu)
				<li	@if($mainmenu->childs()->fe()->count() >= 1) class="have-sub" @endif >
					<a href="{{ $mainmenu->fullUrl }}">{{ $mainmenu->label }}</a>
					@if($mainmenu->childs()->fe()->count() >= 1)
					<ul>
						@foreach($mainmenu->childs()->fe()->get() as $mainmenuchild)
							<li @if($mainmenuchild->childs()->fe()->count() >= 1) class="have-sub" @endif >
                                <a  href="{{ $mainmenuchild->fullUrl }}">{{ $mainmenuchild->label }}</a>
                                @if($mainmenuchild->childs()->fe()->count() >= 1)
                                <ul>
                                    @foreach($mainmenuchild->childs()->fe()->get() as $mainmenusubchild)
                                        <li><a href="{{ $mainmenusubchild->fullUrl }}">{{ $mainmenusubchild->label }}</a></li>
                                    @endforeach
                                </ul>
                                @endif
                            </li>
						@endforeach 
					</ul>
					@endif
				</li>
				@endforeach
            </ul>
            <div class="wa-header__lang dropdown-icon dropdown-lang">
                <div class="dropdown-icon__button">
                    <img class="dropdown-icon__icon" src="{{ asset('flags/'.lang::active().'.png') }}" alt="{{ lang::active() }}" />
                    <span class="dropdown-icon__text">{{ ucwords(lang::active()) }}</span>
                </div>
                <div class="dropdown-icon__content">
                    @foreach(lang::codes() as $lang)
                    <a class="dropdown-icon__content--list" href="{{ url()->lang($lang) }}">
                        <img class="dropdown-icon__icon" src="{{ asset('flags/'.$lang.'.png') }}" alt="{{ $lang }}" />
                        <span class="dropdown-icon__text">{{ ucwords($lang) }}</span>
                    </a>
                    @endforeach
                </div>
            </div>
            @if(isset($search) && is_array($search) && array_get($search,'url'))
            <div class="wa-header__search">
                <div class="wa-header__search--button">
                    <i class="wa-ic-search-outline"></i>
                </div>
                <div class="wa-header__search--content">
                    <form action="{{ array_get($search,'url') }}">
                        <input type="text" name='search' placeholder="{{ array_get($search,'placeholder') ?: 'Search...' }}" />
                        <button>
                            <i class="wa-ic-search-outline"></i>
                        </button>
                    </form>
                </div>
            </div>
            @endif
            @if(isset($button) && is_array($button) && array_get($button,'url'))
            <a href="{{ array_get($button,'url') }}" class="button button-secondary">{{ array_get($button,'label') }}</a>
            @endif
            <div class="burger-button">
                <div class="burger-button__lines">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <span class="burger-button__text">Menu</span>
            </div>
        </div>
    </div>
    <div class="wa-menu-right">
        <div class="wa-menu-right__close"></div>
        <div class="wa-menu-right__content wa-menu-right__overflow">
            <ul>
                @foreach(\Cactuar\Admin\Models\Menu::position('burger') as $mainmenu)
                <li	@if($mainmenu->childs()->fe()->count() >= 1) class="have-sub" @endif >
                    <a href="{{ $mainmenu->fullUrl }}">{{ $mainmenu->label }}</a>
                    @if($mainmenu->childs()->fe()->count() >= 1)
                    <ul>
                        @foreach($mainmenu->childs()->fe()->get() as $mainmenuchild)
                            <li @if($mainmenuchild->childs()->fe()->count() >= 1) class="have-sub" @endif >
                                <a  href="{{ $mainmenuchild->fullUrl }}">{{ $mainmenuchild->label }}</a>
                                @if($mainmenuchild->childs()->fe()->count() >= 1)
                                <ul>
                                    @foreach($mainmenuchild->childs()->fe()->get() as $mainmenusubchild)
                                        <li><a href="{{ $mainmenusubchild->fullUrl }}">{{ $mainmenusubchild->label }}</a></li>
                                    @endforeach
                                </ul>
                                @endif
                            </li>
                        @endforeach 
                    </ul>
                    @endif
                </li>
                @endforeach
            </ul>
            @if(isset($search) && is_array($search) && array_get($search,'url'))
            <div class="search-field">
                <form action="{{ array_get($search,'url') }}">
                    <input type="text"  name='search' placeholder="{{ array_get($search,'placeholder') ?: 'Search...' }}" />
                </form>
            </div>
            @endif
            <div class="lang-logo">
                @foreach(lang::codes() as $lang)
                <a href="{{ url()->lang($lang) }}">
                    <img src="{{ asset('flags/'.$lang.'.png') }}" alt="{{ $lang }}" />
                    <span>{{ config('cadmin.lang.labels.'.$lang) }}</span>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</header>
