<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Admin login</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('nwcms/base/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('nwcms/base/css/light.css') }}">
    <link rel="stylesheet" href="{{ asset('nwcms/base/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('nwcms/admin/custom/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('nwcms/admin/custom/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('nwcms/base/plugins/datepicker/datepicker3.css') }}">
    <link rel="stylesheet" href="{{ asset('nwcms/base/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('nwcms/base/plugins/icheck-bootstrap/icheck-bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('nwcms/base/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('nwcms/admin/c.css') }}">
    <link rel="stylesheet" href="{{ asset('nwcms/admin/adminC.css') }}">
    <link rel="stylesheet" href="{{ asset('nwcms/admin/custom/css/login.css') }}">
    
    <script src="{{ asset('nwcms/base/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('nwcms/base/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    <meta name="robots" content="noindex">
		
    @if ($website->favicon)
        <link rel="icon" href="{{ media::url($website->favicon) }}">
    @endif
</head>
<body>
    
	<div class="login-box card">
		<div class="head">
            <div class="logo" style="background: radial-gradient(44.17% 136.2% at 50% 50%, #076E95 0%, #00558F 100%)">
                <img src="{{ media::url($website->logo) }}" alt="">
            </div>
            {{--<div class="login-img">
                <img src="{{ asset('admin-nwcms/images/material/logo-login.png') }}" width="82" height="40" alt="" class="logo-login">
            </div>--}}
        </div>
		<div class="login-box-body login-card-body card-body bg-white">
            
            @yield('content')

		</div>
		<div class="footer">
            <div class="wrap-logo">
				<div class="col">
					<img src="{{ asset('nwcms/admin/custom/images/material/logo-wcms.png') }}" alt="">
				</div>
			</div>
        </div>

		<div class="login-logo">
			
		</div>

	</div>

	<div class="copyright">
        <p>&copy; {{ date('Y') }} JDIH Kementerian Koordinator Bidang Pangan. All rights reserved.</p>
    </div>

    <script>
		var $url = "{{ admin::url() }}";
		var $asset = "{{ asset('') }}";
		var $mediaPath = "{{ asset(Config::get('cadmin.media.sourcepath')) }}";
		var $token = "{{ csrf_token() }}";
		var $locale = "{{ App::getLocale() }}";
		var $lang = "{{ Config::get('cadmin.lang.default') }}";
		
		//remove auto-build by ckeditor, add wrap textarea
		//$('.ckeditor').removeClass('ckeditor').addClass('my-ckeditor').wrap('<div class="ckeditor-container" style="min-height:320px;">');
	</script>

	<script src="{{ asset('nwcms/base/js/app.js') }}"></script>

	<script src="{{ asset('nwcms/base/plugins/moment/moment.min.js') }}"></script>
	<script src="{{ asset('nwcms/admin/jquery.validate.min.js')}}"></script>
	<script src="{{ asset('nwcms/admin/additional-methods.min.js')}}"></script>
	<script src="{{ asset('nwcms/admin/autoNumeric-1.6.2.js') }}"></script>
	<script src="{{ asset('nwcms/base/plugins/select2/js/select2.full.min.js') }}"></script>
	<script src="{{ asset('nwcms/base/plugins/ckeditor/ckeditor.js') }}"></script>
	<script src="{{ asset('nwcms/base/plugins/daterangepicker/daterangepicker.js') }}"></script>
	<script src="{{ asset('nwcms/base/plugins/datepicker/bootstrap-datepicker.js') }}"></script>

	<script src="{{ asset('nwcms/admin/jquery-swapsies.js') }}"></script>
	<script src="{{ asset('nwcms/admin/c.js')}}"></script>
	<script src="{{ asset('nwcms/admin/adminC.js')}}"></script>

	@stack('assets')
</body>
</html>