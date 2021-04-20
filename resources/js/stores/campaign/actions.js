import api from '~/config/libs/axios'

export function getListData({ commit }, payload = {}) {
	api.post(`${window.location.pathname}/list`, { page: (payload.page ? payload.page : 1) }, { retries: 3 })
		.then(({ data }) => {
			commit("setList", data)
			if (payload.callback) {
				payload.callback()
			}
		})
}