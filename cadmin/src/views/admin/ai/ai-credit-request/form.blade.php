@extends('cactuar::admin.layout-master')

@section('content')
<div class="card">
    <div class="card-header box-header">
        <h3 class="card-title box-title">Request AI Credit</h3><br/><br/>
		<a href="{{ url()->admin($module.'/index') }}" class="btn btn-flat bg-blue btn-info"><i class="fa fa-list"></i> back to index</a>
    
	</div>
	
	{!! Form::open(['class'=>'form-validate cactuar-form']) !!}
	<div class="card-body"> 

		<div class="form-group clearfix">
			<label class="col-md-2 col-xs-12 control-label">Email</label>
			<div class="col-md-10 col-xs-12">
				<input type="text" name="email" class="form-control email required">
				<em class="info">Tagihan akan dikirimkan ke email ini</em>
			</div>
		</div>

		<div class="form-group clearfix">
			<label class="col-md-2 col-xs-12 control-label">Topup amount</label>
			<div class="col-md-10 col-xs-12">
				<input type="text" name="amount" class="form-control numeric required numMin" data-min="{{ $minTopup }}">
				<em class="info">Minimal topup {{ num2string($minTopup + 1) }}</em>
			</div>
		</div>
		<div class="form-group clearfix">
			<label class="col-md-2 col-xs-12 control-label">Billing total</label>
			<div class="col-md-10 col-xs-12">
				<input type="text" name="total" class="form-control numeric required" readonly>
				<em class="info">inc PPN {{ $ppn }}%</em>
			</div>
		</div>

		<div class="col-md-12 col-xs-12">
			<input type="submit" class="btn btn-primary btn-submit-form" value="SEND">
		</div>
	</div>
	{!! Form::close() !!}
</div>

<script>
	$('input[name=amount]').change(function() {
		let ppn = {{ $ppn }};
		let total = string2num($(this).val()) + (string2num($(this).val()) * ppn * 0.01);
		$('input[name=total]').val(num2string(total));
	});
</script>

@endsection