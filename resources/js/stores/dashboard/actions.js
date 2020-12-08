import api from "../../config/libs/axios"
import Message from 'element-ui/lib/message'

// var attempts = 0
// export function showError({ state }, error = "") {
// 	Message.error({
// 		showClose: true,
// 		duration: 5000,
// 		dangerouslyUseHTMLString: true,
// 		message: error,
// 	})
// }

// export function getPolos({ commit, dispatch }, user_id) {
// 	attempts++
// 	return api.post(`${window.location.pathname}/polos`, { user_id }).then(({ data }) => {
// 		commit("setPolos", data)
// 		attempts = 0
// 	}).catch(er => {
// 		if (attempts <= 3) return dispatch('getPolos')
// 		console.log(er)
// 		attempts = 0
// 	})
// }


// export function getDateRanges({ state, commit, dispatch }) {
// 	attempts++
// 	return api.post(`${window.location.pathname}/dates/get-ranges`).then(({ data }) => {
// 		commit("setDateRanges", data)
// 		commit('setDateRange', data[state.predefined_filter])
// 		attempts = 0
// 	}).catch(er => {
// 		if (attempts <= 3) return dispatch('getDateRanges')
// 		console.log(er)
// 		attempts = 0
// 	})
// }

