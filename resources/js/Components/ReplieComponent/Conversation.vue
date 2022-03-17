<template>
    <div
        class="forum-comment is-reply relative mb-2 rounded-xl bg-white hover:border hover:border-grey-400 border border-deep-black/4"
    >
        <div class="flex px-6 py-4 lg:p-5">
            <div class="mr-5 hidden text-left md:block">
                <a
                    class="relative flex items-start mb-2"
                    style="width: 64px; height: 64px; padding: 2px;"
                >
                    <img
                        class="relative bg-white ls-is-cached lazyloaded"
                        style="width: 100%; border-radius: 9px;"
                        width="64"
                        height="64"
                        :src="conversation.owner.avatar"
                        alt="`avatar of ${conversation.owner.avatar} on ${conversation.title}`"
                    />
                </a>
            </div>
            <div class="relative flex-1">
                <header class="mb-4 flex items-center justify-between">
                    <div class="md:hidden">
                        <a href class="relative mr-4 block overflow-hidden rounded-lg">
                            <img
                                :src="conversation.owner.avatar"
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
                            >{{ conversation.owner.name }}</a>
                        </div>
                        <div class="mt-2 flex flex-wrap items-center gap-x-2 text-2xs font-medium">
                            <span class="text-sm text-gray-600">
                                <span class="text-sm text-gray-600">Post {{ conversation.time_ago }}</span>
                            </span>
                        </div>
                    </div>
                </header>
                <h1
                    class="mb-2 rounded-xl px-6 py-4 text-2lg font-semibold text-black md:mb-6 bg-blue-100"
                >{{ conversation.title }}</h1>
                <div class="content user-content text-[13px] text-black">
                 
                    <div v-html="conversation.body"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue'
export default {
    props: {
        conversation: Object
    },
    methods:{
    
    }


}
</script>

<style>
</style>