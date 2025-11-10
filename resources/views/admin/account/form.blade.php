@extends('cactuar::admin.layout-master')

@section('content')

<div class="col-md-12 ">

</div>

<form method="post" class="form-validate">
    <input type="hidden" name="_token" value="{!! csrf_token(); !!}">
    <div class="col-md-6 col-xs-12 ">
        <div class="box box-primary card">
            <div class="box-header card-header">
                <h3 class="box-title">Account</h3><br/>
                <a href="{{ admin::url('account') }}" class="btn btn-flat bg-blue btn-info"><i class="fa fa-list"></i> Back to list</a>
            </div>
            <div class="box-body card-body">
                <div class="form-group">
                    <label>Name</label>
                    <input type='text' name='name' value="{{ $data->name }}" class="form-control required">
                    <span class="info">max 255 characters</span>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type='text' name='email' value="{{ $data->email }}" class="form-control required email" data-table="users" data-field="email" @if ($type == 'detail') data-not="{{ $data->id }}" @endif>
                </div>
                <div class="form-group">
                    <label>Enable</label>
                    {!! Form::select('is_active', ['1' => 'Yes', '0' => 'No'], $data->is_active, ['class' => 'form-control required']) !!}
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="col-md-12 col-xs-12">
        @if ($type == 'detail')
            <input type="submit" class="btn btn-primary" value="Update">
        @else
            <input type="submit" class="btn btn-primary" value="Save">
        @endif
    </div>
</form>

@endsection