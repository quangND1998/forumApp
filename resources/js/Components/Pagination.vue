<template>
  <div v-if="links.length > 3">
    <div class="flex flex-wrap justify-center gap-x-2">
      <div v-for="(link, k) in links" :key="k">
        <div
          v-if="link.url === null"
          class="leading-4 flex items-center h-8  opacity-25 rounded-full border  border-gray-700 dark:border-blue-400 text-gray-700 dark:text-white  p-4 text-2xs font-semibold  cursor-not-allowed "
          v-html="link.label"
        />
        <Link
          v-else
          class="leading-4 flex h-8 items-center justify-center shadow-md border border-transparent rounded-xl bg-gray-200  dark:bg-[#19273f] dark:hover:border-blue-500 p-4 text-2xs font-semibold text-gray-700 dark:text-white md:p-2  md:flex hover:border-blue-500 focus:border-blue focus:text-blue"
          :class="{ 'bg-blue-700 text-white border-blue-500': link.active }"
          :href="link.url"
          v-html="link.label" 
        />
      </div>
    </div>
  </div>
</template>
  
<script>
import { Link } from '@inertiajs/inertia-vue'
export default {
  components:{
    Link
  },
  props: {
    links: Array
  }
};
</script> 