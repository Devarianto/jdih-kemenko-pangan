<footer>
  <div class="wave">
    <svg xmlns="http://www.w3.org/2000/svg"
      width="100%" height="140"
      viewBox="0 180 2500 200"
      fill="#F8F8F8"
      preserveAspectRatio="none">
      <path class="st1"
        d="M 0 250 C 1200 320 1200 100 3000 250 L 3000 550 L 0 550 L 0 250">
        <animate attributeName="d" dur="5s"
          values="M 0 250 C 1200 320 1200 100 3000 250 L 3000 550 L 0 550 L 0 250;
                  M 0 250 C 400 100 400 320 3000 250 L 3000 550 L 0 550 L 0 250;
                  M 0 250 C 1200 280 1200 100 3000 250 L 3000 550 L 0 550 L 0 250"
          repeatCount="indefinite" />
      </path>
    </svg>
  </div>
  <div class="wrapper">
    <div class="top">
      @php($footer = widget(99, 'site-setting-conf', 'footer', false))
      @if($footer)
      <div class="box">
        <div class="logo logo-multi">
          <img src="{{ media::initial($footer->logo)->url }}" alt="{{ media::initial($footer->logo)->alt }}">
          @include('dynamic.component.logo-links', ['homeUrl' => lang::url('/')])
        </div>
        <p class="footer-org-title">
          @if(lang::active() == 'en')
            Legal Documentation and Information Network<br>
            Coordinating Ministry for Food Affairs<br>
            Republic of Indonesia
          @else
            Jaringan Dokumentasi dan Informasi Hukum<br>
            Kementerian Koordinator Bidang Pangan<br>
            Republik Indonesia
          @endif
        </p>
        <address>{!! nl2br(strip_tags($footer->address, '<br>')) !!}</address>
        <a href="tel:{{ preg_replace('/\D/', '', $footer->phone) }}" class="button button-icon button-outline ">
          <i class="wa-icon wa-ic-phone-solid"></i>
          {{ $footer->phone }}
        </a>
      </div>
      @endif
      <div class="box">
        <h6>{{ lang::translate('footer.left') }}</h6>
        @foreach($footLeftMenu as $menu)
        <a href="{{ $menu->fullUrl }}">{{ $menu->label }}</a>
        @endforeach
      </div>
      <div class="box">
        <h6>{{ lang::translate('footer.right') }}</h6>
        @foreach($footRightMenu as $menu)
        <a href="{{ $menu->fullUrl }}">{{ $menu->label }}</a>
        @endforeach
      </div>
       @php($visitorStats = \App\Http\Controllers\Front\VisitorController::getStats())
       <div class="box">
        <h6>{{ lang::translate('global.visitor.title') }}</h6>
        <div class="info">
          <label>{{ lang::translate('global.visitor.today') }}</label>
          <span id="visitor-today">{{ number_format($visitorStats['today'], 0, ',', '.') }}</span>
        </div>
          <div class="info">
          <label>{{ lang::translate('global.visitor.yesterday') }}</label>
          <span id="visitor-yesterday">{{ number_format($visitorStats['yesterday'], 0, ',', '.') }}</span>
        </div>
          <div class="info">
          <label>{{ lang::translate('global.visitor.month') }}</label>
          <span id="visitor-month">{{ number_format($visitorStats['month'], 0, ',', '.') }}</span>
        </div>
        <div class="info">
          <label>{{ lang::translate('global.visitor.total') }}</label>
          <span id="visitor-total">{{ number_format($visitorStats['total'], 0, ',', '.') }}</span>
        </div>
      </div>
    </div>
    <div class="bot">
      <p>{!! og::copyright() !!}</p>
      <div class="bot__right">
        @php($socmed = widget(99, 'site-setting-conf', 'socmed'))
        @foreach ($socmed as $data)
        <a href="{{ $data->link }}" target="__BLANK"><img src="{{ media::initial($data->icon)->url }}" alt="{{ media::initial($data->icon)->alt }}"></a>
        @endforeach
      </div>
    </div>
  </div>
</footer>
