import Vue from 'vue'
import Vuex from 'vuex'

import dashboard from './dashboard'

Vue.use(Vuex)

export default function () {
	const Store = new Vuex.Store({
		modules: {
			dashboard,
		},
	})

	return Store
}
