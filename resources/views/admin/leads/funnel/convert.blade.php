@extends("templates.admin")
@section('title',"Conversão do Lead #".$lead->code)

@section('breadcrumb')
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
		  <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
		  <li class="breadcrumb-item">Converter</li>
		  <li class="breadcrumb-item"><a href="/admin/funil-de-conversao">Funil de Conversão de Leads</a></li>
		  <li class="breadcrumb-item active" aria-current="page"><a href="/admin/funil-de-conversao/{{ $lead->code }}/converter">Conversão do Lead #{{ $lead->code }}</a></li>
		</ol>
	</nav>
@endsection 
@section('content')
<convert-lead
	:lead='@json($lead)'
	:use_tags='@json($resource->useTags())'
	resource_id="{{ $resource->id }}"
	:types='@json($types)'
	:answers='@json($answers)'
	:objections='@json($objections)'	
>
</convert-lead>
@endsection
