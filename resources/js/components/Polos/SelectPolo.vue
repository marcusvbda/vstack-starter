<template>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a @click.prevent="showPolosList" class="nav-link" href="#">
                <span class="badge badge-default pt-1 px-2">{{ polo_name }}</span>
            </a>
        </li>
        <select-dialog ref="select-polo" title="Selecione o polo que deseja logar" btn_text="Selecionar" @selected="selectPolo" :default="logged_id" />
    </ul>
</template>
<script>
export default {
    props: ['polo_name', 'user_id', 'logged_id'],
    data() {
        return {
            visible: false,
            attempts: 0,
        }
    },
    methods: {
        showPolosList() {
            let loading = this.$loading({ text: 'Carregando Polos ...' })
            this.attempts++
            this.$http
                .post('/admin/polos', { user_id: this.user_id })
                .then(({ data }) => {
                    let select_polo = this.$refs['select-polo']
                    select_polo.options = data.map((x) => ({ key: x.id, label: x.name }))
                    select_polo.open()
                    loading.close()
                    this.attempts = 0
                })
                .catch((err) => {
                    if (this.attempts <= 3) return this.showPolosList()
                    loading.close()
                    console.log(err)
                    this.attempts = 0
                })
        },
        selectPolo(polo) {
            let loading = this.$loading({ text: `Logando no polo selecionado ...` })
            this.$http.post(`/admin/polos/change-logged`, { id: polo }).then(({ data }) => {
                window.location.reload()
            })
        },
    },
}
</script>