@extends('cactuar::admin.layout-guest')

@section('content')
	{!! Form::open(['url' => admin::url('guest/forgot'), 'class' => 'form-validate']) !!}
		@include('cactuar::admin.layout-message')
		<div>
			<div class="input-group mb-3">
				<input type="text" class="form-control required" placeholder="" name='username'>
				<label for="username" class="label-animation">Username</label>
			</div>
			<div class="input-group mb-3 logintp">
				<label class="error" for="username"></label>
			</div>
            
            @if(config('cadmin.password.login-captcha') == true)
                {!! recaptcha::init() !!}
                <br>
            @endif
            
			<div class="form-group sidebottom">
				<div class="left">
					<a href="{{ url()->admin('guest/login') }}">Back to Login page</a>
				</div>
				<div class="right">
					<button type="submit" class="btn btn-primary btn-block btn-flat">SUBMIT</button>
				</div>
			</div>
		</div>
	{!! Form::close() !!}
@endsection

@push('assets')
<script src="{{ asset('nwcms/admin/custom/js/login.js') }}"></script>
@endpush