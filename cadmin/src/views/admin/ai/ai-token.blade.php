<div class="col-xl-12">
	<div class="card">
		<div class="card-body">
			<div class="row">
				<div class="col">
					<div class="row">
						<div class="col-auto m-auto">
							<img src="{{ asset('nwcms/admin/custom/images/material/token-icon.svg') }}" class="ai-cms-icon">
						</div>
						<div class="col">
							<h5 class="card-title">Credit</h5>
							<h2 class="fw-bold">Rp {{ $token }}</h2>
						</div>
					</div>
				</div>
				<div class="col">
					<div class="row">
						<div class="col-auto m-auto">
							<img src="{{ asset('nwcms/admin/custom/images/material/usage-icon.svg') }}" class="ai-cms-icon">
						</div>
						<div class="col">
							<h5 class="card-title">Total Usage (Rp)</h5>
							<h2 class="text-danger fw-bold">Rp {{ $usage }}</h2>
						</div>
					</div>
				</div>
				<div class="col m-auto text-center">
					@if(Auth::user()->allow('ai-credit','request'))
					<a class="btn btn-primary btn-lg" href="{{ url()->admin('ai-credit/request') }}">TOPUP CREDIT</a>
					@endif
					@if(Auth::user()->allow('ai-billing-log','index'))
					<a class="btn btn-danger btn-lg" href="{{ url()->admin('ai-billing-log') }}">LOG USAGE</a>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>

<style type="text/css">
	h3.form-subtitle{
		color: #00558F;
		font-weight: 700;
	}
	h3[origin=faq]{
		margin-top: 3rem !important;
	}
</style>