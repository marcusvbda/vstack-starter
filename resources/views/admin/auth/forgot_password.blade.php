@extends("templates.default")
@section('title',"Esqueci a senha")
@section('body')
	<forget-password 
		app_name="{{ config('app.name') }}"
	>
	</forget-password>
@endsection