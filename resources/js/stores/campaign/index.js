import state from './state'
import * as mutations from './mutations'
import * as actions from './actions'
import * as getters from './getters'
import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default function () {
	return new Vuex.Store({
		mutations,
		actions,
		getters,
		state
	})
}
