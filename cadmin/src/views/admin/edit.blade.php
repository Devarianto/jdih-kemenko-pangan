@extends('cactuar::admin.layout-master')

@section('content')

@if (is_array(array_get($data, 'menu')))
<div class="col-md-12">
    @foreach (array_get($data, 'menu') AS $v)
        <a href="{{ array_get($v, 'url') }}" class="btn btn-app">
            <i class="fa fa-{{ array_get($v, 'fa') }}"></i>
            {!! array_get($v, 'label') !!}
        </a>
    @endforeach
</div>
@endif

<form method="post" class="form-validate cactuar-form" @if ($data['file']) enctype="multipart/form-data" @endif>
    <input type="hidden" name="_token" value="{!! csrf_token(); !!}">
    <div class="col-md-12 col-xs-12 ">
        <div class="box box-primary card">
            <div class="box-header card-header">
                <h3 class="box-title card-title">{!! array_get($data, 'label') !!}</h3><br/><br/>
                <div class="clear">
                @foreach (array_get($data,'subMenu') as $v)
                    <a href="{{ array_get($v, 'url') }}" class="btn btn-flat bg-blue btn-info"><i class="fa fa-{{ array_get($v, 'fa') }}"></i> {!! array_get($v, 'label') !!}</a>
                @endforeach
                </div>
            </div>
			<div class="box-body card-body">

                {!! array_get($data, 'form') !!}
			</div>
		</div>
	</div>

	<div class="col-md-12 col-xs-12">
        <input type="submit" class="btn btn-primary btn-submit-form" value="UPDATE">
    </div>
</form>

{!! array_get($data, 'append') !!}

@include('cactuar::admin.component.copy-translation-js')

@endsection
