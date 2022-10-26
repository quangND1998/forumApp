<template>
  <div>
    <div class="md:grid md:gap-6 ">
      <h1 class="dark:text-white">Create conversation</h1>
      <div class="mt-5 md:mt-0 md:col-span-2">
        <form @submit.prevent="submit()">
          <div class="shadow sm:rounded-md sm:overflow-hidden">
            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
              <div class="grid grid-cols-3 gap-6">
                <div class="col-span-3 sm:col-span-2">
                  <label for="company_website" class="block text-sm font-medium text-gray-700">Title</label>
                  <div class="mt-1 flex rounded-md shadow-sm">
                    <span
                      class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm"
                    >Title:</span>
                    <input
                      type="text"
                      v-model="form.title"
                      name="company_website"
                      id="company_website"
                      :class="errors.title ?'border-red-500':''"
                      class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300"
                      placeholder="Title of conversation"
                    />
                  </div>
                  <div class="text-red-500" v-if="errors.title">{{ errors.title }}</div>
                </div>
              </div>

              <div>
                <label for="about" class="block text-sm font-medium text-gray-700">Content</label>
                <div class="mt-1">
                  <!-- <textarea id="about" name="about" v-model="form.body" rows="3"
                                        :class="errors.body ?'border-red-500':''"
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block h-48 w-full sm:text-sm border-gray-300 rounded-md"
                  placeholder="Something..."></textarea>-->
                  <ckeditor v-model="form.body" :config="editorConfig"></ckeditor>
                </div>
                <div class="text-red-500" v-if="errors.body">{{ errors.body }}</div>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700">Select Channels</label>
                <div class="mt-1 flex items-center">
                  <select
                    name="category"
                    v-model="form.chanel_id"
                    required
                    autofocus
                    :class="errors.body ?'border-red-500':''"
                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md"
                  >
                    <option v-for="c in chanels" v-bind:key="c.id" :value="c.id">{{ c.title }}</option>
                  </select>
                </div>
                <div class="text-red-500" v-if="errors.chanel_id">{{ errors.chanel_id }}</div>
              </div>
              <div class="md:grid md:grid-cols-2 md:gap-2">
                <div class="md:col-span-1">
                  <label
                    class="block text-sm font-medium text-gray-700"
                  >Image (This field can be null)</label>
                  <div
                    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md"
                    :class="errors.image ?'border-red-500':''"
                  >
                    <div class="space-y-1 text-center">
                      <svg
                        class="mx-auto h-12 w-12 text-gray-400"
                        stroke="currentColor"
                        fill="none"
                        viewBox="0 0 48 48"
                        aria-hidden="True"
                      >
                        <path
                          d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                          stroke-width="2"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                        />
                      </svg>
                      <div class="flex text-sm text-gray-600">
                        <label
                          for="image-upload"
                          class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500"
                        >
                          <span>Upload a file</span>
                          <input
                            id="image-upload"
                            @change="onFileChangeImage"
                            @input="form.image  = $event.target.files[0]"
                            name="image-upload"
                            type="file"
                            class="sr-only"
                            accept=".png, .jpg, .jpeg"
                          />
                        </label>
                        <p class="pl-1">or drag and drop</p>
                      </div>
                      <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                    </div>
                  </div>
                  <div class="file-upload-image w-20 h-20">
                    <img v-if="image" :src="image" />
                  </div>
                  <div class="text-red-500" v-if="errors.image">{{ errors.image }}</div>
                </div>
                <div class="mt-5 md:mt-0">
                  <label
                    class="block text-sm font-medium text-gray-700"
                  >Video ( This field can be null)</label>
                  <div
                    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md"
                    :class="errors.video ?'border-red-500':''"
                  >
                    <div class="space-y-1 text-center">
                      <svg
                        class="mx-auto h-12 w-12 text-gray-400"
                        stroke="currentColor"
                        fill="none"
                        viewBox="0 0 48 48"
                        aria-hidden="True"
                      >
                        <path
                          d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                          stroke-width="2"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                        />
                      </svg>
                      <div class="flex text-sm text-gray-600">
                        <label
                          for="video-upload"
                          class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500"
                        >
                          <span>Upload a file</span>
                          <input
                            id="video-upload"
                            name="video-upload"
                            @input="form.video  = $event.target.files[0]"
                            type="file"
                            class="sr-only"
                            accept="video/mp4,video/x-m4v,video/*"
                          />
                        </label>
                        <p class="pl-1">or drag and drop</p>
                      </div>
                      <p class="text-xs text-gray-500">MP4 up to 10MB</p>
                    </div>
                  </div>
                  <div class="text-red-500" v-if="errors.video">{{ errors.video }}</div>
                </div>
              </div>
            </div>
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
              <Link
                :href="route('myThread')"
                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
              >Cancel</Link>
              <button
                type="submit"
                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
              >Save</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { events } from "../../event";
import { Link } from "@inertiajs/inertia-vue";
import LayoutForum from "@/Pages/Forum/Layout";
export default {
  layout: LayoutForum,
  components: {
    Link
  },
  data() {
    return {
      image: null,
      visible: false,
      // discussion: new Discussion(),
      form: this.$inertia.form({
        id: null,
        title: null,
        body: null,
        video: null,
        image: null,
        chanel_id: null
      }),

      editorData: "<p>Content of the editor.</p>",
      editorConfig: {
        // The configuration of the editor.
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
  props: {
    chanels: Array,
    errors: Object
  },

  methods: {
    submit() {
      this.form.post(this.route("admin.conversation.store"), {
        preserveState: true,
        onError: errors => {
          if (Object.keys(errors).length > 0) {
            this.visible = true;
          }
        },
        onSuccess: page => {
          this.visible = false;
          this.reset();
        }
      });
    },
    reset() {
      this.form = this.$inertia.form({
        id: null,
        title: null,
        body: null,
        video: null,
        image: null,
        chanel_id: null
      });
    },
    onFileChangeImage(e) {
      const file = e.target.files[0];
      this.image = URL.createObjectURL(file);
    }
  }
};
</script>

<style scoped>
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
</style>