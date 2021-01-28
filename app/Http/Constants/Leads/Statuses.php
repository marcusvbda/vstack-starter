<?php

namespace App\Http\Constants\Leads;

use marcusvbda\vstack\Constants;

class Statuses extends Constants
{
	const _UNQUALIFIED_ = 'Não Qualificado';
	const _WAITING_ = 'Aguardando';
	const _OPPORTUNITY_ = 'Oportunidade';
	const _PROBABLY_QUALIFIED_ = 'Provável Qualificação';
	const _QUALIFIED_ = 'Qualificado';
	const _CUSTOMER_ = 'Convertido';
}