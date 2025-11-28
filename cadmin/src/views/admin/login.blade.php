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
		<div class="input-group mb-3 logintp" style="position:relative;">
			<input type="password" class="form-control required password-field" placeholder="" name="password">
			<label for="password" class="label-animation">Password</label>

			<!-- Toggle Icon -->
			<span class="toggle-password" 
				style="cursor:pointer; position:absolute; right:10px; top:30%; transform:translateY(-30%);">

				<!-- eye outline -->
				<svg class="icon-eye" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
					fill="none" stroke="currentColor" stroke-width="1.6"
					viewBox="0 0 24 24" style="display:none;">
					<path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/>
					<circle cx="12" cy="12" r="3"/>
				</svg>

				<!-- eye-off outline -->
				<svg class="icon-eye-off" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
					fill="none" stroke="currentColor" stroke-width="1.6"
					viewBox="0 0 24 24">
					<path d="M1 12s4-7 11-7c2.1 0 4 .5 5.6 1.3M23 12s-4 7-11 7c-2.1 0-4-.5-5.6-1.3M3 3l18 18"/>
					<path d="M9.5 9.5a3 3 0 0 1 4.2 4.2"/>
				</svg>
			</span>
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
<script>
	document.addEventListener("DOMContentLoaded", function () {
		const passwordInputs = document.querySelectorAll(".password-field");

		passwordInputs.forEach(input => {
			const wrapper = input.closest(".input-group");
			const toggle = wrapper.querySelector(".toggle-password");
			const eye = toggle.querySelector(".icon-eye-off");
			const eyeOff = toggle.querySelector(".icon-eye");

			// Toggle by clicking the icon
			toggle.addEventListener("click", () => {
				if (input.type === "password") {
					input.type = "text";
					eye.style.display = "none";
					eyeOff.style.display = "block";
				} else {
					input.type = "password";
					eyeOff.style.display = "none";
					eye.style.display = "block";
				}
			});
		});
	});

</script>
@endpush