<template>
  <div class="bg-gray-200 dark:bg-gray-900 h-full">
    <div
      role="alert"
      class="xl:w-5/12 mx-auto sm:mx-0 sm:w-6/12 md:w-3/5 w-11/12 bg-white dark:bg-gray-800 shadow-lg rounded flex sm:flex-row flex-col pr-4 absolute left-0 sm:left-auto right-0 sm:top-0 sm:mr-6 mt-16 sm:mt-6 mb-6 sm:mb-0 transition duration-150 ease-in-out"
      id="notification"
    >
      <div
        class="sm:px-6 px-4 mt-4 sm:mt-0 flex items-center sm:justify-center sm:border-r dark:border-gray-700 border-gray-300 text-green-400"
      >
        <svg height="40" viewBox="0 0 128 128" width="40" xmlns="http://www.w3.org/2000/svg">
          <g>
            <path
              d="m40.172 97.482a13.637 13.637 0 0 1 -11.692-20.658l23.827-39.688a13.639 13.639 0 0 1 23.386 0l23.828 39.688a13.638 13.638 0 0 1 -11.693 20.658z"
              fill="#fd445f"
            />
            <path
              d="m40.172 90.4a6.556 6.556 0 0 1 -5.62-9.93l23.827-39.688a6.555 6.555 0 0 1 11.241 0l23.828 39.688a6.556 6.556 0 0 1 -5.62 9.93z"
              fill="#ece6f2"
            />
            <g fill="#293e65">
              <rect height="19.729" rx="3" width="6" x="61" y="51.021" />
              <circle cx="64" cy="79.658" r="3" />
            </g>
          </g>
        </svg>
      </div>
      <div class="flex flex-col justify-center pl-4 sm:w-9/12 py-3">
        <p class="text-lg text-gray-800 dark:text-gray-100 font-semibold pb-1">Permission</p>
        <p class="text-sm text-gray-600 dark:text-gray-400 font-normal pb-2">{{ erros }}</p>
        <div class="flex">
          <span
            class="text-sm pl-2 text-gray-600 dark:text-gray-400 cursor-pointer"
            @click="closeModal()"
          >Dismiss</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import LayoutForum from '@/Pages/Forum/Layout'
export default {
  layout: LayoutForum,
  props: {
    erros: String
  },
  name: "MultipleAction",
  mounted: function () {
    this.onLoad();
  },
  methods: {
    onLoad() {
      var Notification = document.getElementById("notification");
      Notification.style.transform = "translateX(150%)";
      Notification.classList.remove("hidden");
      setTimeout(function () {
        Notification.style.transform = "translateX(0%)";
      }, 1000);
    },
    closeModal() {
      var Notification = document.getElementById("notification");
      Notification.style.transform = "translateX(150%)";
      // this.$inertia.visit(window.history.back(), { preserveState: true });
    }
  }
};
</script>

<style>
</style>