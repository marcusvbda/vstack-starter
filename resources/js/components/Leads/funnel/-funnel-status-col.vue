<template>
    <div :class="`col col-status ${col_class}`">
        <div :class="`status-color-bgtop ${col} card col-header no-border d-flex flex-column py-2 mb-1`">
            <div class="p-2 col-header">
                <b :class="`d-flex flex-row align-items-center status-color ${col} justify-content-center mb-2 title`" @click="visible = !visible">
                    {{ col }} (52)
                    <span :class="`status-color ${col} ${toggle_icon} ml-3`" />
                </b>
                <template v-if="visible">
                    <el-progress class="align-items-center justify-content-center d-flex" :percentage="percentage" :color="progress_color" />
                    <el-pagination
                        class="align-items-center justify-content-center d-flex mt-2"
                        background
                        :page-size="20"
                        small
                        :pager-count="5"
                        layout="prev, pager, next"
                        :total="1000"
                        @current-change="changePage"
                        :current-page="page"
                    />
                </template>
            </div>
        </div>
        <transition name="slide">
            <div class="no-border list-content modern-scroll" v-if="visible">
                <lead-card v-for="i in 30" :key="i" />
            </div>
        </transition>
    </div>
</template>
<script>
import LeadCard from './-lead-card.vue'
export default {
    props: ['col'],
    data() {
        return {
            visible: true,
            progress_color: [
                { color: '#f56c6c', percentage: 20 },
                { color: '#e6a23c', percentage: 40 },
                { color: '#5cb87a', percentage: 60 },
                { color: '#1989fa', percentage: 80 },
                { color: '#6f7ad3', percentage: 100 },
            ],
            page: 1,
        }
    },
    components: {
        'lead-card': require('./-lead-card.vue').default,
    },
    computed: {
        percentage() {
            return Math.floor(Math.random() * (100 - 5 + 1) + 5)
        },
        toggle_icon() {
            return this.visible ? 'el-icon-arrow-down' : 'el-icon-arrow-up'
        },
        col_class() {
            return `${!this.visible && 'hidding'}`
        },
    },
    methods: {
        changePage(page) {
            console.log(page)
            this.page = page
        },
    },
}
</script>