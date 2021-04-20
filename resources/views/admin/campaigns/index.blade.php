@extends("templates.admin")
@section('title',"Dashboard")

@section('breadcrumb')
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
		  <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
		  <li class="breadcrumb-item" aria-current="page">Mostradores e Desempenho</li>
		  <li class="breadcrumb-item"><a href="/admin/campanhas">Campanhas</a></li>
		  <li class="breadcrumb-item active"><a href="/admin/campanhas/{{ $campaign->code }}/leads"> Leads da campanha <b> {{ $campaign->name }}</b></a></li>
		</ol>
	</nav>
@endsection
@section('content')
<campaign-page
	:campaign='@json($campaign)'
	:resources='@json($resources)'
	:resource_filters='@json($resource_filters)'
></campaign-page>
@endsection
