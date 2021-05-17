<template>
    <div :class="`col col-status ${col_class}`">
        <div :class="`status-color-bgtop ${status.name} card col-header no-border d-flex flex-column py-2 mb-1`" v-loading="loading">
            <div class="p-2 col-header">
                <b :class="`d-flex flex-row align-items-center status-color ${status.name} justify-content-center mb-2 title`" @click="visible = !visible">
                    {{ status.name }} {{ animated_showing_total }}
                    <span :class="`status-color ${status.name} ${toggle_icon} ml-3`" />
                </b>
                <template v-if="visible">
                    <el-progress class="align-items-center justify-content-center d-flex" :percentage="percentage" :color="progress_color" />
                    <el-pagination
                        :disabled="qty <= 0"
                        class="align-items-center justify-content-center d-flex mt-2"
                        background
                        :page-size="Number(leads.per_page)"
                        small
                        :pager-count="5"
                        layout="prev, pager, next"
                        :total="Number(qty)"
                        @current-change="changePage"
                        :current-page="leads.current_page"
                    />
                </template>
            </div>
        </div>
        <transition name="slide">
            <div class="no-border list-content modern-scroll" v-if="visible">
                <template v-if="!loading">
                    <lead-card v-for="(lead, i) in leads.data" :key="i" :lead_id="lead.id" />
                </template>
            </div>
        </transition>
    </div>
</template>
<script>
export default {
    props: ['status'],
    data() {
        return {
            visible: false,
            loading: false,
            showing_total: 0,
        }
    },
    watch: {
        qty(newValue) {
            console.log(newValue)
            this.$gsap.to(this.$data, { duration: 0.5, showing_total: newValue })
        },
    },
    components: {
        'lead-card': require('../../Leads/-lead-card.vue').default,
    },
    computed: {
        animated_showing_total() {
            return this.showing_total.toFixed(0)
        },
        leads() {
            return this.$store.state.status_leads[this.status.id]
        },
        progress_color() {
            return this.$store.state.progress_color
        },
        qty() {
            return this.$store.state.status_qty[this.status.id] ? this.$store.state.status_qty[this.status.id] : 0
        },
        total() {
            return this.$store.state.total
        },
        status_qty() {
            return this.$store.state.status_qty
        },
        percentage() {
            if (this.qty <= 0) return 0
            return Math.ceil((this.qty * 100) / this.total)
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
            this.loading = true
            this.$store.dispatch('getStatusLeads', {
                status: this.status.id,
                page,
                callback: () => {
                    this.visible = true
                    this.loading = false
                },
            })
        },
        changePage(page) {
            this.getLeads(page)
        },
    },
}
</script>