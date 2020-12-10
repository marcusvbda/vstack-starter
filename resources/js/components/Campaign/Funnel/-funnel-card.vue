<template>
    <div :class="`funnel-col ${card_class}`" ref="element">
        <div :class="`funnel-card`">
            <template v-if="form.editing">
                <div class="funnel-card-header">
                    <div class="funnel-card-header-input">
                        <input class="form-control form-control-sm mt-2" v-model="form.title" placeholder="Digite o nome da lista ..." />
                    </div>
                </div>
                <div class="funnel-card-body d-flex flex-row align-items-center justify-content-end my-2">
                    <button @click="confirm" class="btn btn-success mr-3" v-if="form.title"><span class="el-icon-check" /></button>
                    <h4 @click="cancelEditing" class="ml-1 mb-0 pointer"><span class="el-icon-close" /></h4>
                </div>
            </template>
            <template v-else>
                <div class="funnel-card-header">
                    <b class="funnel-card-header-title" v-html="_title" @click="clickEvent" />
                </div>
            </template>
        </div>
    </div>
</template>
<script>
export default {
    props: ['title', 'new', 'index', 'sorting'],
    data() {
        return {
            form: {
                editing: false,
                title: null,
            },
        }
    },
    computed: {
        _title() {
            return !this.is_new ? this.title : '<span class="el-icon-plus mr-1"></span> Adicionar nova sessão'
        },
        is_new() {
            return this.new != undefined
        },
        card_class() {
            return `${this.is_new ? 'new' : ''}`
        },
    },
    methods: {
        confirm() {
            if (this.is_new) {
                this.$emit('new-section', this.form.title)
            } else {
                this.$emit('edit-section', this.form.title, this.index)
            }
            this.cancelEditing()
        },
        cancelEditing() {
            this.form.editing = false
        },
        clickEvent() {
            if (this.is_new) {
                this.form.title = null
                this.form.editing = true
            } else {
                this.form.title = this.title
                this.form.editing = true
            }
        },
    },
}
</script>
<style scoped lang="scss">
.funnel-col {
    &.dragging {
        visibility: hidden;
    }
    &.sortable-chosen {
        .funnel-card {
            border: 1px dashed rgb(76, 76, 174);
        }
    }
}
</style>