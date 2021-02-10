<template>
    <div :id="id" ref="content" />
</template>
<script>
import 'grapesjs/dist/css/grapes.min.css'
import 'grapesjs-preset-newsletter/dist/grapesjs-preset-newsletter.css'
// import grapesJsCustomCode from 'grapesjs-custom-code'
import grapesPresetNewsLetter from 'grapesjs-preset-newsletter'
// import grapesPluginForms from 'grapesjs-plugin-forms'
// import grapesPresetWebpage from  'grapesjs-preset-webpage'
import grapesjs from 'grapesjs'
export default {
    props: {
        id: {
            type: String,
            default: 'gjs',
        },
        height: {
            type: String,
            default: '800px',
        },
    },
    data() {
        return {
            editor: null,
            block_manager: null,
            content: this.$attrs.value ?? {
                body: this.$attrs.value?.body,
                css: this.$attrs.value?.css,
            },
        }
    },
    watch: {
        content: {
            deep: true,
            handler(val) {
                this.$emit('input', val)
            },
        },
    },
    created() {
        this.$nextTick(() => {
            this.init()
            // this.createBlocks()
        })
    },
    methods: {
        init() {
            this.editor = grapesjs.init({
                container: `#${this.id}`,
                height: this.height,
                plugins: [
                    // grapesPresetWebpage,
                    // grapesPluginForms,
                    grapesPresetNewsLetter,
                ],
                storageManager: {
                    autosave: true,
                    autoload: false,
                    stepsBeforeSave: 0,
                    contentTypeJson: true,
                },
                styles: this.content.css,
                components: this.content.body,
            })

            this.block_manager = this.editor.BlockManager

            this.editor.on('change', (e) => {
                this.getContent()
            })
        },
        getContent() {
            let content = {}
            content.css = this.editor.getCss()
            content.body = this.editor.getHtml()
            this.content = content
        },
        // createBlocks() {
        //     this.block_manager.add('h1-block', {
        //         label: 'Texto Grande',
        //         content: '<h1>Digite seu texto ...</h1>',
        //         category: 'Basic',
        //         attributes: {
        //             title: 'Texto Grande',
        //         },
        //     })
        // },
    },
}
</script>