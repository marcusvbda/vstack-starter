<template>
	<h1>Aqui vou criar o funil da campanha {{campaign.id}}</h1>
</template>
<script>
import funnelStore from '../../../stores/campaign/funnel'
export default {
	props : ["campaign"],
	store : funnelStore
}
</script>