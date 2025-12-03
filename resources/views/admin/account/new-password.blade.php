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
                    <input type="password" name="password" value="" class="required form-control password-field" origin="password" id="password">
                    <em class="form-info">min 8 char, include uppercase, numeric and special char</em>
                    <span class="toggle-password"
                            style="cursor:pointer; position:absolute; right:10px; top: 47px; transform:translateY(-50%);">

                        <!-- eye outline -->
                        <svg class="icon-eye" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                fill="none" stroke="currentColor" stroke-width="1.6"
                                viewBox="0 0 24 24" style="display:none;">
                            <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>

                        <!-- eye-off outline -->
                        <svg class="icon-eye-off" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                fill="none" stroke="currentColor" stroke-width="1.6"
                                viewBox="0 0 24 24">
                            <path d="M1 12s4-7 11-7c2.1 0 4 .5 5.6 1.3M23 12s-4 7-11 7c-2.1 0-4-.5-5.6-1.3M3 3l18 18"/>
                            <path d="M9.5 9.5a3 3 0 0 1 4.2 4.2"/>
                        </svg>

                    </span>
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

document.addEventListener("DOMContentLoaded", function () {
    const passwordInputs = document.querySelectorAll(".password-field");

    passwordInputs.forEach(input => {
        const wrapper = input.closest("div");
        const toggle = wrapper.querySelector(".toggle-password");
        const eye = toggle.querySelector(".icon-eye-off");
        const eyeOff = toggle.querySelector(".icon-eye");

        // Toggle by clicking the icon
        toggle.addEventListener("click", () => {
            if (input.type === "password") {
                input.type = "text";
                eye.style.display = "none";
                eyeOff.style.display = "block";
            } else {
                input.type = "password";
                eyeOff.style.display = "none";
                eye.style.display = "block";
            }
        });
    });
});
</script>

@endsection