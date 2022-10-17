<template>
    <div class=" mx-auto w-full md:flex-2 xl:max-w-[1024px]">
        <div class="dark:text-gray-700">
            <section class="p-0">
                <h1 class="mb-6 text-xl font-bold dark:text-white"> Most Poppular Channels</h1>
                <div class="grid gap-4 md:grid-cols-3" >
                    <div v-for="(channel,index) in channels.slice(0,3)" :key="index" class="panel relative transition-colors shadow-lg duration-300 bg-white hover:bg-gray-300 dark:bg-coolGray-700 dark:text-white bg-panel-800 dark:hover:bg-coolGray-800  rounded-2xl group flex flex-col justify-between py-6 px-6" style="height: 250px;">
                        <header>
                            <div class="flex items-end justify-between">
                                <h2 class="flex items-center text-xl leading-none dark:text-white">
                                    <span  class="mr-3 inline-block h-5 rounded-xl" style="width: 9px;"     :style="`background-color: ${channel.color}; `"></span>
                                    <Link :href="`/forum?category=${channel.slug}`">
                                        <span class="absolute inset-0 rounded-3xl">

                                        </span>
                                    {{channel.title}} </Link>
                                </h2>
                                <span class="font-cabin text-xs dark:text-grey-600">
                                    {{formatNumber(channel.conversations_count)}} conversations
                                </span> 
                            </div>
                            <p class="clamp two-lines mt-6 text-xs dark:text-grey-100">
                                {{channel.description}}
                            </p>
                        </header>
                        <div class="panel relative transition-colors duration-300  text-gray-700 px-5 rounded-2xl bg-gray-200 dark:text-white dark:bg-gray-500 dark:group-hover:bg-gray-600 py-3 group-hover:hover:bg-grey-500 dark:group-hover:hover:bg-panel-500" style="height: 105px;">
                            <div v-if="channel.last_conversation" class="flex items-center gap-x-2">
                                <img :src="channel.last_conversation.owner.avatar" alt="" class="w-6 rounded-lg">
                                <div class="flex w-full justify-between text-2xs">
                                    <p class="font-poppins font-semibold tracking-tight text-xs">
                                        <Link :href="route('question.getDetail', channel.last_conversation.slug)" class="text-blue-700 hover:underline  ">
                                            <span class="absolute inset-0 rounded-2xl">
                                            </span>
                                            {{channel.last_conversation.owner.name}}
                                        </Link>
                                        posted... 
                                    </p>
                                    <span class="dark:text-grey-600 text-xs">
                                        {{channel.last_conversation.time_ago}}
                                    </span>
                                </div>
                            </div>
                            <div class="clamp three-lines mt-2 text-gray-700 text-[11px] dark:font-medium dark:text-gray-100 object-fill" style="word-break: break-word;" v-html="channel.last_conversation.sub_body">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div class="dark:text-gray-700">
            <section class="p-0">
                <h1 class="mb-6 text-xl font-bold dark:text-white"> More Channels</h1>
                <div class="grid gap-4 md:grid-cols-3" >
                    <div v-for="(channel,index) in channels.slice(3,channels.length)" :key="index" class="panel relative transition-colors  shadow-lg duration-300 bg-white hover:bg-gray-300 dark:bg-coolGray-700 dark:text-white bg-panel-800 dark:hover:bg-coolGray-800  rounded-2xl group flex flex-col justify-between py-6 px-6" style="height: 250px;">
                        <header >
                            <div class="flex items-end justify-between">
                                <h2 class="flex items-center text-xl leading-none dark:text-white">
                                    <span  class="mr-3 inline-block h-5 rounded-xl" style="width: 9px;"     :style="`background-color: ${channel.color}; `"></span>
                                    <Link :href="`/forum?category=${channel.slug}`">
                                        <span class="absolute inset-0 rounded-3xl">

                                        </span>
                                    {{channel.title}} </Link>
                                </h2>
                                <span class="font-cabin text-xs dark:text-grey-600">
                                    {{formatNumber(channel.conversations_count)}} conversations
                                </span> 
                            </div>
                            <p class="clamp two-lines mt-6 text-xs dark:text-grey-100">
                               {{channel.description}}
                            </p>
                        </header>
                        <div v-if="channel.last_conversation" class="panel relative transition-colors duration-300  text-gray-800 px-5 rounded-2xl bg-gray-200 dark:text-white dark:bg-gray-500 dark:group-hover:bg-gray-600 py-3 group-hover:hover:bg-grey-500 dark:group-hover:hover:bg-panel-500" style="height: 105px;">
                            <div class="flex items-center gap-x-2">
                                <img :src="channel.last_conversation.owner.avatar" alt="" class="w-6 rounded-lg">
                                <div class="flex w-full justify-between text-2xs">
                                    <p class="font-poppins font-semibold tracking-tight text-xs">
                                        <Link :href="route('question.getDetail', channel.last_conversation.slug)" class="text-blue-700 hover:underline">
                                            <span class="absolute inset-0 rounded-2xl">
                                            </span>
                                            {{channel.last_conversation.owner.name}}
                                        </Link>
                                        posted... 
                                    </p>
                                    <span class="dark:text-grey-600 text-xs">
                                        {{channel.last_conversation.time_ago}}
                                    </span>
                                </div>
                            </div>
                            <div class="clamp three-lines mt-2 text-[11px] text-gray-800 dark:font-medium dark:text-gray-100 crop-content"  v-html="channel.last_conversation.sub_body">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</template>

<script>
import Notification from "@/Components/Notification";
import { Link } from '@inertiajs/inertia-vue'
import LayoutForum from '@/Pages/Forum/Layout'
import $ from 'jquery'
export default {
    layout: LayoutForum,
    components: {
        Link,
        Notification
    },
    props: {
        channels: Array,
        errors: Object

    },
}
</script>

<style>
.crop-content {
  max-width: 120px;
  overflow-x: auto;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.three-lines {
    -webkit-line-clamp: 3;
}
.clamp {
    -webkit-box-orient: vertical;
    display: -webkit-box;
    overflow: hidden;
}
.two-lines {
    -webkit-line-clamp: 2;
}
</style>