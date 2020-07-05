<template>
    <editor-menu-bar :editor="editor" v-slot:default="editorParams">
        <div>
            <v-btn-toggle class="pr-2">
                <editor-menu-button command="undo" :editor-params="editorParams" />
                <editor-menu-button command="redo" :editor-params="editorParams" />
            </v-btn-toggle>
            <v-btn-toggle multiple class="pr-2">
                <editor-menu-button command="bold" :editor-params="editorParams" />
                <editor-menu-button command="italic" :editor-params="editorParams" />
                <editor-menu-button command="underline" :editor-params="editorParams" />
                <editor-menu-button
                    command="strike"
                    icon="strikethrough"
                    :editor-params="editorParams"
                />
            </v-btn-toggle>
            <v-btn-toggle multiple>
                <editor-menu-button command="paragraph" :editor-params="editorParams" />
                <editor-menu-button
                    command="heading"
                    :args="{ level: 2 }"
                    :editor-params="editorParams"
                />
                <editor-menu-button
                    command="bullet_list"
                    icon="list-ul"
                    :editor-params="editorParams"
                />
                <editor-menu-button
                    command="ordered_list"
                    icon="list-ol"
                    :editor-params="editorParams"
                />
            </v-btn-toggle>
        </div>
    </editor-menu-bar>
</template>

<script>
import { EditorMenuBar } from 'tiptap';
import EditorMenuButton from './EditorMenuButton.vue';

export default {
    name: 'app',
    components: {
        EditorMenuButton,
        EditorMenuBar
    },
    props: {
        editor: {
            type: Object,
            required: true
        }
    }
};
</script>

<style lang="scss">
.ProseMirror {
    text-align: initial;

    &:focus {
        outline: none;
    }
}
</style>
