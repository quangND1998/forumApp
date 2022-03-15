<template>
    <transition name="fade" class="flex flex-wrap p-4 pb-0">
        <div>
            <Conversation :conversation="conversation"></Conversation>

            <!-- <div
                v-for="replie in initalReplies"
                :key="replie.id"
                class="flex flex-wrap md:py-2 mt-8 ml-8"
            >
                <div class="w-full">
                    <div class="flex items-center">
                        <a>
                            <img
                                class="w-12 h-12 rounded-full inline-block mr-2"
                                :src="replie.owner.avatar"
                                :alt="`vatar of ${replie.owner.name} on ${replie.title}`"
                            />
                        </a>
                        <div class="inline-block">
                            <span class="font-bold">{{ replie.owner.name }}</span>
                            <span class="text-sm text-gray-600">| {{ replie.time_ago }}</span>
                        </div>
                    </div>

                    <div
                        class="post body w-full text-lg text-gray-800 leading-relaxed mt-4"
                    >{{ replie.body }}</div>

                 
                </div>
                <div
                    v-for="re_reply in replie.replies"
                    :key="re_reply.id"
                    class="flex flex-wrap md:py-2 mt-8 ml-8"
                >
                    <div class="w-full">
                        <div class="flex items-center">
                            <a>
                                <img
                                    class="w-12 h-12 rounded-full inline-block mr-2"
                                    :src="re_reply.owner.avatar"
                                    :alt="`vatar of ${re_reply.owner.name} on ${re_reply.title}`"
                                />
                            </a>
                            <div class="inline-block">
                                <span class="font-bold">{{ re_reply.owner.name }}</span>
                                <span class="text-sm text-gray-600">| {{ re_reply.time_ago }}</span>
                            </div>
                        </div>

                        <div
                            class="post body w-full text-lg text-gray-800 leading-relaxed mt-4"
                        >{{ re_reply.body }}</div>

                    
                    </div>
                    <div class="w-full border-t mt-4 mb-2"></div>
                </div>
            </div>-->
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
                                style="width: 72px; height: 72px; padding: 2px;"
                            >
                                <img
                                    class="relative bg-white ls-is-cached lazyloaded"
                                    style="width: 100%; border-radius: 9px;"
                                    width="72"
                                    height="72"
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
                                <divc class="flex-1 text-left leading-none">
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
                                </divc>
                            </header>
                            <div class="content user-content text-[13px] text-black">
                                <p>{{ replie.body }}</p>
                                <div v-html="replie.body_in_markdown"></div>
                            </div>
                        </div>
                    </div>
                </div>
                 <div
                v-for="re_reply in replie.replies"
                :key="re_reply.id"
                class="flex flex-wrap md:py-2 mt-1 ml-8"
            >
                <div
                    class="forum-comment w-full is-reply relative mb-2 rounded-xl bg-white hover:border hover:border-grey-400 border border-deep-black/4"
                >
                    <div class="flex px-6 py-4 lg:p-5">
                        <div class="mr-5 hidden text-left md:block">
                            <a
                                class="relative flex items-start mb-2"
                                style="width: 72px; height: 72px; padding: 2px;"
                            >
                                <img
                                    class="relative bg-white ls-is-cached lazyloaded"
                                    style="width: 100%; border-radius: 9px;"
                                    width="72"
                                    height="72"
                                    :src="re_reply.owner.avatar"
                                    :alt="`avatar of ${re_reply.owner.avatar} on ${re_reply.title}`"
                                />
                            </a>
                        </div>
                        <div class="relative flex-1">
                            <header class="mb-4 flex items-center justify-between">
                                <div class="md:hidden">
                                    <a href class="relative mr-4 block overflow-hidden rounded-lg">
                                        <img
                                            :src="re_reply.owner.avatar"
                                            alt="`avatar of ${conversation.owner.avatar} on ${conversation.title}`"
                                            class="lazyload is-circle w-8 bg-white md:w-18"
                                            style="border-radius: 9px;"
                                        />
                                    </a>
                                </div>
                                <divc class="flex-1 text-left leading-none">
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
                                </divc>
                            </header>
                            <div class="content user-content text-[13px] text-black">
                                <p>{{ re_reply.body }}</p>
                                <div v-html="re_reply.body_in_markdown"></div>
                            </div>
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
import { Link } from '@inertiajs/inertia-vue'
import Conversation from '@/Components/ReplieComponent/Conversation'
import LayoutForum from '@/Pages/Forum/Layout'
export default {
    layout: LayoutForum,
    props: {
        conversation: Object,
        initalReplies: Array
    },
    components: {
        Link,
        Conversation
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
</style>