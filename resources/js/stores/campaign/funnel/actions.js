import api from '~/config/libs/axios'
const route = `${window.location.pathname}/api`

export function updateSections({ commit, dispatch }, payback) {
	return api.post(`${route}/update_sections`, payback)
}