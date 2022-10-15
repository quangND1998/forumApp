<template>
    <div
        @click="onClick"
        class="border border-blue-600  text-blue-500 bg-slate-50 dark:text-gray-200  dark:bg-blue-600 dark:hover:bg-blue-700 hover:bg-blue-200  font-bold py-2 px-4 rounded-full text-center cursor-pointer"
    >New Question</div>
</template>

<script>
import { events } from '../event'

export default {
    methods: {
        onClick() {
            window.ChatterEvents.$emit(events.NEW_DISCUSSION)
        }
    }
}
</script>