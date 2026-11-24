<link href='//fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>

<link rel='stylesheet' type='text/css' href="{{ asset('cfind/assets/css/style.css') }}">
<link rel='stylesheet' type='text/css' href="{{ asset('cfind/assets/css/font-awesome.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('cfind/imgAreaSelection/css/imgareaselect-default.css') }}" />
<link rel='stylesheet' type='text/css' href="{{ asset('nwcms/admin/custom/css/style-cfind.css') }}">

@php

if (!function_exists('query')) {
    function query($append=[])
    {
        $query = request()->query();
        foreach($append as $k=>$v) {
            $query[$k] = $v;
        }

        if(array_key_exists('search',$query)) {
            unset($query['search']);
        }

        return http_build_query($query);
    }
}

@endphp

<div class='cfind-main'>
	<div class='cfind-tools'>
        <ul>
			<li class='cfind-create-folder' data-disable="{{ !in_array('create-folder',$buttons) }}"><span class='fa fa-folder'><span class="fa fa-plus"></span></span>
				<div>
					<label>Create new folder</label>
					<form method='post'>
                        <input type="hidden" name="_token" value="{!! csrf_token(); !!}">
                        <input type="hidden" name="path" value="{{ $path['token'] }}">
                        <input type="hidden" name="act" value="create-folder">
						<input type='text' name='folder' value='New Folder'><input type='submit' value='Create'>
					</form>
				</div>
			</li>
			<li class='cfind-create-file' data-disable="{{ !in_array('upload-file',$buttons) }}"><span class='fa fa-file-photo-o'></span><span class="fa fa-plus"></span>
				<div>
					<label>Upload new file</label>
					<form method='post' enctype='multipart/form-data'>
                        <input type="hidden" name="_token" value="{!! csrf_token(); !!}">
                        <input type="hidden" name="path" value="{{ $path['token'] }}">
                        <input type="hidden" name="act" value="upload-file">
						@for($i=1; $i<=5; $i++)
							<input type='file' name='name_{{$i}}'>
						@endfor
						<label><input type='checkbox' name='overide' value='1'><span>Overwrite if exists</span></label><br/>
						<input type='submit' value='Upload'><br/>
					</form>
				</div>
			</li>
			<li class='cfind-delete-folder' data-disable="{{ !in_array('delete-folder',$buttons) }}"><span class='fa fa-remove'></span>
				<div>
					<form method="post">
                        <input type="hidden" name="_token" value="{!! csrf_token(); !!}">
                        <input type="hidden" name="path" value="{{ $path['token'] }}">
                        <input type="hidden" name="act" value="delete-folder">
						<input type="submit" name="delete" value="Delete Folder">
					</form>
				</div>	
			</li>
			<li data-disable="{{ !in_array('up',$buttons) }}"><a href="?{!! query(['path'=>$path['back']]) !!}" class='fa fa-arrow-up'><a></a></li>
			<li class='cfind-path'>
				{{ $path['name'] }}
			</li>
			<li class='cfind-search'>
				<form method='get'>
                    @foreach(request()->query() as $k=>$v)
                        @if(is_array($v) || $k == 'path' || $k == 'csrf_token' || $k == 'search')
                            @continue
                        @endif
                        <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                    @endforeach
                    <input type='text' name='search' value="{{ request()->queryValidated('search','string') }}" placeholder='Search'>
				</form>
			</li>
		</ul>
    </div>
    <div class='cfind-explorer'>
		<ul>
            @foreach([$tree] as $v)
                @include('cactuar::admin.cfind-path',['i'=>$v])
            @endforeach
        </ul>
    </div>

    <div class='cfind-items'>
        @if(session('cfind-error'))
        <div class="cfind-div cfind-message cfind-message-error">
            @foreach(session('cfind-error') as $v)
                {{ $v }}<br/>
            @endforeach
        </div>
        @endif
        @if(session('cfind-success'))
        <div class="cfind-div cfind-message cfind-message-success">
            @foreach(session('cfind-success') as $v)
                {{ $v }}<br/>
            @endforeach
        </div>
        @endif
		 
		@if(count($dirs) <= 0 && count($files) <= 0) 
            <p><i>no item found</i></p>
        @else
		<ul>
            @foreach($dirs as $dir)
            <li class="cfind-item-folder">
                <a href="?{{ query(['path'=>$dir['token']]) }}" title="{{ $dir['name'] }}">
                    <figure></figure>
                    <span>{{ $dir['name'] }}</span>
                </a>
            </li>
            @endforeach

            @foreach($files as $file)
            <li class="cfind-item-file" 
                data-is-file="true"
                data-type="{{ $file['type'] }}"
                data-path="{{ $file['path'] }}"
                data-path-token="{{ $file['path-token'] }}"
                data-size="{{ $file['readable']['size'] }}"
                data-name="{{ $file['name'] }}"
                data-ctime="{{ $file['readable']['time'] }}"
                data-url="{{ $file['url'] }}"
                data-is-image="{{ $file['image'] ? 'true' : 'false' }}"
                data-image-width="{{ $file['dimension']['width'] }}"
                data-image-height="{{ $file['dimension']['height'] }}"
                >
					<a href="" title="{{ $file['name'] }}">
						<figure
                            @if($file['image'] == true)
                                style="background-image:url('{{ $file['url'] }}')"
                            @endif
                        
                        ></figure>
						<span>{{ $file['name'] }}</span>
					</a>
				</li>
            @endforeach
		</ul>
        @endif
	</div>

    <div class='cfind-detail'>
		<div style="display:none;">
			<h3></h3>
			<div class='cfind-item-file'>
				<figure></figure>
			</div>
			<p></p>

            @if(in_array('delete-file',$buttons))
                <a href=# class='remove' ><span class='fa fa-remove'></span> Remove File</a>
            @endif

            <a href=# class="use cfind-" onClick="navigator.clipboard.writeText($('.cfind-detail').attr('data-url'));alert('URL has been copied into your clipboard');return false;"><span class="fa fa-clipboard" ></span> Copy URL</a>
            
            @if(request()->get('opener') == 'cfind')
                <br/><br/>
                @if($resize['avail'] == true)
                    <div class="cfind-message">
                        Image need to be resized to :<br/>

                        @if($resize['width'] > 0)
                            Width : {{ num2string($resize['width']) }}px<br/>
                        @endif
                        @if($resize['height'] > 0) 
                            Height : {{ num2string($resize['height']) }}px<br/>
                        @endif
                    </div>
                    
                    @if($resize['width'] >= 1 && $resize['height'] >= 1 && $resize['type'] == 'cover')
                     <a href=# class="use cfind-use-crop"
                           crop-ratio="{{ $resize['width'].':'.$resize['height'] }}"
                           crop-width="{{ $resize['width'] }}"
                           crop-height="{{ $resize['height'] }}"
                           style="width:150px;"
                           ><span class="fa fa-crop"></span> Select crop area</a>
                    @endif

                    <a href=# class="use cfind-use-auto-crop"><span class="fa fa-image"></span> Auto resize</a>
                @else
                    <a href=# class="use" ><span class="fa fa-map-pin"></span> Use</a>
                @endif
            @endif

            @if(in_array('delete-file',$buttons))
            <div class="cfind-div cfind-delete-file-container" style="display:none;">
				<form method="post">
					<input type="hidden" name="_token" value="{!! csrf_token(); !!}">
                    <input type="hidden" name="act" value="delete-file">
                    <input type='hidden' name="path">
					<input type="hidden" name="file">
				</form>
			</div>
            @endif

            @if(request()->get('opener') == 'cfind' && $resize['avail'] != true)
            <form method="post" id="use" style="display:none;">
                <input type="hidden" name="_token" value="{!! csrf_token(); !!}">
                <input type="hidden" name="act" value="use">
                <input type='hidden' name="path">
                <input type="hidden" name="file">
            </form>
            @endif

            @if(request()->get('opener') == 'cfind' && $resize['avail'] == true)
            <form method="post" id="auto_crop">
                <input type="hidden" name="_token" value="{!! csrf_token(); !!}">
                <input type="hidden" name="act" value="auto-resize">
                <input type="hidden" name="thumb" value="{{ request()->get('thumb') }}">
                <input type='hidden' name="path">
                <input type="hidden" name="file">
            </form>
            @endif
		</div>
	</div>

    <div style='clear:both;'></div>
</div>

@if($resize['avail'] == true && $resize['type'] == 'cover')
<div class='cfind-select-area'>
    <form method="post">
    	<div class="box-crop-side">
        	<div class="left">
		    	<h1>Select crop area</h1>
		    	<div class='selection-area'></div>
	            <input type="hidden" name="_token" value="{!! csrf_token(); !!}">
	            <input type="hidden" name="do" value="resize">
	            
            </div>
            <div class="right">
            	Selected area :<br/>
	            <div class="tx"><input type="text" name="width" class="size" readonly><span class="sat">px</span></div>
	            <span class="xsat">x</span> 
	            <div class="tx"><input type="text" name="height" class="size" readonly><span class="sat">px</span></div><br/><br/>
	            Recommended size :<br/>
	            <div class="tx"><input type="text" name='toWidth' class="size" readonly value="{{ $resize['width'] }}"><span class="sat">px</span></div>
	            <span class="xsat">x</span> 
	            <div class="tx"><input type="text" name='toHeight' class="size" readonly value="{{ $resize['height'] }}"><span class="sat">px</span></div>
	            <br/><br/>
	            
	            <a href=# class="btn selection-area-back"><span class="fa fa-chevron-left"></span> Cancel</a>
	            <a href=# class="btn selection-area-confirm" style="display:none;"><span class="fa fa-crop"></span> Confirm</a>
	            <input type="hidden" name="act" value="custom-resize">
                <input type="hidden" name="x1"><input type="hidden" name="y1">
                <input type="hidden" name="thumb" value="{{ request()->get('thumb') }}">
                <input type='hidden' name="path">
                <input type="hidden" name="file">
            </div>
    	</div>
    </form>
</div>
@endif

@if(request()->get('opener'))
<script src="{{ asset('nwcms/base/plugins/jquery/jquery.min.js') }}"></script>
@endif
<script src="{{ asset('cfind/assets/js/cfind.js') }}?v=20261124"></script>
<script type="text/javascript" src="{{ asset('cfind/imgAreaSelection/scripts/jquery.imgareaselect.pack.js') }}"></script>