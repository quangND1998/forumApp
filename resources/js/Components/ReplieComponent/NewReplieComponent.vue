<template>
    <transition name="fade">
        <div class="w-full text-center">
            <div
                class="fixed inset-0 w-full shadow-sm h-1/3 max-h-screen max-w-4xl"
                height="auto"
                v-if="visible"
                v-cloak
                style="z-index:1000"
            >
                <div
                    class="vfm__container fixed inset-0 outline-none flex mx-auto"
                    aria-expanded="true"
                    role="dialog"
                    tabindex="-1"
                >
                    <div
                        class="vfm__content vfm__content mx-auto flex-1 rounded-none bg-white md:rounded-t-2xl max-h-screen mt-auto overflow-auto flex flex-col w-full md:w-3/4 md:max-h-80 transition-transform vfm--prevent-auto"
                        style="box-shadow: rgba(27, 33, 58, 0.4) 0px 20px 60px -2px; max-width: 800px;"
                    >
                        <div class="flex py-8 px-10 md:px-8 md:py-6">
                            <div class="flex-1">
                                <div class="control flex items-center">
                                    <i class="fas fa-reply"></i>
                                    <p class="font-semibold">
                                        Reply to
                                        <strong class="uppercase text-blue"></strong>
                                    </p>
                                    <button
                                        @click="closeModal()"
                                        class="ml-4 inline-flex h-8 items-baseline rounded-md bg-grey-200 px-4 py-2 text-2xs font-medium text-grey-800 hover:bg-grey-300 ml-auto"
                                    >
                                        <span
                                            class="mr-1 block h-1 w-4 rounded-full bg-languages"
                                        >Minimize</span>
                                    </button>
                                </div>
                                <div class="control">
                                    <textarea
                                        class="textarea mb-1 w-full overflow-auto border-l-0 border-r-0 px-0 py-4 text-sm focus:border-grey-500"
                                        style="min-height: 150px; max-height: 45vh; overflow: hidden; overflow-wrap: break-word; resize: none; height: 150px;"
                                        data-tribute="true"
                                    ></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
import EditorVue from "@/Components/editor/Editor";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import { events } from "../../event";
export default {
    components: {
        ClassicEditor,
        EditorVue
    },
    data() {
        return {
            visible: false,
            form: this.$inertia.form({
                id: null,
                body: null
            }),
            editor: ClassicEditor,
            editorData: "<p>Content of the editor.</p>",
            editorConfig: {
                // The configuration of the editor.
            }
        };
    },
    mounted() {
        var self = this;
        window.ChatterEvents.$on("RelytoQuestion", e => {
            console.log(e);
            self.openModal();
        });
    },
    methods: {
        toggleModal() {
            this.visible = !this.visible;
        },
        closeModal() {
            console.log('aaaa')
            this.visible = false;
        },
        openModal() {
            this.visible = true;
        }
    }
};
</script>

<style scoped>
.textarea {
    max-height: 100%;
    padding: 20px 15px;
}
.control:not(:last-child) {
    margin-bottom: 1.3em;
}
.vfm__container {
    background: 0 0;
    border: 0 solid;
    font-size: 100%;
    font-weight: 400;
    margin: 0;
    padding: 0;
    vertical-align: baseline;
}
.bg-languages {
    --tw-bg-opacity: 1;
    background-color: rgb(241 154 26 / var(--tw-bg-opacity));
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
}
</style>