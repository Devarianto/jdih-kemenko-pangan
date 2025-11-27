@extends('cactuar::admin.layout-master')

@section('content')
<div class="card">
    <div class="card-header box-header">
        <h3 class="card-title box-title">AI Credit</h3><br/><br/>
	</div>
	<div class="card-body"> 
        @include('cactuar::admin.ai.ai-token')
		<hr/>
		<div class="table-responsive"> 
			<h3 style="position:absolute;">Credit Request</h3>
			@php
            $query = Request::query();
            foreach (['sort', 'filter', 'search', 'range', 'page'] as $empty) {
                if (array_key_exists($empty, $query))
                    unset($query[$empty]);
            }
            @endphp
            <form method="post" action="{{ admin::url('admin/filter?'.http_build_query($query)) }}" class="admin-filter " style="float:right;">
                <input type="hidden" name="_token" value="{!! csrf_token(); !!}">
                <input type="hidden" name="segments" value="{{ json_encode(Request::segments()) }}">

				<div>
					<div class="input-group">
						<span class="input-group-text"><i class="fa fa-calendar"></i></span>
						<input type="text" class="form-control date-range-picker" autocomplete=off name='range' value="{{ Request::input('range') }}" style="font-size:12px;width:150px;">
					</div>
				</div>
                <div>
                    <input type='submit' class='btn btn-flat bg-purple btn-midh btn-primary' value='Filter'>
                </div>
            </form>
            <table class="table table-hover">
            	<caption>AI billing request</caption>
                <thead>
                    <tr>
						<th>Request no</th>
						<th>Billing Email</th>
						<th style="text-align:right;">AI Credit Request (Rp)</th>
						<th style="text-align:right;">Ppn (Rp)</th>
						<th style="text-align:right;">Total (Rp)</th>
						<th>Status</th>
						<th>Note</th>
						<th style="width:180px;">Created</th>
                    </tr>
                </thead>

                <tbody>
					@forelse($data as $i)
					<tr>
						<td>{{ array_get($i,'code') }}</td>
						<td>{{ array_get($i,'billingEmail') }}</td>
						<td style="text-align:right;">{{ num2string(array_get($i,'credit')) }}</td>
						<td style="text-align:right;">{{ num2string(array_get($i,'ppn')) }}</td>
						<td style="text-align:right;">{{ num2string(array_get($i,'billingTotal')) }}</td>
						<td>{{ array_get($i,'status') }}</td>
						<td>{{ array_get($i,'note') ?: ' - ' }}</td>
						<td>{{ date2string(array_get($i,'createdAt'), 'd F Y H:i') }}</td>
					</tr>	
					@empty
					<tr><td colspan=5>Empty data</td></tr>
					@endforelse
                </tbody>
            </table>
        </div>
    </div>
	
    {!! $paginator->appends(request()->query())->render('cactuar::admin.paginate') !!}
</div>
@endsection