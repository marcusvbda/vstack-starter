<template>
    <div class="card lead-card mb-1">
        <div class="d-flex flex-row align-items-center justify-content-between">
            <b class="d-flex flex-row align-items-center">
                <span class="el-icon-user-solid mr-2" />
                {{ lead.name }}<small class="ml-2 text-muted">#{{ lead.code }}</small>
            </b>
            <el-dropdown @command="handleCommand">
                <span class="el-dropdown-link"> <span class="el-icon-more" /></span>
                <el-dropdown-menu slot="dropdown" v-if="can_edit">
                    <el-dropdown-item command="convert">Converter Lead</el-dropdown-item>
                    <el-dropdown-item command="edit">Editar Lead</el-dropdown-item>
                </el-dropdown-menu>
            </el-dropdown>
        </div>
        <div class="text-right">
            <small class="text-muted">{{ lead.f_substatus }}</small>
        </div>
        <v-runtime-template class="mb-2" :template="lead.f_rating" />
        <small class="text-muted"> <span class="el-icon-alarm-clock mr-2" /> Data de entrada : {{ lead.f_created_at }}</small>
        <small class="text-muted" v-if="lead.f_schedule"> <span class="el-icon-alarm-clock mr-2" /> Data de agendamento : {{ lead.f_schedule }}</small>
        <small class="text-muted"> <span class="el-icon-alarm-clock mr-2" /> Última conversão : {{ lead.f_last_conversion }}</small>
        <resource-tags-input class="mt-3 extra-mini-tags" v-if="use_tags" :resource="resource_id" :resource_code="lead.code" only_view />
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
        <div class="d-flex flex-column mt-2 align-items-start mt-3">
            <div class="d-flex flex-row justify-content-between w-100">
                <small>
                    <a class="link" :href="`https://www.google.com.br/search?q=${lead.name}`" target="_BLANK">Encontrar no Google</a>
                </small>
                <small>
                    <a class="link" :href="`https://www.facebook.com/search/top/?q=${lead.name}`" target="_BLANK">Encontrar no Facebook</a>
                </small>
            </div>
            <div class="d-flex flex-row justify-content-between w-100">
                <small>
                    <a class="link" :href="`https://www.linkedin.com/search/results/people/?keywords=${lead.name}`" target="_BLANK">Encontrar no Linkedin</a>
                </small>
                <small>
                    <a class="link" :href="`https://twitter.com/search?q=${lead.name}&f=user`" target="_BLANK">Encontrar no Twitter</a>
                </small>
            </div>
        </div>
        <div class="d-flex flex-column mt-2 align-items-start">
            <small class="text-success" v-if="lead.interest"><span class="el-icon-s-flag mr-2" /> {{ lead.interest }}</small>
            <small class="text-primary" v-if="lead.comment"><span class="el-icon-chat-round mr-2" /> {{ lead.comment }}</small>
            <small class="text-danger" v-if="lead.objection"><span class="el-icon-warning mr-2" /> {{ lead.objection }}</small>
            <small class="text-muted" v-if="lead.obs"><span class="el-icon-info mr-2" /> {{ lead.obs }}</small>
        </div>
    </div>
</template>
<script>
import VRuntimeTemplate from 'v-runtime-template'
export default {
    props: ['lead'],
    components: {
        'email-url': require('../../Default/EmailUrl.vue').default,
        'v-runtime-template': VRuntimeTemplate,
    },
    computed: {
        can_edit() {
            return this.$store.state.permissions.can_edit
        },
        use_tags() {
            return this.$store.state.permissions.use_tags
        },
        resource_id() {
            return this.$store.state.resource_id
        },
    },
    methods: {
        handleCommand(command) {
            this[command]()
        },
        convert() {
            window.location.href = `/admin/funil-de-conversao/${this.lead.code}/converter${window.location.search}`
        },
        edit() {
            window.location.href = `/admin/leads/${this.lead.code}/edit`
        },
    },
}
</script>