export function getQueryFilters(state) {
	return state.campaign.processed_filters ? state.campaign.processed_filters : {}
}