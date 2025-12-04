<a href="javascript:;" data-url="{{ url()->current() }}" onclick="navigator.clipboard.writeText(this.dataset.url).then(()=>{ alert('{{ lang::translate('global.url-copy') }}'); });"><img src="{{ asset('images/material/ic-link.svg') }}" alt=""></a>
<a href="{{ $model->share('wa') }}" target="__BLANK"><img src="{{ asset('images/material/ic-wa.svg') }}" alt=""></a>
<a href="{{ $model->share('tw') }}" target="__BLANK"><img src="{{ asset('images/material/ic-x.svg') }}" alt=""></a>
<a href="{{ $model->share('fb') }}" target="__BLANK"><img src="{{ asset('images/material/ic-fb.svg') }}" alt=""></a>