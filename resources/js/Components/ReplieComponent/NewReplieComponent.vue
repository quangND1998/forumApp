<template>
  <transition name="fade">
    <div class="w-full text-center">
      <div
        class="inset-0 w-full shadow-sm h-1/3 max-h-screen max-w-4xl"
        height="auto"
        v-if="visible"
        v-cloak
        style="z-index:1000"
      >
        <div
          class="vfm__container fixed inset-0 outline-none flex mx-auto"
          aria-expanded="true"
          role="dialog"
          tabindex="-1"
        >
          <div
            :style="{ position: StyleCss.position, transition: StyleCss.transition, bottom: StyleCss.bottom }"
            class="vfm__content vfm__content mx-auto flex-1 rounded-none bg-white md:rounded-t-2xl max-h-screen mt-auto overflow-auto flex flex-col w-full md:w-3/4 md:max-h-80 transition-transform vfm--prevent-auto"
            style="box-shadow: rgba(27, 33, 58, 0.4) 0px 20px 60px -2px;max-width: 800px;"
          >
            <div class="flex py-8 px-10 md:px-8 md:py-6">
              <div class="flex-1">
                <form @submit.prevent="save">
                  <div class="control flex items-center">
                    <i class="fas fa-reply"></i>
                    <p class="font-semibold">
                      Reply to
                      <strong class="uppercase text-blue">{{ reply_to }}</strong>
                    </p>
                    <input type="hidden" v-model="form.user_id" />
                    <button
                      v-if="showMize == true"
                      @click.prevent="miniMize()"
                      class="ml-4 inline-flex h-8 items-baseline rounded-md bg-grey-200 px-4 py-2 text-xs font-medium text-grey-800 hover:bg-grey-300 ml-auto"
                    >
                      <span class="mr-1 block h-1 w-4 rounded-full bg-languages">Minimize</span>
                    </button>
                    <button
                      v-else
                      @click.prevent="maxiMize()"
                      class="ml-4 inline-flex h-8 items-baseline rounded-xl bg-grey-200 px-4 py-2 text-xs font-medium text-grey-800 hover:bg-grey-300 ml-auto"
                    >
                      <span class="mr-1 block h-1 w-4 rounded-full bg-blue">Maximize</span>
                    </button>
                  </div>
                  <div class="control">
                    <!-- style="min-height: 150px; max-height: 45vh; overflow: hidden; overflow-wrap: break-word; resize: none; height: 150px;" -->
                    <ckeditor
                      class="textarea mb-1 w-full border-l-0 border-r-0 px-0 py-4 text-sm focus:border-grey-500 overflow-y"
                      data-tribute="true"
                      v-model="form.body"
                      :config="editorConfig"
                      tag-name="textarea"
                    ></ckeditor>
                    <!-- <textarea
                      id="about"
                      name="about"
                      v-model="form.body"
                      rows="3"
                      :class="errors && errors.body ?'border-red-500':''"
                      class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md"
                      placeholder="Something..."
                    ></textarea>-->

                    <div class="text-red-500" v-if="errors && errors.body">{{ errors.body }}</div>
                  </div>
                  <div class="md:grid md:grid-cols-2 md:gap-2">
                    <div class="md:col-span-1">
                      <label
                        class="block text-sm font-medium text-gray-700"
                      >Image (This field can be null)</label>
                      <div
                        class="relative h-28 rounded-lg border-dashed border-2 border-gray-200 bg-white flex justify-center items-center hover:cursor-pointer"
                        :class="errors && errors.image ?'border-red-500':''"
                      >
                        <div class="flex flex-wrap justify-center">
                          <div class="w-full h-full px-4">
                            <img
                              v-if="image"
                              :src="image"
                              alt="..."
                              class="shadow rounded max-w-full h-auto align-middle border-none"
                            />
                          </div>
                        </div>
                        <div class="absolute">
                          <div class="flex flex-col items-center">
                            <i class="fa fa-cloud-upload fa-2x text-gray-200"></i>
                            <span class="block text-gray-400 font-normal">
                              Drag file
                              here
                            </span>
                            <span class="block text-gray-400 font-normal">or</span>
                            <span class="block text-blue-400 font-normal">
                              Browse
                              files
                            </span>
                          </div>
                        </div>
                        <input
                          id="image-upload"
                          @change="onFileChangeImage"
                          class="h-full w-full opacity-0"
                          @input="form.image  = $event.target.files[0]"
                          name="image-upload"
                          type="file"
                          accept=".png, .jpg, .jpeg"
                        />
                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                        <div class="text-red-500" v-if="errors && errors.image">
                          {{ errors.image
                          }}
                        </div>
                      </div>
                    </div>
                    <div class="mt-5 md:mt-0">
                      <label
                        class="block text-sm font-medium text-gray-700"
                      >Video ( This field can be null)</label>
                      <div
                        class="relative h-28 rounded-lg border-dashed border-2 border-gray-200 bg-white flex justify-center items-center hover:cursor-pointer"
                        :class=" errors && errors.video ?'border-red-500':''"
                      >
                        <div class="absolute">
                          <div class="flex flex-col items-center">
                            <i class="fa fa-cloud-upload fa-2x text-gray-200"></i>
                            <span class="block text-gray-400 font-normal">
                              Drag file
                              here
                            </span>
                            <span class="block text-gray-400 font-normal">or</span>
                            <span class="block text-blue-400 font-normal">
                              Browse
                              files
                            </span>
                          </div>
                        </div>

                        <input
                          id="video-upload"
                          name="video-upload"
                          @input="form.video  = $event.target.files[0]"
                          type="file"
                          class="h-full w-full opacity-0"
                          accept="video/mp4,video/x-m4v,video/*"
                        />
                        <p class="text-xs text-gray-500">MP4 up to 10MB</p>
                      </div>
                      <div class="text-red-500" v-if="errors && errors.video">{{ errors.video }}</div>
                    </div>
                  </div>
                  <div class="flex items-center justify-between mt-6">
                    <div class="flex w-full justify-center space-x-6 md:justify-end">
                      <div class="flex-1 md:flex-none">
                        <button
                          @click="closeModal()"
                          class="bg-gray-200 text-white font-bold py-2 px-4 rounded-full w-full normal-case text-grey-800 md:w-auto md:px-10"
                        >Cancel</button>
                      </div>
                      <div class="flex-1 md:flex-none">
                        <button
                          type="submit"
                          class="text-white font-bold py-2 px-4 rounded-full bg-blue-600 w-full normal-case md:w-auto md:px-10"
                        >Post</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
import EditorVue from "@/Components/editor/Editor";
import { events } from "../../event";
export default {
  components: {
    EditorVue
  },

  props: {
    conversation: Object,
    initalReplies: Object,
    errors: Object
  },
  data() {
    return {
      StyleCss: {
        position: "",
        bottom: 0,
        transition: "1s"
      },
      image: null,
      showMize: true,
      reply_to: null,
      visible: false,
      form: this.$inertia.form({
        id: null,
        body: null,
        image: null,
        video: null,
        user_id: null,
        replie_id: null,
        replie_user: null
      }),
      editorData: "<p>Content of the editor.</p>",
      editorConfig: {
        toolbarGroups: [
          { name: "document", groups: ["mode", "document", "doctools"] },
          { name: "clipboard", groups: ["clipboard", "undo"] },
          {
            name: "editing",
            groups: ["find", "selection", "spellchecker", "editing"]
          },
          { name: "forms", groups: ["forms"] },
          { name: "basicstyles", groups: ["basicstyles", "cleanup"] },
          {
            name: "paragraph",
            groups: ["list", "indent", "blocks", "align", "bidi", "paragraph"]
          },
          { name: "links", groups: ["links"] },
          { name: "styles", groups: ["styles"] },
          { name: "colors", groups: ["colors"] },
          { name: "tools", groups: ["tools"] },
          { name: "others", groups: ["others"] },
          { name: "about", groups: ["about"] }
        ]
      }
    };
  },
  mounted() {
    var self = this;
    window.ChatterEvents.$on("RelytoQuestion", e => {
      self.openModal();
    });
    window.ChatterEvents.$on("ReplieEvent", (e, comment) => {
      self.form.replie_id = e.id;
      self.openModalReplie(e, comment);
    });
  },
  methods: {
    save() {
      this.form.post(this.route("admin.replie.store", this.conversation), {
        preserveState: true,
        onError: errors => {
          if (Object.keys(errors).length > 0) {
            this.visible = true;
          }
        },
        onSuccess: page => {
          this.visible = false;
          this.form.reset();
        }
      });
    },

    toggleModal() {
      this.visible = !this.visible;
    },
    closeModal() {
      this.visible = false;
      this.form.reset();
    },
    openModal() {
      this.visible = true;
      this.reply_to = "Post";
    },

    openModalReplie(data, comment) {
      this.visible = true;
      this.reply_to = comment.owner.name;
      this.form.replie_user = comment.owner.id;
    },
    miniMize() {
      this.showMize = false;
      this.StyleCss = {
        position: "relative",
        transition: "1s",
        bottom: "-200px"
      };
    },

    maxiMize() {
      this.showMize = true;
      this.StyleCss = {
        position: "",
        bottom: "0px",
        transition: "1s"
      };
      // console.log(this.StyleCss);
    },
    onFileChangeImage(e) {
      const file = e.target.files[0];
      this.image = URL.createObjectURL(file);
    }
  }
};
</script>

<style scoped>
.textarea {
  max-height: 100%;
  padding: 20px 15px;
}

.control:not(:last-child) {
  margin-bottom: 1.3em;
}
@media (min-width: 768px) {
  .md\:max-h-80 {
    max-height: 34rem;
  }
}
.vfm__container {
  background: 0 0;
  border: 0 solid;
  font-size: 100%;
  font-weight: 400;
  margin: 0;
  padding: 0;
  vertical-align: baseline;
}

.bg-languages {
  --tw-bg-opacity: 1;
  background-color: rgb(241 154 26 / var(--tw-bg-opacity));
}

.bg-blue {
  --tw-bg-opacity: 1;
  background-color: rgb(50 138 241 / var(--tw-bg-opacity));
}

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

.text-blue {
  --tw-text-opacity: 1;
  color: rgb(50 138 241 / var(--tw-text-opacity));
}

.transition-transform {
  transition-property: transform;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  transition-duration: 150ms;
}
</style>