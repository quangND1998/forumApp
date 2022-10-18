<template>
    <Link
        :href="route('conversation.create')"
        class="border border-blue-600 h-full w-full object-fill text-blue-500 bg-slate-50 dark:text-gray-200  dark:bg-blue-600 dark:hover:bg-blue-700 hover:bg-blue-200  font-bold py-2 px-4 rounded-full text-center cursor-pointer"
    >New Question</Link>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue";
export default {
    components:{
        Link
    },
  
}
</script>