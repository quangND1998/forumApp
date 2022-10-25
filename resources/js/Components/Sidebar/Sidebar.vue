<template>
  <nav
    class="nav md:left-0 md:block md:fixed md:top-0 md:bottom-0 md:overflow-y-auto md:flex-row md:flex-nowrap md:overflow-hidden  shadow-xl dark:bg-[#1a263f]  flex flex-wrap items-center justify-between relative md:w-64 z-10 py-4 px-6 bg-blue">
    <div
      class="md:flex-col md:items-stretch md:min-h-full md:flex-nowrap px-0 flex flex-wrap items-center justify-between w-full mx-auto dark:md:text-gray-200 ">
      <!-- Toggler -->
      <button
        class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent dark:text-white"
        type="button" v-on:click="toggleCollapseShow('bg-white m-2 py-3 px-6')">
        <i class="fas fa-bars dark:md:text-gray-200 "></i>
      </button>
      <!-- Brand -->
      <!-- <router-link
        class="md:block text-left md:pb-2 text-blueGray-600 mr-0 inline-block whitespace-nowrap text-sm uppercase font-bold p-4 px-0"
        to="/"
      >
        Vue Notus
      </router-link> -->
      <!-- User -->
      <ul class="md:hidden items-center flex flex-wrap list-none dark:md:text-gray-200 ">
        <li class="inline-block relative">
          <notification-dropdown />
        </li>
        <li class="inline-block relative">
          <user-dropdown />
        </li>
      </ul>
      <!-- Collapse -->
      <div
        class="md:flex md:flex-col md:items-stretch md:opacity-100 md:relative md:mt-4 dark:bg-[#1a263f]  md:shadow-none shadow absolute top-0 left-0 right-0 z-40 overflow-y-auto overflow-x-hidden h-auto items-center flex-1 rounded "
        v-bind:class="collapseShow">
        <!-- Collapse header -->
        <div
          class="md:min-w-full md:hidden block pb-4 mb-4 border-b border-solid border-blueGray-200 dark:md:text-gray-200 ">
          <div class="flex flex-wrap">
            <div class="w-6/12">
              <!-- <router-link
                class="md:block text-left md:pb-2 text-blueGray-600 mr-0 inline-block whitespace-nowrap text-sm uppercase font-bold p-4 px-0"
                to="/"
              >
                Vue Notus
              </router-link> -->
            </div>
            <div class="w-6/12 flex justify-end">
              <button type="button"
                class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent dark:text-white"
                v-on:click="toggleCollapseShow('hidden')">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
        </div>
        <!-- Form -->
        <!-- <form class="mt-6 mb-4 md:hidden">
          <div class="mb-3 pt-0">
            <input type="text" placeholder="Search"
              class="border-0 px-3 py-2 h-12 border border-solid border-blueGray-500 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-base leading-snug shadow-none outline-none focus:outline-none w-full font-normal" />
          </div>
        </form> -->

        <ul class="md:flex-col md:min-w-full flex flex-col list-none">
          <li class="items-center">
            <!-- <router-link
              to="/admin/dashboard"
              v-slot="{ href, navigate, isActive }"
            >
              <a
                :href="href"
                @click="navigate"
                class="text-xs uppercase py-3 font-bold block"
                :class="[
                  isActive
                    ? 'text-emerald-500 hover:text-emerald-600'
                    : 'text-blueGray-700 hover:text-blueGray-500',
                ]"
              >
                <i
                  class="fas fa-tv mr-2 text-sm"
                  :class="[isActive ? 'opacity-75' : 'text-blueGray-300']"
                ></i>
                Dashboard
              </a>
            </router-link> -->
          </li>

          <li class="items-center">
            <!-- <router-link
              to="/admin/settings"
              v-slot="{ href, navigate, isActive }"
            >
              <a
                :href="href"
                @click="navigate"
                class="text-xs uppercase py-3 font-bold block"
                :class="[
                  isActive
                    ? 'text-emerald-500 hover:text-emerald-600'
                    : 'text-blueGray-700 hover:text-blueGray-500',
                ]"
              >
                <i
                  class="fas fa-tools mr-2 text-sm"
                  :class="[isActive ? 'opacity-75' : 'text-blueGray-300']"
                ></i>
                Settings
              </a>
            </router-link> -->
          </li>

          <li class="items-center">
            <!-- <router-link
              to="/admin/tables"
              v-slot="{ href, navigate, isActive }"
            >
              <a
                :href="href"
                @click="navigate"
                class="text-xs uppercase py-3 font-bold block"
                :class="[
                  isActive
                    ? 'text-emerald-500 hover:text-emerald-600'
                    : 'text-blueGray-700 hover:text-blueGray-500',
                ]"
              >
                <i
                  class="fas fa-table mr-2 text-sm"
                  :class="[isActive ? 'opacity-75' : 'text-blueGray-300']"
                ></i>
                Tables
              </a>
            </router-link> -->
          </li>

          <li class="items-center">
            <!-- <router-link to="/admin/maps" v-slot="{ href, navigate, isActive }">
              <a
                :href="href"
                @click="navigate"
                class="text-xs uppercase py-3 font-bold block"
                :class="[
                  isActive
                    ? 'text-emerald-500 hover:text-emerald-600'
                    : 'text-blueGray-700 hover:text-blueGray-500',
                ]"
              >
                <i
                  class="fas fa-map-marked mr-2 text-sm"
                  :class="[isActive ? 'opacity-75' : 'text-blueGray-300']"
                ></i>
                Maps
              </a>
            </router-link> -->
          </li>
        </ul>

        <!-- Divider -->

        <div class="w-full pb-2 mt-12" v-if="$page.props.auth.user !== null">
          <NewQuestionButton v-if="$page.url.startsWith('/forum')"></NewQuestionButton>
          <ReplyButtom v-if="$page.url.startsWith('/question')"></ReplyButtom>
        </div>
        <!-- Heading -->
        <h6  v-if="$page.props.auth.user  == null" 
          class="md:min-w-full text-blueGray-600 dark:text-gray-100  text-xs uppercase font-bold block pt-1 pb-4 no-underline">
          For MissionX Account Only
        </h6>
        <!-- Navigation -->

        <ul v-if="$page.props.auth.user == null" class="md:flex-col md:min-w-full flex flex-col list-none md:mb-4">
          <li class="items-center">
          <Link
            class="text-blueGray-700 dark:text-gray-100 hover:text-blueGray-500 text-xs uppercase py-3 font-bold block"
            :href="route('login')">
          <i class="fas fa-fingerprint text-blueGray-300 mr-2 text-sm"></i>
          Login
          </Link>
          </li>

          <!-- <li class="items-center">
            <Link
              class="text-blueGray-700 dark:text-gray-100 hover:text-blueGray-500 text-xs uppercase py-3 font-bold block"
              :href="route('register')">
            <i class="fas fa-clipboard-list dark:text-gray-100 text-blueGray-300 mr-2 text-sm"></i>
            Register
            </Link>
          </li> -->
        </ul>
        <hr class="my-4 md:min-w-full line-hr" />
        <!-- Heading -->
        <h6
          class="md:min-w-full text-blueGray-500 dark:text-gray-100 text-xs uppercase font-bold block pt-1 pb-4 no-underline">
          Theme
        </h6>
        <button  @click="toggleDarkMode" role="switch" :title="isdark=='dark' ?'Switch to Light Mode?':'Switch to Dark Mode'" >
          <svg   v-if="isdark=='dark'" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
          </svg>
          <svg    v-else  xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
              d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
              clip-rule="evenodd" />
          </svg>
        </button>

        <!-- Divider -->
        <hr class="my-4 md:min-w-full line-hr"/>
        <h6 v-if="hasAnyPermission(['Admin'])"
          class="md:min-w-full text-blueGray-500 dark:text-gray-100 text-xs uppercase font-bold block pt-1 pb-4 no-underline">
          Admin
       
        </h6>
        <!-- <li class="inline-flex" v-if="hasAnyPermission(['Admin'])">
            <Link :class="[$page.component === 'Admin/Permission' ? 'opacity-75 text-blue-300  dark:text-blue-500' : '']"
              :href="route('admin.permissions.index')" target="_blank"
              class="text-blueGray-700 dark:text-gray-100 hover:text-blueGray-400 text-sm block mb-4 no-underline font-semibold">
            <i class="fas fa-shield mr-2  text-blueGray-300  dark:text-gray-100 text-base" :class="[$page.component === 'Admin/Permission' ? 'opacity-75 text-blue-300  dark:text-blue-500' : '']" ></i>
            Permissions
            </Link>
          </li>
          <li class="inline-flex" v-if="hasAnyPermission(['Admin'])">
            <Link :class="[$page.component === 'Admin/Roles' ? 'opacity-75 text-blue-300 dark:text-blue-500' : '']"
              :href="route('admin.roles.index')" target="_blank"
              class="text-blueGray-700 hover:text-blueGray-500 dark:text-gray-100 text-sm block mb-4 no-underline font-semibold">
            <i class="fa-solid fa-circle-check mr-2 text-blueGray-300 dark:text-gray-100 text-base" :class="[$page.component === 'Admin/Roles'  ? 'opacity-75 text-blue-300 dark:text-blue-500' : '']"></i>
            Roles
            </Link>
          </li>
          <li class="inline-flex" v-if="hasAnyPermission(['Admin'])">
            <Link :class="[$page.component === 'Admin/User' ? 'opacity-75 text-blue-300 dark:text-blue-500' : '']"
              :href="route('admin.users.index')" target="_blank"
              class="text-blueGray-700 hover:text-blueGray-500 dark:text-gray-100 text-sm block mb-4 no-underline font-semibold">
            <i class="fas fa-users mr-2 text-blueGray-300 dark:text-gray-100 text-base"  :class="[$page.component === 'Admin/User' ? 'opacity-75 text-blue-300 dark:text-blue-500' : '']"></i>
            Users
            </Link>
          </li> -->

        <hr class="my-4 md:min-w-full line-hr"/>
        <!-- Heading -->
        <h6 
          class="md:min-w-full text-blueGray-500 dark:text-gray-100 text-xs uppercase font-bold block pt-1 pb-4 no-underline">
          Forum
        </h6>
          <li class="inline-flex">
            <Link :class="[$page.url == '/forum' ? 'opacity-75 text-blue-300  dark:text-blue-500' : '']"
              :href="route('forum')" target="_blank"
              class="text-blueGray-700 dark:text-gray-100 hover:text-blueGray-400 text-sm block mb-4 no-underline font-semibold">
            <i class="fas fa-paint-brush mr-2  text-blueGray-300  dark:text-gray-100 text-base" :class="[$page.url == '/forum' ? 'opacity-75 text-blue-300  dark:text-blue-500' : '']" ></i>
            All Thread
            </Link>
          </li>
          <li class="inline-flex">
            <Link :class="[$page.url == '/channels' ? 'opacity-75 text-blue-300 dark:text-blue-500' : '']"
              :href="route('channels')" target="_blank"
              class="text-blueGray-700 hover:text-blueGray-500 dark:text-gray-100 text-sm block mb-4 no-underline font-semibold">
            <i class="fas fa-paint-brush mr-2 text-blueGray-300 dark:text-gray-100 text-base" :class="[$page.url == '/channels' ? 'opacity-75 text-blue-300 dark:text-blue-500' : '']"></i>
            Channels
            </Link>
          </li>
          <li class="inline-flex" v-if="hasAnyPermission(['Admin'])">
            <Link :class="[$page.url == '/admin/channels' ? 'opacity-75 text-blue-300 dark:text-blue-500' : '']"
              :href="route('admin.channels.index')" target="_blank"
              class="text-blueGray-700 hover:text-blueGray-500 dark:text-gray-100 text-sm block mb-4 no-underline font-semibold">
            <i class="fas fa-paint-brush mr-2 text-blueGray-300 dark:text-gray-100 text-base"  :class="[$page.url == '/admin/channels' ? 'opacity-75 text-blue-300 dark:text-blue-500' : '']"></i>
            Manager Channels
            </Link>
          </li>
          <li class="inline-flex">
            <Link
              :class="[$page.url.startsWith('/forum?answered=1') ? 'opacity-75 text-blue-300 dark:text-blue-500' : '']"
              href="/forum?answered=1" target="_blank"
              class="text-blueGray-700 hover:text-blueGray-500 dark:text-gray-100 text-sm block mb-4 no-underline font-semibold">
            <i class="far fa-check-circle mr-2 text-blueGray-300 dark:text-gray-100 text-base" :class="[$page.url == '/forum?answered=1' ? 'opacity-75 text-blue-300 dark:text-blue-500' : '']"></i>
            Solved
            </Link>
          </li>
          <li class="inline-flex">
            <Link href="/forum?answered=0"
              :class="[$page.url.startsWith('/forum?answered=0') ? 'opacity-75 text-blue-300 dark:text-blue-500' : '']"
              target="_blank"
              class="text-blueGray-700 hover:text-blueGray-500 dark:text-gray-100 text-sm block mb-4 no-underline font-semibold">
            <i class="far fa-times-circle mr-2 text-blueGray-300 dark:text-gray-100 text-base" :class="[$page.url == '/forum?answered=0' ? 'opacity-75 text-blue-300 dark:text-blue-500' : '']"></i>
            Unsolved
            </Link>
          </li>
          <li class="inline-flex" >

            <Link  href="/forum?trending=1"
              :class="[$page.url.startsWith('/forum?trending=1') ? 'opacity-75 text-blue-300 dark:text-blue-500' : '']"
              target="_blank"
              class="text-blueGray-700 hover:text-blueGray-500 dark:text-gray-100 text-sm block mb-4 no-underline font-semibold">
            <i class="fa-solid fa-arrow-trend-up mr-2 text-blueGray-300 dark:text-gray-100 text-base"  :class="[$page.url.startsWith('/forum?trending=1') ? 'opacity-75 text-blue-300 dark:text-blue-500' : '']"></i>
            Popular This Week
            </Link>
            </li>

          <li class="inline-flex" >

            <Link  href="/forum?popular=1"
              :class="[$page.url.startsWith('/forum?popular=1') ? 'opacity-75 text-blue-300 dark:text-blue-500' : '']"
              target="_blank"
              class="text-blueGray-700 hover:text-blueGray-500 dark:text-gray-100 text-sm block mb-4 no-underline font-semibold">
            <i class="fa-solid fa-arrow-trend-up mr-2 text-blueGray-300 dark:text-gray-100 text-base"  :class="[$page.url.startsWith('/forum?popular=1') ? 'opacity-75 text-blue-300 dark:text-blue-500' : '']"></i>
            Popular All Time
            </Link>
          </li>

          <li class="inline-flex" v-if="$page.props.auth.user">
            <Link :href="route('myThread')"
              :class="[$page.url.startsWith('/myThread') ? 'opacity-75 text-blue-300 dark:text-blue-500' : '']"
              target="_blank"
              class="text-blueGray-700 hover:text-blueGray-500 dark:text-gray-100 text-sm block mb-4 no-underline font-semibold">
            <i class="far fa-question-circle mr-2 text-blueGray-300 dark:text-gray-100 text-base"  :class="[$page.url.startsWith('/myThread') ? 'opacity-75 text-blue-300 dark:text-blue-500' : '']"></i>
            My Question
            </Link>
          </li>
          <!-- <li class="inline-flex" v-if="$page.props.auth.user">

            <Link :href="route('admin.session.zoom')"
              :class="[$page.url.startsWith('/admin/session') ? 'opacity-75 text-blue-300' : '']"
              class="text-blueGray-700 hover:text-blueGray-500 text-sm block mb-4 no-underline font-semibold">
            <i class="fas fa-vr-cardboard mr-2  text-base"></i>
            Session
            </Link>
          </li>
          <li class="inline-flex" v-if="$page.props.auth.user">

            <Link :href="route('admin.device.index')"
              :class="[$page.url.startsWith('/admin/device') ? 'opacity-75 text-blue-300' : '']"
              class="text-blueGray-700 hover:text-blueGray-500 text-sm block mb-4 no-underline font-semibold">
            <i class="fas fa-vr-cardboard mr-2  text-base"></i>
            Devices
            </Link>
          </li> -->



          <!-- <li class="inline-flex">
            <a
              href="https://www.creative-tim.com/learning-lab/tailwind/vue/alerts/notus"
              target="_blank"
              class="text-blueGray-700 hover:text-blueGray-500 text-sm block mb-4 no-underline font-semibold"
            >
              <i class="fab fa-css3-alt mr-2 text-blueGray-300 text-base"></i>
              CSS Components
            </a>
          </li>

          <li class="inline-flex">
            <a
              href="https://www.creative-tim.com/learning-lab/tailwind/angular/overview/notus"
              target="_blank"
              class="text-blueGray-700 hover:text-blueGray-500 text-sm block mb-4 no-underline font-semibold"
            >
              <i class="fab fa-angular mr-2 text-blueGray-300 text-base"></i>
              Angular
            </a>
          </li>

          <li class="inline-flex">
            <a
              href="https://www.creative-tim.com/learning-lab/tailwind/js/overview/notus"
              target="_blank"
              class="text-blueGray-700 hover:text-blueGray-500 text-sm block mb-4 no-underline font-semibold"
            >
              <i class="fab fa-js-square mr-2 text-blueGray-300 text-base"></i>
              Javascript
            </a>
          </li>

          <li class="inline-flex">
            <a
              href="https://www.creative-tim.com/learning-lab/tailwind/nextjs/overview/notus"
              target="_blank"
              class="text-blueGray-700 hover:text-blueGray-500 text-sm block mb-4 no-underline font-semibold"
            >
              <i class="fab fa-react mr-2 text-blueGray-300 text-base"></i>
              NextJS
            </a>
          </li>

          <li class="inline-flex">
            <a
              href="https://www.creative-tim.com/learning-lab/tailwind/react/overview/notus"
              target="_blank"
              class="text-blueGray-700 hover:text-blueGray-500 text-sm block mb-4 no-underline font-semibold"
            >
              <i class="fab fa-react mr-2 text-blueGray-300 text-base"></i>
              React
            </a>
          </li>

          <li class="inline-flex">
            <a
              href="https://www.creative-tim.com/learning-lab/tailwind/svelte/overview/notus"
              target="_blank"
              class="text-blueGray-700 hover:text-blueGray-500 text-sm block mb-4 no-underline font-semibold"
            >
              <i class="fas fa-link mr-2 text-blueGray-300 text-base"></i>
              Svelte
            </a>
          </li>

          <li class="inline-flex">
            <a
              href="https://www.creative-tim.com/learning-lab/tailwind/vue/overview/notus"
              target="_blank"
              class="text-blueGray-700 hover:text-blueGray-500 text-sm block mb-4 no-underline font-semibold"
            >
              <i class="fab fa-vuejs mr-2 text-blueGray-300 text-base"></i>
              VueJS
            </a>
          </li> -->
        </ul>
      </div>
    </div>
  </nav>
</template>


<script>
import NotificationDropdown from "@/Components/Dropdowns/NotificationDropdown.vue";
import UserDropdown from "@/Components/Dropdowns/UserDropdown.vue";
import { Link } from "@inertiajs/inertia-vue";
import NewQuestionButton from '@/Components/NewQuestionButton'
import ReplyButtom from "@/Components/ReplieComponent/ReplyButtom";
import Icon from "@/Components/Icon";
export default {
  data() {
    return {
      collapseShow: "hidden",
      isdark:true
    };
  },
  mounted(){

    if (localStorage.isdark === undefined) {
      localStorage.isdark = 'dark';
      this.isdark= 'dark';
    } else {

      this.isdark =localStorage.isdark
    }
  },
  methods: {
    toggleCollapseShow: function (classes) {
      this.collapseShow = classes;
    },
    toggleDarkMode(){
      if(this.isdark == 'dark'){
        this.isdark= 'light'
      }
      else{
        this.isdark= 'dark'
      }
      localStorage.isdark = this.isdark;
      // console.log(this.isdark);
      window.ChatterEvents.$emit('changeMode',this.isdark)
    }
  },
  components: {
    NotificationDropdown,
    UserDropdown,
    Link,
    NewQuestionButton,
    ReplyButtom,
    Icon
  },

};
</script>
