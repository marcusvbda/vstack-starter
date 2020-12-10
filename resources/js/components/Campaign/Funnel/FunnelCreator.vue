<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><span class="el-icon-trophy mr-2" />Funil de Conversão</h5>
                </div>
                <div class="card-body">
                    <div class="funnel-row editing">
                        <draggable v-model="sections" ghost-class="dragging" @start="sorting = true" @end="sorting = false" class="d-flex flex-row">
                            <funnel-card v-for="(s, i) in sections" :key="i" :title="s.title" :index="i" @edit-section="editSection" :sorting="sorting" />
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
    data() {
        return {
            sorting: false,
            sections: [{ title: 'teste a' }, { title: 'teste b' }],
        }
    },
    components: {
        'funnel-card': require('./-funnel-card.vue').default,
        draggable,
    },
    computed: {
        // editing: {
        //     get() {
        //         return this.$store.state.editing
        //     },
        //     set(val) {
        //         this.$store.commit('setEditing', val)
        //     },
        // },
    },
    methods: {
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