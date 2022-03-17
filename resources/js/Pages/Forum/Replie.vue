<template>
    <transition name="fade" class="flex flex-wrap p-4 pb-0 w-full">
        <div>
            <Conversation :conversation="conversation"></Conversation>
            <div
                v-for="replie in initalReplies"
                :key="replie.id"
                class="flex flex-wrap md:py-2 mt-1 ml-8"
            >
                <div
                    class="forum-comment w-full is-reply relative mb-2 rounded-xl bg-white hover:border hover:border-grey-400 border border-deep-black/4"
                >
                    <div class="flex px-6 py-4 lg:p-5">
                        <div class="mr-5 hidden text-left md:block">
                            <a
                                class="relative flex items-start mb-2"
                                style="width: 32px; height: 32px; padding: 2px;"
                            >
                                <img
                                    class="relative bg-white ls-is-cached lazyloaded"
                                    style="width: 100%; border-radius: 9px;"
                                    width="32"
                                    height="32"
                                    :src="replie.owner.avatar"
                                    :alt="`avatar of ${replie.owner.avatar} on ${replie.title}`"
                                />
                            </a>
                        </div>
                        <div class="relative flex-1">
                            <header class="mb-4 flex items-center justify-between">
                                <div class="md:hidden">
                                    <a href class="relative mr-4 block overflow-hidden rounded-lg">
                                        <img
                                            :src="replie.owner.avatar"
                                            alt="`avatar of ${conversation.owner.avatar} on ${conversation.title}`"
                                            class="lazyload is-circle w-8 bg-white md:w-18"
                                            style="border-radius: 9px;"
                                        />
                                    </a>
                                </div>
                                <div class="flex-1 text-left leading-none">
                                    <div class="flex items-center">
                                        <a
                                            class="font-lg mr-2 block font-bold text-black"
                                        >{{ replie.owner.name }}</a>
                                    </div>
                                    <div
                                        class="mt-2 flex flex-wrap items-center gap-x-2 text-2xs font-medium"
                                    >
                                        <span class="text-sm text-gray-600">
                                            <span
                                                class="text-sm text-gray-600"
                                            >Post {{ replie.time_ago }}</span>
                                        </span>
                                    </div>
                                </div>
                            </header>
                            <div class="content user-content text-[13px] text-black">
                                <div v-html="replie.body"></div>
                            </div>
                            <LikeReplyButton
                                :replie="replie"
                                :comment="replie"
                                :conversation="conversation"
                            ></LikeReplyButton>
                            <!-- <div
                                class="forum-comment-edit-links relative mt-4 -mb-1 flex justify-end gap-x-2 md:leading-none lg:justify-start justify-start"
                                style="height: 34px;"
                            >
                                <button
                                    class="inline-flex items-center border border-solid border-deep-black/3 bg-grey-200 px-3 font-medium transition-all hover:border-deep-black/10 hover:bg-grey-300 mobile:flex mobile:items-center mobile:p-2 mobile:text-sm md:text-xs reply-likes mobile:text-sm has-none border-deep-black/3 bg-grey-200 mr-auto md:mr-0"
                                >
                                    <svg
                                        width="17"
                                        height="16"
                                        viewBox="0 0 14 13"
                                        class="cursor-pointer fill-current text-gray-300"
                                    >
                                        <path
                                            fill-rule="nonzero"
                                            d="M13.59 1.778c-.453-.864-3.295-3.755-6.59.431C3.54-1.977.862.914.41 1.778c-.825 1.596-.33 4.014.823 5.18L7.001 13l5.767-6.043c1.152-1.165 1.647-3.582.823-5.18z"
                                        />
                                    </svg>
                                </button>
                                <div class="flex">
                                    <a
                                        class="inline-flex items-center border border-solid border-deep-black/3 bg-grey-200 px-3 font-medium transition-all hover:border-deep-black/10 hover:bg-grey-300 mobile:flex mobile:items-center mobile:p-2 mobile:text-sm md:text-xs mr-2 text-grey-800"
                                    >
                                        <svg
                                            width="12"
                                            height="13"
                                            viewBox="0 0 12 13"
                                            class="mr-1 lg:hidden"
                                        >
                                            <path
                                                fill="#78909C"
                                                stroke="#78909C"
                                                stroke-width=".5"
                                                fill-rule="evenodd"
                                                d="M6.96 1.877L4.34.542l.435 1.413a5.196 5.196 0 0 0-3.161 2.64C.32 7.133 1.267 10.2 3.73 11.455s5.5.218 6.794-2.32a5.203 5.203 0 0 0 .316-3.989l-1.145.369c.338.955.29 2.087-.22 3.086-.99 1.944-3.308 2.735-5.194 1.774-1.887-.962-2.61-3.302-1.619-5.246a4.085 4.085 0 0 1 2.461-2.045l.46 1.493 1.377-2.7z"
                                            />
                                        </svg>
                                        Reply
                                    </a>
                                </div>
                            </div>-->
                        </div>
                    </div>
                </div>
                <div
                    v-for="re_reply in replie.replies"
                    :key="re_reply.id"
                    class="flex flex-wrap md:py-2 mt-1 ml-8 w-full"
                >
                    <div
                        class="forum-comment w-full is-reply relative mb-2 rounded-xl bg-white hover:border hover:border-grey-400 border border-deep-black/4"
                    >
                        <div class="flex px-6 py-4 lg:p-5">
                            <div class="mr-5 hidden text-left md:block">
                                <a
                                    class="relative flex items-start mb-2"
                                    style="width: 32px; height: 32px; padding: 2px;"
                                >
                                    <img
                                        class="relative bg-white ls-is-cached lazyloaded"
                                        style="width: 100%; border-radius: 9px;"
                                        width="32"
                                        height="32"
                                        :src="re_reply.owner.avatar"
                                        :alt="`avatar of ${re_reply.owner.avatar} on ${re_reply.title}`"
                                    />
                                </a>
                            </div>
                            <div class="relative flex-1">
                                <header class="mb-4 flex items-center justify-between">
                                    <div class="md:hidden">
                                        <a
                                            href
                                            class="relative mr-4 block overflow-hidden rounded-lg"
                                        >
                                            <img
                                                :src="re_reply.owner.avatar"
                                                alt="`avatar of ${conversation.owner.avatar} on ${conversation.title}`"
                                                class="lazyload is-circle w-8 bg-white md:w-18"
                                                style="border-radius: 9px;"
                                            />
                                        </a>
                                    </div>
                                    <div class="flex-1 text-left leading-none">
                                        <div class="flex items-center">
                                            <a
                                                class="font-lg mr-2 block font-bold text-black"
                                            >{{ re_reply.owner.name }}</a>
                                        </div>
                                        <div
                                            class="mt-2 flex flex-wrap items-center gap-x-2 text-2xs font-medium"
                                        >
                                            <span class="text-sm text-gray-600">
                                                <span
                                                    class="text-sm text-gray-600"
                                                >Post {{ re_reply.time_ago }}</span>
                                            </span>
                                        </div>
                                    </div>
                                </header>
                                <div class="content user-content text-[13px] text-black">
                                    <p>{{ re_reply.body }}</p>
                                    <div v-html="re_reply.body_in_markdown"></div>
                                </div>
                                <LikeReplyButton
                                    :replie="replie"
                                    :comment="re_reply"
                                    :conversation="conversation"
                                ></LikeReplyButton>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <NewReplieComponent :conversation="conversation" :initalReplies="initalReplies"></NewReplieComponent>
        </div>
    </transition>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue'
import Conversation from '@/Components/ReplieComponent/Conversation'
import LayoutForum from '@/Pages/Forum/Layout'
import NewReplieComponent from '@/Components/ReplieComponent/NewReplieComponent'
import LikeReplyButton from '@/Components/ReplieComponent/LikeReplyButton'
export default {
    layout: LayoutForum,
    props: {
        conversation: Object,
        initalReplies: Array,
        errors: Object
    },
    components: {
        Link,
        Conversation,
        NewReplieComponent,
        LikeReplyButton
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
@media (min-width: 992px) {
}
.forum-comment .show-on-hover {
    visibility: hidden;
}

@media (min-width: 768px) {
}
.md\:text-xs {
    font-size: 0.834rem;
}
.hover\:border-grey-400:hover {
    --tw-border-opacity: 1;
    border-color: rgb(235 237 241 / var(--tw-border-opacity));
}
</style>