@extends('cactuar::admin.layout-master')

@section('content')

<div class="col-md-12 ">

</div>

<form method="post" class="form-validate">
    <input type="hidden" name="_token" value="{!! csrf_token(); !!}">
    <div class="col-md-6 col-xs-12 ">
        <div class="box box-primary card">
            <div class="box-header card-header">
                <h3 class="box-title">{!! $title !!}</h3><br/>
                <a href="{{ admin::url('user') }}" class="btn btn-flat bg-blue btn-info"><i class="fa fa-list"></i> Back to list</a>
                @if ($type == 'detail') 
                    <a href="{{ admin::url('user/create') }}" class="btn btn-flat bg-blue btn-info"><i class="fa fa-plus"></i> Create</a>
                @endif
            </div>
            <div class="box-body card-body">
                <div class="form-group">
                    <label>Privilege</label>
                    {!! Form::select('privilege_id', $privilege, $data->privilege_id, ['class' => 'form-control required']) !!}
                </div>
                <div class="form-group">
                    <label>Login Name</label>
                    <input type='text' name='name' value="{{ $data->name }}" class="form-control required unique" 
                           data-table="users" data-field="name" @if ($type == 'detail') data-not="{{ $data->id }}" @endif>
                    <span class="info">lowercase, number or strip (-) only</span>
                </div>
                <div class="form-group">
                    <label>Display Name</label>
                    <input type='text' name='display_name' value="{{ $data->display_name }}" class="form-control required">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type='text' name='email' value="{{ $data->email }}" class="form-control required email"
                           data-table="users" data-field="email" @if ($type == 'detail') data-not="{{ $data->id }}" @endif>
                </div>
                <div class="form-group">
                    <label>New Password</label>
                    <input type='password' name='password' value="" class="form-control @if ($type == 'create') required @endif" >
                    <div>{!! implode('<br>',$passwordInfo) !!}</div>
                </div>
                <div class="form-group">
                    <label>Enable</label>
                    {!! Form::select('is_enable', ['Yes' => 'Yes', 'No' => 'No'], $data->is_enable, ['class' => 'form-control required']) !!}
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