<template>
    <div class="d-flex flex-column">
        <div class="col-md-7 col-sm-12 px-0">
            <el-select v-model="selected_status" multiple placeholder="Selecione os status que deseja visualizar" class="w-100">
                <el-option v-for="key in Object.keys(status)" :key="key" :label="status[key]" :value="key" />
            </el-select>
        </div>
        <div class="funnel-section modern-scroll">
            <funnel-status-col :col="col" v-for="(col, i) in filtered_status" :key="i" />
        </div>
    </div>
</template>
<script>
import funnelStore from '~/stores/funnel'

export default {
    props: ['status', 'get_params', 'can_edit'],
    store: funnelStore,
    data() {
        return {
            selected_status: [],
        }
    },
    computed: {
        permissions() {
            return this.$store.permissions
        },
    },
    created() {
        this.$store.commit('setPermissions', { ...this.permissions, ...{ can_edit: this.can_edit } })
        this.$store.commit('setGetParams', this.get_params)
        this.$nextTick(() => {
            this.selected_status = Object.keys(this.status)
                .filter((x) => !['_CUSTOMER_', '_UNQUALIFIED_'].includes(x))
                .map((x) => x)
        })
    },
    components: {
        'funnel-status-col': require('./-funnel-status-col.vue').default,
    },
    computed: {
        filtered_status() {
            let _status = Object.assign({}, this.status)
            let not_selected_status = Object.keys(this.status).filter((key) => !this.selected_status.includes(key))
            not_selected_status.forEach((key) => {
                delete _status[key]
            })
            return _status
        },
    },
}
</script>
<style lang="scss">
@import 'styles.scss';
</style>