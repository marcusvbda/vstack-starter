<template>
    <div id="lead-convert">
        <identification-row />
        <div class="row">
            <div class="col-12">
                <div class="card no-radius">
                    <div class="card-body">
                        <info-obs-row />
                        <el-steps :active="1" finish-status="success" simple>
                            <el-step title="Step 1" />
                            <el-step title="Step 2" />
                            <el-step title="Step 3" />
                        </el-steps>
                        <div class="mt-3">
                            <h1>INTERESSES</h1>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed id feugiat nisi, id lobortis neque. Nunc auctor tempus condimentum.
                            Fusce ultricies eget ex sed pellentesque. Etiam pulvinar, ligula ac dictum volutpat, odio lacus hendrerit mi, non venenatis lacus
                            sem ut dolor. Pellentesque massa lacus, semper eget hendrerit in, fermentum non sapien. Donec diam erat, dictum sed feugiat sed,
                            mollis eu arcu. Sed vestibulum neque nibh, id porta orci venenatis id. Aenean erat neque, sagittis ut ligula at, suscipit malesuada
                            quam. Ut placerat, diam nec condimentum consectetur, sapien orci vehicula urna, elementum tempor velit lacus at ipsum.
                        </div>
                        <el-tabs type="border-card" class="mt-4">
                            <el-tab-pane label="User">
                                <h1>CONVERSOES</h1>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed id feugiat nisi, id lobortis neque. Nunc auctor tempus condimentum.
                                Fusce ultricies eget ex sed pellentesque. Etiam pulvinar, ligula ac dictum volutpat, odio lacus hendrerit mi, non venenatis
                                lacus sem ut dolor. Pellentesque massa lacus, semper eget hendrerit in, fermentum non sapien. Donec diam erat, dictum sed
                                feugiat sed, mollis eu arcu. Sed vestibulum neque nibh, id porta orci venenatis id. Aenean erat neque, sagittis ut ligula at,
                                suscipit malesuada quam. Ut placerat, diam nec condimentum consectetur, sapien orci vehicula urna, elementum tempor velit lacus
                                at ipsum.
                            </el-tab-pane>
                            <el-tab-pane label="Config">
                                <h1>LEADS RELACIONADOS</h1>
                                {{ lead }}
                            </el-tab-pane>
                            <el-tab-pane label="Role">
                                <h1>CAMPOS ADICIONAIS</h1>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed id feugiat nisi, id lobortis neque. Nunc auctor tempus condimentum.
                                Fusce ultricies eget ex sed pellentesque. Etiam pulvinar, ligula ac dictum volutpat, odio lacus hendrerit mi, non venenatis
                                lacus sem ut dolor. Pellentesque massa lacus, semper eget hendrerit in, fermentum non sapien. Donec diam erat, dictum sed
                                feugiat sed, mollis eu arcu. Sed vestibulum neque nibh, id porta orci venenatis id. Aenean erat neque, sagittis ut ligula at,
                                suscipit malesuada quam. Ut placerat, diam nec condimentum consectetur, sapien orci vehicula urna, elementum tempor velit lacus
                                at ipsum.
                            </el-tab-pane>
                            <el-tab-pane label="Task">
                                <h1>ATENDIMENTO</h1>

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
import leadStore from '~/stores/lead'
export default {
    props: ['lead', 'use_tags', 'resource_id'],
    store: leadStore,
    components: {
        'identification-row': require('./-identification-row').default,
        'info-obs-row': require('./-info-obs-row').default,
    },

    created() {
        this.$store.commit('setUseTags', this.use_tags)
        this.$store.commit('setResourceId', this.resource_id)
        this.$store.commit('setLead', this.lead)
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