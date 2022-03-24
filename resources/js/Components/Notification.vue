<template>
  <div
    class="bg-gray-200 dark:bg-gray-900 h-full z-50"
    style="    width: fit-content;
    height: fit-content;"
    v-if="$page.props.flash.success || $page.props.flash.warning || Object.keys($page.props.errors).length > 0"
  >
    <div
      role="alert"
      class="xl:w-3/12 mx-auto sm:mx-0 sm:w-4/12 md:w-3/12 w-4/12 bg-white dark:bg-gray-800 shadow-lg rounded flex sm:flex-row flex-col pr-4 absolute left-0 sm:left-auto right-0 sm:top-0 sm:mr-6 mt-16 sm:mt-6 mb-6 sm:mb-0 transition duration-150 ease-in-out animated fadeInUp"
      id="notification"
    >
      <div
        class="sm:px-6 px-4 mt-4 sm:mt-0 flex items-center sm:justify-center sm:border-r dark:border-gray-700 border-gray-300 text-green-400"
      >
        <svg
          v-if="$page.props.flash.success"
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 24 24"
          width="40"
          height="40"
          fill="currentColor"
        >
          <path
            class="heroicon-ui"
            d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-2.3-8.7l1.3 1.29 3.3-3.3a1 1 0 0 1 1.4 1.42l-4 4a1 1 0 0 1-1.4 0l-2-2a1 1 0 0 1 1.4-1.42z"
          />
        </svg>

        <svg
          v-if="$page.props.flash.warning"
          height="40"
          viewBox="0 0 128 128"
          width="40"
          xmlns="http://www.w3.org/2000/svg"
        >
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

        <svg
          v-if="Object.keys($page.props.errors).length > 0"
          height="40"
          viewBox="0 0 128 128"
          width="40"
          xmlns="http://www.w3.org/2000/svg"
        >
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
        <p
          class="text-lg text-gray-800 dark:text-gray-100 font-semibold pb-1"
          v-if="$page.props.flash.success"
        >Success</p>
        <p
          class="text-sm text-gray-600 dark:text-gray-400 font-normal pb-2"
          v-if="$page.props.flash.success"
        >{{ $page.props.flash.success }}</p>
        <p
          class="text-lg text-gray-800 dark:text-gray-100 font-semibold pb-1"
          v-if="$page.props.flash.warning"
        >Warning</p>
        <p
          class="text-sm text-gray-600 dark:text-gray-400 font-normal pb-2"
          v-if="$page.props.flash.warning"
        >{{ $page.props.flash.warning }}</p>
        <p
          class="text-lg text-gray-800 dark:text-gray-100 font-semibold pb-1"
          v-if="Object.keys($page.props.errors).length > 0"
        >Warning</p>
        <p
          class="text-sm text-gray-600 dark:text-gray-400 font-normal pb-2"
          v-if="Object.keys($page.props.errors).length > 0"
        >There are {{Object.keys($page.props.errors).length}} form errors.</p>
        <div class="flex">
          <span
            class="text-sm pl-2 text-gray-600 dark:text-gray-400 cursor-pointer"
            @click="closeNotification()"
          >Dismiss</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    closeNotification() {
      var Notification = document.getElementById("notification");
      Notification.style.display = "none";
    }
  }
};
</script>

<style>
</style>