<template>
  <div>
    <!-- <portal-target name="dropdown" slim /> -->
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
            class="bg-white border-b w-full p-4 md:py-0 md:px-12 text-sm md:text-md flex justify-between items-center"
          >
            <div class="mt-1 mr-4"></div>
            <div class="ml-3 relative">
              <breeze-dropdown align="right" width="48">
                <template #trigger>
                  <span class="inline-flex rounded-md">
                    <button
                      type="button"
                      class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                    >
                      {{ $page.props.auth.user.name }}
                      
                    </button>
                  </span>
                </template>

              </breeze-dropdown>
            </div>
            <div
              :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
              class="sm:hidden"
            >
              <div class="pt-2 pb-3 space-y-1">
                <breeze-responsive-nav-link
                  :href="route('dashboard')"
                  :active="route().current('dashboard')"
                >Dashboard</breeze-responsive-nav-link>
              </div>

              <!-- Responsive Settings Options -->
              <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                  <div class="font-medium text-base text-gray-800">{{ $page.props.auth.user.name }}</div>
                  <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                </div>

               
              </div>
            </div>
          </div>
        </div>
        <div class="flex flex-grow overflow-hidden">
          <main-menu
            :url="url()"
            class="bg-indigo-800 flex-shrink-0 w-56 p-12 hidden md:block overflow-y-auto"
          />
          <div class="flex-1 overflow-hidden px-4 py-8 md:p-12 overflow-y-auto" scroll-region>
            <slot />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue'
import Dropdown from "@/Components/Dropdown";
import Icon from "@/Components/Icon";
import Logo from "@/Components/Logo";
import MainMenu from "@/Components/MainMenu";
import BreezeApplicationLogo from "@/Components/ApplicationLogo";
import BreezeDropdown from "@/Components/Dropdown";
import BreezeDropdownLink from "@/Components/DropdownLink";
import BreezeNavLink from "@/Components/NavLink";
import BreezeResponsiveNavLink from "@/Components/ResponsiveNavLink";
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
    BreezeResponsiveNavLink
  },
  data() {
    return {
      showUserMenu: false,
      showingNavigationDropdown: false
    };
  },
  methods: {
    url() {
      return location.pathname.substr(1);
    },
    hideDropdownMenus() {
      this.showUserMenu = false;
    }
  }
};
</script>