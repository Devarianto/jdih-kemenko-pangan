<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        @if(isset($title)) 
            {{ strip_tags($title) }} 
        @else 
            {{ strip_tags($baseTitle) }} 
        @endif
        - Admin
    </title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('nwcms/base/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('nwcms/base/css/light.css') }}">
    <link rel="stylesheet" href="{{ asset('nwcms/base/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('nwcms/admin/custom/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('nwcms/admin/custom/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('nwcms/base/plugins/datepicker/datepicker3.css') }}">
    <link rel="stylesheet" href="{{ asset('nwcms/base/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('nwcms/base/plugins/icheck-bootstrap/icheck-bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('nwcms/base/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('nwcms/admin/c.css') }}">
    <link rel="stylesheet" href="{{ asset('nwcms/admin/adminC.css') }}">
    <link rel="stylesheet" href="{{ asset('nwcms/webarq-icons/style.css') }}">
    
    <script src="{{ asset('nwcms/base/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('nwcms/base/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    <meta name="robots" content="noindex">
    
    @if ($website->favicon)
        <link rel="icon" href="{{ media::url($website->favicon) }}">
    @endif
</head>
<body data-theme="default" data-layout="fluid" data-sidebar-position="left" data-sidebar-layout="default">
<div class="wrapper">
    @if(!request()->get('opener'))
        @include('cactuar::admin.layout-nav')
    @endif
    
    <div class="main">
        @if(!request()->get('opener'))
            @include('cactuar::admin.layout-top-menu')
        @endif

        <main class="content">
            <div class="container-fluid p-0">
                @include('cactuar::admin.layout-message')

                @yield('content')
            </div>
        </main>

        <footer class="footer">
            <div class="container-fluid">
                <div class="row text-muted">
                    <div class="col-6 text-start">
                        <p class="mb-0">
                            <strong>Copyright (c) 2022 <a href="https://webarq.com" target="_blank" rel="noopener">WEBARQ</a></strong>
                        </p>
                    </div>
                    @if(!request()->get('opener'))
                    <div class="col-6 text-end">
                        <ul class="list-inline">
                            @if (config('cadmin.cadmin.documentation-file') && file_exists(config('cadmin.cadmin.documentation-file')))
                            <li class="list-inline-item">
                                <a class="text-muted" href="{{ url()->admin('documentation') }}" target="_blank" rel="noopener">Documentation</a>
                            </li>
                            @endif
                            @if (config('cadmin.cadmin.go-to-web'))
                            <li class="list-inline-item">
                                <a class="text-muted" href="{{ str_replace('[site]',url(''), config('cadmin.cadmin.go-to-web')) }}" target="_blank" rel="noopener">Go to web</a>
                            </li>
                            @endif
                        </ul>
                    </div>
                    @endif
                </div>
            </div>  
        </footer>
    </div>
</div>

<div class="ai-content-box" id="ai-content">
    <form class="ai-content-form">
        <div class="ai-box-header">
            <h2 class="ai-box-title h3">Enter your topic</h2>
            <a class="ai-box-close ai-content-cancel"></a>
        </div>
        <div class="form-group">
            <textarea class="form-control required" name="ai_content_topic"></textarea>
        </div>
        <div class="text-start">
            <label class="error mb-2" for="ai_content_topic"></label>
        </div>
        <div class="form-group text-start mb-2">
            <label class="form-label">Kisaran jumlah kata yang diinginkan : </label>
            <input class="form-control required" name="ai_content_maxlength">
        </div>
        <div class="text-start">
            <label class="error mb-2" for="ai_content_maxlength"></label>
        </div>
        <div class="mb-2 text-start">
            <small><i class="fa fa-circle-info"></i> Credit Anda akan berkurang setiap menggunakan fitur ini.</small>
        </div>
        <div class="text-start">
            <input type="submit" value="Submit" class="btn btn-primary ai-content-submit">
            <a class="btn ai-content-cancel ai-btn-default">Cancel</a>
        </div>
    </form>
</div>
<div class="ai-loader">
    <div>
        <img src="{{ asset('nwcms/admin/custom/images/material/bot-icon-1.svg') }}" alt="ai working">
        <h2>AI is working...</h2>
    </div>
</div>

<div class="ai-content-box" id="ai-box-translate-confirm">
    <form class="ai-content-form form-validate">
        <div class="ai-box-header">
            <h2 class="ai-box-title h3"></h2>
            <a class="ai-box-close ai-content-cancel"></a>
        </div>
        <div class="mb-2 fieldSelections">
            <div class="form-group">
                <select class="form-control" name="fieldSelected">
                </select>
            </div>
        </div>
        <div class="mb-2">
            <textarea class="ai-prepare-text form-control required" id="ai-confirm-textarea-prepare"></textarea>
            <label class="error" for="ai-confirm-textarea-prepare">This field is required</label>
        </div>
        <div class="mb-2 text-start ai-text-gray">
            <small><i class="fa fa-circle-info"></i> AI Credit anda akan berkurang setiap menggunakan fitur ini.</small>
        </div>
        <div class="text-start">
            <a class="btn ai-content-confirm ai-btn-action btn-primary" data-action="translate">Translate</a>
            <a class="btn ai-content-cancel ai-btn-action ai-btn-default" data-action="cancel">Cancel</a>
        </div>
    </form>
</div>

<div class="ai-content-box" id="ai-box-translate-use">
    <form class="ai-content-form">
        <div class="ai-box-header">
            <h2 class="ai-box-title h3"></h2>
            <a class="ai-box-close ai-content-cancel"></a>
        </div>
        <div class="mb-2 fieldSelections">
            <div class="form-group">
                <select class="form-control" name="fieldSelected">
                </select>
            </div>
        </div>
        <div class="mb-2">
            <textarea class="ai-prepare-text form-control" disabled data-readonly="true" id="ai-use-textarea-prepare"></textarea>
        </div>
        <div class="mb-2">
            <div class="row">
                <div class="col-6 text-start">
                    <h4>Result</h4>
                </div>
                <div class="col-6 text-end">
                    <small>
                        Used token <span id="ai-result-token"></span>
                        =
                        <span id="ai-result-idr"></span>
                        IDR Credit
                    </small>
                </div>
            </div>
        </div>
        <div class="mb-2">
            <textarea class="ai-result-text form-control" id="ai-use-textarea-result"></textarea>
        </div>
        <div class="text-start">
            <a class="btn ai-content-confirm ai-btn-action btn-primary" data-action="use">Use Translate</a>
            <a class="btn ai-content-cancel ai-btn-action ai-btn-default" data-action="cancel">Cancel</a>
        </div>
    </form>
</div>

<script>
    var $url = "{{ admin::url() }}";
    var $asset = "{{ asset('') }}";
    var $mediaPath = "{{ media::baseurl() }}";
    var $token = "{{ csrf_token() }}";
    var $locale = "{{ App::getLocale() }}";
    var $lang = "{{ Config::get('cadmin.lang.default') }}";
	
	//remove auto-build by ckeditor, add wrap textarea
	//$('.ckeditor').removeClass('ckeditor').addClass('my-ckeditor').wrap('<div class="ckeditor-container" style="min-height:320px;">');

    $('select.form-control').each(function(k,v){
        if($(v).hasClass('multiselect') || $(v).hasClass('select2')) return;
        $(v).addClass('form-select');
    });
</script>

<script src="{{ asset('nwcms/base/js/app.js') }}"></script>

<script src="{{ asset('nwcms/base/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('nwcms/admin/autoNumeric-1.6.2.js') }}"></script>
<script src="{{ asset('nwcms/base/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('nwcms/base/plugins/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('nwcms/base/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('nwcms/base/plugins/datepicker/bootstrap-datepicker.js') }}"></script>

<script src="{{ asset('nwcms/admin/jquery-validation-1.19.5/jquery.validate.min.js')}}"></script>
<script src="{{ asset('nwcms/admin/jquery-validation-1.19.5/additional-methods.min.js')}}"></script>

<script src="{{ asset('nwcms/admin/jquery-swapsies.js') }}"></script>
<script src="{{ asset('nwcms/admin/c.js')}}"></script>
<script src="{{ asset('nwcms/admin/adminC.js')}}"></script>
<script src="{{ asset('nwcms/webarq-icons/script.js')}}"></script>

@stack('assets')
</body>
</html>
