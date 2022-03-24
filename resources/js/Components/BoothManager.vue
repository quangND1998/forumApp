<template>
  <div>
    <portal-target name="dropdown" slim />
    <div class="flex flex-col">
      <div class="h-screen flex flex-col" @click="hideDropdownMenus">
        <div class="md:flex">
          <div
            class="bg-indigo-900 md:flex-shrink-0 md:w-56 px-6 py-4 flex items-center justify-between md:justify-center"
          >
            <Link class="mt-1" href="/dashboard">
              <logo class="fill-white" width="120" height="28" />
            </Link>
            <dropdown class="md:hidden" placement="bottom-end">
              <svg
                class="fill-white w-6 h-6"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
              >
                <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
              </svg>
              <div slot="dropdown" class="mt-2 px-8 py-4 shadow-lg bg-indigo-800 rounded">
                <main-menu :url="url()" />
              </div>
            </dropdown>
          </div>
          <div
            class="bg-white border-b w-full p-4 md:py-0 md:px-12 text-sm md:text-md flex justify-start items-center"
          >
            <div class="mt-1 mr-auto">
              <div class="avatar-sm float-left mr-2">
                <img src="asset/img/profile.jpg" alt="..." class="avatar-img rounded-circle" />
              </div>
              <div class="info">
                <Link :href="route('admin.profile.index')">{{ $page.props.auth.user.name }}</Link>
              </div>
            </div>
            <language-selector></language-selector>
          </div>
        </div>
        <div class="flex flex-grow overflow-hidden">
          <main-menu
            :url="url()"
            class="bg-indigo-800 flex-shrink-0 w-56 p-12 hidden md:block overflow-y-auto"
          />

          <div class="w-full overflow-y-auto">
            <ul class="flex mb-0 list-none flex-wrap pt-3 pb-4 flex-row">
              <li
                class="-mb-px mr-2 last:mr-0 flex-auto text-center"
                v-if="
                  hasAnyPermission([
                    'users_manage',
                    'create_virtual',
                    'create_booth',
                    'manager_booth',
                    'manager_event',
                  ])
                "
              >
                <Link
                  :href="route('booth.info', data.id)"
                  class="btn text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal"
                  v-on:click="toggleTabs('info')"
                  v-bind:class="{
                    'text-gray-600 bg-white': openTab !== 'info',
                    'text-white bg-gray-600': openTab === 'info',
                  }"
                >
                  <i class="fas fa-info text-base mr-1"></i>
                  {{ __("company_info") }}
                </Link>
              </li>
              <li
                class="-mb-px mr-2 last:mr-0 flex-auto text-center"
                v-if="hasAnyPermission(['users_manage',
                'create_virtual',
                'create_booth',
                'manager_booth',
                'manager_event',])"
              >
                <Link
                  :href="route('booth.indexBooth', data.id)"
                  class="btn text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal"
                  v-on:click="toggleTabs('booth-setting')"
                  v-bind:class="{
                    'text-gray-600 bg-white': openTab !== 'booth-setting',
                    'text-white bg-gray-600': openTab === 'booth-setting',
                  }"
                >
                  <i class="fas fa-images text-base mr-1"></i>
                  {{ __("booth-setting") }}
                </Link>
              </li>

              <li
                class="-mb-px mr-2 last:mr-0 flex-auto text-center"
                v-if="hasAnyPermission(['users_manage',
                'create_virtual',
                'create_booth',
                'manager_booth',
                'manager_event',])"
              >
                <Link
                  :href="route('booth.image_inside', data.id)"
                  class="btn text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal"
                  v-on:click="toggleTabs('image_inside')"
                  v-bind:class="{
                    'text-gray-600 bg-white': openTab !== 'image_inside',
                    'text-white bg-gray-600': openTab === 'image_inside',
                  }"
                >
                  <i class="fas fa-images text-base mr-1"></i>
                  {{ __("image_inside") }}
                </Link>
              </li>

              <li
                class="-mb-px mr-2 last:mr-0 flex-auto text-center"
                v-if="
                  hasAnyPermission([
                    'users_manage',
                    'create_virtual',
                    'create_booth',
                    'manager_booth',
                    'manager_event',
                  ])
                "
              >
                <Link
                  :href="route('booth.videos', data.id)"
                  class="btn text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal"
                  v-on:click="toggleTabs('videos')"
                  v-bind:class="{
                    'text-gray-600 bg-white': openTab !== 'videos',
                    'text-white bg-gray-600': openTab === 'videos',
                  }"
                >
                  <i class="fab fa-youtube text-base mr-1"></i>
                  {{ __("videos") }}
                </Link>
              </li>
              <li
                class="-mb-px mr-2 last:mr-0 flex-auto text-center"
                v-if="
                  hasAnyPermission([
                    'users_manage',
                    'create_virtual',
                    'create_booth',
                    'manager_booth',
                    'manager_event',
                  ])
                "
              >
                <Link
                  :href="route('booth.documents', data.id)"
                  class="btn text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal"
                  v-on:click="toggleTabs('documents')"
                  v-bind:class="{
                    'text-gray-600 bg-white': openTab !== 'documents',
                    'text-white bg-gray-600': openTab === 'documents',
                  }"
                >
                  <i class="fas fa-file-pdf text-base mr-1"></i>
                  {{ __("documents") }}
                </Link>
              </li>

              <li
                class="-mb-px mr-2 last:mr-0 flex-auto text-center"
                v-if="
                  hasAnyPermission([
                    'users_manage',
                    'create_virtual',
                    'create_booth',
                    'manager_booth',
                    'manager_event',
                  ])
                "
              >
                <Link
                  :href="route('booth.product', data.id)"
                  class="btn text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal"
                  v-on:click="toggleTabs('product')"
                  v-bind:class="{
                    'text-gray-600 bg-white': openTab !== 'product',
                    'text-white bg-gray-600': openTab === 'product',
                  }"
                >
                  <i class="fab fa-elementor text-base mr-1"></i>
                  {{ __("Product Panos") }}
                </Link>
              </li>
              <li
                class="-mb-px mr-2 last:mr-0 flex-auto text-center"
                v-if="hasAnyPermission(['users_manage', 'create_virtual'])"
              >
                <Link
                  :href="route('booth.images', data.id)"
                  class="btn text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal"
                  v-on:click="toggleTabs('virtual_images')"
                  v-bind:class="{
                    'text-gray-600 bg-white': openTab !== 'virtual_images',
                    'text-white bg-gray-600': openTab === 'virtual_images',
                  }"
                >
                  <i class="fas fa-images text-base mr-1"></i>
                  {{ __("virtual_images") }}
                </Link>
              </li>

              <li
                class="-mb-px mr-2 last:mr-0 flex-auto text-center"
                v-if="hasAnyPermission(['users_manage', 'create_virtual'])"
              >
                <Link
                  :href="route('booth.group-chat', data.id)"
                  class="btn text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal"
                  v-on:click="toggleTabs('product')"
                  v-bind:class="{ 'text-gray-600 bg-white': openTab !== 'group-chat', 'text-white bg-gray-600': openTab === 'group-chat' }"
                >
                  <i class="fab fa-elementor text-base mr-1"></i>
                  {{ __('Live Chat') }}
                </Link>
              </li>
            </ul>

            <div
              class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded overflow-y-auto"
            >
              <div class="px-4 py-5 flex-auto overflow-y-auto">
                <div class="tab-content tab-space overflow-y-auto">
                  <div
                    class="flex-1 overflow-hidden px-4 py-8 md:p-12 overflow-y-auto"
                    scroll-region
                  >
                    <slot />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue";
import Dropdown from "@/Components/Dropdown";
import Icon from "@/Components/Icon";
import Logo from "@/Components/Logo";
import MainMenu from "@/Components/MainMenu";
import BreezeApplicationLogo from "@/Components/ApplicationLogo";
import BreezeDropdown from "@/Components/Dropdown";
import BreezeDropdownLink from "@/Components/DropdownLink";
import BreezeNavLink from "@/Components/NavLink";
import BreezeResponsiveNavLink from "@/Components/ResponsiveNavLink";
import LanguageSelector from "@/Components/LanguageSelector";
export default {
  components: {
    Dropdown,
    Link,
    Icon,
    Logo,
    MainMenu,
    BreezeApplicationLogo,
    BreezeDropdown,
    BreezeDropdownLink,
    BreezeNavLink,
    BreezeResponsiveNavLink,
    LanguageSelector
  },
  mounted() {
    this.$once(
      "hook:destroyed",
      this.$inertia.on("start", event => {
        this.openTab = event.detail.visit.url.pathname.split("/")[3];
      })
    );
  },
  
  data() {
    return {
      openTab: location.pathname.split("/")[3],
      showUserMenu: false,
      showingNavigationDropdown: false
    };
  },
  props: {
    virtual: Object,
    data: Object
  },

  methods: {
    url() {
      return location.pathname.substr(1);
    },
    hideDropdownMenus() {
      this.showUserMenu = false;
    },
    toggleTabs: function (tabNumber) {
      this.openTab = tabNumber;
    }
  }
};
</script>
