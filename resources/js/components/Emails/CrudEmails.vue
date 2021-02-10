<template>
    <form novalidate="novalidate" class="needs-validation m-0" @submit.prevent="submit">
        <div class="row">
            <!---->
            <div class="col-12">
                <div id="Identificação">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-12 d-flex align-items-center justify-content-between">
                                    <div>
                                        <h4>{{ page_type }} de Email</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="row-responsive-table">
                                        <table class="table table-striped">
                                            <tbody>
                                                <tr class="mb-3">
                                                    <td>Nome*</td>
                                                    <td>
                                                        <div class="d-flex flex-column">
                                                            <div class="input-group">
                                                                <input v-model="form.name" type="text" class="form-control" />
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="mb-3">
                                                    <td>Assunto*</td>
                                                    <td>
                                                        <div class="d-flex flex-column">
                                                            <div class="input-group">
                                                                <input v-model="form.subject" type="text" class="form-control" />
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><html-editor v-model="form.body" /></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!---->
        <div class="row">
            <div class="col-12 d-flex justify-content-end d-flex align-items-center flex-wrap">
                <a href="http://local.vstack.starter/admin/emails" class="mr-5 text-danger link d-none d-lg-block"><b>Cancelar</b></a>
                <button type="sumit" class="btn btn-primary btn-sm-block">Cadastrar</button>
            </div>
        </div>
    </form>
</template>
<script>
export default {
    props: ['email'],
    data() {
        return {
            form: {
                id: this.email?.id ?? null,
                name: this.email?.name ?? null,
                subject: this.email?.subject ?? null,
                body: {
                    css: this.email?.body?.css ?? null,
                    body: this.email?.body?.body ?? null,
                },
            },
        }
    },
    computed: {
        page_type() {
            return this.form.id ? 'Edição' : 'Cadastro'
        },
        store_route() {
            return '/admin/emails/store'
        },
    },
    methods: {
        submit() {
            this.$confirm(`Confirma ${this.page_type} ?`, 'Confirmação', {
                confirmButtonText: 'Sim',
                cancelButtonText: 'Não',
                type: 'warning',
            })
                .then(() => {
                    let loading = this.$loading()
                    this.$http
                        .post(this.store_route, this.form)
                        .then((res) => {
                            let data = res.data
                            if (data.success) return (window.location.href = data.route)
                            loading.close()
                        })
                        .catch((er) => {
                            let errors = er.response.data.errors
                            this.errors = errors
                            loading.close()
                        })
                })
                .catch(() => false)
        },
    },
}
</script>