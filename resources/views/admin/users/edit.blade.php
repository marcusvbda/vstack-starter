@extends("templates.admin")
@section('title',"Profile")
@section("breadcrumb")
<div class="row">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin" class="link">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="/admin/usuarios" class="link">Usuários</a></li>
                    <li class="breadcrumb-item">
                        <a href="/admin/usuarios/{{$user->code}}/edit" class="link">Edição do Usuário
                           <b>{{$user->name}}</b>
                        </a>
                    </li>
                </ol>
            </nav>
        </nav>
    </div>
</div>
@endsection
@section("content")
<div class="row">
    <div class="col-12">
        <div class="d-flex flex-row justify-content-between mb-3">
            <h4>@if( @$resource->icon() ) <span class="{{$resource->icon()}} mr-2"></span> @endif  Usuário {{$user->name}}</h4>
        </div>
    </div>
</div>
<user-profile 
	:user='@json($user)'
	:logged='@json(Auth::user())'
>
</user-profile >
@endsection