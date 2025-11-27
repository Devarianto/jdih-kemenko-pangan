@extends('dynamic.layouts.layout')

@section('content')
{{--
@include('dynamic.components.headers.header-search',['search'=>['url'=>url('search'),'placeholder'=>'cari..'],'button'=>['url'=>url('button'),'label'=>'tombol']])
@include('dynamic.components.headers.header',['search'=>['url'=>url('search'),'placeholder'=>'cari..'],'button'=>['url'=>url('button'),'label'=>'tombol']])
@include('dynamic.components.headers.header-double',['search'=>['url'=>url('search'),'placeholder'=>'cari..'],'button'=>['url'=>url('button'),'label'=>'tombol']])
@include('dynamic.components.headers.header-center',[/*'splitidx'=>2,*/'search'=>['url'=>url('search'),'placeholder'=>'cari..']])
@include('dynamic.components.headers.header-burger',['search'=>['url'=>url('search'),'placeholder'=>'cari..'],'button'=>['url'=>url('button'),'label'=>'tombol']])
--}}
@include('dynamic.components.headers.header-dropdown',['search'=>['url'=>url('search'),'placeholder'=>'cari..'],'button'=>['url'=>url('button'),'label'=>'tombol']])

{!! $menu->blockRender() !!}
{{--
@include('dynamic.components.footers.footer',[
	'socmeds'=>[
		[
			'image'=>asset('images/material/icon-fb.svg'),
			'url'=>'https://www.facebook.com/WEBARQ/',
		],
		[
			'image'=>asset('images/material/icon-ig.svg'),
			'url'=>'https://www.instagram.com/webarq/?hl=en',
		]
	]
])
@include('dynamic.components.footers.footer-menu',[
	'socmeds'=>[
		[
			'image'=>asset('images/material/icon-fb.svg'),
			'url'=>'https://www.facebook.com/WEBARQ/',
		],
		[
			'image'=>asset('images/material/icon-ig.svg'),
			'url'=>'https://www.instagram.com/webarq/?hl=en',
		],
	],
	'email'=>'email@logocompany.com ',
	'phone'=>'021-2221 11122'
])

--}}

@include('dynamic.components.footers.footer-complex',[
	'socmeds'=>[
		[
			'image'=>asset('images/material/icon-fb.svg'),
			'url'=>'https://www.facebook.com/WEBARQ/',
		],
		[
			'image'=>asset('images/material/icon-ig.svg'),
			'url'=>'https://www.instagram.com/webarq/?hl=en',
		],
	],
	'address'=>'Menara Citicon, Jl. Letjen S. Parman No.Kav 72, 
	RT.4/RW.3, Slipi, Jakarta, Kota Jakarta Barat, 
	Daerah Khusus Ibukota Jakarta 11410',
	'email'=>'email@logocompany.com ',
	'phone'=>'021-2221 11122'
])

@endsection