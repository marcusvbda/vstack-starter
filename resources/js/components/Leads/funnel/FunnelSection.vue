<template>
    <div class="mt-3">
        <el-switch v-model="show_finished" active-text="Também mostrar os leads finalizados" />
        <div class="funnel-section modern-scroll">
            <funnel-status-col :col="col" v-for="(col, i) in filtered_status" :key="i" />
        </div>
    </div>
</template>
<script>
export default {
    props: ['status'],
    data() {
        return {
            show_finished: false,
        }
    },
    components: {
        'funnel-status-col': require('./-funnel-status-col.vue').default,
    },
    computed: {
        filtered_status() {
            if (this.show_finished) return this.status
            let _status = Object.assign({}, this.status)
            delete _status['_CUSTOMER_']
            delete _status['_UNQUALIFIED_']
            return _status
        },
    },
}
</script>
<style lang="scss">
@import 'styles.scss';
</style>