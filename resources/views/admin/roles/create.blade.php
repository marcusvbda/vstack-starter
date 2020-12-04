@extends("templates.admin")
@section('title',"Cadastro de grupo de acesso")
@section('breadcrumb')
<div class="row">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin" class="link">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="/admin/grupos-de-acesso" class="link">Grupos de Acesso</a></li>
                    <li class="breadcrumb-item"><a href="/admin/grupos-de-acesso/create" class="link">Cadastro de Grupo de Acesso</a></li>
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
            <h4>@if( @$resource->icon() ) <span class="{{$resource->icon()}} mr-2"></span> @endif Cadastro de {{$resource->singularLabel()}}</h4>
        </div>
    </div>
</div>
<roles-crud 
    :permissions_groups="{{json_encode($permissions)}}">
</roles-crud>
@endsection