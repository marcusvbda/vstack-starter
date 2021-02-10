@extends("templates.admin")
@if(@$email->id)
	@section('title',"Edição de Email #".$email->code)
@else
	@section('title',"Cadastro de grupo de acesso")
@endif

@section('breadcrumb')
<div class="row">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin" class="link">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="/admin/emails" class="link">Emails</a></li>
                    @if(@$email->id)
						<li class="breadcrumb-item"><a href="/admin/emails/{{ $email->code }}/edit" class="link">Edição de Email #{{ $email->code }}</a></li>
					@else
						<li class="breadcrumb-item"><a href="/admin/emails/create" class="link">Cadastro de Emails</a></li>
					@endif
                </ol>
            </nav>
        </nav>
    </div>
</div>
@endsection
@section("content")
<crud-emails 
	:email='@json(@$email)'
>
</crud-emails>
@endsection