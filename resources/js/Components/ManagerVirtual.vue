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
                v-if="hasAnyPermission(['users_manage', 'create_virtual','manager_event']) "
              >
                <Link
                  :href="route('virtual-expo.setting.index', virtual.id)"
                  class="btn text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal"
                  v-on:click="toggleTabs('setting-expo')"
                  v-bind:class="{
                    'text-gray-600 bg-white': openTab !== 'setting-expo',
                    'text-white bg-gray-600': openTab === 'setting-expo',
                  }"
                >
                  <i class="fas fa-cog text-base mr-1"></i>
                  {{ __('info') }}
                </Link>
              </li>
              <li
                class="-mb-px mr-2 last:mr-0 flex-auto text-center"
                v-if="hasAnyPermission(['users_manage', 'create_virtual']) "
              >
                <Link
                  :href="route('virtual-expo.virtual-state.index', virtual.id)"
                  class="btn text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal"
                  v-on:click="toggleTabs('virtual-state')"
                  v-bind:class="{
                    'text-gray-600 bg-white': openTab !== 'virtual-state',
                    'text-white bg-gray-600': openTab === 'virtual-state',
                  }"
                >
                  <i class="fas fa-cog text-base mr-1"></i>
                  {{ __('virtual_state') }}
                </Link>
              </li>

              <li
                class="-mb-px mr-2 last:mr-0 flex-auto text-center"
                v-if="hasAnyPermission(['users_manage', 'create_virtual','manager_event']) "
              >
                <Link
                  :href="route('virtual-expo.category.getVirtual', virtual.id)"
                  class="btn text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal"
                  v-on:click="toggleTabs('category')"
                  v-bind:class="{
                    'text-gray-600 bg-white': openTab !== 'category',
                    'text-white bg-gray-600': openTab === 'category',
                  }"
                >
                  <i class="fas fa-cog text-base mr-1"></i>
                  {{ __('category_booth') }}
                </Link>
              </li>
              <li
                class="-mb-px mr-2 last:mr-0 flex-auto text-center"
                v-if="hasAnyPermission(['users_manage']) "
              >
                <Link
                  :href="
                    route('virtual-expo.virtual-setting.index', virtual.id)
                  "
                  class="btn text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal"
                  v-on:click="toggleTabs('virtual-setting')"
                  v-bind:class="{
                    'text-gray-600 bg-white': openTab !== 'virtual-setting',
                    'text-white bg-gray-600': openTab === 'virtual-setting',
                  }"
                >
                  <i class="fas fa-cog text-base mr-1"></i>
                  {{ __('virtual_setting') }}
                </Link>
              </li>
              <li
                class="-mb-px mr-2 last:mr-0 flex-auto text-center"
                v-if="hasAnyPermission(['users_manage'])"
              >
                <Link
                  :href="
                    route('virtual-expo.content-language.show', virtual.id)
                  "
                  class="btn text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal"
                  v-on:click="toggleTabs('content-language')"
                  v-bind:class="{
                    'text-gray-600 bg-white': openTab !== 'content-language',
                    'text-white bg-gray-600': openTab === 'content-language',
                  }"
                >
                  <i class="fas fa-cog text-base mr-1"></i>
                  {{ __('languages') }}
                </Link>
              </li>
              <li
                class="-mb-px mr-2 last:mr-0 flex-auto text-center"
                v-if="hasAnyPermission(['users_manage', 'create_virtual','manager_event'])"
              >
                <Link
                  :href="
                    route('virtual-expo.setting-color.index', virtual.id)
                  "
                  class="btn text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal"
                  v-on:click="toggleTabs('setting-color')"
                  v-bind:class="{
                    'text-gray-600 bg-white': openTab !== 'setting-color',
                    'text-white bg-gray-600': openTab === 'setting-color',
                  }"
                >
                  <i class="fas fa-cog text-base mr-1"></i>
                  {{ __('setting_color') }}
                </Link>
              </li>
              <li
                class="-mb-px mr-2 last:mr-0 flex-auto text-center"
                v-if="hasAnyPermission(['users_manage']) || (hasAnyPermission(['manager_booth','manager_event', 'create_virtual']) && virtual.virtual_setting.entrance_active == 1 )"
              >
                <Link
                  :href="route('virtual-expo.entrance.index', virtual.id)"
                  class="btn text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal"
                  v-on:click="toggleTabs('entrance')"
                  v-bind:class="{
                    'text-gray-600 bg-white': openTab !== 'entrance',
                    'text-white bg-gray-600': openTab === 'entrance',
                  }"
                >
                  <i class="fas fa-cog text-base mr-1"></i>
                  {{ __('entrance') }}
                </Link>
              </li>
              <li
                class="-mb-px mr-2 last:mr-0 flex-auto text-center"
                v-if="hasAnyPermission(['users_manage']) || (hasAnyPermission(['manager_booth','manager_event','create_virtual']) && virtual.virtual_setting.lobby_active == 1 )"
              >
                <Link
                  :href="route('virtual-expo.lobby.index', virtual.id)"
                  class="btn text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal"
                  v-on:click="toggleTabs('lobby')"
                  v-bind:class="{
                    'text-gray-600 bg-white': openTab !== 'lobby',
                    'text-white bg-gray-600': openTab === 'lobby',
                  }"
                >
                  <i class="fas fa-cog text-base mr-1"></i>
                  {{ __('lobby') }}
                </Link>
              </li>

              <li
                class="-mb-px mr-2 last:mr-0 flex-auto text-center"
                v-if="hasAnyPermission(['users_manage']) || (hasAnyPermission(['manager_booth','manager_event','create_virtual']) && virtual.virtual_setting.conference_active == 1 )"
              >
                <Link
                  :href="route('virtual-expo.seminor.index', virtual.id)"
                  class="btn text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal"
                  v-on:click="toggleTabs('auditorium')"
                  v-bind:class="{
                    'text-gray-600 bg-white': openTab !== 'auditorium',
                    'text-white bg-gray-600': openTab === 'auditorium',
                  }"
                >
                  <i class="fas fa-cog text-base mr-1"></i>
                  {{ __('virtual_conferences') }}
                </Link>
              </li>
              <li
                class="-mb-px mr-2 last:mr-0 flex-auto text-center"
                v-if="hasAnyPermission(['users_manage', 'create_virtual','manager_event']) || (hasAnyPermission(['manager_booth','manager_event','create_virtual']) && virtual.virtual_setting.hall_active == 1 )"
              >
                <Link
                  :href="route('virtual-expo.space.index', virtual.id)"
                  class="btn text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal"
                  v-on:click="toggleTabs('space-exhibition')"
                  v-bind:class="{
                    'text-gray-600 bg-white': openTab !== 'space-exhibition',
                    'text-white bg-gray-600': openTab === 'space-exhibition',
                  }"
                >
                  <i class="fas fa-cog text-base mr-1"></i>
                  {{ __('exhibition_hall') }}
                </Link>
              </li>
              <li
                class="-mb-px mr-2 last:mr-0 flex-auto text-center"
                v-if="hasAnyPermission(['users_manage', 'manager_event', 'manager_booth', 'create_booth', 'create_virtual'])"
              >
                <Link
                  :href="route('virtual-expo.booth.index', virtual.id)"
                  class="btn text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal"
                  v-on:click="toggleTabs('booth')"
                  v-bind:class="{
                    'text-gray-600 bg-white': openTab !== 'booth',
                    'text-white bg-gray-600': openTab === 'booth',
                  }"
                >
                  <i class="fas fa-cog text-base mr-1"></i>
                  {{ __('booth') }}
                </Link>
              </li>

              <li
                class="-mb-px mr-2 last:mr-0 flex-auto text-center"
                v-if="hasAnyPermission(['users_manage', 'create_virtual','manager_event'])"
              >
                <Link
                  :href="route('virtual-expo.documents.index', virtual.id)"
                  class="btn text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal"
                  v-on:click="toggleTabs('documents')"
                  v-bind:class="{
                    'text-gray-600 bg-white': openTab !== 'documents',
                    'text-white bg-gray-600': openTab === 'documents',
                  }"
                >
                  <i class="fas fa-cog text-base mr-1"></i>
                  {{ __('Agenda') }}
                </Link>
              </li>

              <li
                class="-mb-px mr-2 last:mr-0 flex-auto text-center"
                v-if="hasAnyPermission(['users_manage', 'create_virtual','manager_event'])"
              >
                <Link
                  :href="route('virtual-expo.speaker.index', virtual.id)"
                  class="btn text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal"
                  v-on:click="toggleTabs('speakers')"
                  v-bind:class="{
                    'text-gray-600 bg-white': openTab !== 'speakers',
                    'text-white bg-gray-600': openTab === 'speakers',
                  }"
                >
                  <i class="fas fa-cog text-base mr-1"></i>
                  {{ __('speakers') }}
                </Link>
              </li>

              <li
                class="-mb-px mr-2 last:mr-0 flex-auto text-center"
                v-if="hasAnyPermission(['users_manage', 'create_virtual','manager_event'])"
              >
                <Link
                  :href="route('virtual-expo.sponsor.index', virtual.id)"
                  class="btn text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal"
                  v-on:click="toggleTabs('sponsors')"
                  v-bind:class="{
                    'text-gray-600 bg-white': openTab !== 'sponsors',
                    'text-white bg-gray-600': openTab === 'sponsors',
                  }"
                >
                  <i class="fas fa-cog text-base mr-1"></i>
                  {{ __('sponsors') }}
                </Link>
              </li>
              <li
                class="-mb-px mr-2 last:mr-0 flex-auto text-center"
                v-if="hasAnyPermission(['users_manage', 'create_virtual','manager_event'])"
              >
                <Link
                  :href="route('virtual-expo.infor.index', virtual.id)"
                  class="btn text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal"
                  v-on:click="toggleTabs('infor')"
                  v-bind:class="{
                    'text-gray-600 bg-white': openTab !== 'infor',
                    'text-white bg-gray-600': openTab === 'infor',
                  }"
                >
                  <i class="fas fa-cog text-base mr-1"></i>
                  {{ __('Landing Page') }}
                </Link>
              </li>
              <!-- <li
                class="-mb-px mr-2 last:mr-0 flex-auto text-center"
                v-if="hasAnyPermission(['users_manage','create_virtual'])"
              >
                <Link
                  :href="route('chat.index',1)"
                  class="btn text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal"
                  v-on:click="toggleTabs('documents')"
                  v-bind:class="{
                    'text-gray-600 bg-white': openTab !== 'documents',
                    'text-white bg-gray-600': openTab === 'documents',
                  }"
                >
                  <i class="fas fa-cog text-base mr-1"></i>
                  {{ __('document') }}
                </Link>
              </li>-->
              <li class="ml-3 nav-item text-right">
                <a class="btn btn-info" :href="'expo/' + virtual.title" target="_blank">
                  <i class="fas fa-external-link-alt"></i> Preview
                </a>
                  <a
                    :href="'expo/' + virtual.name +'/booths'" 
                    target="_blank"
                    class="btn btn-info"
                  >
                  <i class="fas fa-chart-line"></i>
                    Analytics
                  </a>
                <!-- <li class="ml-3 nav-item  text-right">
                    <a class='btn btn-info' :href="'fh/'+ project.title +'/general'+'?lang='+ project.languages.language" target="_blank"> <i
                            class="fas fa-external-link-alt"></i>
                        Xem
                        dự
                        án</a>
                </li>-->
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
    virtual: Object
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
