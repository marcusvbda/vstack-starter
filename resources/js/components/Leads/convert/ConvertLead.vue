<template>
    <div id="lead-convert">
        <div class="row">
            <div class="col-12">
                <div class="d-flex flex-column header">
                    <span v-html="lead.f_status_badge" />
                    <a :href="`/admin/leads/${lead.code}/edit`" class="lead-name" target="_BLANK">
                        {{ lead.name ? lead.name : undefined_text }} <small class="ml-2 f-12">#{{ lead.code }}</small>
                    </a>
                    <small class="text-muted f-12">{{ lead.f_last_conversion_date }}</small>
                </div>
            </div>
        </div>
        <resource-tags-input class="mt-3" v-if="use_tags" :resource="resource_id" :resource_code="lead.code" />
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-row justify-content-between">
                            <div class="d-flex flex-column">
                                <b class="f-12 text-muted">Nome</b>
                                <span class="f-12">
                                    <a :href="`/admin/leads/${lead.code}/edit`" class="link" target="_BLANK">
                                        {{ lead.name ? lead.name : undefined_text }}
                                    </a>
                                </span>
                            </div>
                            <div class="d-flex flex-column">
                                <b class="f-12 text-muted">Data de Nascimento</b>
                                <span class="f-12">{{ lead.f_birthdate ? lead.f_birthdate : undefined_text }}</span>
                            </div>
                            <div class="d-flex flex-column">
                                <b class="f-12 text-muted">Idade</b>
                                <span class="f-12">{{ lead.age ? `${lead.age} Ano${lead.age > 1 ? 's' : ''}` : undefined_text }}</span>
                            </div>
                            <div class="d-flex flex-column">
                                <b class="f-12 text-muted">Email</b>
                                <email-url type="email" class="f-12" v-if="lead.email" :value="lead.email">
                                    {{ lead.email }}
                                </email-url>
                                <span class="f-12" v-else>{{ undefined_text }}o</span>
                            </div>
                            <div class="d-flex flex-column">
                                <b class="f-12 text-muted">WhatsApp</b>
                                <email-url type="wpp" class="f-12" v-if="lead.cellphone_number" :value="lead.cellphone_number">
                                    {{ lead.cellphone_number }}
                                </email-url>
                                <span class="f-12" v-else>{{ undefined_text }}o</span>
                            </div>
                            <div class="d-flex flex-column">
                                <b class="f-12 text-muted">Telefone Fixo</b>
                                <span class="f-12">{{ lead.phone_number ? lead.phone_number : undefined_text }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <el-steps :active="1" finish-status="success" simple>
                            <el-step title="Step 1" />
                            <el-step title="Step 2" />
                            <el-step title="Step 3" />
                        </el-steps>
                        <div class="mt-3">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed id feugiat nisi, id lobortis neque. Nunc auctor tempus condimentum.
                            Fusce ultricies eget ex sed pellentesque. Etiam pulvinar, ligula ac dictum volutpat, odio lacus hendrerit mi, non venenatis lacus
                            sem ut dolor. Pellentesque massa lacus, semper eget hendrerit in, fermentum non sapien. Donec diam erat, dictum sed feugiat sed,
                            mollis eu arcu. Sed vestibulum neque nibh, id porta orci venenatis id. Aenean erat neque, sagittis ut ligula at, suscipit malesuada
                            quam. Ut placerat, diam nec condimentum consectetur, sapien orci vehicula urna, elementum tempor velit lacus at ipsum.
                        </div>
                        <el-tabs type="border-card" class="mt-4">
                            <el-tab-pane label="User">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed id feugiat nisi, id lobortis neque. Nunc auctor tempus condimentum.
                                Fusce ultricies eget ex sed pellentesque. Etiam pulvinar, ligula ac dictum volutpat, odio lacus hendrerit mi, non venenatis
                                lacus sem ut dolor. Pellentesque massa lacus, semper eget hendrerit in, fermentum non sapien. Donec diam erat, dictum sed
                                feugiat sed, mollis eu arcu. Sed vestibulum neque nibh, id porta orci venenatis id. Aenean erat neque, sagittis ut ligula at,
                                suscipit malesuada quam. Ut placerat, diam nec condimentum consectetur, sapien orci vehicula urna, elementum tempor velit lacus
                                at ipsum.
                            </el-tab-pane>
                            <el-tab-pane label="Config">
                                {{ lead }}
                            </el-tab-pane>
                            <el-tab-pane label="Role">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed id feugiat nisi, id lobortis neque. Nunc auctor tempus condimentum.
                                Fusce ultricies eget ex sed pellentesque. Etiam pulvinar, ligula ac dictum volutpat, odio lacus hendrerit mi, non venenatis
                                lacus sem ut dolor. Pellentesque massa lacus, semper eget hendrerit in, fermentum non sapien. Donec diam erat, dictum sed
                                feugiat sed, mollis eu arcu. Sed vestibulum neque nibh, id porta orci venenatis id. Aenean erat neque, sagittis ut ligula at,
                                suscipit malesuada quam. Ut placerat, diam nec condimentum consectetur, sapien orci vehicula urna, elementum tempor velit lacus
                                at ipsum.
                            </el-tab-pane>
                            <el-tab-pane label="Task">
                                {{ lead }}
                            </el-tab-pane>
                        </el-tabs>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12">{{ lead }}</div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['lead', 'use_tags', 'resource_id'],
    data() {
        return {
            undefined_text: 'Não Informado',
        }
    },
}
</script>
<style lang="scss">
#lead-convert {
    .header {
        .lead-name {
            cursor: pointer;
            font-size: 25px;
            color: #4e5259;
            opacity: 0.7;
            transition: 0.3s;
            font-weight: 600;
            line-height: 20px;
            &:hover {
                text-decoration: unset;
                opacity: 1;
            }
        }
    }
}
</style>