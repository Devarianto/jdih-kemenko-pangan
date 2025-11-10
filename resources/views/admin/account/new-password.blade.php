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
                    <label>New Password</label>
                    <input type='password' name="password" class="form-control required" minlength="6">
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="col-md-12 col-xs-12">
        <input type="submit" class="btn btn-primary" value="Update">
    </div>
</form>

@endsection