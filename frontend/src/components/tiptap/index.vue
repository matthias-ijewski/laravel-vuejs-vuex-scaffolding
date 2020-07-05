<template>
    <div class="editor">
        <editor-menu-bubble
            class="menububble"
            :editor="editor"
            @hide="hideLinkMenu"
            v-slot="{ commands, isActive, getMarkAttrs, menu }"
        >
            <div
                class="menububble"
                :class="{ 'is-active': menu.isActive }"
                :style="`left: ${menu.left}px; bottom: ${menu.bottom}px;`"
            >
                <form
                    class="menububble__form"
                    v-if="linkMenuIsActive"
                    @submit.prevent="setLinkUrl(commands.link, linkUrl)"
                >
                    <v-text-field
                        background-color="#fff"
                        v-model="linkUrl"
                        append-icon="mdi-check-bold"
                        @click:append="setLinkUrl(commands.link, linkUrl)"
                        outlined
                        clearable
                        clear-icon="mdi-close-circle"
                        label="Link"
                        type="text"
                        ref="linkInput"
                        placeholder="http://"
                        @keydown.esc="hideLinkMenu"
                    ></v-text-field>
                </form>

                <template v-else>
                    <v-btn
                        small
                        @click="showLinkMenu(getMarkAttrs('link'))"
                        :class="{ 'is-active': isActive.link() }"
                    >
                        <span>
                            {{ isActive.link() ? 'Link bearbeiten' : 'Link hinzufügen'}}
                            <v-icon small>mdi-link</v-icon>
                        </span>
                    </v-btn>
                </template>
            </div>
        </editor-menu-bubble>
        <editor-component :content="content" :editor="editor"></editor-component>
        <editor-content :editor="editor" class="pt-5" />
    </div>
</template>

<script>
import {
    Editor,
    EditorContent,
    EditorMenuBubble,
    EditorFloatingMenu
} from 'tiptap';
import {
    Blockquote,
    CodeBlock,
    HardBreak,
    Heading,
    HorizontalRule,
    OrderedList,
    BulletList,
    ListItem,
    TodoItem,
    TodoList,
    Bold,
    Code,
    Italic,
    Link,
    Strike,
    Underline,
    History
} from 'tiptap-extensions';
import EditorComponent from './Editor.vue';

export default {
    name: 'app',
    components: {
        EditorComponent,
        // EditorMenuButton,
        EditorContent,
        EditorMenuBubble
        // EditorFloatingMenu
    },
    props: {
        content: {
            default: ''
        },
        //
        // gets passed back with the content by the  input event
        id: {
            default: 0
        },
        //
        options: {
            default() {
                return {
                    menu: [
                        'undo',
                        'redo',
                        [
                            'bold',
                            'italic',
                            'underline',
                            {
                                command: 'strike',
                                icon: 'strikethrough'
                            }
                        ],
                        [
                            'paragraph',
                            {
                                command: 'heading',
                                args: {
                                    level: 1
                                },
                                slot: 'H1'
                            },
                            {
                                command: 'bullet_list',
                                icon: 'list-ul'
                            },
                            {
                                command: 'ordered_list',
                                icon: 'list-ol'
                            }
                        ]
                    ]
                };
            }
        }
    },
    data() {
        console.log(
            this.options.menu
                .flatMap(this.getCommands)
                .filter(function(value, index, self) {
                    return self.indexOf(value) === index;
                })
                .map(fn => {
                    if (typeof fn === 'function') return new fn();
                })
        );
        return {
            linkUrl: null,
            linkMenuIsActive: false,
            editor: new Editor({
                extensions: [
                    new HardBreak(),
                    new HardBreak(),
                    new Heading({ levels: [1, 2, 3] }),
                    new BulletList(),
                    new OrderedList(),
                    new ListItem(),
                    new Bold(),
                    new Code(),
                    new Italic(),
                    new Link(),
                    new Strike(),
                    new Underline(),
                    new History()
                ],
                content: `${this.content}`,
                onUpdate: ({ getHTML }) => {
                    this.$emit('input', {
                        content: getHTML(),
                        id: this.id
                    });
                }
            })
        };
    },
    methods: {
        html() {
            return this.editor.getHTML();
        },
        showLinkMenu(attrs) {
            this.linkUrl = attrs.href;
            this.linkMenuIsActive = true;
            this.$nextTick(() => {
                this.$refs.linkInput.focus();
            });
        },
        hideLinkMenu() {
            this.linkUrl = null;
            this.linkMenuIsActive = false;
        },
        setLinkUrl(command, url) {
            command({ href: url });
            this.hideLinkMenu();
        },
        mapCommand(command) {
            const commands = {
                undo: History,
                redo: History
            };

            if (Object.prototype.hasOwnProperty.call(commands, command)) {
                return commands[command];
            }
        },
        getCommands(item, index, array) {
            if (typeof item === 'string') {
                return this.mapCommand(item);
            } else if (typeof item === 'object') {
                if (Object.prototype.hasOwnProperty.call(item, 'command')) {
                    return this.mapCommand(item.command);
                } else {
                    return item.map(this.getCommands);
                }
            }
        }
    }
};
</script>

<style lang="scss">
// @import "~/node_modules/@fortawesome/fontawesome-free/css/all.css";
// @import "~@fortawesome/fontawesome-free/css/all.css";
.ProseMirror {
    text-align: initial;

    // &:focus {
    //   outline: none;
    // }
}
.menububble__form .v-input {
    min-width: 200px;
}
.editor {
    position: relative;
    border-bottom: 1px solid #ccc;
    &__floating-menu {
        position: absolute;
        z-index: 1;
        margin-top: -0.75rem;
        margin-left: 1rem;
        visibility: hidden;
        opacity: 0;
        transition: opacity 0.2s, visibility 0.2s;
        &.is-active {
            opacity: 1;
            visibility: visible;
        }
    }

    .menububble {
        position: absolute;
        display: flex;
        z-index: 20;
        margin-bottom: 0.5rem;
        transform: translateX(-50%);
        visibility: hidden;
        opacity: 0;
        transition: opacity 0.2s, visibility 0.2s;

        &.is-active {
            opacity: 1;
            visibility: visible;
        }

        &__form {
            display: flex;
            align-items: center;
        }

        &__input {
            font: inherit;
            border: none;
            background: transparent;
        }
    }
}
</style>
