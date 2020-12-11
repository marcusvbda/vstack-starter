<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><span class="el-icon-trophy mr-2" />Funil de Conversão</h5>
                </div>
                <div class="card-body">
                    <div class="funnel-row editing">
                        <draggable v-model="sections" class="d-flex flex-row">
                            <funnel-card v-for="(s, i) in sections" :key="i" :title="s.title" :index="i" @edit-section="editSection" :seq="getSeq(s, i)" />
                        </draggable>
                        <funnel-card new @new-section="newSection" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import funnelStore from '~/stores/campaign/funnel'
import draggable from 'vuedraggable'

export default {
    props: ['campaign'],
    store: funnelStore,
    computed: {
        sections: {
            set(val) {
                return this.$store.commit('setSections', val)
            },
            get() {
                return this.$store.state.sections
            },
        },
    },
    components: {
        'funnel-card': require('./-funnel-card.vue').default,
        draggable,
    },
    methods: {
        getSeq(s, index) {
            s.seq = index
            return index
        },
        toggleEditing(val) {
            this.editing = val
        },
        newSection(title) {
            this.sections.push({ title })
        },
        editSection(title, index) {
            this.sections[index].title = title
        },
    },
}
</script>
<style lang="scss">
@import './styles.scss';
</style>