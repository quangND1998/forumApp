<template>
    <div :class="isdark =='dark'? 'dark':''"  >

        <sidebar />
        <div class="relative md:ml-64 bg-gray-100 dark:bg-theme-black bg-height">
            <admin-navbar />
            <header-stats />
            <div class="flex-1 overflow-hidden  px-4 py-8 md:p-4 overflow-y-auto" scroll-region>
                      <slot />
                <NewQuestionComponent :chanels="chanels" :errors="errors"></NewQuestionComponent>
            </div>
        </div>

    </div>
</template>
<script>

import AdminNavbar from "@/Components/Navbars/AdminNavbar.vue";
import Sidebar from "@/Components/Sidebar/Sidebar.vue";
import HeaderStats from "@/Components/Headers/HeaderStats.vue";
import FooterAdmin from "@/Components/Footers/FooterAdmin.vue";
import NewQuestionComponent from "@/Components/Question/NewQuestionComponent"


export default {
    name: "admin-layout",
    props: {
        chanels: Array,
        errors: Object
    },
    data(){
        return{
            isdark:'dark'
        }
    } ,
    components: {
        AdminNavbar,
        Sidebar,
        HeaderStats,
        FooterAdmin,
        NewQuestionComponent

    },
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
<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.75s;
}

.fade-enter,
.fade-leave-to

/* .fade-leave-active below version 2.1.8 */
  {
  opacity: 0;
}
.section,
section {
    margin-left: auto;
    margin-right: auto;
    max-width: 1700px;
    padding: 20px;
    position: relative;
}
.bg-height{
    min-height: 100%;
 }
</style>
