@extends('cactuar::admin.layout-master')

@section('content')
<div class="card">
    <div class="card-header box-header">
        <h3 class="card-title box-title">AI Log</h3><br/><br/>
		<a href="{{ url()->admin($module.'/download').'?'.http_build_query(request()->query()) }}" class="btn btn-flat bg-blue btn-info"><i class="fa fa-download"></i> Download</a>
    </div>
	<div class="card-body"> 
        <div class="table-responsive"> 
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
            	<caption>AI Billing</caption>
                <thead>
                    <tr>
						<th>Action</th>
						<th style="text-align:right;">Usage (Rp)</th>
						<th style="text-align:right;">AI Credit (Rp)</th>
						<th>Admin</th>
						<th>IP</th>
						<th>Note</th>
						<th style="width:180px;">Created</th>
                    </tr>
                </thead>

                <tbody>
					@forelse($data as $i)
					<tr>
						<td>{{ array_get($i,'action') }}</td>
						<td style="text-align:right;">{{ num2string(array_get($i,'webarqToken') ?: 0,2) }}</td>
						<td style="text-align:right;">{{ num2string(array_get($i,'saldoAkhir') ?: 0,2) }}</td>
						<td>{{ array_get($i,'action') == 'topup' ? '-' : array_get($i,'adminName') }}</td>
						<td>{{ array_get($i,'action') == 'topup' ? '-' : array_get($i,'ip') }}</td>
						<td>{{ array_get($i,'note') ?: ' - ' }}</td>
						<td>{{ date2string(array_get($i,'createdAt'), 'd F Y H:i') }}</td>
					</tr>	
					@empty
					<tr><td colspan=6>Empty data</td></tr>
					@endforelse
                </tbody>
            </table>
        </div>
    </div>
	
    {!! $paginator->appends(request()->query())->render('cactuar::admin.paginate') !!}
</div>
@endsection