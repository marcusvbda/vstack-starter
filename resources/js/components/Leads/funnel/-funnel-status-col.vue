<template>
    <div :class="`col col-status ${col_class}`">
        <div :class="`status-color-bgtop ${col} card col-header no-border d-flex flex-column py-2 mb-1`">
            <div class="p-2 col-header">
                <b :class="`d-flex flex-row align-items-center status-color ${col} justify-content-center mb-2 title`" @click="visible = !visible">
                    {{ col }} ({{ leads.total }})
                    <span :class="`status-color ${col} ${toggle_icon} ml-3`" />
                </b>
                <template v-if="visible">
                    <el-progress class="align-items-center justify-content-center d-flex" :percentage="percentage" :color="progress_color" />
                    <el-pagination
                        :disabled="leads.total <= 0"
                        class="align-items-center justify-content-center d-flex mt-2"
                        background
                        :page-size="Number(leads.per_page)"
                        small
                        :pager-count="5"
                        layout="prev, pager, next"
                        :total="Number(leads.total)"
                        @current-change="changePage"
                        :current-page="leads.current_page"
                    />
                </template>
            </div>
        </div>
        <transition name="slide">
            <div class="no-border list-content modern-scroll" v-if="visible" v-loading="loading">
                <lead-card v-for="(lead, i) in leads.data" :key="i" :lead="lead" />
            </div>
        </transition>
    </div>
</template>
<script>
export default {
    props: ['col'],
    data() {
        return {
            visible: false,
            progress_color: [
                { color: '#f56c6c', percentage: 20 },
                { color: '#e6a23c', percentage: 40 },
                { color: '#5cb87a', percentage: 60 },
                { color: '#1989fa', percentage: 80 },
                { color: '#6f7ad3', percentage: 100 },
            ],
            total: 0,
            leads: {
                data: [],
                current_page: 1,
                per_page: 0,
                total: 0,
            },
            loading: false,
        }
    },
    components: {
        'lead-card': require('./-lead-card.vue').default,
    },
    computed: {
        get_params() {
            return this.$store.state.get_params
        },
        percentage() {
            if (this.leads.total <= 0) return 0
            return Math.ceil((this.leads.total * 100) / this.total)
        },
        toggle_icon() {
            return this.visible ? 'el-icon-arrow-down' : 'el-icon-arrow-up'
        },
        col_class() {
            return `${!this.visible && 'hidding'}`
        },
    },
    created() {
        this.$nextTick(() => {
            this.getLeads(1)
        })
    },
    methods: {
        getLeads(page) {
            this.loading = true
            this.$http
                .post(`${window.location.pathname}/filter`, { ...{ status: this.col, page: page }, ...this.get_params }, { retries: 3 })
                .then(({ data }) => {
                    this.leads = data.leads
                    this.total = data.total
                    this.visible = true
                    this.loading = false
                })
        },
        changePage(page) {
            this.getLeads(page)
        },
    },
}
</script>