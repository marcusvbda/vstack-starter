<template>
    <div>
        <div class="row mb-3 mt-2">
            <div class="col-12 d-flex flex-row align-items-center">
                <h4 class="mb-1">
                    <span :class="`${resources.leads.icon} mr-2`"></span> Leads da Campanha <b>{{ campaign.name }}</b>
                </h4>
            </div>
        </div>
        <div v-loading="loading_list">
            {{ list }}
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