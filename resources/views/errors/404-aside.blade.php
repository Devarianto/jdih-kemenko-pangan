@php

$offline = false;
$title = '';
$subtitle = '';
$intro = '';
$button = '';
$icon = '';

try {
	$web = conf('site-setting');
	$offline = $web->status == 'offline' ? true : false;
	$page = conf('404-aside');
	$subtitle = $page->translated('subtitle');
	$title = $page->translated('title');
	$intro = $page->translated('intro');
	$button = $page->translated('button');
	$icon = $page->icon;
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
		<div class="wrapper misc__wrapper">
			<div class="wrap-misc">
				<div class="wrap-misc__left">
					<h6>{{ $subtitle }}</h6>
					<h2 class="title-medium">{{ $title }}</h2>
					<p>{{ $intro }}</p>
					<button onclick="window.location.href='{{ url('/') }}'" class="button-outline">{{ $button }}</button>
				</div>
				<div class="wrap-misc__right">
					<figure>
						{!! media::initial($icon)->html !!}
					</figure>
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