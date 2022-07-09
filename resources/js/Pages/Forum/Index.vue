<template>
  <div>
    <Notification></Notification>
    <div class="sm:hidden relative w-12/12 mx-auto bg-white rounded">
      <div class="w-full pb-2" v-if="$page.props.auth.user !== null">
        <NewQuestionButton v-if="$page.url.startsWith('/forum')"></NewQuestionButton>
        <ReplyButtom v-if="$page.url.startsWith('/question')"></ReplyButtom>
      </div>
    </div>
    <div class="mb-6 flex flex-wrap justify-center md:mb-8 md:justify-between">
      <div class="flex flex-1">
        <div class="mobile:mr-4 mr-6 md:hidden lg:block">
          <div class="select-wrap">
            <select
              v-model="filter"
              @change="Filter"
              class="flex cursor-pointer items-center rounded-full bg-grey-400 px-5 py-3 text-xs leading-none text-grey-800"
              style="width: 115px;"
            >
              <option value="all">All</option>
              <option
                v-for="(chanel, index) in chanels"
                :key="index"
                :value="chanel.title"
              >{{ chanel.title }}</option>
            </select>
          </div>
        </div>
      </div>
      <form class="search-form mt-5 h-[40px] w-full rounded-full bg-grey-400 md:mt-0 md:w-52">
        <span
          class="z-10 h-full leading-snug font-normal absolute text-center text-blueGray-300 bg-transparent rounded text-base items-center justify-center w-8 pl-3 py-3"
        >
          <i class="fas fa-search"></i>
        </span>
        <input
          v-model="term"
          @keyup="search"
          type="text"
          placeholder="Search here..."
          class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm shadow outline-none focus:outline-none focus:ring w-full pl-10"
        />
      </form>
    </div>

    <div v-for="post in conversations.data" :key="post.id">
      <div
        class="flex cursor-pointer items-center flex-col md:flex-row md:hover:bg-gray-200 hover:rounded-lg md:px-6 md:py-4 transition-all px-6 py-5 md:px-0 md:py-0 rounded-lg -mx-2 md:mx-0"
      >
        <div class="w-full md:w-auto md:mr-6 flex items-center md:block mb-4 md:mb-0">
          <span class="icon mr-3 md:mr-0">
            <img
              :alt="post.owner.username"
              width="50"
              height="50"
              class="bg-white relative rounded-full"
              style="max-width: none; max-height: 50px;"
              :src="post.owner.avatar"
            />
          </span>
          <!-- <div class="inline-block">
                        <span class="font-bold">{{ post.owner.name }}</span>
                        <span class="text-sm text-gray-600">| {{ post.time_ago }}</span>
          </div>-->
          <strong class="uppercase md:hidden">{{ post.owner.username }}</strong>

          <div class="flex md:hidden items-center justify-center ml-auto">
            <span
              class="mr-1 btn btn-channel rounded-md ml-5 block w-24 py-1 px-2 text-center text-xs is-eloquent"
              :style="`color: ${post.chanel.color}; border-color: ${post.chanel.color} `"
            >
              {{ post.chanel.title
              }}s
            </span>
            <span class="text-gray-800 text-xs">posted {{ post.time_ago }}</span>

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
            <Link
              :href="route('question.getDetail', post.slug)"
              class="mb-3 md:mb-1 text-base md:text-lg font-bold md:font-semibold tracking-tight text-gray-900 hover:text-gray-900"
              style="word-break: break-word;"
            >
              {{ post.title }}
              <span
                class="text-gray-800 text-xs font-bold"
              >posted {{ post.time_ago }}</span>
            </Link>

            <div v-if="post.lastReplie" class="text-gray-800 text-xs">
              <Link
                class="text-blue-600 uppercase font-bold"
                v-if="$page.props.auth.user"
                :href="route('profile', $page.props.auth.user.name)"
              >{{ post.lastReplie.user.name }}</Link>replied
              <span class="font-bold">{{ post.lastReplie.time_ago }}</span>
            </div>
            <div
              v-if="post.solved == 1"
              class="ml-2 inline-flex h-5 items-center rounded-full border border-solid border-blue-500 px-2 text-xs font-medium text-blue-500"
              style="line-height: 1.1;"
            >
              <svg width="8" viewBox="0 0 21 16" class="mr-1 hidden md:block">
                <path fill="none" d="M-3-5h27v27H-3z" />
                <path
                  class="fill-current"
                  d="M7.439 12.152l-5.037-5.36c-.447-.477-1.119-.477-1.566 0a1.204 1.204 0 0 0 0 1.667l6.603 7.03L20.086 2.025a1.204 1.204 0 0 0 0-1.668c-.447-.476-1.12-.476-1.567 0L7.44 12.152z"
                  opacity=".5"
                />
              </svg>
              solved
            </div>
          </div>
        </div>
        <div
          class="relative hidden text-center md:ml-auto md:flex md:flex-row-reverse md:items-center"
          style="top: -10px;"
        >
          <div class="flex items-center justify-center ml-4">
            <div class="mr-1">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="15"
                height="19"
                viewBox="0 0 15 10"
                class="relative"
                style="top: -2px;"
              >
                <path
                  fill="#78909C"
                  fill-rule="evenodd"
                  d="M7.5 0C3.344 0 0 2.818 0 6.286c0 1.987 1.094 3.757 2.781 4.914l.117 2.35c.022.438.338.58.704.32l2.023-1.442c.594.144 1.219.18 1.875.18 4.156 0 7.5-2.817 7.5-6.285C15 2.854 11.656 0 7.5 0z"
                  opacity=".5"
                />
              </svg>
            </div>
            <span class="text-xs text-gray-800 font-semibold text-left leading-none relative">
              {{ post.count_reply
              }}
            </span>
          </div>
          <div class="flex items-center justify-center">
            <div class="mr-1">
              <svg xmlns="http://www.w3.org/2000/svg" width="19" height="13" viewBox="0 0 19 13">
                <g fill="none" fill-rule="evenodd">
                  <path d="M0-3h19v19H0z" />
                  <path
                    fill="#78909C"
                    d="M9.5.562C5.542.562 2.161 3.025.792 6.5c1.37 3.475 4.75 5.937 8.708 5.937s7.339-2.462 8.708-5.937C16.838 3.025 13.458.562 9.5.562zm0 9.896A3.96 3.96 0 0 1 5.542 6.5 3.96 3.96 0 0 1 9.5 2.542 3.96 3.96 0 0 1 13.458 6.5 3.96 3.96 0 0 1 9.5 10.458zm0-6.333A2.372 2.372 0 0 0 7.125 6.5 2.372 2.372 0 0 0 9.5 8.875 2.372 2.372 0 0 0 11.875 6.5 2.372 2.372 0 0 0 9.5 4.125z"
                    opacity=".5"
                  />
                </g>
              </svg>
            </div>
            <span class="text-xs text-gray-800 font-semibold text-left leading-none">{{ post.view }}</span>
          </div>
          <div class="flex items-center justify-center">
            <!-- <a
              :class="`items-center justify-center border hiddentext-white font-medium leading-tight rounded-full py-1 px-3 text-xs uppercase  shadow-md hover:bg-[${post.chanel.color}] hover:shadow-lg focus:bg-[${post.chanel.color}] focus:shadow-lg focus:outline-none focus:ring-0 active:bg-[${post.chanel.color}] active:shadow-lg transition duration-150 ease-in-out`"
              :style="`color: ${post.chanel.color}; border-color: ${post.chanel.color};   `"
            >{{ post.chanel.title }}</a>-->

            <button
              type="button"
              :class="`text-[${post.chanel.color}] hover:text-white border border-[${post.chanel.color}] hover:bg-[${post.chanel.color}] focus:ring-4 focus:outline-none focus:ring-[${post.chanel.color}] font-medium  rounded-full py-1 px-3 text-center mr-2 mb-2 dark:border-[${post.chanel.color}] dark:text-[${post.chanel.color}] dark:hover:text-white dark:hover:bg-[${post.chanel.color}] dark:focus:ring-[${post.chanel.color}]`"
              :style="`border-color: ${post.chanel.color};   `"
            >{{ post.chanel.title }}</button>
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
    this.listenForNewConverstion();
    this.listenForDeleteConverstion();
    this.listenForViewConverstion();
    this.listenForSolvedConversation();
  },
  data() {
    return {
      term: null,
      filter: this.category,
      answered: this.solved
    };
  },
  methods: {
    Filter(event) {
      if (event.target.value == "all") {
        this.filter = event.target.value;
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
</style>