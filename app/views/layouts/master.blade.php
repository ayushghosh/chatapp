<!doctype html>
<html lang="en">
	<head>
		<title>{{ $title }}</title>
		{{ HTML::style('/css/bootstrap.min.css') }}

		{{ HTML::style('/css/master.css') }}
	</head>
	
	<body>
		<div class="pageContainer">
			@section('header')
			<div class="header">
				@section('header__menuToggle')
					<div class="header__menuToggle"><i class="glyphicon glyphicon-tasks">&nbsp;</i></div>
				@show	
					<div class="header__appName">ChatApp</div>
				</div>
			@show
			<div class="content container">
				@section('content')

				@show
			</div>
			@section('footer')
			<div class="footer">
				
			</div>
			@show
		</div>
		@section('outView')

		@show
		@section('inlineJS')
		{{ HTML::script('js/jquery-2.1.1.min.js') }}
		
		@show
	</body>
</html>