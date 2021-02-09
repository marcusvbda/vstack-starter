<template>
    <form @submit.prevent="submit">
        <div class="row mt-2">
            <div class="col-12">
                <div class="d-flex flex-row justify-content-between mb-3">
                    <h4><span class="el-icon-star-on mr-2"></span> Configuração de Regra de Classificação</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div id="Informações Básicas">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="row-responsive-table">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="w-70">Descrição</th>
                                                    <th class="w-30">Peso</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="mb-3" v-for="(key, i) in Object.keys(rating_rules)" :key="i">
                                                    <td>{{ key }}</td>
                                                    <td>
                                                        <input class="form-control" type="number" v-model="rating_rules[key]" />
                                                    </td>
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
        <div class="row">
            <div class="col-12 d-flex justify-content-end d-flex align-items-center flex-wrap">
                <button type="submit" class="btn btn-primary btn-sm-block">Salvar</button>
            </div>
        </div>
    </form>
</template>
<script>
export default {
    props: ['rating_rule'],
    data() {
        return {
            rating_rules: this.rating_rule,
        }
    },
    methods: {
        submit() {
            this.$loading()
            this.$http.post(window.location.pathname, this.rating_rules).then(({ data }) => {
                window.location.reload()
            })
        },
    },
}
</script>