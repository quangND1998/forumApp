<template>
  <div class="flex flex-w">

    <!-- <notification-dropdown /> -->
    <NotificationsDatabase />
    <a
      class="text-blueGray-500 block"
      href="#pablo"
      ref="btnDropdownRef"
      v-on:click="toggleDropdown($event)"
    >
      <div class="items-center flex">
        <span
          class="w-12 h-12 text-sm text-white bg-blueGray-200 inline-flex items-center justify-center rounded-full"
        >
          <img
            v-if="$page.props.auth.user"
            alt="..."
            class="w-full rounded-full align-middle border-none shadow-lg"
            :src="$page.props.auth.user.avatar"
          />
        </span>
      </div>
    </a>

    <div
      ref="popoverDropdownRef"
      class="bg-white text-base z-50 float-left py-2 list-none text-left rounded shadow-lg min-w-48"
      v-bind:class="{
        hidden: !dropdownPopoverShow,
        block: dropdownPopoverShow,
      }"
    >
      <a
        v-if="$page.props.auth.user && $page.props.auth.token"
        :href="API_URL+`/autologin?token=${$page.props.auth.token}`" target="_blank"
        class="flex items-center text-sm py-2 px-4 font-normal w-full whitespace-nowrap bg-transparent text-blueGray-700"
      >
      
        <icon name="profile" class="w-4 h-4 mr-2" />Account
      </a>
      <a
        v-else
        :href="API_URL+'/user'" target="_blank"
        class="flex items-center text-sm py-2 px-4 font-normal w-full whitespace-nowrap bg-transparent text-blueGray-700"
      >
      
        <icon name="profile" class="w-4 h-4 mr-2" />Account
      </a>
      <Link
        class="flex items-center text-sm py-2 px-4 font-normal w-full whitespace-nowrap bg-transparent text-blueGray-700"
        :href="route('logout')"
        as="button"
        type="button"
        method="post"
      >
        <icon name="logout" class="w-4 h-4 mr-2" />
        <div class="text-sm">Logout</div>
      </Link>
      <!-- <a
        href="javascript:void(0);"
        class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700"
      >Something else here</a>
      <div class="h-0 my-2 border border-solid border-blueGray-100" />
      <a
        href="javascript:void(0);"
        class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700"
      >Seprated link</a>-->
    </div>
  </div>
</template>

<script>
import NotificationDropdown from "@/Components/Dropdowns/NotificationDropdown.vue";
import NotificationsDatabase from "@/Components/Dropdowns/NotificationsDatabase";
import { createPopper } from "@popperjs/core";
import Icon from "@/Components/Icon";
import { Link } from "@inertiajs/inertia-vue";

export default {
  components: {
    Link,
    Icon,
    NotificationDropdown,
    NotificationsDatabase
  },
  data() {
    return {
      dropdownPopoverShow: false,
      image: 'assets/img/team-1-800x800.jpg',
      API_URL :process.env.MIX_API_URL
    };
  },
  methods: {
    toggleDropdown: function (event) {
      event.preventDefault();
      if (this.dropdownPopoverShow) {
        this.dropdownPopoverShow = false;
      } else {
        this.dropdownPopoverShow = true;
        createPopper(this.$refs.btnDropdownRef, this.$refs.popoverDropdownRef, {
          placement: "bottom-start",
        });
      }
    },
  },
};
</script>
