<template>
    <div :class="`col col-status ${col_class}`">
        <div :class="`card status-color-bgtop ${col}`">
            <div class="card-header no-border py-2" @click="visible = !visible">
                <b :class="`d-flex flex-row align-items-center status-color ${col} justify-content-center`">
                    {{ col }}
                    <span :class="`status-color ${col} ${toggle_icon} ml-3`" />
                </b>
            </div>
            <transition name="slide">
                <div class="card-body no-border list-content modern-scroll" v-if="visible">
                    <p v-for="i in 100" :key="i">{{ i }}</p>
                </div>
            </transition>
        </div>
    </div>
</template>
<script>
export default {
    props: ['col'],
    data() {
        return {
            visible: true,
        }
    },
    computed: {
        toggle_icon() {
            return this.visible ? 'el-icon-arrow-down' : 'el-icon-arrow-up'
        },
        col_class() {
            return `${!this.visible && 'hidding'}`
        },
    },
}
</script>