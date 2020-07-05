<template>
    <v-btn icon small :class="activeClass" @click.prevent="editorParams.commands[command](args)">
        <slot>
            <v-icon>{{icons[command]}}</v-icon>
            <!-- <i class="fas fa-fw" :class="iconClass"></i> -->
        </slot>
        <!-- </button> -->
    </v-btn>
</template>

<script>
export default {
    name: 'editor-menu-button',
    data: () => ({
        icons: {
            undo: 'mdi-undo',
            redo: 'mdi-redo',
            bold: 'mdi-format-bold',
            italic: 'mdi-format-italic',
            underline: 'mdi-format-underline',
            strike: 'mdi-format-strikethrough',
            paragraph: 'mdi-format-paragraph',
            heading: 'mdi-format-header-1',
            bullet_list: 'mdi-format-list-bulleted',
            ordered_list: 'mdi-format-list-numbered'
        }
    }),
    props: {
        command: {
            required: true,
            type: String
        },
        editorParams: {
            required: true,
            type: Object,
            default: () => {}
        },
        args: {
            type: Object,
            default: () => {}
        },
        icon: {
            type: String
        }
    },
    computed: {
        activeClass() {
            var active =
                this.editorParams.isActive[this.command] &&
                this.editorParams.isActive[this.command](this.args)
                    ? 'active'
                    : null;
            return active;
        },
        mdi() {
            return `mdi-format-${this.icon ? this.icon : this.command}`;
        }
    }
};
</script>

<style scoped>
button.active {
    background-color: #ccc;
}
button::before {
    opacity: 0 !important;
}
</style>
