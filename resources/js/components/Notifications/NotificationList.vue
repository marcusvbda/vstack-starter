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
                <div class="card" style="height: 100%; overflow: auto">
                    <div class="card-body p-0">
                        <div class="infinite-list-wrapper">
                            <table class="table table-striped table-hover">
                                <tbody v-infinite-scroll="load" infinite-scroll-disabled="disabled">
                                    <tr v-for="(note, i) in notifications" :key="i">
                                        <td @click="goTo(note.data.route)" width="1%" class="pointer">
                                            <b><span :class="`${note.data.icon} mr-4`" style="font-size: 30px" /></b>
                                        </td>
                                        <td @click="goTo(note.data.route)" class="pointer">
                                            <span v-html="note.data.message" />
                                        </td>
                                        <td @click="goTo(note.data.route)" width="15%" class="pointer">
                                            <small v-html="note.f_created_at" class="ml-auto" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-center" v-if="loading">Carregando...</td>
                                        <td colspan="3" class="text-center" v-if="noMore">Sem mais notificações...</td>
                                    </tr>
                                </tbody>
                            </table>
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
            attempts_qty: 0,
            qty: 0,
            has_new: false,
            notifications: [],
            loading: false,
            current_page: 0,
            last_page: -1,
        }
    },
    computed: {
        noMore() {
            return this.last_page == this.current_page
        },
        disabled() {
            return this.loading || this.noMore
        },
    },
    created() {
        this.getPaginatedNotifications()
        this.getNotificationQty()
        this.initiatPusherListenUser()
    },
    methods: {
        goTo(route) {
            window.location.href = route
        },
        load() {
            this.getPaginatedNotifications()
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
            this.attempts_qty++
            this.$http
                .post(`/admin/notificacoes/get-qty`)
                .then(({ data }) => {
                    this.qty = data.qty
                    this.attempts_qty = 0
                })
                .catch((er) => {
                    if (this.attempts_qty <= 3) return this.getNotificationQty()
                    console.log(er)
                    this.attempts_qty = 0
                })
        },
        getPaginatedNotifications() {
            this.attempts++
            this.loading = true
            this.$http
                .post(`/admin/notificacoes/paginated`, { page: ++this.current_page })
                .then(({ data }) => {
                    this.current_page = data.current_page
                    this.last_page = data.last_page
                    this.notifications = _.concat(this.notifications, data.data)
                    this.attempts = 0
                    this.loading = false
                })
                .catch((er) => {
                    if (this.attempts <= 3) return this.getPaginatedNotifications()
                    console.log(er)
                    this.attempts = 0
                    this.loading = false
                })
        },
    },
}
</script>
<style lang="scss" >
html {
    overflow: hidden !important;
}
.pointer {
    cursor: pointer;
}
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
        height: 700px;
        text-align: center;
        .list {
            padding: 0;
            margin: 0;
            list-style: none;
            .list-item {
                opacity: 0.6;
                transition: 0.5s;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                height: 50px;
                background: #f5f5f5;
                margin-top: 10px;
                &:hover {
                    opacity: 1;
                }
            }
        }
    }
}
</style>