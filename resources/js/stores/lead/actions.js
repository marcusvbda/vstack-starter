// import api from '~/config/libs/axios'

// export function getStatusLeads({ state, commit }, { page, status, callback }) {
// 	let get_params = state.get_params
// 	api.post(`${window.location.pathname}/filter`, {
// 		...{ status: status, page: page },
// 		...get_params
// 	}, { retries: 3 })
// 		.then(({ data }) => {
// 			let leads = {}
// 			leads[status] = data.leads
// 			commit('setStatusLeads', leads)
// 			commit('setTotal', data.total)
// 			let qty = {}
// 			qty[status] = data.leads.total
// 			commit('setStatusQty', qty)
// 			if (callback) callback()
// 		})
// }