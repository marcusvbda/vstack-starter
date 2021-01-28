export function setGetParams(state, payload) {
	state.get_params = payload
}

export function setPermissions(state, payload) {
	state.permissions = payload
}

export function setTotal(state, payload) {
	state.total = payload
}

export function setStatusQty(state, payload) {
	state.status_qty = { ...state.status_qty, ...payload }
}

export function setStatusLeads(state, payload) {
	state.status_leads = { ...state.status_leads, ...payload }
}

export function setResourceId(state, payload) {
	state.resource_id = payload
}