<template>
    <h1 class="logo" :style="{ fontSize: `${size}px` }"><b>L</b>ead<b>s</b></h1>
</template>
<script>
export default {
    props: {
        size: {
            type: String,
            default: '60',
        },
    },
}
</script>
<style lang="scss" scoped>
.logo {
    letter-spacing: -2px;
    color: inherit;
    display: flex;
    align-items: center;
    position: relative;
    color: #001737;
    text-transform: lowercase;
    font-weight: bolder;
    margin-bottom: 0;
    b {
        display: inline-block;
        color: #0168fa;
        font-weight: 400;
    }
}
</style>