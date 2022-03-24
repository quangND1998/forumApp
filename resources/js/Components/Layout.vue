<template>
  <div>
    <portal-target name="dropdown" slim />
    <div class="flex flex-col">
      <div class="h-screen flex flex-col" @click="hideDropdownMenus">
        <div class="md:flex">
          <div
            class="bg-indigo-900 md:flex-shrink-0 md:w-56 px-6 py-4 flex items-center justify-between md:justify-center"
          >
            <Link class="mt-1" :href="route('dashboard')">
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
            class="bg-white border-b w-full p-4 md:py-0 md:px-4 text-sm md:text-md flex justify-start items-center"
          >
            <div class="mt-1 mr-auto">
              <div class="avatar-sm float-left mr-2">
                <img src="asset/img/profile.jpg" alt="..." class="avatar-img rounded-circle" />
              </div>

              <Link :href="route('admin.profile.index')">{{ $page.props.auth.user.name }}</Link>
            </div>

            <language-selector></language-selector>
          </div>
        </div>
        <div class="flex flex-grow overflow-hidden">
          <main-menu
            :url="url()"
            class="bg-indigo-800 flex-shrink-0 w-56 p-4 hidden md:block overflow-y-auto"
          />
          <div class="flex-1 overflow-hidden px-4 py-8 md:p-4 overflow-y-auto" scroll-region>
            <slot />
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
    },

  }
};
</script>