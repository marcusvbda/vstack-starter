<template>
    <div id="notification-view">
        <div class="row" v-if="has_new">
            <div class="col-12" @click="update_page">
                <el-alert
                    class="new-notifications"
                    title="Você Possui Novas Notificações"
                    type="warning"
                    description="Clique aqui para atualizar a página e ve-las"
                    show-icon
                    :closable="false"
                />
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <p class="mb-2 text-center mb-3"><b>Notificações</b></p>
                        <p class="text-center" v-if="has_new">
                            <a href="/admin/notificacoes">Ver Novas Notificações</a>
                        </p>
                        <p class="text-center" v-else>Você Não Possui Novas Notificações</p>
                    </div>
                    <div class="card-footer">
                        <p class="text-center">Listagem de Notificações em ordem decrescente</p>
                    </div>
                </div>
            </div>
            <div class="col-md-9 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="infinite-list-wrapper" style="overflow: auto">
                            <ul class="list" v-infinite-scroll="load" infinite-scroll-disabled="disabled">
                                <li v-for="i in count" class="list-item" :key="i">{{ i }}</li>
                            </ul>
                            <p v-if="loading">Carregando...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['user'],
    data() {
        return {
            attempts: 0,
            qty: 0,
            has_new: false,
            count: 10,
            loading: false,
        }
    },
    computed: {
        noMore() {
            return this.count >= 20
        },
        disabled() {
            return this.loading || this.noMore
        },
    },
    created() {
        this.getNotificationQty()
        this.initiatPusherListenUser()
    },
    methods: {
        load() {
            this.loading = true
            setTimeout(() => {
                this.count += 10
                this.loading = false
            }, 2000)
        },
        update_page() {
            window.location.reload()
        },
        initiatPusherListenUser() {
            if (laravel.user.id && laravel.chat.pusher_key) {
                this.$echo.private(`App.User.${laravel.user.id}`).listen('.notifications.user', (n) => {
                    this.qty = n.qty
                    this.has_new = true
                    document.title = `(${this.qty}) - Notificações`
                })
            }
        },
        getNotificationQty() {
            this.attempts++
            this.$http
                .post(`/admin/notificacoes/get-qty`)
                .then(({ data }) => {
                    this.qty = data.qty
                    this.attempts = 0
                })
                .catch((er) => {
                    if (this.attempts <= 3) return this.getNotificationQty()
                    console.log(er)
                    this.attempts = 0
                })
        },
    },
}
</script>
<style lang="scss" scoped>
#notification-view {
    .new-notifications {
        margin-bottom: 20px;
        border: 1px solid;
        opacity: 0.8;
        transition: 0.5s;
        cursor: pointer;
        &:hover {
            opacity: 1;
        }
    }

    .infinite-list-wrapper {
        height: 1000%;
        text-align: center;
        .list {
            padding: 0;
            margin: 0;
            list-style: none;
            .list-item {
                display: flex;
                align-items: center;
                justify-content: center;
                height: 50px;
                background: #fff6f6;
                color: #ff8484;
                margin-top: 10px;
            }
        }
    }
}
</style>