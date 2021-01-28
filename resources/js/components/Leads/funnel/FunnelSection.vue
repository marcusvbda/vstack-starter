<template>
    <div class="d-flex flex-column">
        <div class="col-md-7 col-sm-12 px-0">
            <label> Total de Leads : <counter-number :start="0" :end="total" :times="10" :speed="50" /> </label>
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
    props: ['status', 'get_params', 'can_edit', 'use_tags', 'resource_id'],
    store: funnelStore,
    components: {
        'counter-number': require('vue-number-scroll').default,
        'funnel-status-col': require('./-funnel-status-col.vue').default,
    },
    data() {
        return {
            selected_status: [],
        }
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
        permissions() {
            return this.$store.permissions
        },
        total() {
            return this.$store.state.total
        },
        status_qty() {
            return this.$store.state.status_qty
        },
    },
    created() {
        this.$store.commit('setPermissions', { can_edit: this.can_edit, use_tags: this.use_tags })
        this.$store.commit('setResourceId', this.resource_id)
        this.$store.commit('setGetParams', this.get_params)
        this.$nextTick(() => {
            this.selected_status = Object.keys(this.status)
                .filter((x) => !['_CUSTOMER_', '_QUALIFIED_', '_UNQUALIFIED_'].includes(x))
                .map((x) => x)
        })
    },
}
</script>
<style lang="scss">
.funnel-section {
    margin-top: 20px;
    display: flex;
    flex-direction: row;
    max-width: 100%;
    overflow-x: auto;

    .no-border {
        border-radius: 0;
    }

    .col {
        &.col-status {
            min-width: 350px;
            padding: 0;
            margin-top: 10px;
            margin-bottom: 10px;

            &.hidding {
                max-width: 100px !important;
                opacity: 0.5;
                font-size: 12px;
            }

            .col-header {
                .title {
                    cursor: pointer;
                    transform: scale(0.95);
                    transition: 0.3s;
                    &:hover {
                        transform: scale(1);
                    }
                }
            }

            .list-content {
                min-height: 550px;
                max-height: 550px;
                overflow-y: auto;

                .lead-card {
                    padding: 10px;
                    font-size: 12px;
                }
            }
        }
    }

    .extra-mini-tags {
        margin-top: 5px !important;
        margin-bottom: 5px !important;
        .resource-tag {
            font-size: 10px;
        }
    }
}
</style>