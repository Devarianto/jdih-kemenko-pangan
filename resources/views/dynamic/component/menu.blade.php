<div class="wrapper">
  <a href="{{ lang::url('/') }}" class="logo">
    <img src="{{ media::initial(conf('site-setting')->value('logo'))->url }}" alt="{{ media::initial(conf('site-setting')->value('logo'))->alt }}">
  </a>
  <div class="right-header">
    <nav>
      <ul>
        @foreach($mainMenu as $main)
        @php($childs = $main->childs()->fe()->get())
        @if($childs->count() > 0)
        <li class="have-child">
          <a href="{{ $main->fullUrl }}" @class(['active' => isset($menu) && in_array($main->id, $menu->activeIds)])>{{ $main->label }}</a>
          <div class="child">
            <ul>
              @foreach($childs as $child)
              <li><a href="{{ $child->fullUrl }}" @class(['active' => isset($menu) && in_array($child->id, $menu->activeIds)])>{{ $child->label }}</a></li>
              @endforeach
            </ul>
          </div>
        </li>
        @else
        <li>
          <a href="{{ $main->fullUrl }}" @class(['active' => isset($menu) && in_array($main->id, $menu->activeIds)])>{{ $main->label }}</a>
        </li>
        @endif
        @endforeach
      </ul>
    </nav>
    <div class="right-header__login">
      @if(Auth::guard('account')->check())
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <a href="javascript:void(0)" class="button-icon" onclick="this.closest('form').submit()">
          <i class="wa-icon wa-ic-logout-outline"></i>
          {{ lang::translate('dashboard.logout') }}
        </a>
      </form>
      @else
      <a href="javascript:void(0)" onclick="openPopup('#popup-login')">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
          <path d="M15.344 15L15.5882 14.7558C15.9137 14.4303 15.9137 13.903 15.5882 13.5774C15.2627 13.2518 14.7354 13.2519 14.4098 13.5774L12.7437 15.2435C12.6666 15.3204 12.6055 15.4128 12.5632 15.5149C12.4789 15.7186 12.4789 15.948 12.5632 16.1516C12.6055 16.2538 12.6665 16.346 12.7437 16.423L14.4098 18.0891C14.5725 18.2519 14.7857 18.3333 14.9989 18.3333C15.2122 18.3333 15.4254 18.2519 15.5881 18.0892C15.9136 17.7637 15.9136 17.2363 15.5881 16.9108L15.344 16.6667H17.4989C17.9595 16.6667 18.3323 16.2935 18.3323 15.8333C18.3323 15.3732 17.9595 15 17.4989 15H15.344Z" fill="white"/>
          <path d="M4.30024 14.4678L4.22458 14.7644C4.08708 15.3117 4.19449 15.8952 4.51758 16.3652C4.86183 16.8648 5.41441 17.1944 6.03616 17.2693C7.34474 17.4223 8.67774 17.5 9.99933 17.5C10.3313 17.5 10.6642 17.4918 10.9962 17.4829C11.4561 17.4711 11.8198 17.0883 11.8076 16.628C11.7954 16.1755 11.4251 15.8167 10.9751 15.8167C10.9669 15.8167 10.9596 15.8167 10.9523 15.8171C9.37766 15.8566 7.78666 15.7963 6.23308 15.6144C6.08824 15.5969 5.96374 15.5261 5.89049 15.4199C5.83599 15.3406 5.81966 15.2559 5.84008 15.1738L5.91416 14.8853C6.14608 13.9978 6.81508 13.2666 7.70616 12.9281C9.16124 12.3694 10.7823 12.3601 12.2716 12.9203C12.3033 12.9338 12.3399 12.9488 12.3945 12.9704C12.5068 13.0128 12.6077 13.0664 12.7135 13.1385C13.0943 13.3977 13.6127 13.3 13.8715 12.9196C14.1311 12.5395 14.0327 12.0208 13.6526 11.7616C13.4393 11.6163 13.2221 11.502 13.0642 11.4463C13.0202 11.4243 12.9762 11.4063 12.9641 11.4048C12.9388 11.3922 12.9137 11.3812 12.8876 11.371C11.0004 10.6548 8.96016 10.6613 7.11199 11.371C5.71958 11.8994 4.66891 13.0558 4.30024 14.4678Z" fill="white"/>
          <path d="M14.1654 5.83334C14.1654 3.53601 12.296 1.66667 9.9987 1.66667C7.70136 1.66667 5.83203 3.53601 5.83203 5.83334C5.83203 8.13067 7.70136 10 9.9987 10C12.296 10 14.1654 8.13067 14.1654 5.83334ZM7.4987 5.83334C7.4987 4.45476 8.62011 3.33334 9.9987 3.33334C11.3773 3.33334 12.4987 4.45476 12.4987 5.83334C12.4987 7.21192 11.3773 8.33334 9.9987 8.33334C8.62011 8.33334 7.4987 7.21192 7.4987 5.83334Z" fill="white"/>
        </svg>
        
        {{ lang::translate('dashboard.login') }}
      </a> 
      @endif
    </div>
    <div class="right-header__lang">
      @if (lang::active() == 'en')
      <img src="{{asset('images/material/US.svg')}}" alt="">
      @else
      <img src="{{asset('images/material/IND.svg')}}" alt="">
      @endif
      <div class="drop-language">
        <a href="{{ url()->lang('id') }}"><img src="{{ asset('images/material/IND.svg') }}" alt=""></a>
        <a href="{{ url()->lang('en') }}"><img src="{{ asset('images/material/US.svg') }}" alt=""></a>
      </div>
    </div>
    <div class="toggle-menu">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
</div>
@if (!is_null($menu_peraturan_front))
<div class="header-bot">
  <div class="wrapper">
    <form action="{{ $menu_peraturan_front->permalink }}" id="frm-search-global">
      <input type="text" name="search" placeholder="{{ lang::translate('global.search') }}">
    </form>
  </div>
</div>
@endif

<div class="popup popup-login" id="popup-login">
  <div class="popup__overlay"></div>
  <div class="popup__box popup__box--large">
    <div class="popup__content">
      <figure>
        <img 
        src="{{ media::initial(conf('site-setting')->value('login-image'))->url }}"
        data-img-large="{{ media::initial(conf('site-setting')->value('login-image'))->url }}"
        data-img-medium="{{ media::initial(conf('site-setting')->value('login-image-medium'))->url }}"
        data-img-small="{{ media::initial(conf('site-setting')->value('login-image-small'))->url }}" alt="{{ media::initial(conf('site-setting')->value('login-image'))->alt }}">
      </figure>
      <figcaption>
        <h5> {{ lang::translate('dashboard.form-login.title-form-login') }} </h5>
        <p>{{ lang::translate('dashboard.form-login.intro-form-login') }}</p>
        <form method="POST" action="{{ route('login') }}">
          @csrf
          <div class="row row-wrap">
            <div class="column column-100">
              <label for="">{{ lang::translate('dashboard.form-login.label-email') }}</label>
              <input type="email" name="email" placeholder="{{ lang::translate('dashboard.form-login.placeholder-email') }}" value="{{ old('email') }}">
            </div>
            <div class="column column-100">
              <label for="">{{ lang::translate('dashboard.form-login.label-password') }}</label>
              <input type="password" name="password" placeholder="{{ lang::translate('dashboard.form-login.placeholder-password') }}">
            </div>
              <div class="column column-100">
              <button type="submit" class="button button-gradient button-full">{{ lang::translate('dashboard.form-login.button-submit-login') }}</button>
            </div>
            <div class="column column-100">
              <div id="login-error" style="color:#ffdddd; background:#7f1d1d; padding:8px 12px; border-radius:6px; display:none;"></div>
            </div>
          </div>
        </form>
        <small>{!! og::copyright() !!}</small>
      </figcaption>
    </div>
  </div>
</div>

@push('footer')
<script>
  (function() {
    const popup = document.getElementById('popup-login');
    if (!popup) return;
    const form = popup.querySelector('form');
    const errorBox = document.getElementById('login-error');
    if (!form) return;
    let successLogin = false;
    form.addEventListener('submit', async function(e) {
      e.preventDefault();
      if (errorBox) {
        errorBox.style.display = 'none';
        errorBox.textContent = '';
      }
      const submitBtn = form.querySelector('button[type="submit"]');
      const originalText = submitBtn ? submitBtn.textContent : '';
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.style.background = "grey";
        submitBtn.textContent = "{{ lang::translate('dashboard.form-login.process') }}";
      }
      try {
        const formData = new FormData(form);
        const res = await fetch(form.action, {
          method: 'POST',
          headers: { 'Accept': 'application/json' },
          body: formData,
          credentials: 'same-origin'
        });
        if (res.ok) {
          const data = await res.json();
          if (data && data.redirect) {
            window.location.href = data.redirect;
          } else {
            window.location.href = "{{ route('dashboard') }}";
          }

          successLogin = true;
          return;
        }
        // handle validation/auth errors
        let msg = "{{ lang::translate('dashboard.form-login.unknown-user') }}";
        try {
          const data = await res.json();
          if (data && (data.message || (data.errors && data.errors.email && data.errors.email[0]))) {
            msg = data.message || data.errors.email[0];
          }
        } catch (_) {}
        if (errorBox) {
          errorBox.textContent = msg;
          errorBox.style.display = 'block';
        } else {
          alert(msg);
        }
      } catch (err) {
        if (errorBox) {
          errorBox.textContent = "{{ lang::translate('dashboard.form-login.failed-network') }}";
          errorBox.style.display = 'block';
        } else {
          alert("{{ lang::translate('dashboard.form-login.failed-network') }}");
        }
      } finally {
        if (submitBtn && successLogin == false) {
          submitBtn.disabled = false;
          submitBtn.style.background = "";
          submitBtn.textContent = originalText;
        }
      }
    });
  })();
  </script>
@endpush

<section class="menu-mobile">
  <nav>
    <ul>
      @foreach($mainMenu as $main)
      @php($childs = $main->childs()->fe()->get())
      @if($childs->count() > 0)
      <li>
        <a href="{{ $main->fullUrl }}" @class(['active' => isset($menu) && in_array($main->id, $menu->activeIds)])>{{ $main->label }}</a>
        <i class="wa-icon wa-ic-chevron-down-solid"></i>
        <div class="child">
          @foreach($childs as $child)
          <a href="{{ $child->fullUrl }}" @class(['active' => isset($menu) && in_array($child->id, $menu->activeIds)])>{{ $child->label }}</a>
          @endforeach
        </div>
      </li>
      @else
      <li>
        <a href="{{ $main->fullUrl }}" @class(['active' => isset($menu) && in_array($main->id, $menu->activeIds)])>{{ $main->label }}</a>
      </li>
      @endif
      @endforeach
    </ul>
  </nav>
  <div class="menu-mobile__bottom">
    <div class="lang">
      <select name="change_lang_mobile" id="" onchange="if(this.value) window.location.href=this.value;">
        @foreach(lang::codes() as $lang)
        <option value="{{ url()->lang($lang) }}" @selected($lang == lang::active())>{{ config('cadmin.lang.labels-fe.'.$lang) }}</option>
        @endforeach
      </select>
    </div>
    <form action="" class="search">
      <input type="text" placeholder="Search">
      <button type="submit">
        <i class="wa-icon wa-ic-search-outline"></i>
      </button>
    </form>
  </div>
</section>
