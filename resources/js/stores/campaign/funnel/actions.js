// import api from 'axios'
// const axiosRetry = require('axios-retry')
// axiosRetry(api, {
// 	retries: 3,
// 	shouldResetTimeout: true,
// 	retryCondition: (_error) => true
// })
// import Message from 'element-ui/lib/message'

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
// 	}).catch(er => {
// 		console.log(er)
// 	})
// }


// export function getDateRanges({ state, commit, dispatch }) {
// 	return api.post(`${window.location.pathname}/dates/get-ranges`).then(({ data }) => {
// 		commit("setDateRanges", data)
// 		commit('setDateRange', data[state.predefined_filter])
// 	}).catch(er => {
// 		console.log(er)
// 	})
// }

