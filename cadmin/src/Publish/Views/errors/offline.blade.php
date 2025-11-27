@extends('errors.layout-misc')

@section('content')

<section class="misc">
    <figure class="bg">
		{!! media::initial(conf('offline-page')->background)->html !!}
    </figure>
    <div class="wrapper misc__wrapper">
        <div class="wrap-misc">
            <div class="wrap-misc__center undermaintenance">
                <figure>
					{!! media::initial(conf('site-setting')->logo)->html !!}
				</figure>
                <h6>{{ conf('offline-page')->translated('subtitle') }}</h6>
                <h2 class="title-medium">{{ conf('offline-page')->translated('title') }}</h2>
                <p>{{ conf('offline-page')->translated('intro') }}</p>
            </div>
        </div>
    </div>
</section>
@push('head')
	<link rel="stylesheet" type="text/css" href="{{ asset('css/misc.css')}}" preload>
@endpush
@endsection