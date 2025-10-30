@if (isset($formValidate) && is_array($formValidate))
    <div class="callout callout-danger alert alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <p>
            @foreach($formValidate AS $e)
                {!! $e !!}<br/>
            @endforeach
        </p>
    </div>
@endif

<div class='stickys btn-group clearfix'>
    <div class="sticky sticky-lang btn bg-purple btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="position:relative;">
        <span><i class="fa fa-language"></i> <em></em></span>
        <ul class="dropdown-menu">
            @foreach (Config::get('cadmin.lang.codes') as $lang)
                <li><a href=# class='toggle-actor toggle-actor dropdown-item' data-lang="{{$lang}}" toggle-target='{{$lang}}-container' toggle-group='lang'>{{ Config::get('cadmin.lang.labels.'.$lang) }}</a></li>
            @endforeach
        </ul>
    </div>
    @if(/*config('cadmin.ai.enable.translate') != true &&*/ count(config('cadmin.lang.codes')) >= 2)
    <div class="sticky btn bg-yellow copy-translation btn-warning">
        <span>
            <span class="copy-text"><i class="fa fa-copy"></i> <span><em>Copy translation</em></span></span>
            <span class="copied" style="display:none"><i class="fa fa-check"></i> Copied</span>
        </span>
    </div>
    @endif
    <div class="sticky sticky-title btn bg-gray btn-secondary" style="cursor: unset;">
        <span><i class="fa fa-tag"></i> <em></em></span>
    </div>
</div>

{!! $form !!}
