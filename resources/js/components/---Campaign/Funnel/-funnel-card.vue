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
                    <button class="drop-button" @click.prevent="destroy" v-if="!is_new"><span class="icon el-icon-error" /></button>
                </div>
                <div class="funnel-card-body d-flex flex-column m-2" v-if="!is_new">
                    <div class="d-flex flex-row">
                        <a class="f-12" href="#" @click.prevent="behavior_dialog = true">Adicionar Comportamento</a>
                    </div>
                </div>
            </template>
        </div>
        <el-dialog title="Adicionar Comportamento" :visible.sync="behavior_dialog" width="30%">
            <span>lorem ipsum</span>
            <span slot="footer" class="dialog-footer">
                <el-button @click="behavior_dialog = false">Cancel</el-button>
                <el-button type="primary" @click="behavior_dialog = false">Confirm</el-button>
            </span>
        </el-dialog>
    </div>
</template>
<script>
export default {
    props: ['section', 'new', 'index', 'seq'],
    data() {
        return {
            behavior_dialog: false,
            form: {
                editing: false,
                title: null,
            },
        }
    },
    computed: {
        _title() {
            return !this.is_new ? `${this.section.title}` : '<span class="el-icon-plus mr-1"></span> Adicionar nova sessão'
        },
        is_new() {
            return this.new != undefined
        },
        card_class() {
            return `${this.is_new ? 'new' : ''}`
        },
    },
    methods: {
        destroy() {
            this.$confirm('Deseja excluir esta sessão ?', 'Confirmação').then(() => {
                this.$emit('destroy-section', this.index)
            })
        },
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