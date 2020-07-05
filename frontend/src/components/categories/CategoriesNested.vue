<style scoped>
.item-container {
    max-width: 20rem;
    margin: 0;
}
.item {
    padding: 1rem;
    border: solid black 1px;
    background-color: #fefefe;
}
.item-sub {
    margin: 0 0 0 1rem;
}
</style>


<template>
    <div>
        <!-- {{categories}} -->
        <draggable
            v-bind="dragOptions"
            tag="div"
            class="item-container"
            :list="list"
            :value="value"
            @input="emitter"
        >
            <div class="item-group" :key="el.id" v-for="el in realValue">
                <div class="item">{{ el.title }}</div>
                <categories-nested class="item-sub" :list="el.children" />
            </div>

            <!-- <transition-group type="transition" name="drag">
                        <v-expansion-panel v-for="(item,i) in category.photos" :key="i">
                            <v-expansion-panel-header>
                                <div>
                                    <v-btn
                                        class="withoutActive handle"
                                        icon
                                        right
                                        @click.native.stop
                                    >
                                        <v-icon>mdi-format-align-justify</v-icon>
                                    </v-btn>
                                    <v-btn
                                        icon
                                        @click.native.stop="toggleCategoryable(item,'published')"
                                    >
                                        <v-icon v-if="item.pivot.published" color="green">mdi-check</v-icon>
                                        <v-icon v-else color="red">mdi-close</v-icon>
                                    </v-btn>
                                    <v-btn icon right @click.native.stop="editCategoryable(item,i)">
                                        <v-icon>mdi-pencil</v-icon>
                                    </v-btn>
                                    <v-btn icon right @click.native.stop="removePhoto(item)">
                                        <v-icon>mdi-delete</v-icon>
                                    </v-btn>
                                    {{item.pivot.title}}
                                </div>
                            </v-expansion-panel-header>
                            <v-expansion-panel-content>
                                <v-row>
                                    <v-col cols="4">
                                        <v-img
                                            :src="src(item.slug)"
                                            :lazy-src="preview(item.slug)"
                                            class="grey lighten-2"
                                        ></v-img>
                                    </v-col>
                                    <v-col cols="8">
                                        <div v-if="!item.editing" v-html="item.pivot.text"></div>
                                        <div v-else>
                                            <v-text-field
                                                label="Titel"
                                                v-model="editables[item.id].title"
                                            ></v-text-field>
                                            <tiptap
                                                @input="onEditorInput"
                                                class="my-2"
                                                :content="editables[item.id].text"
                                                :id="item.id"
                                            ></tiptap>
                                            <div class="text-right">
                                                <v-btn
                                                    color="light"
                                                    small
                                                    class="mr-2"
                                                    @click="cancelEditCategoryable(item)"
                                                >Abbrechen</v-btn>
                                                <v-btn
                                                    color="primary"
                                                    small
                                                    @click="updateCategoryable(item)"
                                                >Speichern</v-btn>
                                            </div>
                                        </div>
                                    </v-col>
                                </v-row>
                            </v-expansion-panel-content>
                        </v-expansion-panel>
            </transition-group>-->
        </draggable>
    </div>
</template>
<script>
import draggable from 'vuedraggable';
export default {
    props: {
        value: {
            required: false,
            type: Array,
            default: null
        },
        list: {
            required: false,
            type: Array,
            default: null
        }
    },
    components: {
        draggable
    },
    computed: {
        dragOptions() {
            return {
                animation: 0,
                group: 'description',
                disabled: false,
                ghostClass: 'ghost'
            };
        },
        // this.value when input = v-model
        // this.list  when input != v-model
        realValue() {
            return this.value ? this.value : this.list;
        }
    },
    methods: {
        emitter(value) {
            this.$emit('input', value);
        }
    },
    name: 'categories-nested'
};
</script>