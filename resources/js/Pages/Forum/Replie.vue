<template>
  <transition name="fade" class="flex flex-wrap p-4 pb-0 w-full">
    <div>
      <div class="sm:hidden relative w-12/12 mx-auto rounded">
        <div class="w-full pb-2" v-if="$page.props.auth.user !== null">
          <ReplyButtom v-if="$page.url.startsWith('/question')"></ReplyButtom>
        </div>
      </div>
      <div v-if="conversation.lock_comment" class="bg-indigo-900 text-center py-4 lg:px-4 mb-4">
        <div
          class="p-2 bg-indigo-800 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex"
          role="alert"
        >
          <span
            class="flex rounded-full bg-indigo-500 uppercase px-2 py-1 text-xs font-bold mr-3"
          >New</span>
          <span class="font-semibold mr-2 text-left flex-auto">
            Can't comment or reply because the post owner has locked
            this feature
          </span>
        </div>
      </div>
      <Conversation :conversation="conversation"></Conversation>
      <div
        v-for="replie in initalReplies.data"
        :key="replie.id"
        class="flex flex-wrap md:py-2 mt-1 ml-8"
        :id="replie.id"
      >
        <div
          class="forum-comment w-full is-reply relative mb-2 rounded-xl bg-white hover:border hover:border-grey-400 border border-deep-black/4"
          :class="replie.id== replie_id ? 'hover:border-grey-400 border-2 border-deep-black/4 border-blue-500':''"
        >
          <div class="flex px-6 py-4 lg:p-5">
            <div class="mr-5 hidden text-left md:block">
              <a
                class="relative flex items-start mb-2"
                style="width: 32px; height: 32px; padding: 2px;"
              >
                <img
                  class="relative bg-white ls-is-cached lazyloaded"
                  style="width: 100%; border-radius: 9px;"
                  width="32"
                  height="32"
                  :src="replie.owner.avatar"
                  :alt="`avatar of ${replie.owner.avatar} on ${replie.title}`"
                />
              </a>
            </div>
            <div class="relative flex-1">
              <header class="mb-4 flex items-center justify-between">
                <div class="md:hidden">
                  <a href class="relative mr-4 block overflow-hidden rounded-lg">
                    <img
                      :src="replie.owner.avatar"
                      alt="`avatar of ${conversation.owner.avatar} on ${conversation.title}`"
                      class="lazyload is-circle w-8 bg-white md:w-18"
                      style="border-radius: 9px;"
                    />
                  </a>
                </div>
                <div class="flex-1 text-left leading-none">
                  <div class="flex items-center">
                    <a class="font-lg mr-2 block font-bold text-black">{{ replie.owner.name }}</a>
                  </div>
                  <div class="mt-2 flex flex-wrap items-center gap-x-2 text-2xs font-medium">
                    <span class="text-sm text-gray-600">
                      <span class="text-sm text-gray-600">Post {{ replie.time_ago }}</span>
                    </span>
                  </div>
                </div>
                <div v-if="replie.best_answer == 1" class="relative ml-3 flex" style="top: -5px;">
                  <span
                    class="inline-flex items-center rounded-full bg-blue-500 px-3 py-1 text-2xs font-bold uppercase text-white md:text-2xs"
                  >
                    Best
                    Answer
                  </span>
                </div>
              </header>
              <div class="content user-content text-[13px] text-black">
                <div v-html="replie.body"></div>
                <div class="md:grid md:grid-cols-2 md:gap-2">
                  <div>
                    <div class="grid grid-cols-2 gap-4">
                      <div v-for="(image,index) in replie.images" :key="index">
                        <div class="bg-sky-300 ...">
                          <img :src="image.image" class="object-fill h-48 w-96 ..." />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div>
                    <div class="grid grid-cols-2 gap-4">
                      <div v-for="(video,index) in replie.videos" :key="index">
                        <video class="object-fill h-48 w-96 ..." controls>
                          <source :src="video.video" type="video/mp4" />
                        </video>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <LikeReplyButton :replie="replie" :comment="replie" :conversation="conversation"></LikeReplyButton>
            </div>
          </div>
        </div>
        <div
          v-for="re_reply in replie.replies"
          :key="re_reply.id"
          class="flex flex-wrap md:py-2 mt-1 ml-8 w-full"
          :id="re_reply.id"
        >
          <div
            class="forum-comment w-full is-reply relative mb-2 rounded-xl bg-white hover:border hover:border-grey-400 border border-deep-black/4"
            :class="re_reply.id== replie_id ? 'hover:border-blue-400 border-2 border-deep-black/4 border-blue-500':''"
          >
            <div class="flex px-6 py-4 lg:p-5">
              <div class="mr-5 hidden text-left md:block">
                <a
                  class="relative flex items-start mb-2"
                  style="width: 32px; height: 32px; padding: 2px;"
                >
                  <img
                    class="relative bg-white ls-is-cached lazyloaded"
                    style="width: 100%; border-radius: 9px;"
                    width="32"
                    height="32"
                    :src="re_reply.owner.avatar"
                    :alt="`avatar of ${re_reply.owner.avatar} on ${re_reply.title}`"
                  />
                </a>
              </div>
              <div class="relative flex-1">
                <header class="mb-4 flex items-center justify-between">
                  <div class="md:hidden">
                    <a href class="relative mr-4 block overflow-hidden rounded-lg">
                      <img
                        :src="re_reply.owner.avatar"
                        alt="`avatar of ${conversation.owner.avatar} on ${conversation.title}`"
                        class="lazyload is-circle w-8 bg-white md:w-18"
                        style="border-radius: 9px;"
                      />
                    </a>
                  </div>
                  <div class="flex-1 text-left leading-none">
                    <div class="flex items-center">
                      <a class="font-lg mr-2 block font-bold text-black">{{ re_reply.owner.name }}</a>
                    </div>
                    <div class="mt-2 flex flex-wrap items-center gap-x-2 text-2xs font-medium">
                      <span class="text-sm text-gray-600">
                        <span class="text-sm text-gray-600">Post {{ re_reply.time_ago }}</span>
                      </span>
                    </div>
                  </div>
                  <div
                    v-if="re_reply.best_answer == 1"
                    class="relative ml-3 flex"
                    style="top: -5px;"
                  >
                    <span
                      class="inline-flex items-center rounded-full bg-blue-500 px-3 py-1 text-2xs font-bold uppercase text-white md:text-2xs"
                    >
                      Best
                      Answer
                    </span>
                  </div>
                </header>
                <div class="content user-content text-[13px] text-black">
                  <!-- <p>{{ re_reply.body }}</p> -->
                  <Link
                    class="text-blue"
                    :href="'/@' + re_reply.user_reply.name"
                  >@{{ re_reply.user_reply.name }}</Link>
                  <span v-html="re_reply.body"></span>
                  <div class="md:grid md:grid-cols-2 md:gap-2">
                    <div>
                      <div class="grid grid-cols-2 gap-4">
                        <div v-for="(image,index) in re_reply.images" :key="index">
                          <div class="bg-sky-300 ...">
                            <img :src="image.image" class="object-fill h-48 w-96 ..." />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div>
                      <div class="grid grid-cols-2 gap-4">
                        <div v-for="(video,index) in re_reply.videos" :key="index">
                          <video class="object-fill h-48 w-96 ..." controls>
                            <source :src="video.video" type="video/mp4" />
                          </video>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <LikeReplyButton :replie="replie" :comment="re_reply" :conversation="conversation"></LikeReplyButton>
              </div>
            </div>
          </div>
        </div>
      </div>
      <pagination class="mt-6" :links="initalReplies.meta.links" />
      <NewReplieComponent
        v-if="conversation.lock_comment == false"
        :conversation="conversation"
        :initalReplies="initalReplies"
      ></NewReplieComponent>
      <UpdateReplieComponent
        v-if="conversation.lock_comment == false"
        :conversation="conversation"
        :initalReplies="initalReplies"
      ></UpdateReplieComponent>
    </div>
  </transition>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue";
import Conversation from "@/Components/ReplieComponent/Conversation";
import LayoutForum from "@/Pages/Forum/Layout";
import NewReplieComponent from "@/Components/ReplieComponent/NewReplieComponent";
import LikeReplyButton from "@/Components/ReplieComponent/LikeReplyButton";
import UpdateReplieComponent from "@/Components/ReplieComponent/UpdateReplieComponent";
import ReplyButtom from "@/Components/ReplieComponent/ReplyButtom";
import Pagination from "@/Components/Pagination";
export default {
  layout: LayoutForum,
  props: {
    conversation: Object,
    initalReplies: Object,
    errors: Object,
    replie_id: String
  },
  components: {
    Link,
    Conversation,
    NewReplieComponent,
    LikeReplyButton,
    UpdateReplieComponent,
    ReplyButtom,
    Pagination
  },
  mounted() {
    this.listenForNewComment();
    this.listenForLikeComment();
    this.listenForUpdateComment();
    this.listenForLockComment();
    this.listenForUpdateConversation();
    this.$nextTick(() => {
      if (this.replie_id !== null) {
        const element = document.getElementById(this.replie_id);
        element.scrollIntoView();
      }
    });
  },
  data() {
    return {
      user_online: [],
      replyId: this.replie_id
    };
  },
  methods: {
    listenForNewComment() {
      // var self = this;
      // window.socketio.on("replie_event." + this.conversation.id + ":App\\Events\\ReplieCommentEvent", function (e) {
      //   console.log(e)
      //   let index = self.initalReplies.findIndex(x => x.id == e.replie_id);
      //   console.log(index);
      //   if (e.replie_id == null && index == -1) {
      //     self.initalReplies.push(e);
      //   } else {
      //     // this.initalReplies.forEach(element => {
      //     //     if(element.id == e.replie_id){
      //     //         element.replies.push(e);
      //     //     }

      //     // });
      //     for (let i = 0; i < self.initalReplies.length; i++) {
      //       if (self.initalReplies[i].id == e.replie_id) {
      //         self.initalReplies[i].replies.push(e);
      //       }
      //     }
      //   }

      // });

      window.Echo.channel("replie_event." + this.conversation.id).listen(
        "ReplieCommentEvent",
        e => {
          if (e.replie_id == null) {
            this.initalReplies.data.push(e);
          } else {
            // this.initalReplies.forEach(element => {
            //     if(element.id == e.replie_id){
            //         element.replies.push(e);
            //     }

            // });
            for (let i = 0; i < this.initalReplies.data.length; i++) {
              if (this.initalReplies.data[i].id == e.replie_id) {
                this.initalReplies.data[i].replies.push(e);
              }
            }
          }
        }
      );
    },
    listenForLikeComment() {
      // var self = this;
      // window.socketio.on("like_event:App\\Events\\LikeCommentEvent", function (e) {
      //   let index = self.initalReplies.findIndex(x => x.id == e.replie_id);
      //   if (e.replie_id == null && index == -1) {
      //     self.initalReplies.forEach(element => {
      //       if (element.id == e.id) {
      //         element.likes = e.likes;
      //         element.best_answer = e.best_answer;
      //       }
      //     });
      //   } else {
      //     self.initalReplies.forEach(element => {
      //       if (element.id == e.replie_id) {
      //         element.replies.forEach(replie => {
      //           if (replie.id == e.id) {
      //             replie.likes = e.likes;
      //             replie.best_answer = e.best_answer;
      //           }
      //         });
      //       }
      //     });
      //   }
      //   // increase the power everytime we load test route
      //   // $('#power').text(parseInt($('#power').text()) + parseInt(message.data.power));
      // });
      window.Echo.channel("like_event").listen("LikeCommentEvent", e => {
        if (e.replie_id == null) {
          this.initalReplies.data.map(element => {
            element.best_answer = 0;
            if (element.id == e.id) {
              element.likes = e.likes;
              element.best_answer = e.best_answer;
            }
            element.replies.map(replie => {
              replie.best_answer = 0;
            });
          });
        } else {
          this.initalReplies.data.map(element => {
            element.best_answer = 0;
            if (element.id == e.replie_id) {
              element.replies.map(replie => {
                replie.best_answer = 0;
                if (replie.id == e.id) {
                  replie.likes = e.likes;
                  replie.best_answer = e.best_answer;
                }
              });
            }
          });
        }
      });
    },
    listenForUpdateComment() {
      window.Echo.channel("update-replie." + this.conversation.id).listen(
        "UpdateReplieEvent",
        e => {
          if (e.replie_id == null) {
            let index = this.initalReplies.data.findIndex(x => x.id == e.id);
            this.initalReplies.data.splice(index, 1, e);
          } else {
            this.initalReplies.data.forEach(element => {
              if (element.id == e.replie_id) {
                let index = element.replies.findIndex(x => x.id == e.id);
                element.replies.splice(index, 1, e);
              }
            });
          }
        }
      );
    },
    listenForLockComment() {
      // var self = this;
      // window.socketio.on("sovled-conversation:App\\Events\\SovledConversationEvent", function (e) {

      //   if (self.conversation.id == e.id) {
      //     self.conversation.lock_comment = e.lock_comment
      //   }
      // });
      window.Echo.channel("sovled-conversation").listen(
        "SovledConversationEvent",
        e => {
          if (this.conversation.id == e.id) {
            this.conversation.lock_comment = e.lock_comment;
          }
        }
      );
    },
    listenForUpdateConversation() {
      window.Echo.channel("update-conversation." + this.conversation.id).listen(
        "UpdateConversation",
        e => {
          // console.log(e);
          if (this.conversation.id == e.id) {
            this.conversation.body = e.body;
            this.conversation.title = e.title;
          }
        }
      );
    },
    scrollToReply() {
      const element = document.getElementById(this.replie_id);
      element.scrollIntoView();
    }
  }
};
</script>


<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.05s;
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

@media (min-width: 992px) {
}

.forum-comment .show-on-hover {
  visibility: hidden;
}

@media (min-width: 768px) {
}

.md\:text-xs {
  font-size: 0.834rem;
}

.hover\:border-grey-400:hover {
  --tw-border-opacity: 1;
  border-color: rgb(235 237 241 / var(--tw-border-opacity));
}

.text-blue {
  --tw-text-opacity: 1;
  color: rgb(50 138 241 / var(--tw-text-opacity));
}
</style>