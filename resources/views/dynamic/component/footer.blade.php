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
        <div class="logo"><img src="{{ media::initial($footer->logo)->url }}" alt="{{ media::initial($footer->logo)->alt }}"></div>
        <p>{{ $footer->translated('title') }}</p>
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
       <div class="box">
        <h6>JUMLAH PENGUNJUNG</h6>
        <div class="info">
          <label>Hari Ini</label>
          <span>85</span>
        </div>
          <div class="info">
          <label>Kemarin</label>
          <span>64</span>
        </div>
          <div class="info">
          <label>Bulan</label>
          <span>3.000</span>
        </div>
        <div class="info">
          <label>Total</label>
          <span>36.016.786</span>
        </div>
      </div>
    </div>
    <div class="bot">
      <p>©2025  Biro Hukum Kementerian Kordinator Bidang Pangan. Site by <a href="https://webarq.com" target="_blank">WEBARQ</a></p>
      <div class="bot__right">
        <a href=""><img src="{{asset('images/material/ic-ig.svg')  }}" alt=""></a>
        <a href=""><img src="{{asset('images/material/ic-x.svg')  }}" alt=""></a>
        <a href=""><img src="{{asset('images/material/ic-yt.svg')  }}" alt=""></a>
        <a href=""><img src="{{asset('images/material/ic-fb.svg')  }}" alt=""></a>
      </div>
    </div>
  </div>
</footer>
