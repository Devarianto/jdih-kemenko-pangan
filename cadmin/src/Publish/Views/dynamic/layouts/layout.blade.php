<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
		{!! og::render() !!}
		@include('static.component.assets')
		@stack('head')
	</head>
	<body>
		{!! og::body() !!}

		@yield('content')

		@stack('footer')
	</body>
</html>
