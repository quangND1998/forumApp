<template>
    <transition name="fade">
        <div class="w-full text-center">
            <div
                class="inset-0 w-full shadow-sm h-1/3 max-h-screen max-w-4xl"
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
                        :style="{ position: StyleCss.position, transition: StyleCss.transition, bottom: StyleCss.bottom }"
                        class="vfm__content vfm__content mx-auto flex-1 rounded-none bg-white md:rounded-t-2xl max-h-screen mt-auto overflow-auto flex flex-col w-full md:w-3/4 md:max-h-80 transition-transform vfm--prevent-auto"
                        style="box-shadow: rgba(27, 33, 58, 0.4) 0px 20px 60px -2px;max-width: 800px;"
                    >
                        <div class="flex py-8 px-10 md:px-8 md:py-6">
                            <div class="flex-1">
                                <form @submit.prevent="update">
                                    <div class="control flex items-center">
                                        <i class="fas fa-reply"></i>
                                        <p class="font-semibold">
                                            Update Reply to
                                            <strong
                                                class="uppercase text-blue"
                                            >{{ reply_to }}</strong>
                                        </p>
                                        <input type="hidden" v-model="form.user_id" />
                                        <button
                                            v-if="showMize == true"
                                            @click.prevent="miniMize()"
                                            class="ml-4 inline-flex h-8 items-baseline rounded-md bg-grey-200 px-4 py-2 text-xs font-medium text-grey-800 hover:bg-grey-300 ml-auto"
                                        >
                                            <span
                                                class="mr-1 block h-1 w-4 rounded-full bg-languages"
                                            >Minimize</span>
                                        </button>
                                        <button
                                            v-else
                                            @click.prevent="maxiMize()"
                                            class="ml-4 inline-flex h-8 items-baseline rounded-xl bg-grey-200 px-4 py-2 text-xs font-medium text-grey-800 hover:bg-grey-300 ml-auto"
                                        >
                                            <span
                                                class="mr-1 block h-1 w-4 rounded-full bg-blue"
                                            >Maximize</span>
                                        </button>
                                    </div>
                                    <div class="control">
                                        <ckeditor
                                            class="textarea mb-1 w-full border-l-0 border-r-0 px-0 py-4 text-sm focus:border-grey-500 overflow-y"
                                            style="min-height: 150px; max-height: 45vh; overflow: hidden; overflow-wrap: break-word; resize: none; height: 150px;"
                                            data-tribute="true"
                                            v-model="form.body"
                                           
                                            :config="editorConfig"
                                            tag-name="textarea"
                                        ></ckeditor>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div
                                            class="flex w-full justify-center space-x-6 md:justify-end"
                                        >
                                            <div class="flex-1 md:flex-none">
                                                <button
                                                    @click="closeModal()"
                                                    class="bg-gray-200 text-white font-bold py-2 px-4 rounded-full w-full normal-case text-grey-800 md:w-auto md:px-10"
                                                >Cancel</button>
                                            </div>
                                            <div class="flex-1 md:flex-none">
                                                <button
                                                    type="submit"
                                                    class="text-white font-bold py-2 px-4 rounded-full bg-blue-600 w-full normal-case md:w-auto md:px-10"
                                                >Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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

import { events } from "../../event";
export default {
    components: {
        EditorVue
    },

    props: {
        conversation: Object,
        initalReplies: Array,
        errors: Object
    },
    data() {
        return {
            StyleCss: {
                position: '',
                bottom: 0,
                transition: '1s'
            },
            showMize: true,
            reply_to: null,
            visible: false,
            form: this.$inertia.form({
                id: null,
                body: null,
                user_id: null,
                replie_id: null,
                reply_user: null
            }),
            editorData: "<p>Content of the editor.</p>",
            editorConfig: {
                // toolbar: ['bold', 'italic', '|', 'link']
            }
        };
    },
    mounted() {
        // var self = this;

        window.ChatterEvents.$on("editReplyEvent", e => {
            this.form.id = e.id;
            this.form.body = e.body
            this.openModalReplie(e);
        })
    },
    methods: {



        update() {
            this.form.put(this.route('admin.replie.update', this.form.id), {

                preserveState: true,
                onError: errors => {
                    if (Object.keys(errors).length > 0) {
                        this.visible = true;
                    }
                },
                onSuccess: page => {
                    this.visible = false;
                    this.reset();

                }
            })

        },
        toggleModal() {
            this.visible = !this.visible;
        },
        closeModal() {

            this.visible = false;
            this.reset();
        },
        openModal() {
            this.visible = true;
            this.reply_to = "Post"
        },

        openModalReplie(data) {
            // console.log(data)
            this.visible = true;
            this.reply_to = data.owner.name
         
        },
        miniMize() {
            this.showMize = false;
            this.StyleCss = {
                position: 'relative',
                transition: '1s',
                bottom: '-200px'
            }
        },

        maxiMize() {
            this.showMize = true;
            this.StyleCss = {
                position: '',
                bottom: '0px',
                transition: '1s',
            }
            // console.log(this.StyleCss);
        },
        reset(){
            this.form=this.$inertia.form({
                id: null,
                body: null,
                user_id: null,
                replie_id: null,
                reply_user: null
            })
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
.bg-blue {
    --tw-bg-opacity: 1;
    background-color: rgb(50 138 241 / var(--tw-bg-opacity));
}
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
}
.text-blue {
    --tw-text-opacity: 1;
    color: rgb(50 138 241 / var(--tw-text-opacity));
}
.transition-transform {
    transition-property: transform;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 150ms;
}
</style>