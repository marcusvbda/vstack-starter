<template>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<div class="d-flex flex-row align-items-center">
						<h5><span class="el-icon-trophy mr-2" />Funil de Conversão</h5>
						<a href="#" @click.prevent="toggleEditing(true)" class="ml-auto link" v-if="!editing">Editar</a>
					</div>
				</div>
				<div class="card-body">{{ editing }}</div>
			</div>
		</div>
	</div>
</template>
<script>
import funnelStore from '~/stores/campaign/funnel'
export default {
	props : ["campaign"],
	store : funnelStore,
	computed : {
		editing : {
			get() {
				return this.$store.state.editing	
			},
			set(val) {
				this.$store.commit('setEditing',val)
			}
		}
	},
	methods : {
		toggleEditing(val) {
			this.editing = val
		}
	}
}
</script>