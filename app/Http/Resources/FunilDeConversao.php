<?php

namespace App\Http\Resources;

class FunilDeConversao extends Leads
{
	public function canCreate()
	{
		return false;
	}

	public function viewListBlade()
	{
		return "admin.leads.funnel";
	}
}