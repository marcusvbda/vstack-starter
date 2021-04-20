<template>
    <div>
        <resource-filter-tags ref="tags_filter" :resource_filters="resource_filters" :get_params="query_filters" prevent_close />
        <router-view />
    </div>
</template>
<script>
import Vue from 'vue'
import VueRouter from 'vue-router'
import campaignStore from '~/stores/campaign'
Vue.use(VueRouter)
export default {
    props: ['campaign', 'resources', 'resource_filters'],
    router: new VueRouter({
        routes: [{ path: '/', name: 'list', component: require('./pages/list/-index.vue').default }],
    }),
    store: campaignStore,
    created() {
        this.$store.commit('setResources', this.resources)
        this.$store.commit('setCampaign', this.campaign)
    },
    computed: {
        query_filters() {
            return this.$store.getters.getQueryFilters
        },
    },
}
</script>