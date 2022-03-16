<template>
    <div>
        <UpdateQuestionComponent :errors="errors" :chanels="chanels"></UpdateQuestionComponent>
        <div v-for="post in conversations.data" :key="post.id">
            <div
                class="flex cursor-pointer items-center flex-col md:flex-row md:hover:bg-gray-200 hover:rounded-lg md:px-6 md:py-4 mb-6 md:mb-0 transition-all px-6 py-5 md:px-0 md:py-0 rounded-lg -mx-2 md:mx-0"
            >
                <div class="w-full md:w-auto md:mr-6 flex items-center md:block mb-4 md:mb-0">
                    <span class="icon mr-3 md:mr-0">
                        <img
                            :alt="post.owner.username"
                            width="50"
                            height="50"
                            class="bg-white relative rounded-full"
                            style="max-width: none; max-height: 50px;"
                            :src="post.owner.avatar"
                        />
                    </span>
                    <!-- <div class="inline-block">
                        <span class="font-bold">{{ post.owner.name }}</span>
                        <span class="text-sm text-gray-600">| {{ post.time_ago }}</span>
                    </div>-->
                    <strong class="uppercase md:hidden">{{ post.owner.username }}</strong>

                    <div class="flex md:hidden items-center justify-center ml-auto">
                        <span
                            class="mr-3 inline-flex text-white rounded-full h-6 px-3 justify-center items-center text-xs"
                            :style="`background-color: ${post.chanel.color}`"
                        >{{ post.chanel.title }}s</span>
                        <span class="text-gray-800 text-xs">posted {{ post.time_ago }}</span>
                        <i
                            @click="onEdit(post)"
                            class="fas fa-edit cursor-pointer rounded-md px-2 py-2 m-2 border-1 border-green-400"
                        ></i>
                        <i
                            @click="onDelete(post.id)"
                            class="fas fa-trash-alt cursor-pointer md:hover:bg-red-400 hover:rounded-lg rounded-md px-2 py-2 border border-soild"
                        ></i>
                    </div>
                </div>

                <div class="w-full md:pr-10 lg:pr-0 lg:w-5/6 md:mb-0">
                    <div class="lg:pr-10">
                        <Link
                            :href="route('question.getDetail', post.slug)"
                            class="mb-3 md:mb-1 text-base md:text-lg font-bold md:font-semibold tracking-tight text-gray-900 hover:text-gray-900"
                            style="word-break: break-word;"
                        >
                            {{ post.title }}
                            <span
                                class="hidden md:inline-flex text-white rounded-full h-4 px-3 justify-center items-center text-xs lowercase"
                                :style="`background-color: ${post.chanel.color}`"
                            >{{ post.chanel.title }}</span>
                            <span class="text-gray-800 text-xs font-bold">posted {{ post.time_ago }}</span>
                        </Link>
                        <i
                            @click="onEdit(post)"
                            class="fas fa-edit cursor-pointer md:hover:bg-green-400 hover:rounded-lg rounded-md px-2 py-2 border border-soild"
                        ></i>
                        <i
                            @click="onDelete(post.id)"
                            class="fas fa-trash-alt cursor-pointer md:hover:bg-red-400 hover:rounded-lg rounded-md px-2 py-2 border border-soild"
                        ></i>
                        <div v-if="post.lastReplie" class="text-gray-800 text-xs">
                            <span
                                class="text-blue-600 uppercase font-bold"
                            >{{ post.lastReplie.user.name }}</span>
                            replied
                            <span
                                class="font-bold"
                            >{{ post.lastReplie.time_ago }}</span>
                        </div>
                        <div
                            v-if="post.solved == 1"
                            class="ml-2 inline-flex h-5 items-center rounded-full border border-solid border-blue-500 px-2 text-xs font-medium text-blue-500"
                            style="line-height: 1.1;"
                        >
                            <svg width="8" viewBox="0 0 21 16" class="mr-1 hidden md:block">
                                <path fill="none" d="M-3-5h27v27H-3z" />
                                <path
                                    class="fill-current"
                                    d="M7.439 12.152l-5.037-5.36c-.447-.477-1.119-.477-1.566 0a1.204 1.204 0 0 0 0 1.667l6.603 7.03L20.086 2.025a1.204 1.204 0 0 0 0-1.668c-.447-.476-1.12-.476-1.567 0L7.44 12.152z"
                                    opacity=".5"
                                />
                            </svg>
                            solved
                        </div>
                    </div>
                </div>
                <div
                    class="hidden md:flex md:items-center md:flex-row-reverse text-center md:ml-auto relative"
                    style="top: -10px;"
                >
                    <div class="flex items-center justify-center ml-4">
                        <div class="mr-1">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="15"
                                height="19"
                                viewBox="0 0 15 10"
                                class="relative"
                                style="top: -2px;"
                            >
                                <path
                                    fill="#78909C"
                                    fill-rule="evenodd"
                                    d="M7.5 0C3.344 0 0 2.818 0 6.286c0 1.987 1.094 3.757 2.781 4.914l.117 2.35c.022.438.338.58.704.32l2.023-1.442c.594.144 1.219.18 1.875.18 4.156 0 7.5-2.817 7.5-6.285C15 2.854 11.656 0 7.5 0z"
                                    opacity=".5"
                                />
                            </svg>
                        </div>
                        <span
                            class="text-xs text-gray-800 font-semibold text-left leading-none relative"
                        >{{ post.count_reply }}</span>
                    </div>
                    <div class="flex items-center justify-center">
                        <div class="mr-1">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="19"
                                height="13"
                                viewBox="0 0 19 13"
                            >
                                <g fill="none" fill-rule="evenodd">
                                    <path d="M0-3h19v19H0z" />
                                    <path
                                        fill="#78909C"
                                        d="M9.5.562C5.542.562 2.161 3.025.792 6.5c1.37 3.475 4.75 5.937 8.708 5.937s7.339-2.462 8.708-5.937C16.838 3.025 13.458.562 9.5.562zm0 9.896A3.96 3.96 0 0 1 5.542 6.5 3.96 3.96 0 0 1 9.5 2.542 3.96 3.96 0 0 1 13.458 6.5 3.96 3.96 0 0 1 9.5 10.458zm0-6.333A2.372 2.372 0 0 0 7.125 6.5 2.372 2.372 0 0 0 9.5 8.875 2.372 2.372 0 0 0 11.875 6.5 2.372 2.372 0 0 0 9.5 4.125z"
                                        opacity=".5"
                                    />
                                </g>
                            </svg>
                        </div>
                        <span
                            class="text-xs text-gray-800 font-semibold text-left leading-none"
                        >{{ post.view }}</span>
                    </div>
                </div>
            </div>
        </div>

        <pagination class="mt-6" :links="conversations.meta.links" />
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue'
import Pagination from "@/Components/Pagination";
import LayoutForum from '@/Pages/Forum/Layout'
import UpdateQuestionComponent from '@/Components/Question/UpdateQuestionComponent';
export default {
    layout: LayoutForum,
    props: {
        conversations: Object,
        chanels: Array,
        errors: Object
    },
    components: {
        Pagination,
        Link,
        UpdateQuestionComponent
    },
    methods: {
        onEdit(data) {
            window.ChatterEvents.$emit('EditConversaion', data)
        },
        onDelete(id) {
            if (!confirm("Are you sure want to remove?")) return;
            this.$inertia.delete(
                this.route("admin.conversation.delete", id),
                null,
                {
                    preserveState: true
                }
            );
        }
    }

}
</script>


<style>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
}
.post.body h1 {
    font-size: 2.25rem;
}
.post.body h2 {
    font-size: 2rem;
}
.post.body h3 {
    font-size: 1.75rem;
}
.post.body ul {
    list-style-type: disc !important;
    margin-top: 10px;
    margin-left: 30px;
}
.post.body ol {
    list-style-type: decimal !important;
    margin-top: 10px;
    margin-left: 30px;
}
.post.body blockquote {
    margin-top: 10px;
    margin-left: 30px;
    padding-left: 10px;
    padding-top: 10px;
    padding-bottom: 10px;
    border-left: solid #ccc 4px !important;
}
.fill-current {
    fill: currentColor;
}
</style>