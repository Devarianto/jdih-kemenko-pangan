@extends('cactuar::admin.layout-guest')

@section('content')

{!! Form::open(['url' => admin::url('guest/login'), 'class' => 'form-validate']) !!}
	@include('cactuar::admin.layout-message')
	<div>
		<div class="input-group mb-3">
			<input type="text" class="form-control required" placeholder="" name='username'>
			<label for="username" class="label-animation">Username</label>
		</div>
		<div class="input-group mb-3 logintp">
			<label class="error" for="username"></label>
		</div>
		<div class="input-group mb-3 logintp">
			<input type="password" class="form-control required"  placeholder="" name='password'>
			<label for="password" class="label-animation">Password</label>
		</div>
		<div class="input-group mb-3 logintp">
			<label class="error" for="password"></label>
		</div>
        
        @if(config('cadmin.password.login-captcha') == true)
            {!! recaptcha::init() !!}
            <br>
        @endif
        
		<div class="form-group sidebottom">
			<div class="left">
					<a href="{{ url()->admin('guest/forgot') }}">Forgot Password?</a>
			</div>
			<div class="right">
				<button type="submit" class="btn btn-primary btn-block btn-flat btn-login">LOGIN</button>
			</div>
		</div>
	</div>
	@if (Session::get('redirectParam'))
		<input type="hidden" name="redirect" value="{{ Session::get('redirectParam') }}">
	@endif
{!! Form::close() !!}

@endsection

@push('assets')
<script src="{{ asset('nwcms/admin/custom/js/login.js') }}"></script>
@endpush