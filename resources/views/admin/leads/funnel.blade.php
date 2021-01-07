@extends("templates.admin")
@section('title',"Funil de Conversão")

@section('breadcrumb')
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
		  <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
		  <li class="breadcrumb-item">Converter</li>
		  <li class="breadcrumb-item active" aria-current="page"><a href="/admin/leads/funil-de-conversao">Funil de Conversão de Leads</a></li>
		</ol>
	</nav>
@endsection
<?php 
    $model_count = $resource->model->count();
	$filters = $resource->filters();
	$report_mode = false;
    $globalFilterData = [
        "filter_route" => request()->url(),
        "query" => request()->query(),
        "value" => @$_GET["_"] ? $_GET["_"] : ""
    ];
?>
@section('content')
<div class="row mb-3 mt-2">
    <div class="col-12 d-flex flex-row align-items-center">
        <h4 class="mb-1">
			<span class='el-icon-magic-stick mr-2 mr-2'></span>Funil de Conversão de Lead
			<small class="ml-3 text-muted">Esteira de Produção</small>
		</h4>
    </div>
</div>
<div class="row d-flex align-items-end mb-2">
    <div class="col-12 d-flex align-items-end justify-content-between">
		<resource-filter-tags 
			ref="tags_filter" 
			:resource_filters="{{json_encode($filters)}}" 
			:get_params="{{json_encode($_GET)}}"
		>
		</resource-filter-tags>
		<div class="d-flex flex-row align-items-center">
            @include("vStack::resources.partials._filter_btn")
            @if($resource->search())
				<resource-filter-global 
					class="ml-2" 
					:data='@json($globalFilterData)'
				>
				</resource-filter-global>
            @endif
        </div>
    </div>
</div>

<funnel-section :status='@json($status)'></funnel-section>
@endsection
