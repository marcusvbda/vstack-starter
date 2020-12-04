<template>
    <div class="row mb-5">
        <div class="col-12">
            <form class="needs-validation m-0" novalidate v-on:submit.prevent="submit" @keypress.13.prevent>
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="card box-shadow">
                            <div class="card-header d-flex align-items-center">
                                <b>Informações Básicas</b>
                            </div>
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row-responsive-table">
                                            <table class="table table-striped mb-0">
                                                <tbody>
                                                    <v-input label="Nome *" v-model="form.name" :errors="errors.name ? errors.name : false" />
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3" v-if="show_password">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header px-3">
                                <el-switch active-text="Alterar a senha" v-model="form.change_password" />
                            </div>
                            <div class="card-body p-0" v-if="form.change_password">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row-responsive-table">
                                            <table class="table table-striped mb-0">
                                                <tbody>
                                                    <v-input
                                                        type="password"
                                                        label="Senha *"
                                                        v-model="form.password"
                                                        :errors="errors.password ? errors.password : false"
                                                    />
                                                    <v-input
                                                        type="password"
                                                        label="Confirme a senha *"
                                                        v-model="form.password_confirm"
                                                        :errors="errors.password_confirm ? errors.password_confirm : false"
                                                    />
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3 mb-5">
                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
export default {
    props: ['user', 'logged'],
    data() {
        return {
            loading: false,
            form: {
                id: this.user.id,
                name: this.user.name,
                change_password: false,
                password: null,
                password_confirm: null,
            },
            errors: {},
            loading_avatar: false,
        }
    },
    computed: {
        name() {
            return `${this.form.firstname} ${this.form.lastname}`
        },
        show_password() {
            return this.logged.id == this.user.id
        },
    },
    methods: {
        submit() {
            let loading = this.$loading()
            this.$http
                .post('/admin/profile', this.form)
                .then((resp) => {
                    resp = resp.data
                    this.errors = []
                    if (resp.success) {
                        if (this.hide_password == undefined) return window.location.reload()
                        return (window.location.href = '/admin/usuarios')
                    }
                })
                .catch((er) => {
                    loading.close()
                    this.errors = er.response.data.errors
                    this.$validationErrorMessage(er)
                })
        },
    },
}
</script>