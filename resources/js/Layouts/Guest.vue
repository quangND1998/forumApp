<template>
  <div :class="isdark =='dark'? 'dark':''"
    class="min-h-screen  flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100  dark:bg-slate-600"
  >
    <!-- <div>
            <Link href="/">
                <breeze-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </Link>
    </div>-->

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg dark:bg-slate-600 ">
      <slot />
    </div>
  </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue";

import BreezeApplicationLogo from "@/Components/ApplicationLogo";

export default {
  components: {
    BreezeApplicationLogo,
    Link
  },
  data(){
        return{
            isdark:'dark'
        }
    } ,
  mounted() {

    if (localStorage.isdark === undefined) {

        localStorage.isdark = 'dark';

    } else {
        this.isdark =localStorage.isdark
    }
    // console.log(this.isdark)
    window.ChatterEvents.$on('changeMode',e=>{
        // console.log('changeMode',e)
        this.isdark= e
        localStorage.isdark = e;
    })

},
};
</script>
