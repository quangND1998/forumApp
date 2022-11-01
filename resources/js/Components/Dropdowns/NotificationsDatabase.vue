<template>
    <div>
      <Head :title="newNotifications.length >0 ? `(${newNotifications.length}) Forum MissionX`:'Forum MissionX'"></Head>
      <a
        class="text-blueGray-500 block py-1 px-3"
        ref="btnDropdownRef"
        v-on:click="toggleDropdown($event)"
      >
        <i class="fas fa-bell relative inline-flex px-2.5 py-1.5 items-center">
          <span
            v-if="newNotifications.length > 0"
            class="absolute -top-2 -right-2 h-5 w-5 rounded-full bg-red-600 flex justify-center items-center items"
          >
            <span>{{ newNotifications.length }}</span>
          </span>
        </i>
      </a>
      <div
        ref="popoverDropdownRef"
        class="right-0 mt-2 bg-white rounded-md shadow-lg overflow-hidden z-50 dark:bg-[#233153]"
        style="width:25rem;"
        v-bind:class="{
          hidden: !dropdownPopoverShow,
          block: dropdownPopoverShow,
        }"
      >
        <li class="block  text-black text-center font-bold py-2 dark:text-white">
          <div class="grid grid-cols-2 ">
            <span
              class="h-full w-full" 
              @click="switchTab($event, 'new')"
            >
              <a href="javascript:;">New</a>
              <div :class="[tab === 'new' ? 'w-full h-1 bg-indigo-700 rounded-t-md' : '']">
              </div>
            </span>
            <span
              class=""
              
              @click="switchTab($event, 'old')"
            >
              <a href="javascript:;">Old</a>
              <div :class="[tab === 'old' ? 'w-full h-1 bg-indigo-700 rounded-t-md' : '']">
                    </div>
            </span>
          </div>
        </li>
        <!-- <a v-for="(notify,index) in notifications" :key="index"
          href="javascript:void(0);"
          class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700"
        >
          {{notify.message}} 
        </a>-->
        <div class="py-2" v-if="tab === 'new'">
          <Link :href="'/question/'+notification.data.slug" :data="{ replyId:notification.data.replyId  }"  class="flex items-center px-4 py-3 border-b hover:bg-gray-100 -mx-2" v-for="(notification, index) in newNotifications" :key="index">
            <img
              class="h-8 w-8 rounded-full object-cover mx-1"
              :src="notification.data.owner.avatar"
              alt="avatar"
            />
            <p class="text-gray-700 dark:text-white dark:hover:text-black text-sm mx-2">
              <span class="font-bold "  href="#">{{notification.data.owner.name}}</span> {{notification.data.action}}
              <small class="time pull-right">
                <i class="fa fa-clock-o"></i>
                <span>{{diffForHumans(notification.data.time_ago) }}</span>
              </small>
              <span class="font-bold text-blue-500" href="#">{{notification.data.message}}</span>
            </p>
          </Link>
          <li v-if="!newNotifications.length">
              <span class="place-content-center text-center tex-xs  dark:bg-black dark:text-white">There are no new notifications</span>
            </li>
        </div>
        <div class="py-2" v-if="tab === 'old'">
          <Link :href="'/question/'+notification.data.slug" :data="{ replyId:notification.data.replyId  }" class="flex items-center px-4 py-3 border-b hover:bg-gray-100 -mx-2" v-for="(notification, index) in oldNotifications" :key="index">
            <img
              class="h-8 w-8 rounded-full object-cover mx-1"
              :src="notification.data.owner.avatar"
              alt="avatar"
            />
            <p class="text-gray-700 text-sm mx-2 dark:text-white dark:hover:text-black">
              <span class="font-bold dark:text-black" href="#">{{notification.data.owner.name}}</span> {{notification.data.action}}
              <small class="time pull-right">
                <i class="fa fa-clock-o"></i>
                <span>{{ diffForHumans(notification.data.time_ago) }}</span>
              </small>
              <span class="font-bold text-blue-500" href="#">{{notification.data.message}}</span>
            </p>
          </Link>
          <li v-if="!oldNotifications.length">
              <span class="place-content-center text-center dark:bg-black dark:text-white">There are no old notifications</span>
            </li>
        </div>
        <li v-if="newNotifications.length && tab === 'new'"  class="place-content-center text-center dark:bg-[#233153] dark:text-white dark:hover:text-blue-500">
          <a href="javascript:;" @click="markAllAsRead">
            <i class="fa fa-check"></i>
            <span>Mark all as read</span>
          </a>
        </li>
      </div>
    </div>
  </template>
  <script>
  import { createPopper } from "@popperjs/core";
  import { Link,Head } from "@inertiajs/inertia-vue";
  export default {
    data() {
      return {
        tab: "new",
        dropdownPopoverShow: false,
        notifications: [],
        user: this.$page.props.auth.user,
        sound:'http://soundbible.com/mp3/Air Plane Ding-SoundBible.com-496729130.mp3'
      };
    },
    components:{
      Link,
      Head
    },
    created(){
      this.getNotifications();
    },
    mounted() {
      if(this.user){
        this.listenForNewConversation();
      }
    
    
    },
    computed: {
      newNotifications() {
        return this.notifications.filter(n => !n.read_at);
      },
      oldNotifications() {
        return this.notifications.filter(n => n.read_at);
      }
    },
  
    methods: {
      toggleDropdown: function(event) {
        event.preventDefault();
        if (this.dropdownPopoverShow) {
          this.dropdownPopoverShow = false;
        } else {
          this.dropdownPopoverShow = true;
          createPopper(this.$refs.btnDropdownRef, this.$refs.popoverDropdownRef, {
            placement: "bottom-start"
          });
        }
      },
      getNotifications(){
        axios
        .get("/notifications")
        .then(response => {
          console.log(response.data);
          this.notifications = response.data
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        });
      },
      listenForNewConversation() {
        Echo.private("users." + this.user.id).notification(
          notification => {
            this.playSound(this.sound)
            this.tap ="new"
            this.notifications.unshift(notification);
          }
        );
  
      },
      markAllAsRead(event) {
        event.stopPropagation();
        axios
        .get("/notifications/markAsRead")
        .then(response => {
          this.notifications.filter(n => !n.read_at).forEach(function(notification) {
            notification.read_at = new Date().toUTCString
          })
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        });
      },

      playSound (sound) {
        if(sound) {
          var audio = new Audio(sound);
          audio.play();
        }
      },
      switchTab(event, tab) {
        event.stopPropagation();
  
        this.tab = tab;
      },
    }
  };
  </script>
  