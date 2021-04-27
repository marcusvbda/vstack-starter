<template>
    <div>
        <div class="row mb-3 mt-2">
            <div class="col-12 d-flex flex-row align-items-center">
                <h4 class="mb-1">
                    <span :class="`${resources.leads.icon} mr-2`"></span> Leads da Campanha <b>{{ campaign.name }}</b>
                </h4>
            </div>
        </div>
        <div v-loading="loading_list" class="row">
            <div class="col-md-4 col-sm-12 mb-3" v-for="(lead, l) in list.data" :key="l">
                <lead-card class="mb-2 h-100" :lead_id="lead.id" />
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            loading_list: true,
            current_page: 1,
        }
    },
    components: {
        'lead-card': require('../../../Leads/-lead-card.vue').default,
    },
    computed: {
        campaign() {
            return this.$store.state.campaign
        },
        resources() {
            return this.$store.state.resources
        },
        list() {
            return this.$store.state.list
        },
    },
    created() {
        this.updateList()
    },
    methods: {
        updateList() {
            this.$store.dispatch('getListData', {
                page: this.current_page,
                callback: () => {
                    this.loading_list = false
                },
            })
        },
    },
}
</script>