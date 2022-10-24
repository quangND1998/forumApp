<template>
  <svg
    width="17"
    height="16"
    viewBox="0 0 14 13"
    :class="checkIsLike() ? 'cursor-pointer fill-current text-blue-500' : 'cursor-pointer  text-gray-300 fill-white'"
  >
    <path
      fill-rule="nonzero"
      d="M13.59 1.778c-.453-.864-3.295-3.755-6.59.431C3.54-1.977.862.914.41 1.778c-.825 1.596-.33 4.014.823 5.18L7.001 13l5.767-6.043c1.152-1.165 1.647-3.582.823-5.18z"
    />
  </svg>
</template>
<script>
export default {
  props: {
    comment: Object,
    user: Object
  },
  methods: {
    checkIsLike() {
      if (this.user && this.comment.likes.length > 0) {
        if (this.comment.likes.includes(this.user.name)) {
          return true;
        }
        return false;
      } else {
        return false;
      }
    }
  }
};
</script>

<style>
</style>