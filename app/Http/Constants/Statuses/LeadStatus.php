<?php

namespace App\Http\Constants\Statuses;

use marcusvbda\vstack\Constants;

class LeadStatus extends Constants
{
	const _UNQUALIFIED_ = 'Não Qualificado';
	const _OPPORTUNITY_ = 'Oportunidade';
	const _WAITING_ = 'Aguardando';
	const _PROBABLY_QUALIFIED_ = 'Provavel Qualificação';
	const _QUALIFIED_ = 'Qualificado';
	const _CUSTOMER_ = 'Convertido';
}