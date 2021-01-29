<template>
    <div class="mb-4 info-obs">
        <div class="row mb-4" v-if="is_not_qualified">
            <div class="col-12">
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">{{ lead.f_status }}</h4>
                    <p>
                        {{ lead.objection }}
                        {{ lead.other_objection }}
                    </p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-7 col-sm-12">
                <el-tabs type="border-card">
                    <el-tab-pane label="Contatos Anteriores">
                        <el-timeline class="pt-3" v-if="lead.tries.length > 0">
                            <el-timeline-item v-for="(t, i) in lead.tries" :key="i" :timestamp="`${t.date} - ${t.timestamp}`">
                                <p class="f-12 text-muted">
                                    <p class="mr-1 mb-0" v-if="t.type">Tipo : <b v-html="t.type" /></p>
                                    <p class="mr-1 mb-0" v-if="t.obs">Observações : <b v-html="t.obs" /></p>
                                    <p class="mr-1 mb-0" v-if="t.comment">Comentário : <b v-html="t.comment" /></p>
                                    <p class="mr-1 mb-0" v-if="t.objection">
										Objeção : <b v-html="t.objection" /><span class="ml-1" v-if="t.other_objection" v-html="t.other_objection"/>
									</p>
                                </p>
                            </el-timeline-item>
                        </el-timeline>
                        <div class="text-muted text-center f-12" v-else>Nenhuma contato anterior</div>
                    </el-tab-pane>
                    <el-tab-pane label="Conversões Anteriores">
                        <el-timeline class="pt-3" v-if="lead.conversions.length > 0">
                            <el-timeline-item v-for="(conversion, i) in lead.conversions" :key="i" :timestamp="`${conversion.date} - ${conversion.timestamp}`">
                                <p class="mb-0" v-html="conversion.desc" />
                                <p class="mb-0" v-html="conversion.obs" />
                                <p class="f-12 text-muted" v-if="conversion.user">
                                    <span class="mr-1">Por : <b v-html="conversion.user" /></span>
                                </p>
                            </el-timeline-item>
                        </el-timeline>
                        <div class="text-muted text-center f-12" v-else>Nenhuma conversão anterior</div>
                    </el-tab-pane>
					<el-tab-pane label="Lead Completo (Webhook)" v-if="lead.lead_api">
						 <pre>{{ lead.lead_api | pretty }}</pre>
                    </el-tab-pane>
                </el-tabs>
            </div>
            <div class="col-md-5 col-sm-12 bg-light d-flex flex-column py-3">
                <div class="d-flex flex-row align-items-center mb-3 f-12">
                    <b class="mr-1">Observações :</b>
                    <span v-html="lead.obs" />
                    <a href="#" class="ml-3" @click.prevent="edit('obs')">
                        <i class="el-icon-edit" />
                    </a>
                </div>
                <div class="d-flex flex-row align-items-center f-12">
                    <b class="mr-1">Comentários :</b>
                    <span v-html="lead.comment" />
                    <a href="#" class="ml-3" @click.prevent="edit('comment')">
                        <i class="el-icon-edit" />
                    </a>
                </div>
                <el-dialog :title="editing_form.title" :visible.sync="dialogVisible" width="40%">
                    <textarea class="form-control" v-model="editing_form.value" rows="8" />
                    <span slot="footer" class="dialog-footer">
                        <el-button @click="dialogVisible = false">Cancelar</el-button>
                        <el-button type="primary" @click="confirm">Confirmar</el-button>
                    </span>
                </el-dialog>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            dialogVisible: false,
            editing_form: {
                field: null,
                title: null,
                value: null,
            },
        }
    },
    computed: {
        lead() {
            return this.$store.state.lead
        },
        is_not_qualified() {
            return this.lead.status == '_UNQUALIFIED_'
        },
    },
    methods: {
        edit(field) {
            this.editing_form.field = field
            this.editing_form.title = field == 'comment' ? 'Comentários' : 'Observações'
            this.editing_form.value = this.lead[field]
            this.dialogVisible = true
        },
        confirm() {
            this.lead[this.editing_form.field] = this.editing_form.value
            this.dialogVisible = false
        },
    },
}
</script>
<style lang="scss">
.info-obs {
    .el-tabs__content {
        height: 300px;
        min-height: 300px;
        max-height: 300px;
        overflow-y: auto;
    }
}
</style>