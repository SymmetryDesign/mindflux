<template>
    <div ref="input" :style="editorStyles"></div>
</template>

<script>
    import Quill from 'quill'

    export default {
        props: {
            value: {
                type: String,
                default: null
            },
            height: {
                type: [String, Number],
                default: 300,
            }
        },

        data() {
            return {
                quill: null,
                content: this.value
            }
        },

        mounted() {
            this.quill = new Quill(this.$refs.input, {
                theme: 'snow'
            });

            this.quill.on('text-change', () => {
                this.content = this.quill.container.firstChild.innerHTML;
                this.$emit('input', this.content);
            });

            this.init();
        },

        watch: {
            value: function (val) {
                this.content = val;
            }
        },

        computed: {
            editorStyles() {
                return [
                    {height: this.height + 'px'}
                ]
            }
        },

        methods: {
            init() {
                this.quill.pasteHTML(this.content);
            }
        }
    }
</script>
