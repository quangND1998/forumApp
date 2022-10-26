<template>
  <button  :disabled="isBlock()"  class="toggle-favorite rounded-md inline-flex items-center   dark:bg-[#213154] border-deep-black/3 bg-gray-200 px-3 font-medium transition-all hover:border-deep-black/10 hover:bg-grey-300 mobile:flex mobile:items-center mobile:p-2 mobile:text-sm md:text-xs reply-likes mobile:text-sm has-none border-deep-black/3 bg-grey-200 mr-auto md:mr-0"  :title="`Liked by ${comment.likes} `" @click="toggle">
    <FavoriteIcon
    :comment="comment" :user="user"
      class="toggle-favorite__icon"
      :class="iconClasses"
      @animationend.native="onIconAnimationEnds"

    />
    <transition name="favorite-particles-transition">
      <div v-if="animating" class="toggle-favorite__particles"></div>
    </transition>
    <span class="ml-1" v-if="comment.likes.length > 0">{{ comment.likes.length }}</span>
  </button>
</template>

<script>
import FavoriteIcon from "./FavoriteIcon";
export default {
  name: "ToggleFavorite",
  components: {
    FavoriteIcon
  },
  props:{
    comment:Object,
    user:Object
  },
  data() {
    return {
      favorited: this.checkIsLike(),
      animating: false
    };
  },
  computed: {
    iconClasses() {
      return {
        // "toggle-favorite__icon--favorited": this.checkIsLike(),
        // "toggle-favorite__icon--animate": this.checkIsLike()
        "toggle-favorite__icon--favorited": this.favorited,
        "toggle-favorite__icon--animate": this.animating
      };
    }
  },
  methods: {
    toggle() {
      // Only animate on favoriting.
      if (!this.favorited) {
        this.animating = true;
      }
      this.$inertia.post(
          this.route("admin.replie.like", this.comment.id), this.form,
          { preserveState: true, preserveScroll: true }
      );

      this.favorited = !this.favorited;
    },
    onIconAnimationEnds() {
      this.animating = false;
    },
    checkIsLike() {
        if (this.user && this.comment.likes.length > 0) {
            if (this.comment.likes.includes(this.user.name)) {
                return true;
            }
            return false;
        }
        else {
            return false;
        }

    },

  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss">
$particles-animation-duration: 0.8s;
$icon-animation-duration: 0.48s;
$icon-color: #4682f3;
$icon-border-color: hsl(0, 0%, 10%);

@keyframes favorite-icon-animation {
  0% {
    opacity: 1;
    transform: scale(0.1);
  }

  50% {
    opacity: 1;
    transform: scale(1.1);
  }

  80% {
    opacity: 1;
    transform: scale(0.9);
  }

  100% {
    opacity: 1;
    transform: scale(1);
  }
}

@keyframes favorite-particles-animation {
  0% {
    background-position: left center;
  }
  100% {
    background-position: right center;
  }
}

// Particles animation.
.favorite-particles-transition-enter-active {
  background-image: url("/particles-sprite.png");
  background-size: 2500% auto;
  background-position: left center;
  background-repeat: no-repeat;

  animation-duration: $particles-animation-duration;
  animation-timing-function: steps(24);
  animation-name: favorite-particles-animation;
}

.toggle-favorite {
  font-size: 20px;
  position: relative;

  &__icon {
    height: 16px;
    width: 14px;

    // Transition mainly for when un-favoriting
    transition: fill-opacity 0.2s, stroke 0.2s;
    // fill: $icon-color;
    // fill-opacity: 0;
    // stroke: $icon-border-color;

    &--favorited {
      fill-opacity: 1;
       fill: $icon-color;
      stroke: $icon-color;
    }

    // Icon animation
    &--animate {
      opacity: 0;
      transform: scale(0);
      animation-duration: $icon-animation-duration;
      animation-delay: $particles-animation-duration - $icon-animation-duration;
      animation-name: favorite-icon-animation;
    }
  }

  &__particles {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 4em;
    height: 4em;
  }
}

// .toggle-favorite{
//   font-size: 20px;
//   position: relative;
// }
// .toggle-favorite__icon{
//     height: 16px;
//     width: 14px;

//     // Transition mainly for when un-favoriting
//     transition: fill-opacity 0.2s, stroke 0.2s;
//     fill: $icon-color;
//     fill-opacity: 0;
//     stroke: $icon-border-color;
// }
// .toggle-favorite__icon--favorited{
//       fill-opacity: 1;
//       stroke: $icon-color;
// }
// .toggle-favorite__icon--animate{
//       opacity: 1;
//       transform: scale(0);
//       animation-duration: $icon-animation-duration;
//       animation-delay: $particles-animation-duration - $icon-animation-duration;
//       animation-name: favorite-icon-animation;
// }
// .toggle-favorite__particles{
//   position: absolute;
//     top: 50%;
//     left: 50%;
//     transform: translate(-50%, -50%);
//     width: 4em;
//     height: 4em;
// }
// .fill-white{
//      transition: fill-opacity 0.2s, stroke 0.2s;
//     fill: #FFF;
//     fill-opacity: 1;
//     stroke: #FFF;
// }
</style>
