<li
	@if($i['token'] == $path['token'])
		class="active"
	@endif
><a href="?{{ query(['path'=>$i['token']]) }}">{{ basename($i['name']) }}</a>
	@if(array_get($i,'childs') && count($i['childs']) >= 1)
		<ul>
			@foreach($i['childs'] as $v)
				@include('cactuar::admin.cfind-path',['i'=>$v])
			@endforeach
		</ul>
	@endif

</li>