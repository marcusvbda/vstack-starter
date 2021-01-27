<template>
    <div class="card lead-card mb-1">
        <div class="d-flex flex-row align-items-center justify-content-between">
            <b class="d-flex flex-row align-items-center"><span class="el-icon-user-solid mr-2" />{{ lead.name }}</b>
            <el-dropdown @command="handleCommand">
                <span class="el-dropdown-link"> <span class="el-icon-more" /></span>
                <el-dropdown-menu slot="dropdown" v-if="can_edit">
                    <el-dropdown-item command="convert">Converter Lead</el-dropdown-item>
                    <el-dropdown-item command="edit">Editar Lead</el-dropdown-item>
                </el-dropdown-menu>
            </el-dropdown>
        </div>
        <small class="text-muted"> <span class="el-icon-alarm-clock mr-2" /> Data de entrada : {{ lead.f_created_at }}</small>
        <small class="text-muted"> <span class="el-icon-alarm-clock mr-2" /> Última conversão : {{ lead.f_last_conversion }}</small>
        <div class="mt-2">
            <email-url type="email" :value="lead.email">{{ lead.email }}</email-url>
        </div>
        <div class="d-flex flex-row justify-content-between align-items-center mt-1" v-if="lead.phone_number || lead.cellphone_number">
            <div>
                <span class="text-muted" v-if="lead.phone_number">{{ lead.phone_number }}</span>
            </div>
            <div>
                <email-url v-if="lead.cellphone_number" type="wpp" :value="lead.cellphone_number">{{ lead.cellphone_number }}</email-url>
            </div>
        </div>
        <div class="d-flex flex-row mt-2 align-items-center">
            <small class="text-muted" v-if="lead.obs"><span class="el-icon-info mr-2" /> {{ lead.obs }}</small>
        </div>
    </div>
</template>
<script>
export default {
    props: ['lead'],
    components: {
        'email-url': require('../../Default/EmailUrl.vue').default,
    },
    computed: {
        can_edit() {
            return this.$store.state.permissions.can_edit
        },
    },
    methods: {
        handleCommand(command) {
            this[command]()
        },
        convert() {
            window.location.href = `/admin/leads/${this.lead.code}`
        },
        edit() {
            window.location.href = `/admin/leads/${this.lead.code}/edit`
        },
    },
}
</script>