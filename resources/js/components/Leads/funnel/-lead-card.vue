<template>
    <div class="card lead-card mb-1">
        <div class="d-flex flex-row align-items-center justify-content-between">
            <b class="d-flex flex-row align-items-center"><span class="el-icon-user-solid mr-2" />Joao da Silva Sauro</b>
            <el-dropdown @command="handleCommand">
                <span class="el-dropdown-link"> <span class="el-icon-more" /></span>
                <el-dropdown-menu slot="dropdown">
                    <el-dropdown-item command="convert">Converter Lead</el-dropdown-item>
                    <el-dropdown-item command="edit">Editar Lead</el-dropdown-item>
                </el-dropdown-menu>
            </el-dropdown>
        </div>
        <small class="text-muted"> <span class="el-icon-alarm-clock mr-2" /> Última conversão : 07/01/2021 </small>
        <div class="mt-2"><email-url type="email" value="bassalobre.vinicius@gmail.com">bassalobre.vinicius@gmail.com</email-url></div>
        <div class="d-flex flex-row justify-content-between align-items-center">
            <div>(14) 3425-4246</div>
            <div><email-url type="wpp" value="(14) 996766177">(14) 99676-6177</email-url></div>
        </div>
        <div class="d-flex flex-row mt-2 align-items-center">
            <small class="text-muted"><span class="el-icon-info mr-2" /> Possui interesse em lorem ipsum ...</small>
        </div>
    </div>
</template>
<script>
import EmailUrl from '../../Default/EmailUrl.vue'
export default {
    props: [],
    methods: {
        handleCommand(command) {
            this[command]()
        },
        convert() {
            console.log('converter')
        },
        edit() {
            console.log('editar')
        },
    },
}
</script>