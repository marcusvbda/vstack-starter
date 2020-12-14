export function setCampaign(state, payload) {
	state.campaign = payload
}

export function setSections(state, payload) {
	state.campaign.data.sections = payload
}