@extends("templates.default")
@section('title',"Renovação de Senha")
@section('body')
	<renew-password
		token="{{ $token }}"
		app_name="{{ config('app.name') }}"
	>
	</renew-password>
@endsection