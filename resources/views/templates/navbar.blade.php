<?php
$user = Auth::user();
function currentClass($routes)
{
    $routes = is_array($routes) ? $routes : [$routes];
    $class = "";
    $current = Request::server('REQUEST_URI');
    foreach($routes as $route)
    {
        $contain = strpos($route, "/*");
        if (!$contain) {
            if($current == $route) return "active";
        } else {
            $route = str_replace("/*", "", $route);
            if(strpos($current, $route) !== false) return "active";
        }
    }
    return "";
}
$user = Auth::user();
$is_super_admin = $user->isSuperAdmin();
$is_admin = $user->hasRole(["admin"]);
$is_admin_or_super_admin = $user->hasRole(["admin","super-admin"]);
$polo = $user->polo;
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light py-0">
	<a class="navbar-brand py-0" href="/admin">
		<text-logo size="30" />
	</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	  <span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item {{ currentClass(['/admin']) }}">
				<a class="nav-link" href="/admin"><i class="el-icon-data-line mr-2"></i>CRM Dashboard <span class="sr-only">(current)</span></a>
			</li>
			<li class="nav-item dropdown {{ currentClass(['/admin/leads/*','/admin/funil-de-conversao/*']) }}">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="el-icon-attract mr-2"></i>Oportunidades
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<a class="dropdown-item @if(!hasPermissionTo('viewlist-leads')) disabled @endif {{ currentClass(['/admin/leads/*'])  }}" href="/admin/leads" data-label="Base de Leads">Leads</a>
					<a class="dropdown-item @if(!hasPermissionTo('convertion-funnel')) disabled @endif {{ currentClass(['/admin/funil-de-conversao/*'])  }}" href="/admin/funil-de-conversao" data-label="Esteira de Produção">Funil de Conversão</a>
				</div>
			</li>
			<li class="nav-item dropdown {{ currentClass(['/admin/emails/*','/admin/campanhas/*','/admin/captacao/*','/admin/automacao/*']) }}">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="el-icon-s-flag mr-2"></i>Marketing
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<a class="dropdown-item @if(!hasPermissionTo('viewlist-email')) disabled @endif {{ currentClass(['/admin/emails/*'])  }}" href="/admin/emails" data-label="Pré-Definição de Emails">Emails</a>
					<a class="dropdown-item @if(!hasPermissionTo('viewlist-campaign')) disabled @endif {{ currentClass(['/admin/campanhas/*'])  }}" href="/admin/campanhas" data-label="Campanhas de Marketing">Campanhas</a>
					<a class="dropdown-item @if(!hasPermissionTo('viewlist-capture')) disabled @endif {{ currentClass(['/admin/captacao/*'])  }}" href="/admin/captacao" data-label="Captação de Leads">Captação</a>
					<a class="dropdown-item @if(!hasPermissionTo('viewlist-automation')) disabled @endif {{ currentClass(['/admin/automacao/*'])  }}" href="/admin/automacao" data-label="Automação de Campanha">Automação</a>
				</div>
			</li>
			<li class="nav-item dropdown {{ currentClass(['/admin/relatorios/*']) }}">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="el-icon-data-analysis mr-2"></i>Relatórios
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<a class="dropdown-item @if(!hasPermissionTo('conversion-report')) disabled @endif {{ currentClass(['/admin/relatorios/leads/*'])  }}" href="/admin/relatorios/leads" data-label="Relatório de Leads">Leads</a>
					<a class="dropdown-item @if(!hasPermissionTo('campaign-report')) disabled @endif {{ currentClass(['/admin/relatorios/campanhas/*'])  }}" href="/admin/relatorios/campanhas" data-label="Relatório de Campanhas">Campanha</a>
					<a class="dropdown-item @if(!hasPermissionTo('capture-report')) disabled @endif {{ currentClass(['/admin/relatorios/captacao/*'])  }}" href="/admin/relatorios/captacao" data-label="Relatório de Captação">Captação</a>
					<a class="dropdown-item @if(!hasPermissionTo('automation-report')) disabled @endif {{ currentClass(['/admin/relatorios/automacao/*'])  }}" href="/admin/relatorios/automacao" data-label="Relatório de Automação">Automação</a>
				</div>
			</li>
			<li class="nav-item dropdown {{ currentClass(['/admin/resposta-contatos/*','/admin/tipos-contato/*','/admin/respostas-contato/*','/admin/regra-classificacao/*','/admin/objecoes/*']) }}">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="el-icon-bangzhu mr-2"></i>Extras
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<a class="dropdown-item @if(!hasPermissionTo('viewlist-objections')) disabled @endif {{ currentClass(['/admin/objecoes/*'])  }}" href="/admin/objecoes" data-label="Objeções de respostas negativas">Objeções de Contato</a>
					<a class="dropdown-item @if(!hasPermissionTo('viewlist-contactype')) disabled @endif {{ currentClass(['/admin/tipos-contato/*'])  }}" href="/admin/tipos-contato" data-label="Formar que o lead foi contato">Tipos de Contato</a>
					<a class="dropdown-item @if(!hasPermissionTo('viewlist-leadanswer')) disabled @endif {{ currentClass(['/admin/respostas-contato/*'])  }}" href="/admin/respostas-contato" data-label="Contatos com Lead">Respostas de Contato</a>
					<a class="dropdown-item @if(!hasPermissionTo('config-rating-behavior')) disabled @endif {{ currentClass(['/admin/regra-classificacao/*'])  }}" href="/admin/regra-classificacao" data-label="Regra de Rating de Lead">Regra de Classificação</a>
				</div>
			</li>
		</ul>
		<select-polo polo_name="{{ $polo->name }}" user_id="{{ $user->id }}" :logged_id='@json($polo->id)'></select-polo>
		<notification-bell polo_id="{{ $polo->id }}" :active='@json(currentClass(['/admin/notificacoes/*']))'></notification-bell>
		<ul class="navbar-nav">
			<li class="nav-item dropdown hover-color ml-0">
				<a class="nav-link dropdown-toggle py-0 d-flex flex-row align-items-center" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<div class="d-flex flex-column mr-2">
						<b>{{ $user->name }}</b>
						<small class="f-12">{{ $user->email }}</small>
					</div>
				</a>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
					@if($is_super_admin)
						<a class="dropdown-item" href="/admin/permissoes">Permissões</a>
					@endif
					<a class="dropdown-item @if(!$is_admin_or_super_admin) disabled @endif" href="/admin/grupos-de-acesso">Grupos de Acesso</a>
					<a class="dropdown-item" href="/admin/usuarios/{{ $user->code }}/edit">
						<div class="d-flex justify-content-between">
							<span>Conta</span>
							<span class="badge badge-default ml-5 pt-1 px-2">ID.: {{ $user->code }}</span>
						</div>
					</a>
					<a class="dropdown-item @if(!$is_admin_or_super_admin) disabled @endif" href="/admin/usuarios">Usuários</a>
					<a class="dropdown-item @if(!$is_admin_or_super_admin) disabled @endif" href="/admin/polos">Polos</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="/login">Sair</a>
				</div>
			</li>
		</ul>	
	</div>
</nav>