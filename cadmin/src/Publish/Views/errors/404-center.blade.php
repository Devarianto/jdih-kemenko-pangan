@php

$offline = false;
$title = '';
$subtitle = '';
$intro = '';
$button = '';
$background = '';

try {
	$web = conf('site-setting');
	$offline = $web->status == 'offline' ? true : false;
	$page = conf('404-center');
	$subtitle = $page->translated('subtitle');
	$title = $page->translated('title');
	$intro = $page->translated('intro');
	$button = $page->translated('button');
	$background = $page->background;
} catch(\Exception $e) {
	die('<h1 style="text-align:center;margin-top:100px;">404/Page not found</h1>');
}
@endphp

@if($offline == true)
	@include('errors.offline')
@else
	@extends('errors.layout-misc') 
	@section('content')

	<!-- middle -->
	<section class="misc">
		<figure class="bg">
			<img src="{{ url()->convert($background,'webp') }}" alt="{{ media::initial($background)->alt }}">
		</figure>
		<div class="wrapper misc__wrapper">
			<div class="wrap-misc not-column">
				<div class="wrap-misc__center">
					<h6>{{ $subtitle }}</h6>
					<h2 class="title-medium">{{ $title }}</h2>
					<p>{{ $intro }}</p>
					<button onclick="window.location.href='{{ url('/') }}'" class="button-outline">{{ $button }}</button>
				</div>
			</div>
		</div>
	</section>
	<!-- end of middle -->
	@push('head')
	<link rel="stylesheet" type="text/css" href="{{ asset('css/misc.css')}}" preload />
	@endpush 
	@endsection
@endif