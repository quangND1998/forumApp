<template>
  <div>
    <Notification></Notification>

    <div class="sm:hidden relative w-12/12 mx-auto  rounded">
      <div class="w-full pb-2" v-if="$page.props.auth.user !== null">
        <NewQuestionButton v-if="$page.url.startsWith('/forum')"></NewQuestionButton>
        <ReplyButtom v-if="$page.url.startsWith('/question')"></ReplyButtom>
      </div>
    </div>
    <div class="mb-6 flex flex-wrap justify-center md:mb-8 md:justify-between">
      <div class="flex flex-1">
        <div class="mobile:mr-4 mr-6 md:hidden lg:block">
          <div class="select-wrap">
            <select v-model="filter" @change="Filter"
              class="flex cursor-pointer items-center rounded-full bg-grey-400 px-5 py-3 text-xs leading-none text-grey-800 dark:bg-[#233153] text-blue dark:text-white"
              style="width: fit-content;">
              <option value="all">All</option>
              <option v-for="(chanel, index) in chanels" :key="index" :value="chanel.slug">{{ chanel.title }}</option>
            </select>
          </div>
        </div>
      </div>
      <!-- <div class="flex flex-1 items-center justify-end gap-x-3 md:flex-none">
        <button @click="toggleDarkMode">
          <svg
            v-if="dark"
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
          </svg>
          <svg
            v-else
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              fill-rule="evenodd"
              d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
              clip-rule="evenodd"
            />
          </svg>
        </button>
      </div> -->
      <div class="hidden gap-x-3 md:flex md:items-center mr-3">
          <button  @click="changeExcerpt(false)" class="forum-excerpt-toggle  hover:bg-gray-400 dark:hover:bg-gray-500 bg-gray-200 dark:bg-[#172741] " >
            <svg width="15" height="15" viewBox="0 0 15 15" class="mx-2">
              <g class="forum-excerpt-toggle-lines fill-current text-black/50 text-gray-400 " fill-rule="evenodd" >
                <rect class="forum-excerpt-toggle-line " width="15"  height="16" rx="2"  :class="[show_forum_excerpts=== false ? 'text-black dark:text-white dark:bg-white' : '']"   ></rect>
                <!-- <rect class="forum-excerpt-toggle-line" width="15"  height="6" y="9" rx="2"  :class="[show_forum_excerpts=== false ? 'text-black dark:text-white dark:bg-white' : '']" ></rect> -->
              </g>
            </svg>
          </button>
          <button  @click="changeExcerpt(true)" class="forum-excerpt-toggle hover:bg-gray-400 dark:hover:bg-gray-500 bg-gray-200 dark:bg-[#172741]">
            <svg width="15" height="15" viewBox="0 0 15 15" class="mx-2">
              <g class="forum-excerpt-toggle-lines fill-current  text-black/50 text-gray-400 " fill-rule="evenodd">
                <rect class="forum-excerpt-toggle-line" width="15"  height="4" rx="2"  :class="[show_forum_excerpts ===true ? 'text-black dark:text-white dark:bg-gray-100' : '']" ></rect>
                <rect class="forum-excerpt-toggle-line" width="8"  height="4" y="11" rx="2"  :class="[show_forum_excerpts ===true ? 'text-black dark:text-white dark:bg-white' : '']" ></rect>
                <rect class="forum-excerpt-toggle-line" width="15"  height="4" y="5.5" rx="2" :class="[show_forum_excerpts ===true ? 'text-black dark:text-white dark:bg-white' : '']" ></rect>
              </g>
            </svg>
          </button>
      </div>
      <form class="search-form mt-5 h-[40px] w-full rounded-full bg-grey-400 md:mt-0 md:w-52 relative ">
        <span
          class="z-10 leading-snug font-normal absolute text-center text-blueGray-300 bg-transparent  rounded text-base items-center justify-center w-8 pl-3 py-3">
          <i class="fas fa-search"></i>
        </span>
        <input v-model="term" @keyup="search" type="text" placeholder="Search here..."
          class="border-1 px-3 py-3 placeholder-blueGray-300 text-blueGray-600  bg-white dark:bg-[#233153] rounded text-sm shadow outline-none focus:outline-none focus:ring w-full pl-10 bg-blue-opacity  dark:text-white" />
      </form>
    </div>

    <div v-for="post in conversations.data" :key="post.id">
      <div
        class="panel relative transition-colors shadow-lg bg-gray-200 text-gray-700 dark:bg-slate-600  dark:hover:bg-slate-700 duration-300 dark:text-gray-200 hover:bg-gray-300 px-5 py-4 rounded-2xl conversation-list-item mb-3 flex cursor-pointer flex-col md:flex-row">
        <div class="w-full md:w-auto md:mr-6 flex items-center md:block mb-4 md:mb-0">
          <span class="icon mr-3 md:mr-0">
            <img :alt="post.owner.name" width="50" height="50" class="bg-white relative rounded-full"
              style="max-width: none; max-height: 50px;" :src="post.owner.avatar" />
          </span>
          <!-- <div class="inline-block">
                        <span class="font-bold">{{ post.owner.name }}</span>
                        <span class="text-sm -600">| {{ post.time_ago }}</span>
          </div>-->
          <strong class="uppercase md:hidden">{{ post.owner.name }}</strong>

          <div class="flex md:hidden items-center justify-center ml-auto">
            <span class="mr-1 btn btn-channel rounded-md ml-5 block w-24 py-1 px-2 text-center text-xs is-eloquent"
              :style="`color: ${post.chanel.color}; border-color: ${post.chanel.color} `">
              {{ post.chanel.title
              }}s
            </span>
            <span class="text-white text-xs">posted {{ post.time_ago }}</span>

            <!-- <div class="flex bg-gray-200 rounded-full h-6 items-center">
                            <div class="flex py-2 px-3 items-center">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="13"
                                    height="12"
                                    viewBox="0 0 15 14"
                                    class="mr-2"
                                >
                                    <path
                                        fill="#78909C"
                                        fill-rule="evenodd"
                                        d="M7.5 0C3.344 0 0 2.818 0 6.286c0 1.987 1.094 3.757 2.781 4.914l.117 2.35c.022.438.338.58.704.32l2.023-1.442c.594.144 1.219.18 1.875.18 4.156 0 7.5-2.817 7.5-6.285C15 2.854 11.656 0 7.5 0z"
                                        opacity=".5"
                                    />
                                </svg>
                                <span
                                    class="text-xs text-gray-800 font-semibold leading-none"
                                >{{ discussion.answers }}</span>
                            </div>
            </div>-->
          </div>
        </div>

        <div class="w-full md:pr-10 lg:pr-0 lg:w-5/6 md:mb-0">
          <div class="lg:pr-10">
            <Link :href="route('question.getDetail', post.slug)"
              class="mb-3 md:mb-1 text-base md:text-lg font-bold md:font-semibold tracking-tight  no-underline hover:underline"
              style="word-break: break-word;">
            {{ post.title }}
            <span class=" text-xs font-bold">posted {{ post.time_ago }}</span>
            </Link>

            <div v-if="show_forum_excerpts"
              class="mt-2 conversation-list-excerpt lg:clamp two-lines mb-6 break-words text-[13px] leading-normal  dark:font-medium dark:text-grey-100 lg:mb-0 lg:pr-8"
              v-html="post.sub_body"></div>

            <div
              class="text-xs font-semibold leading-none tracking-tight text-grey-800 dark:text-grey-100 mt-3">
              <Link class="text-blue-600 uppercase font-bold no-underline hover:underline" v-if="post.lastReplie !==null"
                :href="route('profile',  post.lastReplie.user.email)">{{ post.lastReplie.user.name }}</Link>
                <Link class="text-blue-600 uppercase font-bold no-underline hover:underline" v-else
                :href="route('profile',  post.owner.email)">{{ post.owner.name }}</Link>

              <span v-if="post.lastReplie !==null" class="font-bold">replied {{ post.lastReplie.time_ago }}</span>
              <span v-else class="font-bold">posted {{post.time_ago }}</span>

              <div v-if="post.solved == 1"
                class="ml-2 inline-flex h-5 items-center rounded-full border border-solid border-blue-500 px-2 text-xs font-medium text-white bg-blue-600"
                style="line-height: 1.1;">
                <svg width="8" viewBox="0 0 21 16" class="mr-1 hidden md:block text-white">
                  <path fill="none" d="M-3-5h27v27H-3z" />
                  <path class="fill-current"
                    d="M7.439 12.152l-5.037-5.36c-.447-.477-1.119-.477-1.566 0a1.204 1.204 0 0 0 0 1.667l6.603 7.03L20.086 2.025a1.204 1.204 0 0 0 0-1.668c-.447-.476-1.12-.476-1.567 0L7.44 12.152z"
                    opacity=".5" />
                </svg>
                solved
              </div>
            </div>
          </div>
        </div>
        <div class="relative hidden text-center md:ml-auto md:flex md:flex-row-reverse md:items-center"
          style="top: -10px;">
          <div class="flex items-center justify-center ml-4">
            <div class="mr-1">
              <svg xmlns="http://www.w3.org/2000/svg" width="15" height="19" viewBox="0 0 15 10" class="relative "
                style="top: -2px;">
                <path :fill="isdark=='dark' ? '#fdfeff':'#78909C'" fill-rule="evenodd"
                  d="M7.5 0C3.344 0 0 2.818 0 6.286c0 1.987 1.094 3.757 2.781 4.914l.117 2.35c.022.438.338.58.704.32l2.023-1.442c.594.144 1.219.18 1.875.18 4.156 0 7.5-2.817 7.5-6.285C15 2.854 11.656 0 7.5 0z" />
              </svg>
            </div>
            <span class="text-xs text-black  dark:text-white font-semibold text-left leading-none">
              {{ post.count_reply
              }}
            </span>
          </div>
          <div class="flex items-center justify-center">
            <div class="mr-1 dark:text-gray-200">
              <svg xmlns="http://www.w3.org/2000/svg" width="19" height="13" viewBox="0 0 19 13" class="relative ">
                <g fill="none" fill-rule="evenodd">
                  <path d="M0-3h19v19H0z" />
                  <path :fill="isdark=='dark' ? '#fdfeff':'#78909C'"
                    d="M9.5.562C5.542.562 2.161 3.025.792 6.5c1.37 3.475 4.75 5.937 8.708 5.937s7.339-2.462 8.708-5.937C16.838 3.025 13.458.562 9.5.562zm0 9.896A3.96 3.96 0 0 1 5.542 6.5 3.96 3.96 0 0 1 9.5 2.542 3.96 3.96 0 0 1 13.458 6.5 3.96 3.96 0 0 1 9.5 10.458zm0-6.333A2.372 2.372 0 0 0 7.125 6.5 2.372 2.372 0 0 0 9.5 8.875 2.372 2.372 0 0 0 11.875 6.5 2.372 2.372 0 0 0 9.5 4.125z" />
                </g>
              </svg>
            </div>
            <span class="text-xs text-black  dark:text-white font-semibold text-left leading-none">{{ post.view
            }}</span>
          </div>
          <div class="flex items-center justify-center">
            <a :class="`items-center justify-center border hiddentext-white font-medium leading-tight rounded-full py-1 px-3 text-xs mr-2 shadow-md hover:bg-[${post.chanel.color}] hover:shadow-lg focus:bg-[${post.chanel.color}] focus:shadow-lg focus:outline-none focus:ring-0 active:bg-[${post.chanel.color}] active:shadow-lg transition duration-150 ease-in-out`"
              :style="`background-color: ${post.chanel.color}; border-color: ${post.chanel.color}; color:white  `">
              {{
              post.chanel.title }}
            </a>
            <!-- <a
              :class="`items-center justify-center border hiddentext-white font-medium leading-tight rounded-full py-1 px-3 text-xs uppercase  shadow-md hover:bg-[${post.chanel.color}] hover:shadow-lg focus:bg-[${post.chanel.color}] focus:shadow-lg focus:outline-none focus:ring-0 active:bg-[${post.chanel.color}] active:shadow-lg transition duration-150 ease-in-out`"
              :style="`color: ${post.chanel.color}; border-color: ${post.chanel.color};  `"
            >{{ post.chanel.title }}</a>-->
          </div>
        </div>
      </div>
    </div>

    <pagination class="mt-6" :links="conversations.meta.links" />
  </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue";
import Pagination from "@/Components/Pagination";
import LayoutForum from "@/Pages/Forum/Layout";
import NewQuestionButton from "@/Components/NewQuestionButton";
import ReplyButtom from "@/Components/ReplieComponent/ReplyButtom";
import Notification from "@/Components/Notification";
export default {
  layout: LayoutForum,
  props: {
    conversations: Object,
    chanels: Array,
    category: String,
    solved: String
  },
  components: {
    Pagination,
    NewQuestionButton,
    ReplyButtom,
    Link,
    Notification
  },
  mounted() {
    if (localStorage.show_forum_excerpts === undefined) {

      localStorage.show_forum_excerpts = true;
      this.show_forum_excerpts =true
    } else {
      this.show_forum_excerpts = JSON.parse(localStorage.show_forum_excerpts)
    }

    if (localStorage.isdark === undefined) {

      localStorage.isdark = 'dark';
      this.isdark=  'dark'
    } else {
      this.isdark = localStorage.isdark
    }
    window.ChatterEvents.$on('changeMode', e => {
      // console.log('changeMode',e)
      this.isdark = e
      localStorage.isdark = e;
    })
    this.listenForNewConverstion();
    this.listenForDeleteConverstion();
    this.listenForViewConverstion();
    this.listenForSolvedConversation();
  },
  data() {
    return {
      show_forum_excerpts:true,
      isdark: 'dark',
      term: null,
      filter: this.category,
      answered: this.solved
    };
  },
  methods: {
    Filter(event) {
      if (event.target.value == "all") {
        this.$inertia.get(this.route("forum"));
      } else {
        this.filter = event.target.value;
        let query = {
          category: event.target.value,
          term: this.term,
          answered: this.answered
        };

        this.$inertia.get(this.route("forum"), query);
      }
    },
    search() {
      if (this.filter == null) {
        let query = {
          category: this.filter,
          term: this.term,
          answered: this.answered
        };
        this.$inertia.get(this.route("forum"), query, { preserveState: true });
      } else {
        let query = {
          category: this.filter,
          term: this.term,
          answered: this.answered
        };
        this.$inertia.get(this.route("forum"), query, { preserveState: true });
      }
    },
    listenForNewConverstion() {
      // var self = this;
      // window.socketio.on("conversation_event:App\\Events\\NewConversationEvent", function (e) {
      //   let index = self.conversations.data.findIndex(x => x.id == e.id);
      //   if (index == -1) {
      //     self.conversations.data.unshift(e);
      //   }

      // });
      window.Echo.channel("conversation_event").listen(
        "NewConversationEvent",
        e => {
          this.conversations.data.unshift(e);
        }
      );
    },
    listenForDeleteConverstion() {
      //   var self = this;
      //   window.socketio.on("deleteConversation_event:App\\Events\\DeleteConvsesationEvent", function (e) {

      //     self.conversations.data.unshift(e);

      //     let index = self.conversations.data.findIndex(x => x.id == e.id);
      //     self.conversations.data.splice(index, 1);
      //   });
      window.Echo.channel("deleteConversation_event").listen(
        "DeleteConvsesationEvent",
        e => {
          let index = this.conversations.data.findIndex(x => x.id == e.id);
          this.conversations.data.splice(index, 1);
        }
      );
    },
    listenForViewConverstion() {
      window.Echo.channel("view_conversation_event").listen(
        "ViewConversationEvent",
        e => {
          let index = this.conversations.data.findIndex(x => x.id == e.id);
          this.conversations.data.splice(index, 1, e);
        }
      );
    },
    listenForSolvedConversation() {
      // var self = this;
      // window.socketio.on("sovled-conversation:App\\Events\\SovledConversationEvent", function (e) {

      //   console.log('redis', e)

      //   let index = self.conversations.data.findIndex(x => x.id == e.id);
      //   if (self.conversations.data[index] !== undefined) {
      //     self.conversations.data[index].solved = e.solved
      //   }
      //   // increase the power everytime we load test route
      //   // $('#power').text(parseInt($('#power').text()) + parseInt(message.data.power));
      // });

      window.Echo.channel("sovled-conversation").listen(
        "SovledConversationEvent",
        e => {
          // console.log(e);

          let index = this.conversations.data.findIndex(x => x.id == e.id);
          if (this.conversations.data[index] !== undefined) {
            this.conversations.data[index].solved = e.solved;
          }
          // this.conversations.data[index].solved = e.solved
        }
      );
    },
    changeExcerpt(e){
      this.show_forum_excerpts= e;
      localStorage.show_forum_excerpts=e;
    }
  }
};
</script>


<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}

.fade-enter,
.fade-leave-to

/* .fade-leave-active below version 2.1.8 */
  {
  opacity: 0;
}

.post.body h1 {
  font-size: 2.25rem;
}

.post.body h2 {
  font-size: 2rem;
}

.post.body h3 {
  font-size: 1.75rem;
}

.post.body ul {
  list-style-type: disc !important;
  margin-top: 10px;
  margin-left: 30px;
}

.post.body ol {
  list-style-type: decimal !important;
  margin-top: 10px;
  margin-left: 30px;
}

.post.body blockquote {
  margin-top: 10px;
  margin-left: 30px;
  padding-left: 10px;
  padding-top: 10px;
  padding-bottom: 10px;
  border-left: solid #ccc 4px !important;
}

.fill-current {
  fill: currentColor;
}

.select-wrap {
  position: relative;
}

.btn-channel {
  border: 1px solid;
  color: var(--channel-color);
}

@media (min-width: 992px) {
  .lg\:clamp {
    -webkit-box-orient: vertical;
    display: -webkit-box;
    overflow: hidden;
  }
}

@media (min-width: 992px) {
  .lg\:mb-0 {
    margin-bottom: 0;
  }
}
.forum-excerpt-toggle {
    align-items: center;
    border-radius: 0.5rem;
    cursor: pointer;
    display: flex;
    padding-bottom: 0.5rem;
    padding-top: 0.5rem;
}
.forum-excerpt-toggle .forum-excerpt-toggle-lines {
    opacity: .402;
}

.bg-grey-400 {
    --tw-bg-opacity: 1;
    background-color: rgb(235 237 241/var(--tw-bg-opacity));
}
</style>
