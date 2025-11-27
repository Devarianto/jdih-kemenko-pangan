@extends('cactuar::admin.layout-master')

@section('content')
<div class="col-md-12 ">
</div>

<form method="POST" action="{{ url()->admin('account/new-password') }}" id="generateform" class="form-validate">
    @csrf
    <input type="hidden" name="unique" value="{{ request()->get('unique', optional($account ?? null)->id) }}">
    <div class="col-md-6 col-xs-12 ">
        <div class="box box-primary card">
            <div class="box-header card-header">
                <h3 class="box-title">Account</h3><br/>
                <a href="{{ \Cactuar\Admin\Helpers\admin::url('account') }}" class="btn btn-flat bg-blue btn-info"><i class="fa fa-list"></i> Back to list</a>
            </div>
            <div class="box-body card-body">
                <div class="form-group">
                    <label>New Password</label>
                    <input type="text" name="password" id="password" class="form-control required" minlength="6">
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-success" onclick="randomPassword(10)"><i class="fa fa-magic"></i> Generate</button>
                    <button type="button" class="btn btn-default" onclick="copyPassword()"><i class="fa fa-copy"></i> Copy</button>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="col-md-12 col-xs-12">
        <input type="submit" class="btn btn-primary" value="Update">
    </div>
</form>

<script>
function randomPassword(length) {
    var chars = "abcdefghijklmnopqrstuvwxyz!@#$%^&*()-+<>ABCDEFGHIJKLMNOP1234567890";
    var pass = "";
    for (var x = 0; x < length; x++) {
        var i = Math.floor(Math.random() * chars.length);
        pass += chars.charAt(i);
    }
    document.getElementById('password').value = pass;
}
function copyPassword() {
  var copyText = document.getElementById("password");
  copyText.select();
  copyText.setSelectionRange(0, 99999);
  document.execCommand("copy");
  alert("Copied the new Password: " + copyText.value);
}
</script>

@endsection