<!DOCTYPE html>
<html lang="en">
<head>
	
	<meta charset="UTF-8">

	<title>@yield('title', 'Home') | Blog Facilito</title>
	<link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/journjal/bootstrap.css') }}">
	<link rel="stylesheet" href="{{ asset('css/general.css')}}">
	<link rel="stylesheet" href="{{ asset('plugins/font-awesome-4.6.3/css/font-awesome.min.css') }}">
</head>
<body>

	<header>
		@include('front.template.partials.header')
	</header>

	<div class="container">
		@yield('content')
	
		<footer>
			<hr>
			Todos los derechos reservados &copy {{ date('Y')}}
		</footer>

	</div>
	
	<script src="{{ asset('plugins/jquery/js/jquery-3.1.0.js') }}"> </script>
</body>
</html>