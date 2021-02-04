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
                    <el-tab-pane label="Contatos">
                        <el-timeline class="pt-3">
							<el-timeline-item>
                                <p class="f-12 text-muted">
                                    <a href="#" @click.prevent="addContact" class="link"><span class="el-icon-circle-plus mr-1" />Novo Contato</a>
                                </p>
                            </el-timeline-item>
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
						 <pre>{{ lead.lead_api || pretty }}</pre>
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
				
				<el-dialog title="Novo Contato" :visible.sync="form_new_contact.visible" width="85%" :close-on-click-modal="false" :top="10">
                    <el-steps :active="form_new_contact.step" align-center finish-status="success" :space="500">
						<el-step title="Step 1" description="Defina o tipo do contato"/>
						<el-step title="Step 2" description="Resposta do contato"/>
						<el-step title="Step 3" description="Objeção do contato"/>
						<el-step title="Step 4" description="Dados para retorno"/>
						<el-step title="Step 5" description="Conclusão do Contato"/>
					</el-steps>
					<div class="d-flex flex-column my-4">
						<template v-if="form_new_contact.step == 0">
							<label>Selecione o tipo de contato</label>
							<el-select
								v-model="form_new_contact.type"
								filterable
								placeholder="Selecione o tipo de contato"
							>
								<el-option label="Via Ligação Telefonica" value="phone" />
								<el-option label="Via Mensagem SMS" value="sms" />
								<el-option label="Via Mensagem Whatsapp" value="wpp" />
								<el-option label="Via Mensagem Telegram" value="wpp" />
								<el-option label="Via Email" value="email" />
							</el-select>
							<small class="text-muted">Selecione o meio que o operador utilizará para efetuar o contato com o lead</small>
							<hr>
							<span slot="footer" class="dialog-footer d-flex justify-content-end">
								<el-button type="primary" @click="finishStepOne">
									Avançar<span class="el-icon-right ml-2" />
								</el-button>
							</span>
						</template>
						<template v-if="form_new_contact.step == 1">
							<label>Informe a resposta do contato</label>
							<el-select v-model="form_new_contact.answer" placeholder="Informe a resposta do contato">
								<el-option-group label="Resposta Neutra">
									<el-option label="Sem Contato (Reagendar Retorno)" value="no_answer" />
								</el-option-group>
								<el-option-group label="Resposta Negativa">
									<el-option label="Sem Interesse" value="no_interest" />
								</el-option-group>
								<el-option-group label="Resposta Positiva">
									<el-option label="Tem Interesse" value="has_interest" />
								</el-option-group>
							</el-select>
							<small class="text-muted">Selecione a resposta do contato referente a proposta realizada</small>
							<hr>
							<span slot="footer" class="dialog-footer d-flex justify-content-end">
								<el-button @click="form_new_contact.step = 0">
									<span class="el-icon-back mr-2" />Voltar
								</el-button>
								<el-button type="primary" @click="finishStepTwo">
									Avançar<span class="el-icon-right ml-2" />
								</el-button>
							</span>
						</template>
						<template v-if="form_new_contact.step == 2">
							<label>Selecione a objeção informada pelo contato</label>
							<el-select v-model="form_new_contact.objection" placeholder="Selecione a objeção do contato">
								<el-option label="Financeiro" value="financeiro" />
								<el-option label="Ausência de Curso" value="ausencia do curso" />
								<el-option label="Desconhecimento da Marca" value="desconhecimento da marca" />
								<el-option label="Resistência ao EAD" value="resistência ao EAD" />
								<el-option label="Estuda em Outra Instituição" value="estuda em outra instituição" />
								<el-option label="Outro" value="outro" />
							</el-select>
							<small class="text-muted">Selecione a resposta do contato referente a proposta realizada</small>
							<div class="mt-3 d-flex flex-column" v-if="form_new_contact.objection == 'outro' ">
								<label>Descreva a objeção</label>
								<textarea
									v-model="form_new_contact.other_objection" 
									placeholder="Descreva a objeção"  class="form-control"
									:rows="3"
									style="resize:none;"
								/>
								<small class="text-muted">Selecione a resposta do contato referente a proposta realizada</small>
							</div>
							<hr>
							<span slot="footer" class="dialog-footer d-flex justify-content-end">
								<el-button @click="form_new_contact.step = 1">
									<span class="el-icon-back mr-2" />Voltar
								</el-button>
								<el-button type="primary" @click="finishStepThree">
									Avançar<span class="el-icon-right ml-2" />
								</el-button>
							</span>
						</template>
						<template v-if="form_new_contact.step == 3">
							<label>Selecione informações para reagendamento de contato</label>
							<el-date-picker
								v-model="form_new_contact.schedule"
								type="datetime"
								placeholder="Seleciona a data e hora"
								class="w-100"
								format="dd/MM/yyyy  HH:mm:ss"
							/>
							<small class="text-muted">Nesta data e hora seu usuário será notificado para efetuar um novo contato com este lead</small>
							<hr>
							<span slot="footer" class="dialog-footer d-flex justify-content-end">
								<el-button @click="form_new_contact.step = 1">
									<span class="el-icon-back mr-2" />Voltar
								</el-button>
								<el-button type="primary" @click="finishStepFour">
									Avançar<span class="el-icon-right ml-2" />
								</el-button>
							</span>
						</template>
						<template v-if="form_new_contact.step == 4">
							{{ form_new_contact }}
						</template>
					</div>
                </el-dialog>
            </div>
        </div>
    </div>
</template>
<script>
const new_contact = () => {
    return {
        step: 0,
        visible: false,
        type: null,
        answer: null,
        objection: null,
        other_objection: null,
        schedule: null,
    }
}
export default {
    data() {
        return {
            dialogVisible: false,
            editing_form: {
                field: null,
                title: null,
                value: null,
            },
            form_new_contact: new_contact(),
        }
    },
    computed: {
        lead() {
            return this.$store.state.lead
        },
        is_not_qualified() {
            return this.lead.substatus.status.value == 'unqualified'
        },
    },
    methods: {
        finishStepFour() {
            if (!this.form_new_contact.schedule) return this.$message.error('Define a data e hora do agendamento')
            this.form_new_contact.step = 4
        },
        finishStepThree() {
            if (!this.form_new_contact.objection) return this.$message.error('Selecione a objeção do contato')
            if (this.form_new_contact.objection == 'outro') {
                if (!this.form_new_contact.other_objection) return this.$message.error('Informe a descrição da objeção do contato')
            }
            this.form_new_contact.step = 4
        },
        finishStepTwo() {
            if (!this.form_new_contact.answer) return this.$message.error('Selecione a respota do contato')
            if (this.form_new_contact.answer == 'no_interest') return (this.form_new_contact.step = 2)
            if (this.form_new_contact.answer == 'no_answer') return (this.form_new_contact.step = 3)
            this.form_new_contact.step = 4
        },
        finishStepOne() {
            if (!this.form_new_contact.type) return this.$message.error('Selecione o tipo do contato')
            this.form_new_contact.step++
        },
        confirmNewContact() {
            this.form_new_contact.visible = false
        },
        addContact() {
            this.form_new_contact = new_contact()
            this.form_new_contact.visible = true
        },
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