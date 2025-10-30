@if(isset($adminWarning))
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-message">
            {!! $adminWarning !!}
        </div>
    </div>
@endif

@if (Session::get('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-message">
            {!! Session::get('success') !!}
        </div>
    </div>
@endif

@if (Session::get('error'))
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-message">
            {!! Session::get('error') !!}
        </div>
    </div>
@endif

@if (count($errors) > 0)
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <div class="alert-message">
        @foreach($errors->all() AS $e)
            {!! $e !!}<br/>
        @endforeach
    </div>
</div>
@endif


@if (isset($errc))
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-message">
            @foreach($errc AS $e)
                {!! $e !!}<br/>
            @endforeach
        </div>
    </div>
@endif

@if (isset($warningc)) 
    <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-message">
            @foreach($warningc AS $e)
                {!! $e !!}<br/>
            @endforeach
        </div>
    </div>
@endif