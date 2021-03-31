@extends("templates.default")
@section('title',"Login")
@section('body')
	<auth-login 
		app_name="{{ config('app.name') }}"
	>
	</auth-login>
@endsection