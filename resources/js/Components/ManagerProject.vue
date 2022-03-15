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
              <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
                <Link
                  :href="route('admin.project.info.getinfo', project.id)"
                  class="btn text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal"
                  v-on:click="toggleTabs('info')"
                  v-bind:class="{ 'text-gray-600 bg-white': openTab !== 'info', 'text-white bg-gray-600': openTab === 'info' }"
                >
                  <i class="fas fa-info-circle text-base mr-1"></i>
                  {{ __('project_info') }}
                </Link>
              </li>
              <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
                <Link
                  v-if="project.info !== null"
                  :href="route('admin.project.setting_project.index', project.id)"
                  class="btn text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal"
                  v-on:click="toggleTabs('setting_project')"
                  v-bind:class="{ 'text-gray-600 bg-white': openTab !== 'setting_project', 'text-white bg-gray-600': openTab === 'setting_project' }"
                >
                  <i class="fas fa-cog text-base mr-1"></i>
                  {{ __('project_setting') }}
                </Link>
              </li>
              <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
                <Link
                  :href="route('admin.project.general.showGeneral', project.id)"
                  class="btn text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal"
                  v-on:click="toggleTabs('general')"
                  v-bind:class="{ 'text-gray-600 bg-white': openTab !== 'general', 'text-white bg-gray-600': openTab === 'general' }"
                >
                  <i class="fas fa-cog text-base mr-1"></i>
                  {{ __('general_view') }}
                </Link>
              </li>
              <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
                <Link
                  :href="route('admin.project.subdivision.showSubdivision', project.id)"
                  class="btn text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal"
                  v-on:click="toggleTabs('subdivision')"
                  v-bind:class="{ 'text-gray-600 bg-white': openTab !== 'subdivision', 'text-white bg-gray-600': openTab === 'subdivision' }"
                >
                  <i class="fas fa-briefcase text-base mr-1"></i>
                  {{ __('arena') }}
                </Link>
              </li>
              <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
                <Link
                  :href="route('admin.project.ground.showGroundProject', project.id)"
                  class="btn text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal"
                  v-on:click="toggleTabs('ground')"
                  v-bind:class="{ 'text-gray-600 bg-white': openTab !== 'ground', 'text-white bg-gray-600': openTab === 'ground' }"
                >
                  <i class="fas fa-briefcase text-base mr-1"></i>
                  {{ __('ground') }}
                </Link>
              </li>
              <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
                <Link
                  v-if="project.info !== null"
                  :href="route('admin.project.videolink.index', project.id)"
                  preserve-state
                  class="btn text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal"
                  v-on:click="toggleTabs('videolink')"
                  v-bind:class="{ 'text-gray-600 bg-white': openTab !== 'videolink', 'text-white bg-gray-600': openTab === 'videolink' }"
                >
                  <i class="fab fa-youtube text-base mr-1"></i> List Video
                </Link>
              </li>
              <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
                <Link
                  v-if="project.info !== null"
                  :href="route('admin.project.brochure.showbrochure', project.id)"
                  preserve-state
                  class="btn text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal"
                  v-on:click="toggleTabs('brochure')"
                  v-bind:class="{ 'text-gray-600 bg-white': openTab !== 'brochure', 'text-white bg-gray-600': openTab === 'brochure' }"
                >
                  <i class="far fa-file-pdf text-base mr-1"></i> List Brochure
                </Link>
              </li>
              <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
                <Link
                  :href="route('admin.project.image.index', project.id)"
                  preserve-state
                  class="btn text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal"
                  v-on:click="toggleTabs('imageProject')"
                  v-bind:class="{ 'text-gray-600 bg-white': openTab !== 'imageProject', 'text-white bg-gray-600': openTab === 'imageProject' }"
                >
                  <i class="fas fa-briefcase text-base mr-1"></i>
                  {{ __('project_images') }}
                </Link>
              </li>
              <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
                <Link
                  :href="route('admin.project.showflat.show', project.id)"
                  preserve-state
                  class="btn text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal"
                  v-on:click="toggleTabs('showflat')"
                  v-bind:class="{ 'text-gray-600 bg-white': openTab !== 'showflat', 'text-white bg-gray-600': openTab === 'showflat' }"
                >
                  <i class="fas fa-briefcase text-base mr-1"></i>
                  {{ __('show_flat') }}
                </Link>
              </li>
              <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
                <Link
                  :href="route('admin.project.amentities.index', project.id)"
                  preserve-state
                  class="btn text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal"
                  v-on:click="toggleTabs('amentities')"
                  v-bind:class="{ 'text-gray-600 bg-white': openTab !== 'amentities', 'text-white bg-gray-600': openTab === 'amentities' }"
                >
                  <i class="fas fa-briefcase text-base mr-1"></i>
                  {{ __('amenities') }}
                </Link>
              </li>
              <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
                <Link
                  :href="route('admin.project.address.show', project.id)"
                  preserve-state
                  class="btn text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal"
                  v-on:click="toggleTabs('address')"
                  v-bind:class="{ 'text-gray-600 bg-white': openTab !== 'address', 'text-white bg-gray-600': openTab === 'address' }"
                >
                  <i class="fas fa-map-marked-alt text-base mr-1"></i>
                  {{ __('address') }} {{ __('project') }}
                </Link>
              </li>
              <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
                <Link
                  :href="route('project.scenes.index', project.id)"
                  preserve-state
                  class="btn text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal"
                  v-on:click="toggleTabs('scenes')"
                  v-bind:class="{ 'text-gray-600 bg-white': openTab !== 'scenes', 'text-white bg-gray-600': openTab === 'scenes' }"
                >
                  <i class="fas fa-vr-cardboard text-base mr-1"></i>
                  VR
                </Link>
              </li>

              <li class="ml-3 nav-item text-right">
                <a
                  class="btn btn-info"
                  :href="'fh/' + project.title + '/general' + '?lang=' + project.languages.language"
                  target="_blank"
                >
                  <i class="fas fa-external-link-alt"></i>
                  Xem
                  dự
                  án
                </a>
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
        this.openTab = event.detail.visit.url.pathname.split("/")[4];
      })
    );
  },
  data() {
    return {
      openTab: location.pathname.split("/")[4],
      showUserMenu: false,
      showingNavigationDropdown: false
    };
  },
  props: {
    project: Object
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