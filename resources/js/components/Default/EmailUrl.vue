<template>
    <div>
        <a href="#" @click.prevent="dialog = !dialog" class="link"><slot /></a>
        <el-dialog title="Tips" :visible.sync="dialog" width="30%">
            <span>This is a message {{ value }}</span>
            <span slot="footer" class="dialog-footer">
                <el-button @click="dialog = false">Cancel</el-button>
                <el-button type="primary" @click="dialog = false">Confirm</el-button>
            </span>
        </el-dialog>
    </div>
</template>
<script>
export default {
    props: ['value'],
    data() {
        return {
            dialog: false,
        }
    },
}
</script>